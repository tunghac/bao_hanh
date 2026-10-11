<?php
require "db.php";
session_start();

function rc_escape($value): string
{
  return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
}

function rc_date($value): string
{
  if (!$value) {
    return "-";
  }

  $date = DateTime::createFromFormat("Y-m-d", (string) $value);
  return $date ? $date->format("d/m/Y") : rc_escape($value);
}

function rc_money($value): string
{
  return number_format((float) ($value ?? 0), 0, ",", ".") . " đ";
}

function rc_progress_step($status, $percent): int
{
  $status = trim((string) $status);
  $percent = (int) $percent;

  if ($status === "Hoàn thành" || $percent >= 100) {
    return 5;
  }

  if ($status === "Đang sửa") {
    return 4;
  }

  if ($status === "Chờ linh kiện" || $percent >= 40) {
    return 3;
  }

  if ($status === "Đã tiếp nhận" || $percent >= 20) {
    return 1;
  }

  return 1;
}

$lookup_type = trim((string) ($_GET["lookup_type"] ?? "rma"));
$lookup_value = trim((string) ($_GET["lookup"] ?? ""));

if (!in_array($lookup_type, ["rma", "phone", "serial"], true)) {
  $lookup_type = "rma";
}

$lookup_result = null;
$lookup_error = "";

if ($lookup_value !== "") {
  $lookup_value_for_query = $lookup_value;

  if ($lookup_type === "phone") {
    $lookup_value_for_query = preg_replace(
      "/\s+/",
      "",
      $lookup_value_for_query,
    );
  }

  try {
    if ($lookup_type === "rma") {
      /*
       * Mã phiếu thực tế của hệ thống được tạo tại xu_ly_dat_lich.php
       * dưới dạng BK-YYYY-xxxx và lưu trong booking_requests.booking_code.
       */
      $stmt = $pdo->prepare(
        "SELECT
                    c.customer_id,
                    c.full_name,
                    c.phone,
                    c.address,
                    d.device_id,
                    d.device_name,
                    d.imei_serial,
                    r.repair_id,
                    r.received_date,
                    r.status AS repair_status,
                    r.progress_percent,
                    r.total_cost,
                    t.full_name AS technician_name,
                    b.booking_code,
                    b.branch_name,
                    b.appointment_date,
                    b.appointment_time,
                    b.status AS booking_status,
                    b.error_description
                 FROM booking_requests b
                 INNER JOIN customers c ON c.customer_id = b.customer_id
                 INNER JOIN devices d ON d.device_id = b.device_id
                 LEFT JOIN repairs r ON r.repair_id = (
                    SELECT MAX(r2.repair_id)
                    FROM repairs r2
                    WHERE r2.device_id = d.device_id
                 )
                 LEFT JOIN technicians t ON t.tech_id = r.tech_id
                 WHERE UPPER(b.booking_code) = UPPER(?)
                 LIMIT 1",
      );
      $stmt->execute([$lookup_value_for_query]);
      $lookup_result = $stmt->fetch();
    } elseif ($lookup_type === "serial") {
      $stmt = $pdo->prepare(
        "SELECT
                    c.customer_id,
                    c.full_name,
                    c.phone,
                    c.address,
                    d.device_id,
                    d.device_name,
                    d.imei_serial,
                    r.repair_id,
                    r.received_date,
                    r.status AS repair_status,
                    r.progress_percent,
                    r.total_cost,
                    t.full_name AS technician_name,
                    b.booking_code,
                    b.branch_name,
                    b.appointment_date,
                    b.appointment_time,
                    b.status AS booking_status,
                    b.error_description
                 FROM devices d
                 INNER JOIN customers c ON c.customer_id = d.customer_id
                 LEFT JOIN repairs r ON r.repair_id = (
                    SELECT MAX(r2.repair_id)
                    FROM repairs r2
                    WHERE r2.device_id = d.device_id
                 )
                 LEFT JOIN technicians t ON t.tech_id = r.tech_id
                 LEFT JOIN booking_requests b ON b.booking_id = (
                    SELECT MAX(b2.booking_id)
                    FROM booking_requests b2
                    WHERE b2.device_id = d.device_id
                 )
                 WHERE d.imei_serial = ?
                 LIMIT 1",
      );
      $stmt->execute([$lookup_value_for_query]);
      $lookup_result = $stmt->fetch();
    } else {
      $stmt = $pdo->prepare(
        "SELECT
                    c.customer_id,
                    c.full_name,
                    c.phone,
                    c.address,
                    d.device_id,
                    d.device_name,
                    d.imei_serial,
                    r.repair_id,
                    r.received_date,
                    r.status AS repair_status,
                    r.progress_percent,
                    r.total_cost,
                    t.full_name AS technician_name,
                    b.booking_code,
                    b.branch_name,
                    b.appointment_date,
                    b.appointment_time,
                    b.status AS booking_status,
                    b.error_description
                 FROM customers c
                 INNER JOIN devices d ON d.customer_id = c.customer_id
                 LEFT JOIN repairs r ON r.repair_id = (
                    SELECT MAX(r2.repair_id)
                    FROM repairs r2
                    WHERE r2.device_id = d.device_id
                 )
                 LEFT JOIN technicians t ON t.tech_id = r.tech_id
                 LEFT JOIN booking_requests b ON b.booking_id = (
                    SELECT MAX(b2.booking_id)
                    FROM booking_requests b2
                    WHERE b2.device_id = d.device_id
                 )
                 WHERE REPLACE(c.phone, ' ', '') = ?
                 ORDER BY
                    CASE WHEN r.received_date IS NULL THEN 1 ELSE 0 END,
                    r.received_date DESC,
                    d.device_id DESC
                 LIMIT 1",
      );
      $stmt->execute([$lookup_value_for_query]);
      $lookup_result = $stmt->fetch();
    }
  } catch (Throwable $e) {
    $lookup_error =
      "Không thể thực hiện tra cứu. Vui lòng kiểm tra kết nối MySQL.";
  }

  if (!$lookup_result && $lookup_error === "") {
    $lookup_error = "Không tìm thấy thông tin phù hợp trong dữ liệu hệ thống.";
  }
}

