<?php
require "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit("Phương thức không được hỗ trợ.");
}

if (
  empty($_POST) &&
  empty($_FILES) &&
  (int) ($_SERVER["CONTENT_LENGTH"] ?? 0) > 0
) {
  http_response_code(413);
  exit(
    "Tổng dung lượng tải lên vượt giới hạn máy chủ. Vui lòng giảm kích thước tệp hoặc tăng post_max_size trong php.ini."
  );
}

$required_fields = [
  "full_name",
  "phone",
  "device_type",
  "model_name",
  "branch_id",
  "appointment_date",
  "appointment_time",
];

foreach ($required_fields as $field) {
  if (!isset($_POST[$field]) || trim((string) $_POST[$field]) === "") {
    http_response_code(422);
    exit("Vui lòng điền đầy đủ thông tin đặt lịch.");
  }
}

$full_name = trim($_POST["full_name"]);
$phone = trim($_POST["phone"]);
$device_type = trim($_POST["device_type"]);
$model_name = trim($_POST["model_name"]);
$serial_imei = trim($_POST["serial_imei"] ?? "");
$common_issues = array_map("trim", (array) ($_POST["common_issues"] ?? []));
$common_issues = array_values(array_filter($common_issues));
$error_description = trim($_POST["error_description"] ?? "");
$branch_id = (int) $_POST["branch_id"];
$branch_names = [
  1 => "Hub 124 Thái Hà, Q. Đống Đa",
  2 => "Trụ Sở Keangnam Landmark 72, Nam Từ Liêm",
  3 => "Điểm tiếp nhận Cầu Giấy",
];
$appointment_date = $_POST["appointment_date"];
$appointment_time = trim($_POST["appointment_time"]);

$parsed_date = DateTime::createFromFormat("!Y-m-d", $appointment_date);
$date_errors = DateTime::getLastErrors();
if (
  $parsed_date === false ||
  ($date_errors !== false &&
    ($date_errors["warning_count"] > 0 || $date_errors["error_count"] > 0))
) {
  http_response_code(422);
  exit("Ngày hẹn không hợp lệ.");
}

$allowed_device_types = [
  "Điện thoại",
  "Laptop/PC",
  "Máy tính bảng",
  "Gia dụng thông minh",
];
$allowed_times = [
  "09:00 - 09:30",
  "10:30 - 11:00",
  "14:00 - 14:30",
  "16:30 - 17:00",
];
$today = new DateTimeImmutable("today");
$selected_date = DateTimeImmutable::createFromFormat(
  "!Y-m-d",
  $appointment_date,
);

if (!in_array($device_type, $allowed_device_types, true)) {
  http_response_code(422);
  exit("Vui lòng chọn loại thiết bị.");
}

if ($selected_date === false || $selected_date < $today) {
  http_response_code(422);
  exit("Ngày hẹn không được ở quá khứ.");
}

if (!in_array($appointment_time, $allowed_times, true)) {
  http_response_code(422);
  exit("Khung giờ hẹn không hợp lệ.");
}

$issue_parts = $common_issues;
if ($error_description !== "") {
  $issue_parts[] = $error_description;
}
$error_description = implode(" | ", array_values(array_unique($issue_parts)));
if ($error_description === "") {
  http_response_code(422);
  exit("Vui lòng chọn hoặc mô tả lỗi cần kiểm tra.");
}

$media_files = [];
$max_media_size = 50 * 1024 * 1024;
$allowed_media_types = [
  "image/jpeg" => "jpg",
  "image/png" => "png",
  "image/webp" => "webp",
  "video/mp4" => "mp4",
];
$uploaded_media = $_FILES["issue_media"] ?? null;
if ($uploaded_media && is_array($uploaded_media["name"] ?? null)) {
  $file_count = count(
    array_filter($uploaded_media["name"], static fn($name) => $name !== ""),
  );
  if ($file_count > 5) {
    http_response_code(422);
    exit("Chỉ được tải lên tối đa 5 tệp.");
  }

  $file_info = new finfo(FILEINFO_MIME_TYPE);
  foreach ($uploaded_media["name"] as $index => $original_name) {
    $upload_error = $uploaded_media["error"][$index] ?? UPLOAD_ERR_NO_FILE;
    if ($upload_error === UPLOAD_ERR_NO_FILE || $original_name === "") {
      continue;
    }
    if ($upload_error !== UPLOAD_ERR_OK) {
      http_response_code(422);
      exit(
        $upload_error === UPLOAD_ERR_INI_SIZE ||
        $upload_error === UPLOAD_ERR_FORM_SIZE
          ? "Tệp vượt quá giới hạn tải lên của máy chủ."
          : "Tải tệp lên thất bại. Vui lòng thử lại."
      );
    }
    if (($uploaded_media["size"][$index] ?? 0) > $max_media_size) {
      http_response_code(422);
      exit("Mỗi tệp tải lên không được vượt quá 50MB.");
    }

    $temporary_path = $uploaded_media["tmp_name"][$index] ?? "";
    if ($temporary_path === "" || !is_uploaded_file($temporary_path)) {
      http_response_code(422);
      exit("Không nhận được tệp tải lên hợp lệ.");
    }
    $mime_type = $file_info->file($temporary_path);
    if (!isset($allowed_media_types[$mime_type])) {
      http_response_code(422);
      exit(
        "Định dạng tệp không được hỗ trợ. Chỉ nhận JPG, PNG, WEBP hoặc MP4."
      );
    }

    $media_files[] = [
      "temporary_path" => $temporary_path,
      "extension" => $allowed_media_types[$mime_type],
    ];
  }
}

