<?php
require "db.php";
session_start();
$account_id = (int) ($_SESSION["account_id"] ?? 0);
$lookup_code = trim((string) ($_GET["booking"] ?? ""));
$tracking = null;
if ($lookup_code !== "") {
  $stmt = $pdo->prepare(
    "SELECT b.*, c.full_name, c.phone, d.device_name, d.imei_serial, r.status AS repair_status, r.progress_percent, r.received_date, r.total_cost FROM booking_requests b JOIN customers c ON c.customer_id = b.customer_id JOIN devices d ON d.device_id = b.device_id LEFT JOIN repairs r ON r.repair_id = (SELECT MAX(r2.repair_id) FROM repairs r2 WHERE r2.device_id = b.device_id) WHERE b.booking_code = ? AND (c.account_id = ? OR ? = 0) LIMIT 1",
  );
  $stmt->execute([$lookup_code, $account_id, $account_id]);
  $tracking = $stmt->fetch();
} elseif ($account_id > 0) {
  $stmt = $pdo->prepare(
    "SELECT b.*, c.full_name, c.phone, d.device_name, d.imei_serial, r.status AS repair_status, r.progress_percent, r.received_date, r.total_cost FROM booking_requests b JOIN customers c ON c.customer_id = b.customer_id JOIN devices d ON d.device_id = b.device_id LEFT JOIN repairs r ON r.repair_id = (SELECT MAX(r2.repair_id) FROM repairs r2 WHERE r2.device_id = b.device_id) WHERE c.account_id = ? ORDER BY b.created_at DESC LIMIT 1",
  );
  $stmt->execute([$account_id]);
  $tracking = $stmt->fetch();
}
if (!$tracking && $account_id > 0) {
  $tracking = [
    "booking_code" => "Chưa có phiếu",
    "repair_status" => "Chưa có dữ liệu",
    "status" => "Chưa có dữ liệu",
    "progress_percent" => 0,
    "received_date" => "-",
    "device_name" => "Chưa có thiết bị",
    "imei_serial" => "",
    "full_name" => "",
    "phone" => "",
    "branch_name" => "-",
    "appointment_date" => "-",
    "appointment_time" => "-",
    "error_description" => "Tài khoản chưa có phiếu tiếp nhận.",
    "total_cost" => 0,
  ];
}
$tracking_percent = (int) ($tracking["progress_percent"] ?? 0);
$tracking_status =
  $tracking["repair_status"] ?? ($tracking["status"] ?? "Đã tiếp nhận");
$step_statuses = [
  "Đã tiếp nhận",
  "Đang chẩn đoán",
  "Chờ duyệt báo giá",
  "Đang sửa",
  "Hoàn thành",
];
$current_step =
  $tracking_status === "Hoàn thành"
    ? 5
    : ($tracking_status === "Đang sửa"
      ? 4
      : ($tracking_percent >= 40
        ? 3
        : ($tracking_percent >= 20
          ? 2
          : 1)));