$device_name = $lookup_result["device_name"] ?? "Chưa có thiết bị";
$customer_name = $lookup_result["full_name"] ?? "-";
$customer_phone = $lookup_result["phone"] ?? "-";
$customer_address = $lookup_result["address"] ?? "-";
$serial_imei = $lookup_result["imei_serial"] ?? "-";
$repair_status =
  $lookup_result["repair_status"] ??
  ($lookup_result["booking_status"] ?? "Chưa có dữ liệu");
$repair_percent = (int) ($lookup_result["progress_percent"] ?? 0);
$repair_step = rc_progress_step($repair_status, $repair_percent);
$booking_code = $lookup_result["booking_code"] ?? "-";
$technician_name = $lookup_result["technician_name"] ?? "-";
$received_date = $lookup_result["received_date"] ?? null;
$error_description = $lookup_result["error_description"] ?? "";
$total_cost = $lookup_result["total_cost"] ?? 0;

if ($lookup_result && $repair_status === "Hoàn thành") {
  $status_text = "Hoàn thành";
} elseif ($lookup_result && $repair_status !== "") {
  $status_text = $repair_status;
} else {
  $status_text = "Chưa có dữ liệu";
}

if ($lookup_result) {
  $status_class = in_array($status_text, ["Hoàn thành"], true)
    ? "bg-emerald-50 text-emerald-700"
    : "bg-secondary-fixed text-primary";
} else {
  $status_class = "bg-surface-container text-on-surface-variant";
}