$booking_code = "BK-" . date("Y") . "-" . random_int(1000, 9999);
$saved_media_paths = [];
$saved_media_files = [];

try {
  $upload_directory =
    dirname(__DIR__) .
    DIRECTORY_SEPARATOR .
    "uploads" .
    DIRECTORY_SEPARATOR .
    "repairs";
  if (
    $media_files &&
    !is_dir($upload_directory) &&
    !mkdir($upload_directory, 0755, true) &&
    !is_dir($upload_directory)
  ) {
    throw new RuntimeException("Không thể tạo thư mục lưu tệp.");
  }

  $pdo->beginTransaction();

  foreach ($media_files as $media_file) {
    $file_name = bin2hex(random_bytes(16)) . "." . $media_file["extension"];
    $destination = $upload_directory . DIRECTORY_SEPARATOR . $file_name;
    if (!move_uploaded_file($media_file["temporary_path"], $destination)) {
      throw new RuntimeException("Không thể lưu tệp tải lên.");
    }
    $saved_media_files[] = $destination;
    $saved_media_paths[] = "../uploads/repairs/" . $file_name;
  }

  // 1. Kiểm tra khách hàng đã có chưa (theo SĐT)
  $stmt = $pdo->prepare(
    "SELECT customer_id, account_id FROM customers WHERE phone = ?",
  );
  $stmt->execute([$phone]);
  $customer = $stmt->fetch();

  if ($customer) {
    $customer_id = $customer["customer_id"];
    $stmt = $pdo->prepare(
      "UPDATE customers SET full_name = ? WHERE customer_id = ?",
    );
    $stmt->execute([$full_name, $customer_id]);
  } else {
    $stmt = $pdo->prepare(
      "INSERT INTO customers (full_name, phone) VALUES (?, ?)",
    );
    $stmt->execute([$full_name, $phone]);
    $customer_id = $pdo->lastInsertId();
  }

  // 2. Lưu thiết bị
  if ($serial_imei === "") {
    $device_name = $device_type . " - " . $model_name;
    $stmt = $pdo->prepare(
      "INSERT INTO devices (customer_id, device_name, imei_serial) VALUES (?, ?, NULL)",
    );
    $stmt->execute([$customer_id, $device_name]);
    $device_id = $pdo->lastInsertId();
  } else {
    $stmt = $pdo->prepare(
      "INSERT INTO devices (customer_id, device_name, imei_serial) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE device_name=?",
    );
    $device_name = $device_type . " - " . $model_name;
    $stmt->execute([$customer_id, $device_name, $serial_imei, $device_name]);

    $stmt = $pdo->prepare(
      "SELECT device_id FROM devices WHERE customer_id = ? AND imei_serial = ?",
    );
    $stmt->execute([$customer_id, $serial_imei]);
    $device_id = $stmt->fetchColumn();
  }

  // 3. Lưu lịch hẹn và tạo hồ sơ sửa chữa để theo dõi tiến độ.
  $stmt = $pdo->prepare(
    "INSERT INTO booking_requests (booking_code, customer_id, device_id, device_type, branch_name, error_description, media_paths, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
  );
  $stmt->execute([
    $booking_code,
    $customer_id,
    $device_id,
    $device_type,
    $branch_names[$branch_id] ?? "Chưa xác định",
    $error_description,
    json_encode($saved_media_paths, JSON_UNESCAPED_SLASHES),
    $appointment_date,
    $appointment_time,
  ]);
  $stmt = $pdo->prepare(
    "INSERT INTO repairs (device_id, tech_id, received_date, damage_level, status, progress_percent, total_cost) VALUES (?, 1, ?, 'Trung bình', 'Đã tiếp nhận', 20, 0)",
  );
  $stmt->execute([$device_id, $appointment_date]);
  $_SESSION["customer_id"] = (int) $customer_id;
  if ($customer && !empty($customer["account_id"])) {
    $_SESSION["account_id"] = (int) $customer["account_id"];
  }

  $pdo->commit();
  header("Location: thiet-bi-lich-su.php?booking=" . urlencode($booking_code));
  exit();
} catch (Throwable $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  foreach ($saved_media_files as $saved_media_file) {
    if (is_file($saved_media_file)) {
      unlink($saved_media_file);
    }
  }
  http_response_code(500);
  exit("Không thể lưu lịch hẹn. Vui lòng thử lại hoặc gọi hotline 1800 6868.");
}
?>