$tracking_media = json_decode($tracking["media_paths"] ?? "[]", true);
if (!is_array($tracking_media)) {
  $tracking_media = [];
}
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
    <style>body.has-database-tracking main > div > #database-tracking-view ~ * { display: none; }</style>
  </head>
  <body class="bg-surface font-body-md text-body-md text-on-surface antialiased<?php echo $tracking
    ? " has-database-tracking"
    : ""; ?>" data-auth-gate>
    <!-- Header with 5 standard navigation items -->
    <header class="site-header fixed top-0 w-full z-50 bg-surface-container-lowest border-b border-surface-container shadow-sm">
      <div class="h-20 max-w-[1440px] mx-auto px-margin flex items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-lg">
          <a class="flex items-center gap-space-sm shrink-0" data-path="trang-chu" href="#">
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
          <!-- Standard 5 navigation items with active highlight -->
          <nav class="site-nav hidden xl:flex items-center gap-1">
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="trang-chu" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">search</span>
              <span>Tra cứu</span><link href="trang-chu.php"/>
            </a>
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dat-lich" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">build</span>
              <span>Bảo hành &amp; Sửa chữa</span><link href="dat-lich-hen.php"/>
            </a>
            <a aria-current="page" class="px-space-sm py-2 rounded-lg font-label-md text-label-md bg-primary-container text-on-primary font-bold shadow-sm" data-path="theo-doi-tien-do" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">track_changes</span>
              <span>Theo dõi</span><link href="tra-cuu-tien-do.php"/>
            </a>
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="thiet-bi-lich-su" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">devices</span>
              <span>Thiết bị</span><link href="thiet-bi-lich-su.php"/>
            </a>
            <a class="px-space-sm py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="chi-nhanh-ho-tro" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">location_on</span>
              <span>Chi nhánh</span><link href="tra-cuu-chi-nhanh.php"/>
            </a>
          </nav>
        </div>
        <div class="site-actions flex items-center gap-space-md">
          <div class="hidden md:flex items-center gap-space-xs px-space-sm py-1.5 bg-surface-container rounded-lg">
            <span class="material-symbols-outlined text-secondary text-[20px]">
              support_agent
            </span>
            <div class="flex flex-col">
              <span class="font-label-sm text-label-sm text-on-surface-variant leading-none">
                Tổng đài 24/7
              </span>
              <a class="font-headline-sm text-headline-sm text-primary leading-tight hover:text-secondary transition-colors" href="tel:18006868">
                1800 6868
              </a>
            </div>
          </div>
          <a class="site-action-link inline-flex items-center gap-1.5 h-10 px-3 bg-primary hover:bg-secondary text-on-primary font-label-md text-label-md rounded-lg shadow-sm transition-all" data-path="dat-lich-hen" href="dat-lich-hen.php">
            <span class="material-symbols-outlined text-[18px]">calendar_month</span>
            <span>Đặt lịch</span>
          </a>
          <div class="flex items-center gap-space-sm">
            <button class="flex items-center gap-1 font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors px-space-xs py-space-xs rounded" type="button">
              <span class="material-symbols-outlined text-[18px]">
                language
              </span>
              <span class="font-semibold">
                VIE
              </span>
            </button>
            <a class="site-account" data-auth-action="logout" data-path="tai-khoan" href="#" aria-label="Đăng nhập" title="Đăng nhập">
              <span class="material-symbols-outlined text-[20px]">person</span>
            </a>
          </div>
        </div>
      </div>
    </header>
    <main class="w-full pt-20 bg-surface">
      <div class="max-w-[1200px] mx-auto w-full px-margin py-space-lg flex flex-col gap-space-lg">
        <?php if ($tracking): ?>
        <section id="database-tracking-view" class="flex flex-col gap-space-lg">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md pb-space-xs border-b border-surface-container"><div><p class="font-label-md text-label-md text-on-surface-variant">Theo dõi phiếu sửa chữa</p><h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">Tiến Độ &amp; Duyệt Báo Giá</h1><p class="font-body-md text-body-md text-on-surface-variant">Mã phiếu: <strong class="text-secondary"><?php echo htmlspecialchars(
            $tracking["booking_code"],
          ); ?></strong></p></div><span class="font-label-md text-label-md bg-primary-fixed text-primary px-3 py-2 rounded-lg"><?php echo htmlspecialchars(
  $tracking_status,
); ?></span></div>
          <section class="w-full bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-surface-container"><div class="flex items-center justify-between pb-space-md border-b border-surface-container mb-space-md"><h2 class="font-headline-sm text-headline-sm text-primary">Tiến Độ Quy Trình 5 Bước</h2><span class="font-label-md text-label-md text-secondary"><?php echo $tracking_percent; ?>% hoàn tất</span></div><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-space-md">
            <?php foreach ($step_statuses as $index => $step):

              $step_number = $index + 1;
              $is_done = $step_number <= $current_step;
              $is_current = $step_number === $current_step;
              ?><article class="p-space-sm rounded-lg border <?php echo $is_current
  ? "border-amber-400 bg-amber-50"
  : ($is_done
    ? "border-emerald-200 bg-emerald-50"
    : "border-surface-container bg-surface-container-low"); ?>"><div class="flex items-center justify-between"><span class="w-7 h-7 rounded-full <?php echo $is_current
  ? "bg-amber-500"
  : ($is_done
    ? "bg-emerald-600"
    : "bg-surface-variant"); ?> text-on-primary flex items-center justify-center font-bold"><?php echo $is_done &&
 !$is_current
   ? "✓"
   : $step_number; ?></span><span class="font-label-sm text-label-sm"><?php echo $is_current
  ? "Hiện tại"
  : ($is_done
    ? "Hoàn tất"
    : "Đang chờ"); ?></span></div><h3 class="font-headline-sm text-headline-sm text-primary mt-2"><?php echo $step_number .
  ". " .
  htmlspecialchars(
    $step,
  ); ?></h3><p class="font-body-sm text-body-sm text-on-surface-variant"><?php echo $step_number ===