$search_value = rc_escape($lookup_value);
$input_placeholder =
  $lookup_type === "phone"
    ? "Nhập số điện thoại khách hàng (VD: 0918 456 789)..."
    : ($lookup_type === "serial"
      ? "Nhập số Serial / IMEI thiết bị (VD: C02GG3VCMD6R)..."
      : "Nhập mã phiếu RMA (VD: RMA-2025-8892)...");
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Bảo hành &amp; Sửa chữa | ReliantCare</title>
    <link href="../favicon.svg" rel="icon" type="image/svg+xml"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Plus+Jakarta+Sans:wght@600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="../css/style.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="../js/script.js?v=20260917-php-routes"></script>
  </head>
  <body class="bg-surface font-body-md text-body-md text-on-surface antialiased">
    <header class="site-header fixed top-0 w-full z-50 bg-surface/95 backdrop-blur-md border-b border-surface-container">
      <div class="h-20 max-w-[1440px] mx-auto px-margin flex items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-lg">
          <a class="flex items-center gap-space-sm" data-path="trang-chu" href="trang-chu.php">
            <img alt="ReliantCare Logo" class="site-logo h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFQit0nSEGzWIX2Hs1fbneLlx7PZPUL5u44rQddKG3LZzxBRtLbh6Oj0JO8t2fv-8peBpQi_ccVp7l5NLJqj3_Gunplze4QcWNvFpTUW1OJG-V4gILP0YsiG3En89FCd2w5OtxM9i_2V1MIZ8-frYYOhSI0Q1dpzawU_-ge9PoygpMMNkvQLt8MnCCJRqRq2IoPlgkMt3QpR5Bw224matMkjgJXNwrtslv8qSmYURpTJlE6gGlU6DpIg"/>
            <div class="flex flex-col">
              <span class="font-headline-sm text-headline-sm text-primary tracking-tight">
                ReliantCare
              </span>
              <span class="site-brand-subtitle font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                <span class="material-symbols-outlined" aria-hidden="true">build</span>
                <span>Bảo hành &amp; Sửa chữa</span>
              </span>
            </div>
          </a>
          <nav class="site-nav hidden xl:flex items-center gap-1.5">
            <a aria-current="page" class="px-space-sm py-2 rounded-lg font-label-md text-label-md bg-primary text-on-primary font-semibold shadow-sm transition-colors" data-path="trang-chu" href="trang-chu.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">search</span>
              <span>Tra cứu</span><link href="trang-chu.php"/>
            </a>
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dat-lich-hen" href="dat-lich-hen.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">build</span>
              <span>Bảo hành &amp; Sửa chữa</span><link href="dat-lich-hen.php"/>
            </a>
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="tra-cuu-tien-do" href="tra-cuu-tien-do.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">track_changes</span>
              <span>Theo dõi</span><link href="tra-cuu-tien-do.php"/>
            </a>
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="so-bao-hanh-dien-tu" href="thiet-bi-lich-su.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">devices</span>
              <span>Thiết bị</span><link href="thiet-bi-lich-su.php"/>
            </a>
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="tra-cuu-chi-nhanh" href="tra-cuu-chi-nhanh.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">location_on</span>
              <span>Chi nhánh</span><link href="tra-cuu-chi-nhanh.php"/>
            </a>
          </nav>
        </div>
        <div class="site-actions flex items-center gap-space-md">
          <a class="hidden sm:flex items-center gap-space-xs px-space-sm py-2 rounded-lg hover:bg-surface-container text-primary transition-colors" href="tel:18006868">
            <span class="material-symbols-outlined text-secondary text-[20px]">
              call
            </span>
            <div class="flex flex-col text-left">
              <span class="font-label-sm text-[10px] text-on-surface-variant uppercase tracking-wider">
                Hotline
              </span>
              <span class="font-headline-sm text-headline-sm font-bold text-primary leading-tight">
                1800 6868
              </span>
            </div>
          </a>
          <a class="site-action-link inline-flex items-center gap-space-xs h-10 px-space-md bg-primary hover:bg-secondary text-on-primary font-label-lg text-label-lg rounded-lg shadow-sm transition-all" data-path="dat-lich-hen" href="dat-lich-hen.php">
            <span class="material-symbols-outlined text-[18px]">
              calendar_month
            </span>
            <span>
              Đặt lịch
            </span>
          </a>
          <a class="site-account" data-auth-action="logout" data-path="tai-khoan" href="#" aria-label="Đăng nhập" title="Đăng nhập">
            <span class="material-symbols-outlined text-[20px]">person</span>
          </a>
        </div>
      </div>
    </header>
    <main class="w-full pt-20 bg-surface">
      <div class="flex flex-col w-full">
        <!-- Hero & Clean Omni Search Section -->
        <section class="w-full bg-gradient-to-b from-surface-container-low to-surface py-space-xl">
          <div class="max-w-[1040px] mx-auto px-margin flex flex-col items-center text-center">
            <h1 class="font-display-lg text-display-lg text-primary tracking-tight">
              Tra cứu thông tin bảo hành &amp; Tiến độ sửa chữa
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-2 mb-space-lg">
              Kiểm tra thời hạn bảo hành chính hãng và theo dõi chi tiết tình trạng sửa chữa thiết bị thời gian thực.
            </p>
            <!-- Clean Search Box -->
            <div class="w-full bg-surface-container-lowest rounded-xl shadow-md p-space-md border border-surface-container text-left">
              <!-- Tab Selection -->
              <div class="flex items-center gap-2 pb-space-sm border-b border-surface-container">
                <button class="search-tab-btn flex items-center gap-1.5 px-space-md py-2 rounded-lg font-label-md text-label-md <?php echo $lookup_type ===
                "rma"
                  ? "bg-primary text-on-primary shadow-sm"
                  : "text-on-surface-variant hover:bg-surface-container hover:text-on-surface"; ?> transition-all" id="tab-rma" data-lookup-tab="rma">
                  <span class="material-symbols-outlined text-[18px]">
                    receipt_long
                  </span>
                  <span>
                    Mã phiếu RMA
                  </span>
                </button>
                <button class="search-tab-btn flex items-center gap-1.5 px-space-md py-2 rounded-lg font-label-md text-label-md <?php echo $lookup_type ===
                "phone"
                  ? "bg-primary text-on-primary shadow-sm"
                  : "text-on-surface-variant hover:bg-surface-container hover:text-on-surface"; ?> transition-all" id="tab-phone" data-lookup-tab="phone">
                  <span class="material-symbols-outlined text-[18px]">
                    phone_iphone
                  </span>
                  <span>
                    Số điện thoại
                  </span>
                </button>
                <button class="search-tab-btn flex items-center gap-1.5 px-space-md py-2 rounded-lg font-label-md text-label-md <?php echo $lookup_type ===
                "serial"
                  ? "bg-primary text-on-primary shadow-sm"
                  : "text-on-surface-variant hover:bg-surface-container hover:text-on-surface"; ?> transition-all" id="tab-serial" data-lookup-tab="serial">
                  <span class="material-symbols-outlined text-[18px]">
                    qr_code_scanner
                  </span>
                  <span>
                    Serial / IMEI
                  </span>
                </button>
              </div>
              <!-- Input Bar -->
              <form class="mt-space-md flex flex-col sm:flex-row items-center gap-space-sm" data-search-form="lookup">
                <div class="relative flex-1 w-full flex items-center">
                  <span class="material-symbols-outlined absolute left-space-md text-on-surface-variant text-[22px] pointer-events-none">
                    search
                  </span>
                  <input class="w-full h-13 py-3.5 pl-12 pr-10 rounded-lg bg-surface-container-low text-on-surface font-headline-sm text-headline-sm focus:bg-surface-container-lowest focus:outline-none focus:ring-2 focus:ring-secondary transition-all" id="omni-search-input" placeholder="<?php echo rc_escape(
                    $input_placeholder,
                  ); ?>" type="text" value="<?php echo $search_value; ?>"/>
                  <button class="absolute right-space-md text-on-surface-variant hover:text-on-surface p-1 rounded" data-action="clear-search" title="Xóa" type="button">
                    <span class="material-symbols-outlined text-[20px]">
                      cancel
                    </span>
                  </button>
                </div>
                <button class="w-full sm:w-auto h-13 px-space-xl py-3.5 rounded-lg bg-primary hover:bg-secondary text-on-primary font-label-lg text-label-lg font-semibold flex items-center justify-center gap-space-xs shadow transition-all whitespace-nowrap" type="submit">
                  <span>
                    Tra cứu
                  </span>
                  <span class="material-symbols-outlined text-[18px]">
                    arrow_forward
                  </span>
                </button>
              </form>
            </div>
          </div>
        </section>
        <!-- Direct 2-Card Result Section -->
        <section class="w-full max-w-[1040px] mx-auto px-margin pb-space-xl" id="lookup-results-section">
          <?php if ($lookup_value !== "" && $lookup_error !== ""): ?>
          <div class="mb-space-md rounded-xl border border-surface-container bg-surface-container-lowest px-space-md py-space-sm text-body-sm text-on-surface-variant">
            <?php echo rc_escape($lookup_error); ?>
          </div>
          <?php elseif ($lookup_result): ?>
          <div class="mb-space-md rounded-xl border border-surface-container bg-surface-container-lowest px-space-md py-space-sm text-body-sm text-on-surface-variant">
            Đã tìm thấy thông tin khách hàng: <strong class="text-primary"><?php echo rc_escape(
              $customer_name,
            ); ?></strong>
            · SĐT: <strong class="text-primary"><?php echo rc_escape(
              $customer_phone,
            ); ?></strong>
          </div>
          <?php endif; ?>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg items-stretch">
            <!-- Thẻ 1: Thời hạn bảo hành -->
            <div class="bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm flex flex-col justify-between">
              <div>
                <div class="flex items-start justify-between gap-space-sm pb-space-sm border-b border-surface-container">
                  <div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">
                      Thời hạn bảo hành
                    </span>
                    <h3 class="font-headline-md text-headline-md text-primary mt-0.5">
                      <?php echo rc_escape($device_name); ?>
                    </h3>
                  </div>
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full <?php echo $status_class; ?> font-label-sm text-label-sm font-bold">
                    <span class="w-2 h-2 rounded-full bg-emerald-600">
                    </span>
                    <span>
                      <?php echo rc_escape(
                        $lookup_result ? "Có dữ liệu" : "Chưa có dữ liệu",
                      ); ?>
                    </span>
                  </span>
                </div>
                <div class="grid grid-cols-2 gap-space-sm my-space-md p-space-md bg-surface-container-low rounded-lg">
                  <div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">
                      Ngày tiếp nhận
                    </span>
                    <div class="font-headline-sm text-headline-sm text-primary font-semibold mt-0.5">
                      <?php echo rc_date(
                        $lookup_result["received_date"] ?? null,
                      ); ?>
                    </div>
                  </div>
                  <div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">
                      Serial / IMEI
                    </span>
                    <div class="font-headline-sm text-headline-sm text-primary font-semibold mt-0.5">
                      <?php echo rc_escape($serial_imei); ?>
                    </div>
                  </div>
                </div>
                <div class="flex items-center justify-between text-body-sm text-body-sm text-on-surface-variant pt-1">
                  <span>
                    Khách hàng: <?php echo rc_escape(
                      $customer_name,
                    ); ?> | SĐT: <?php echo rc_escape($customer_phone); ?>
                  </span>
                  <span class="font-medium text-secondary">
                    Chi phí: <?php echo rc_money($total_cost); ?>
                  </span>
                </div>
              </div>
              <div class="pt-space-md mt-space-md border-t border-surface-container">
                <a class="inline-flex items-center justify-center gap-1 w-full h-10 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-md text-label-md font-medium transition-colors" data-path="so-bao-hanh-dien-tu" href="#">
                  <span class="material-symbols-outlined text-[18px]">
                    verified
                  </span>
                  <span>
                    Xem sổ bảo hành điện tử
                  </span>
                </a>
              </div>
            </div>
            <!-- Thẻ 2: Tình trạng sửa chữa -->
            <div class="bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm flex flex-col justify-between">
              <div>
                <div class="flex items-start justify-between gap-space-sm pb-space-sm border-b border-surface-container">
                  <div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold">
                      Tiến độ sửa chữa
                    </span>
                    <h3 class="font-headline-md text-headline-md text-primary mt-0.5">
                      <?php echo rc_escape($booking_code); ?>
                    </h3>
                  </div>
                  <span class="px-2.5 py-1 rounded bg-secondary-fixed text-primary font-label-sm text-label-sm font-bold">
                    <?php echo $lookup_result
                      ? "Bước " . $repair_step . "/5"
                      : "Chưa có dữ liệu"; ?>
                  </span>
                </div>
                <div class="my-space-md p-space-md bg-surface-container-low rounded-lg">
                  <span class="font-label-sm text-label-sm text-on-surface-variant">
                    Trạng thái hiện tại
                  </span>
                  <div class="font-headline-sm text-headline-sm text-secondary font-bold mt-0.5">
                    <?php
                    echo rc_escape($status_text);
                    echo $repair_percent > 0
                      ? " - " . $repair_percent . "%"
                      : "";
                    ?>
                  </div>
                  <p class="font-body-sm text-body-sm text-on-surface-variant mt-1.5">
                    <?php echo rc_escape(
                      $error_description !== ""
                        ? $error_description
                        : ($lookup_result
                          ? "Chưa có mô tả sự cố trong dữ liệu đặt lịch."
                          : "Nhập số điện thoại, mã phiếu hoặc Serial / IMEI để xem thông tin."),
                    ); ?>
                  </p>
                </div>
                <div class="flex items-center justify-between text-body-sm text-body-sm text-on-surface-variant pt-1">
                  <span>
                    Tiếp nhận: <?php echo rc_date($received_date); ?>
                  </span>
                  <span>
                    KTV: <?php echo rc_escape($technician_name); ?>
                  </span>
                </div>
              </div>
              <div class="pt-space-md mt-space-md border-t border-surface-container">
                <a class="inline-flex items-center justify-center gap-1 w-full h-10 rounded-lg bg-primary hover:bg-secondary text-on-primary font-label-md text-label-md font-semibold transition-colors" data-path="tra-cuu-tien-do" href="#">
                  <span>
                    Xem chi tiết tiến độ &amp; duyệt báo giá
                  </span>
                  <span class="material-symbols-outlined text-[18px]">
                    arrow_forward
                  </span>
                </a>
              </div>
            </div>
          </div>
        </section>
        <!-- Minimal Announcements Section (1-2 clean banners) -->
        <section class="w-full max-w-[1040px] mx-auto px-margin pb-space-xl">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
            <!-- Banner 1: Ưu đãi pin -->
            <div class="bg-surface-container-lowest border border-surface-container rounded-xl p-space-md flex items-center justify-between gap-space-md shadow-sm">
              <div class="flex items-start gap-space-sm">
                <div class="w-10 h-10 rounded-lg bg-secondary-fixed text-primary flex items-center justify-center shrink-0">
                  <span class="material-symbols-outlined text-[22px]">
                    battery_charging_full
                  </span>
                </div>
                <div>
                  <h4 class="font-headline-sm text-headline-sm text-primary">
                    Ưu Đãi 30% Thay Pin Chính Hãng
                  </h4>
                  <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                    Áp dụng khi đặt lịch sửa chữa trực tuyến trong tuần này.
                  </p>
                </div>
              </div>
              <a class="shrink-0 px-space-sm py-2 rounded-lg bg-surface-container hover:bg-secondary hover:text-on-secondary text-primary font-label-md text-label-md font-semibold transition-colors" data-path="dat-lich-hen" href="dat-lich-hen.php">
                Đặt lịch
              </a>
            </div>
            <!-- Banner 2: Lịch phục vụ -->
            <div class="bg-surface-container-lowest border border-surface-container rounded-xl p-space-md flex items-center justify-between gap-space-md shadow-sm">
              <div class="flex items-start gap-space-sm">
                <div class="w-10 h-10 rounded-lg bg-surface-container text-primary flex items-center justify-center shrink-0">
                  <span class="material-symbols-outlined text-[22px]">
                    event_available
                  </span>
                </div>
                <div>
                  <h4 class="font-headline-sm text-headline-sm text-primary">
                    Phục Vụ Xuyên Suốt Lễ 30/4 - 1/5
                  </h4>
                  <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                    Tất cả chi nhánh mở cửa 08:00 - 21:00 hàng ngày.
                  </p>
                </div>
              </div>
              <a class="shrink-0 px-space-sm py-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-label-md text-label-md font-semibold transition-colors" data-path="tra-cuu-chi-nhanh" href="#">
                Chi nhánh
              </a>
            </div>
          </div>
        </section>
        <!-- Interactive JavaScript -->
      </div>
    </main>
    <footer class="w-full bg-surface-container-lowest border-t border-surface-container py-space-lg">
      <div class="max-w-[1040px] mx-auto px-margin flex flex-col sm:flex-row items-center justify-between gap-space-md text-body-sm text-body-sm text-on-surface-variant">
        <div class="flex items-center gap-space-sm">
          <img alt="ReliantCare Logo" class="site-logo h-6 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFQit0nSEGzWIX2Hs1fbneLlx7PZPUL5u44rQddKG3LZzxBRtLbh6Oj0JO8t2fv-8peBpQi_ccVp7l5NLJqj3_Gunplze4QcWNvFpTUW1OJG-V4gILP0YsiG3En89FCd2w5OtxM9i_2V1MIZ8-frYYOhSI0Q1dpzawU_-ge9PoygpMMNkvQLt8MnCCJRqRq2IoPlgkMt3QpR5Bw224matMkjgJXNwrtslv8qSmYURpTJlE6gGlU6DpIg"/>
          <span class="font-headline-sm text-body-md text-primary font-bold">
            ReliantCare Việt Nam
          </span>
          <span>
            •
          </span>
          <span>
            Hotline:
            <strong class="text-primary font-semibold">
              1800 6868
            </strong>
            (Miễn phí)
          </span>
        </div>
        <div class="flex items-center gap-space-md">
          <span>
            © 2025 ReliantCare VN
          </span>
          <a class="hover:text-primary transition-colors" data-path="tra-cuu-chi-nhanh" href="#">
            Hệ thống trung tâm
          </a>
          <a class="hover:text-primary transition-colors" data-path="dieu-khoan-dich-vu" href="#">
            Chính sách bảo hành
          </a>
        </div>
      </div>
    </footer>
    <script>
      (function () {
        document.addEventListener('submit', function (event) {
          const form = event.target.closest('[data-search-form="lookup"]');
          if (!form) return;

          event.preventDefault();
          event.stopImmediatePropagation();

          const input = document.getElementById('omni-search-input');
          if (!input || !input.value.trim()) {
            alert('Vui lòng nhập thông tin để tra cứu.');
            if (input) input.focus();
            return;
          }

          let lookupType = 'rma';
          const activeTab = document.querySelector('.search-tab-btn.bg-primary');
          if (activeTab && activeTab.dataset.lookupTab) {
            lookupType = activeTab.dataset.lookupTab;
          }

          const url = new URL(window.location.href);
          url.searchParams.set('lookup_type', lookupType);
          url.searchParams.set('lookup', input.value.trim());
          window.location.href = url.toString();
        }, true);
      })();
    </script>

  </body>
</html>