1
  ? htmlspecialchars($tracking["received_date"])
  : ($is_done
    ? "Đã cập nhật trong hồ sơ"
    : "Chưa cập nhật"); ?></p></article><?php
            endforeach; ?>
          </div></section>
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg"><section class="bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm"><h2 class="font-headline-sm text-headline-sm text-primary border-b border-surface-container pb-space-sm mb-space-sm">Thông Tin Phiếu Tiếp Nhận</h2><div class="flex flex-col gap-space-xs font-body-sm text-body-sm"><div class="flex justify-between py-1 border-b border-surface-container-low"><span>Thiết bị</span><strong class="text-primary text-right"><?php echo htmlspecialchars(
            $tracking["device_name"],
          ); ?></strong></div><div class="flex justify-between py-1 border-b border-surface-container-low"><span>Số Serial</span><strong><?php echo htmlspecialchars(
  $tracking["imei_serial"] ?: "Chưa cập nhật",
); ?></strong></div><div class="flex justify-between py-1 border-b border-surface-container-low"><span>Khách hàng</span><strong><?php echo htmlspecialchars(
  $tracking["full_name"],
); ?></strong></div><div class="flex justify-between py-1 border-b border-surface-container-low"><span>Số điện thoại</span><strong><?php echo htmlspecialchars(
  $tracking["phone"],
); ?></strong></div><div class="flex justify-between py-1 border-b border-surface-container-low"><span>Chi nhánh</span><strong><?php echo htmlspecialchars(
  $tracking["branch_name"],
); ?></strong></div><div class="flex justify-between py-1"><span>Ngày/giờ hẹn</span><strong class="text-secondary"><?php echo htmlspecialchars(
  $tracking["appointment_date"] . " " . $tracking["appointment_time"],
); ?></strong></div></div><div class="bg-surface-container-low p-space-sm rounded-lg mt-space-md text-body-sm text-on-surface-variant"><strong class="text-primary block">Lỗi ghi nhận:</strong><?php echo htmlspecialchars(
  $tracking["error_description"],
); ?></div></section><section class="bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm"><h2 class="font-headline-sm text-headline-sm text-primary border-b border-surface-container pb-space-sm mb-space-sm">Bảng Báo Giá Chi Tiết &amp; Duyệt Trực Tuyến</h2><div class="flex justify-between py-3 border-b border-surface-container"><span>Chi phí hiện tại trong hồ sơ</span><strong class="text-secondary text-xl"><?php echo number_format(
  (float) ($tracking["total_cost"] ?? 0),
  0,
  ",",
  ".",
); ?> VNĐ</strong></div><p class="font-body-sm text-body-sm text-on-surface-variant mt-3">Báo giá sẽ được cập nhật khi kỹ thuật viên hoàn tất chẩn đoán.</p></section></div>
          <?php if ($tracking_media): ?>
          <section class="bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm">
            <h2 class="font-headline-sm text-headline-sm text-primary mb-space-sm">Ảnh/video hiện trạng</h2>
            <div class="flex flex-wrap gap-space-sm">
              <?php foreach ($tracking_media as $media_path): ?>
              <?php $media_url = htmlspecialchars(
                $media_path,
                ENT_QUOTES,
                "UTF-8",
              ); ?>
              <?php if (
                strtolower(pathinfo($media_path, PATHINFO_EXTENSION)) === "mp4"
              ): ?>
              <video class="w-48 max-w-full rounded-lg border border-surface-container" controls preload="metadata" src="<?php echo $media_url; ?>"></video>
              <?php else: ?>
              <a class="block w-32 h-32 overflow-hidden rounded-lg border border-surface-container" href="<?php echo $media_url; ?>" target="_blank" rel="noopener">
                <img class="w-full h-full object-cover" src="<?php echo $media_url; ?>" alt="Ảnh hiện trạng thiết bị" loading="lazy"/>
              </a>
              <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </section>
          <?php endif; ?>
        </section>
        <?php endif; ?>
        <!-- 1. HEADER & QUICK TICKET LOOKUP -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md pb-space-xs border-b border-surface-container">
          <div>
            <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-on-surface-variant font-label-md text-label-md mb-1">
              <a class="hover:text-secondary transition-colors" href="#">
                Trang chủ
              </a>
              <span class="material-symbols-outlined text-[14px]">
                chevron_right
              </span>
              <span class="text-on-surface-variant">
                Tiến độ &amp; Báo giá
              </span>
              <span class="material-symbols-outlined text-[14px]">
                chevron_right
              </span>
              <span class="font-bold text-primary">
                #RMA-2025-8892
              </span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">
              Theo Dõi Tiến Độ &amp; Duyệt Báo Giá
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
              Xác nhận phương án kỹ thuật trực tuyến nhanh chóng, minh bạch và an toàn.
            </p>
          </div>
          <div class="flex items-center gap-2 bg-surface-container-lowest p-1.5 rounded-xl border border-surface-container shadow-sm self-start md:self-center" data-auth-private>
            <div class="flex items-center gap-1 px-space-sm py-1 bg-surface-container rounded-lg">
              <span class="material-symbols-outlined text-outline text-[18px]">
                search
              </span>
              <input class="bg-transparent text-primary font-body-sm text-body-sm w-44 sm:w-56 focus:outline-none placeholder-outline" placeholder="Mã phiếu / IMEI khác..." type="text" value="RMA-2025-8892"/>
            </div>
            <button class="h-9 px-space-md rounded-lg bg-primary hover:bg-secondary text-on-primary font-label-md text-label-md transition-colors shadow-sm" type="button">
              Tra cứu
            </button>
          </div>
        </div>
        <!-- 2. THANH TIẾN TRÌNH 5 MỐC RÕ NÉT -->
        <section aria-label="Thanh tiến trình sửa chữa" class="w-full bg-surface-container-lowest rounded-xl p-space-lg shadow-sm border border-surface-container" data-auth-private>
          <div class="flex items-center justify-between pb-space-md border-b border-surface-container mb-space-md">
            <div class="flex items-center gap-space-xs">
              <span class="material-symbols-outlined text-secondary text-[22px]">
                linear_scale
              </span>
              <h2 class="font-headline-sm text-headline-sm text-primary">
                Tiến Độ Quy Trình 5 Bước
              </h2>
            </div>
            <div class="flex items-center gap-space-md text-on-surface-variant font-label-sm text-label-sm">
              <span class="flex items-center gap-1">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600">
                </span>
                Đã hoàn tất
              </span>
              <span class="flex items-center gap-1">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500">
                </span>
                Cần duyệt
              </span>
              <span class="flex items-center gap-1">
                <span class="w-2.5 h-2.5 rounded-full bg-outline-variant">
                </span>
                Đang chờ
              </span>
            </div>
          </div>
          <!-- 5-Step Connected Flow -->
          <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-space-md">
            <!-- Mốc 1: Tiếp nhận -->
            <div class="flex flex-col gap-1.5 p-space-sm rounded-lg bg-emerald-50/70 border border-emerald-200">
              <div class="flex items-center justify-between">
                <span class="w-7 h-7 rounded-full bg-emerald-600 text-on-primary flex items-center justify-center font-label-sm font-bold">
                  <span class="material-symbols-outlined text-[16px]">
                    check
                  </span>
                </span>
                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold">
                  Hoàn tất
                </span>
              </div>
              <h3 class="font-headline-sm text-headline-sm text-primary mt-1">
                1. Tiếp nhận
              </h3>
              <p class="font-label-sm text-label-sm text-on-surface-variant">
                09:15 • 25/10/2025
              </p>
              <p class="font-body-sm text-body-sm text-on-surface-variant">
                Hub Thái Hà tiếp nhận &amp; niêm phong máy.
              </p>
            </div>
            <!-- Mốc 2: Chẩn đoán -->
            <div class="flex flex-col gap-1.5 p-space-sm rounded-lg bg-emerald-50/70 border border-emerald-200">
              <div class="flex items-center justify-between">
                <span class="w-7 h-7 rounded-full bg-emerald-600 text-on-primary flex items-center justify-center font-label-sm font-bold">
                  <span class="material-symbols-outlined text-[16px]">
                    check
                  </span>
                </span>
                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold">
                  Hoàn tất
                </span>
              </div>
              <h3 class="font-headline-sm text-headline-sm text-primary mt-1">
                2. Chẩn đoán
              </h3>
              <p class="font-label-sm text-label-sm text-on-surface-variant">
                10:45 • Hôm nay
              </p>
              <p class="font-body-sm text-body-sm text-on-surface-variant">
                Xác định lỗi cáp eDP, tấm nền còn tốt.
              </p>
            </div>
            <!-- Mốc 3: Báo giá (Hiện tại - Cần duyệt) -->
            <div class="flex flex-col gap-1.5 p-space-sm rounded-lg bg-amber-50 border-2 border-amber-400 shadow-sm" id="step-node-3">
              <div class="flex items-center justify-between">
                <span class="w-7 h-7 rounded-full bg-amber-500 text-on-primary flex items-center justify-center font-label-sm font-bold" id="step-node-3-icon">
                  3
                </span>
                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-amber-200 text-amber-900 font-bold" id="step-node-3-badge">
                  Chờ bạn duyệt
                </span>
              </div>
              <h3 class="font-headline-sm text-headline-sm text-amber-950 font-bold mt-1">
                3. Báo giá
              </h3>
              <p class="font-label-sm text-label-sm text-amber-800">
                11:30 • Hôm nay
              </p>
              <p class="font-body-sm text-body-sm text-amber-900 leading-snug">
                Vui lòng kiểm tra chi phí và nhấn duyệt bên dưới.
              </p>
            </div>
            <!-- Mốc 4: Đang xử lý -->
            <div class="flex flex-col gap-1.5 p-space-sm rounded-lg bg-surface-container-low border border-surface-container transition-all" id="step-node-4">
              <div class="flex items-center justify-between">
                <span class="w-7 h-7 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-label-sm font-bold" id="step-node-4-icon">
                  4
                </span>
                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-medium" id="step-node-4-badge">
                  Tiếp theo
                </span>
              </div>
              <h3 class="font-headline-sm text-headline-sm text-primary mt-1">
                4. Đang xử lý
              </h3>
              <p class="font-label-sm text-label-sm text-on-surface-variant">
                Dự kiến ~120 phút
              </p>
              <p class="font-body-sm text-body-sm text-on-surface-variant">
                Tiến hành ngay sau khi nhận phê duyệt.
              </p>
            </div>
            <!-- Mốc 5: Chờ nhận máy -->
            <div class="flex flex-col gap-1.5 p-space-sm rounded-lg bg-surface-container-low border border-surface-container">
              <div class="flex items-center justify-between">
                <span class="w-7 h-7 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-label-sm font-bold">
                  5
                </span>
                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-medium">
                  16:30 hôm nay
                </span>
              </div>
              <h3 class="font-headline-sm text-headline-sm text-primary mt-1">
                5. Chờ nhận máy
              </h3>
              <p class="font-label-sm text-label-sm text-on-surface-variant">
                Bàn giao &amp; Kiểm tra
              </p>
              <p class="font-body-sm text-body-sm text-on-surface-variant">
                Nhận tại cửa hàng hoặc giao tận nhà.
              </p>
            </div>
          </div>
        </section>
        <!-- 3. THÔNG TIN THIẾT BỊ & KẾT QUẢ CHẨN ĐOÁN LỖI -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg" data-auth-private>
          <!-- Thông tin phiếu & Thiết bị (5 cột) -->
          <div class="lg:col-span-5 bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm flex flex-col gap-space-md">
            <div class="flex items-center justify-between border-b border-surface-container pb-space-sm">
              <h3 class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[20px]">
                  laptop_mac
                </span>
                Thông Tin Phiếu Tiếp Nhận
              </h3>
              <span class="font-label-sm text-label-sm font-bold text-secondary bg-surface-container px-2 py-0.5 rounded">
                RMA-2025-8892
              </span>
            </div>
            <div class="flex flex-col gap-space-xs font-body-sm text-body-sm">
              <div class="flex justify-between py-1 border-b border-surface-container-low">
                <span class="text-on-surface-variant">
                  Thiết bị:
                </span>
                <strong class="text-primary font-medium text-right">
                  MacBook Pro 14" M2 Pro (2023)
                </strong>
              </div>
              <div class="flex justify-between py-1 border-b border-surface-container-low">
                <span class="text-on-surface-variant">
                  Số Serial:
                </span>
                <span class="font-mono text-on-surface font-semibold">
                  C02GG9VCMD6R
                </span>
              </div>
              <div class="flex justify-between py-1 border-b border-surface-container-low" data-auth-private>
                <span class="text-on-surface-variant">
                  Khách hàng:
                </span>
                <span class="text-on-surface" data-auth-blank>
                  Nguyễn Hoàng Minh
                </span>
              </div>
              <div class="flex justify-between py-1 border-b border-surface-container-low" data-auth-private>
                <span class="text-on-surface-variant">
                  Số điện thoại:
                </span>
                <span class="text-on-surface" data-auth-blank>
                  0918 293 847
                </span>
              </div>
              <div class="flex justify-between py-1">
                <span class="text-on-surface-variant">
                  Chi nhánh tiếp nhận:
                </span>
                <span class="text-on-surface font-medium">
                  Hub 124 Thái Hà, Đống Đa, HN
                </span>
              </div>
            </div>
            <div class="bg-surface-container-low p-space-sm rounded-lg text-body-sm text-on-surface-variant">
              <strong class="text-primary block font-label-md text-label-md mb-0.5">
                Tình trạng lúc gửi máy:
              </strong>
              Màn hình chớp nháy sọc khi gập mở góc 45°-90°. Vỏ máy xước nhẹ góc đáy bên trái, tem niêm phong đầy đủ.
            </div>
          </div>
          <!-- Trạng thái chẩn đoán & Nguyên nhân lỗi ngắn gọn (7 cột) -->
          <div class="lg:col-span-7 bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm flex flex-col justify-between gap-space-md">
            <div>
              <div class="flex items-center justify-between border-b border-surface-container pb-space-sm mb-space-sm">
                <h3 class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
                  <span class="material-symbols-outlined text-secondary text-[20px]">
                    medical_services
                  </span>
                  Kết Quả Chẩn Đoán Kỹ Thuật
                </h3>
                <span class="font-label-sm text-label-sm text-emerald-800 bg-emerald-100 font-semibold px-2 py-0.5 rounded">
                  Đã xác minh
                </span>
              </div>
              <div class="flex items-center gap-space-sm mb-space-sm">
                <div class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-label-sm">
                  TH
                </div>
                <div class="flex flex-col text-body-sm">
                  <span class="font-headline-sm text-headline-sm text-primary">
                    KTV Trần Minh Hoàng
                    <span class="font-normal text-body-sm text-on-surface-variant">
                      (Chứng chỉ ACMT #8849)
                    </span>
                  </span>
                  <span class="text-on-surface-variant">
                    Bàn kỹ thuật 03 • Phòng sạch vô trùng
                  </span>
                </div>
              </div>
              <div class="p-space-md rounded-xl bg-surface-container-low flex flex-col gap-2">
                <p class="font-body-md text-body-md text-on-surface">
                  <strong>
                    Nguyên nhân lỗi:
                  </strong>
                  Cụm cáp tín hiệu
                  <strong>
                    eDP Flexible Cable
                  </strong>
                  bị mỏi cơ học và đứt vi mạch ngầm do tần suất gập mở lâu ngày.
                </p>
                <p class="font-body-md text-body-md text-on-surface">
                  <strong>
                    Tình trạng linh kiện gốc:
                  </strong>
                  Tấm nền màn hình Liquid Retina XDR và mặt kính hiển thị còn nguyên vẹn 100%, không cần thay cụm màn hình.
                </p>
                <div class="flex items-center gap-2 pt-1 text-emerald-700 font-label-md text-label-md">
                  <span class="material-symbols-outlined text-[18px]">
                    check_circle
                  </span>
                  <span>
                    Phương án tối ưu: Chỉ thay thế cáp eDP chính hãng, tiết kiệm đáng kể chi phí cho quý khách.
                  </span>
                </div>
              </div>
            </div>
            <div class="pt-space-xs border-t border-surface-container flex items-center justify-between text-body-sm text-on-surface-variant">
              <span>
                Báo cáo kỹ thuật chi tiết đã lưu vào hồ sơ điện tử
              </span>
              <a class="text-secondary hover:underline font-medium inline-flex items-center gap-1" href="#">
                <span class="material-symbols-outlined text-[16px]">
                  description
                </span>
                Tải phiếu (.PDF)
              </a>
            </div>
          </div>
        </div>
        <!-- 4. BẢNG DUYỆT BÁO GIÁ MINH BẠCH & 2 NÚT QUYẾT ĐỊNH CHÍNH -->
        <section class="w-full bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm flex flex-col gap-space-md" data-auth-private>
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-space-sm border-b border-surface-container">
            <div>
              <h2 class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[22px]">
                  receipt_long
                </span>
                Bảng Báo Giá Chi Tiết &amp; Duyệt Trực Tuyến
              </h2>
              <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                Bóc tách rõ ràng tiền công, linh kiện thay thế và chính sách bảo hành.
              </p>
            </div>
            <span class="font-label-sm text-label-sm text-amber-800 bg-amber-100 font-bold px-3 py-1 rounded-full self-start sm:self-center">
              Hạn xác nhận: 14:00 hôm nay
            </span>
          </div>
          <!-- Bảng giá -->
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr class="bg-surface-container font-label-md text-label-md text-primary">
                  <th class="py-space-sm px-space-md rounded-l-lg">
                    Hạng mục sửa chữa
                  </th>
                  <th class="py-space-sm px-space-md">
                    Phân loại &amp; Ghi chú
                  </th>
                  <th class="py-space-sm px-space-md text-center">
                    Bảo hành
                  </th>
                  <th class="py-space-sm px-space-md text-right">
                    Đơn giá
                  </th>
                  <th class="py-space-sm px-space-md rounded-r-lg text-right">
                    Thành tiền
                  </th>
                </tr>
              </thead>
              <tbody class="font-body-md text-body-md divide-y divide-surface-container">
                <!-- Item 1: Linh kiện -->
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                  <td class="py-space-md px-space-md font-medium text-primary">
                    1. Cáp tín hiệu eDP Flexible Cable chính hãng OEM
                  </td>
                  <td class="py-space-md px-space-md text-on-surface-variant text-body-sm">
                    Linh kiện thay thế chuẩn Part No: 923-0892 cho MacBook Pro 14"
                  </td>
                  <td class="py-space-md px-space-md text-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-surface-container text-secondary font-label-sm text-label-sm font-semibold">
                      12 tháng 1-đổi-1
                    </span>
                  </td>
                  <td class="py-space-md px-space-md text-right text-on-surface">
                    1.450.000 đ
                  </td>
                  <td class="py-space-md px-space-md text-right font-bold text-primary">
                    1.450.000 đ
                  </td>
                </tr>
                <!-- Item 2: Công tháo lắp -->
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                  <td class="py-space-md px-space-md font-medium text-primary">
                    2. Tiền công kỹ thuật &amp; bảo dưỡng nhiệt
                  </td>
                  <td class="py-space-md px-space-md text-on-surface-variant text-body-sm">
                    Công bóc tách phòng sạch, vệ sinh quạt kép và tra keo tản nhiệt MX-4
                  </td>
                  <td class="py-space-md px-space-md text-center text-on-surface-variant text-body-sm">
                    Theo máy
                  </td>
                  <td class="py-space-md px-space-md text-right line-through text-outline">
                    350.000 đ
                  </td>
                  <td class="py-space-md px-space-md text-right font-bold text-emerald-700">
                    0 đ
                    <span class="font-normal text-body-sm">
                      (Miễn phí)
                    </span>
                  </td>
                </tr>
                <!-- Item 3: Phí khám -->
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                  <td class="py-space-md px-space-md font-medium text-primary">
                    3. Phí kiểm tra &amp; chẩn đoán đo đạc
                  </td>
                  <td class="py-space-md px-space-md text-on-surface-variant text-body-sm">
                    Đo xung vi mạch và kiểm tra chạm chập nguồn
                  </td>
                  <td class="py-space-md px-space-md text-center text-on-surface-variant text-body-sm">
                    Tiêu chuẩn
                  </td>
                  <td class="py-space-md px-space-md text-right line-through text-outline">
                    250.000 đ
                  </td>
                  <td class="py-space-md px-space-md text-right font-bold text-emerald-700">
                    0 đ
                    <span class="font-normal text-body-sm">
                      (Miễn phí)
                    </span>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr class="bg-surface-container-low font-medium">
                  <td class="py-space-md px-space-md text-body-sm text-on-surface-variant" colspan="3">
                    * Đơn giá đã bao gồm thuế GTGT (VAT 10%). Khách hàng chỉ thanh toán đúng số tiền niêm yết sau khi nghiệm thu hài lòng.
                  </td>
                  <td class="py-space-md px-space-md text-right font-label-lg text-label-lg text-primary uppercase">
                    Tổng thanh toán:
                  </td>
                  <td class="py-space-md px-space-md text-right font-display-lg text-display-lg text-secondary font-bold">
                    1.450.000
                    <span class="font-headline-sm text-headline-sm">
                      VNĐ
                    </span>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- HAI NÚT QUYẾT ĐỊNH CHÍNH NỔI BẬT -->
          <div class="p-space-md bg-surface-container-low rounded-xl flex flex-col md:flex-row items-center justify-between gap-space-md">
            <div class="flex items-center gap-space-sm">
              <span class="material-symbols-outlined text-secondary text-[28px]">
                shield
              </span>
              <div>
                <p class="font-headline-sm text-headline-sm text-primary">
                  Cam kết ReliantCare
                </p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Không sửa được hoàn tiền 100%. Bảo mật dữ liệu cá nhân tuyệt đối.
                </p>
              </div>
            </div>
            <div class="flex items-center gap-space-sm w-full md:w-auto">
              <!-- Nút từ chối sửa -->
              <button class="h-12 px-space-lg rounded-xl border border-error text-error hover:bg-error-container hover:text-on-error-container font-label-lg text-label-lg font-semibold transition-colors flex items-center justify-center gap-1.5 flex-1 md:flex-none" data-action="decline-repair" type="button">
                <span class="material-symbols-outlined text-[20px]">
                  close
                </span>
                <span>
                  Từ chối sửa
                </span>
              </button>
              <!-- Nút đồng ý sửa (1-click) -->
              <button class="h-12 px-space-xl rounded-xl bg-primary hover:bg-secondary text-on-primary font-label-lg text-label-lg font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 flex-1 md:flex-none group" id="btn-approve" data-action="approve-repair" type="button">
                <span class="material-symbols-outlined text-[22px] group-hover:scale-110 transition-transform">
                  check_circle
                </span>
                <span>
                  Đồng ý sửa (Duyệt 1-Click)
                </span>
              </button>
            </div>
          </div>
          <!-- Toast thông báo thành công sau khi duyệt -->
          <div class="hidden p-space-md bg-emerald-50 border border-emerald-300 rounded-xl flex items-center justify-between text-emerald-950" id="approval-success-toast">
            <div class="flex items-center gap-space-sm">
              <span class="material-symbols-outlined text-emerald-600 text-[26px]">
                task_alt
              </span>
              <div>
                <p class="font-headline-sm text-headline-sm font-bold">
                  Xác nhận duyệt báo giá thành công!
                </p>
                <p class="font-body-md text-body-md">
                  Kỹ thuật viên đã nhận lệnh và bắt đầu thay linh kiện cáp eDP. Dự kiến hoàn thành lúc 16:30.
                </p>
              </div>
            </div>
            <span class="font-label-md text-label-md px-space-sm py-1 bg-emerald-200 text-emerald-900 rounded-lg font-bold">
              ĐÃ KÍCH HOẠT
            </span>
          </div>
        </section>
        <!-- 5. TÌNH TRẠNG TIẾP THEO KHI HOÀN TẤT: TÙY CHỌN NHẬN MÁY -->
        <section class="w-full bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm flex flex-col gap-space-sm" data-auth-private>
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 pb-space-xs border-b border-surface-container">
            <h3 class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
              <span class="material-symbols-outlined text-secondary text-[22px]">
                local_shipping
              </span>
              Tình Trạng Tiếp Theo &amp; Tùy Chọn Nhận Máy Sau Khi Sửa Xong
            </h3>
            <span class="font-label-sm text-label-sm text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full font-semibold self-start sm:self-center">
              Dự kiến bàn giao: 16:30 hôm nay
            </span>
          </div>
          <p class="font-body-md text-body-md text-on-surface-variant">
            Sau khi kỹ thuật viên thay thế và kiểm tra xong 12 bước tiêu chuẩn, bạn có thể lựa chọn một trong hai phương thức nhận máy:
          </p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-md pt-space-xs">
            <!-- Tùy chọn 1: Tại trung tâm -->
            <label class="cursor-pointer p-space-md rounded-xl border-2 border-primary bg-surface-container-low flex flex-col gap-1 transition-all">
              <div class="flex items-center justify-between">
                <span class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
                  <span class="material-symbols-outlined text-secondary text-[20px]">
                    storefront
                  </span>
                  Nhận trực tiếp tại trung tâm
                </span>
                <input checked="" class="w-4 h-4 text-primary accent-primary" name="delivery_opt" type="radio"/>
              </div>
              <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                Địa chỉ: Hub 124 Thái Hà, Q. Đống Đa, Hà Nội. Kỹ thuật viên sẽ hỗ trợ kiểm tra cùng khách hàng và hướng dẫn test máy tại chỗ.
              </p>
            </label>
            <!-- Tùy chọn 2: Giao tận nhà -->
            <label class="cursor-pointer p-space-md rounded-xl border border-surface-container bg-surface-container-low hover:border-secondary flex flex-col gap-1 transition-all">
              <div class="flex items-center justify-between">
                <span class="font-headline-sm text-headline-sm text-primary flex items-center gap-2">
                  <span class="material-symbols-outlined text-secondary text-[20px]">
                    moped
                  </span>
                  Giao máy tận nhà (Miễn phí)
                </span>
                <input class="w-4 h-4 text-primary accent-primary" name="delivery_opt" type="radio"/>
              </div>
              <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                Vận chuyển xe máy chống sốc an toàn. Giao tới địa chỉ đăng ký của bạn. Khách hàng kiểm tra máy hoạt động tốt mới thanh toán.
              </p>
            </label>
          </div>
        </section>
          <section class="w-full bg-surface-container-lowest rounded-xl p-space-lg border border-surface-container shadow-sm flex flex-col gap-space-md" data-auth-guest>
            <div class="flex items-start gap-space-sm">
              <span class="material-symbols-outlined text-secondary text-[26px]">verified</span>
              <div>
                <h2 class="font-headline-sm text-headline-sm text-primary">Quy trình bảo hành ReliantCare</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                  Tiếp nhận thiết bị, kiểm tra kỹ thuật, báo giá minh bạch và bàn giao sau khi hoàn tất.
                </p>
              </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-space-sm">
              <div class="bg-surface-container-low rounded-lg p-space-md">
                <span class="font-label-sm text-label-sm text-secondary font-bold">01</span>
                <h3 class="font-headline-sm text-headline-sm text-primary mt-1">Tiếp nhận</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Ghi nhận tình trạng thiết bị và nhu cầu hỗ trợ.</p>
              </div>
              <div class="bg-surface-container-low rounded-lg p-space-md">
                <span class="font-label-sm text-label-sm text-secondary font-bold">02</span>
                <h3 class="font-headline-sm text-headline-sm text-primary mt-1">Kiểm tra</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Kỹ thuật viên chẩn đoán và tư vấn phương án phù hợp.</p>
              </div>
              <div class="bg-surface-container-low rounded-lg p-space-md">
                <span class="font-label-sm text-label-sm text-secondary font-bold">03</span>
                <h3 class="font-headline-sm text-headline-sm text-primary mt-1">Bàn giao</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Thông báo kết quả và hẹn nhận thiết bị thuận tiện.</p>
              </div>
            </div>
            <a class="site-action-link inline-flex items-center justify-center gap-2 h-10 px-space-md bg-primary hover:bg-secondary text-on-primary font-label-md text-label-md rounded-lg shadow-sm transition-all self-start" data-path="dat-lich-hen" href="dat-lich-hen.php">
              <span class="material-symbols-outlined text-[18px]">calendar_month</span>
              <span>Đặt lịch sửa chữa / bảo hành</span>
            </a>
          </section>
      </div>
    </main>
    <!-- FOOTER TỐI GIẢN -->
    <footer class="w-full bg-surface-container-lowest border-t border-surface-container py-space-md">
      <div class="max-w-[1200px] mx-auto px-margin flex flex-col sm:flex-row items-center justify-between gap-space-sm font-body-sm text-body-sm text-on-surface-variant">
        <div class="flex items-center gap-2">
          <img alt="ReliantCare Logo" class="site-logo h-6 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFQit0nSEGzWIX2Hs1fbneLlx7PZPUL5u44rQddKG3LZzxBRtLbh6Oj0JO8t2fv-8peBpQi_ccVp7l5NLJqj3_Gunplze4QcWNvFpTUW1OJG-V4gILP0YsiG3En89FCd2w5OtxM9i_2V1MIZ8-frYYOhSI0Q1dpzawU_-ge9PoygpMMNkvQLt8MnCCJRqRq2IoPlgkMt3QpR5Bw224matMkjgJXNwrtslv8qSmYURpTJlE6gGlU6DpIg"/>
          <span class="font-headline-sm text-headline-sm text-primary">
            ReliantCare Việt Nam
          </span>
          <span class="hidden sm:inline">
            |
          </span>
          <span class="hidden sm:inline">
            Tổng đài hỗ trợ 24/7:
            <a class="font-semibold text-secondary hover:underline" href="tel:18006868">
              1800 6868
            </a>
          </span>
        </div>
        <div class="flex items-center gap-space-md">
          <span>
            © 2025 ReliantCare. Bảo lưu mọi quyền.
          </span>
          <a class="hover:text-secondary transition-colors" href="#">
            Điều khoản
          </a>
          <a class="hover:text-secondary transition-colors" href="#">
            Bảo mật
          </a>
        </div>
      </div>
    </footer>
  </body>
</html>
