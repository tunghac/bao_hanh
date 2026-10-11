<?php
require "db.php";
session_start();
$account_id = (int) ($_SESSION["account_id"] ?? 0);
$session_customer_id = (int) ($_SESSION["customer_id"] ?? 0);
$customer = null;
$devices = [];
$histories = [];
$bookings = [];
if ($account_id > 0 || $session_customer_id > 0) {
  $stmt =
    $account_id > 0
      ? $pdo->prepare(
        "SELECT customer_id, full_name, phone FROM customers WHERE account_id = ? LIMIT 1",
      )
      : $pdo->prepare(
        "SELECT customer_id, full_name, phone FROM customers WHERE customer_id = ? LIMIT 1",
      );
  $stmt->execute([$account_id > 0 ? $account_id : $session_customer_id]);
  $customer = $stmt->fetch();
  if ($customer) {
    $stmt = $pdo->prepare(
      "SELECT d.device_id, d.device_name, d.imei_serial, r.status, r.progress_percent, r.received_date, r.total_cost FROM devices d LEFT JOIN repairs r ON r.repair_id = (SELECT MAX(r2.repair_id) FROM repairs r2 WHERE r2.device_id = d.device_id) WHERE d.customer_id = ? ORDER BY d.device_id DESC",
    );
    $stmt->execute([$customer["customer_id"]]);
    $devices = $stmt->fetchAll();
    $stmt = $pdo->prepare(
      "SELECT b.booking_code, b.appointment_date, b.appointment_time, b.error_description, b.media_paths, b.branch_name, b.status, d.device_name, d.imei_serial FROM booking_requests b JOIN devices d ON d.device_id = b.device_id WHERE b.customer_id = ? ORDER BY b.created_at DESC",
    );
    $stmt->execute([$customer["customer_id"]]);
    $bookings = $stmt->fetchAll();
    $histories = $bookings;
  }
}
if (!$customer && $account_id > 0) {
  $customer = [
    "customer_id" => 0,
    "full_name" => "Chưa cập nhật hồ sơ",
    "phone" => "Chưa cập nhật",
  ];
}
$selected_booking = null;
$booking_code = trim((string) ($_GET["booking"] ?? ""));
foreach ($bookings as $booking) {
  if ($booking["booking_code"] === $booking_code) {
    $selected_booking = $booking;
    break;
  }
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
    <style>
      body.has-database-view .legacy-device-view { display: none; }
      .site-footer { width: 100%; margin-top: 0; }
      .site-footer > div { min-height: 56px; }
    </style>
  </head>
  <body class="bg-surface font-body-md text-body-md text-on-surface antialiased<?php echo $customer
    ? " has-database-view"
    : ""; ?>" data-auth-gate>
    <header class="site-header fixed top-0 w-full z-50 bg-surface/95 backdrop-blur-xl border-b border-surface-container-high/60">
      <div class="h-20 max-w-[1440px] mx-auto px-margin-mobile md:px-margin flex items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-lg">
          <a class="flex items-center gap-space-sm" data-path="trang-chu" href="#">
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
          <!-- Standardized 5-Item Navigation with Active Highlight on 'Thiết bị & Lịch sử sửa chữa' -->
          <nav class="site-nav hidden xl:flex items-center gap-1.5">
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="trang-chu" href="trang-chu.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">search</span>
              <span>Tra cứu</span><link href="trang-chu.php"/>
            </a>
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dat-lich-hen" href="dat-lich-hen.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">build</span>
              <span>Bảo hành &amp; Sửa chữa</span><link href="dat-lich-hen.php"/>
            </a>
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="tra-cuu-tien-do" href="tra-cuu-tien-do.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">track_changes</span>
              <span>Theo dõi</span><link href="tra-cuu-tien-do.php"/>
            </a>
            <a aria-current="page" class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md bg-primary-container text-on-primary font-semibold shadow-sm" data-path="thiet-bi-lich-su" href="thiet-bi-lich-su.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">devices</span>
              <span>Thiết bị</span><link href="thiet-bi-lich-su.php"/>
            </a>
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="tra-cuu-chi-nhanh" href="tra-cuu-chi-nhanh.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">location_on</span>
              <span>Chi nhánh</span><link href="tra-cuu-chi-nhanh.php"/>
            </a>
          </nav>
        </div>
        <div class="site-actions flex items-center gap-space-md">
          <div class="hidden md:flex items-center gap-space-xs px-space-sm py-space-xs bg-surface-container rounded-lg">
            <span class="material-symbols-outlined text-secondary text-[20px]">
              support_agent
            </span>
            <div class="flex flex-col">
              <span class="font-label-sm text-label-sm text-on-surface-variant leading-none">
                Hotline
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
          <div class="flex items-center gap-space-sm pl-space-xs">
            <a class="site-account" data-auth-action="logout" data-path="tai-khoan" href="#" aria-label="Đăng nhập" title="Đăng nhập">
              <span class="material-symbols-outlined text-[20px]">person</span>
            </a>
          </div>
        </div>
      </div>
    </header>
    <main class="w-full pt-20 bg-surface">
      <div class="flex flex-col w-full">
        <!-- Content Container -->
        <div class="w-full max-w-[1280px] mx-auto px-margin-mobile md:px-margin py-space-lg md:py-space-xl flex flex-col gap-space-lg">
          <?php if ($customer): ?>
          <section id="database-device-view" class="flex flex-col gap-space-lg">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm pb-2 border-b border-surface-container">
              <div>
                <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary tracking-tight">Thiết Bị Của Tôi &amp; Lịch Sử Sửa Chữa</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Dữ liệu được tải trực tiếp từ tài khoản và hồ sơ kỹ thuật của bạn.</p>
              </div>
              <span class="font-label-md text-label-md text-primary bg-primary-fixed px-3 py-2 rounded-lg"><?php echo count(
                $devices,
              ); ?> thiết bị</span>
            </div>
            <section class="w-full bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex flex-col sm:flex-row sm:items-center justify-between gap-space-md">
              <div>
                <h2 class="font-headline-sm text-headline-sm text-primary font-bold"><?php echo htmlspecialchars(
                  $customer["full_name"],
                ); ?></h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant">SĐT: <?php echo htmlspecialchars(
                  $customer["phone"],
                ); ?></p>
              </div>
              <span class="font-label-md text-label-md text-secondary">Tài khoản đã xác thực</span>
            </section>
            <section class="flex flex-col gap-space-sm">
              <div class="flex items-center justify-between"><h2 class="font-headline-md text-headline-md text-primary">Giới Thiệu Sản Phẩm Mới</h2><span class="font-body-sm text-body-sm text-on-surface-variant">Sản phẩm phù hợp với thiết bị của bạn</span></div>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-md">
                <?php foreach ($devices as $device): ?>
                <article class="bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex flex-col gap-space-sm">
                  <span class="font-label-sm text-label-sm text-secondary">Gợi ý cho <?php echo htmlspecialchars(
                    $device["device_name"],
                  ); ?></span>
                  <h3 class="font-headline-sm text-headline-sm text-primary">Gói chăm sóc thiết bị</h3>
                  <p class="font-body-sm text-body-sm text-on-surface-variant">Vệ sinh, kiểm tra tổng quát và cập nhật tình trạng thiết bị định kỳ.</p>
                  <a class="text-secondary font-label-md text-label-md font-semibold hover:underline" href="dat-lich-hen.php">Đặt lịch dịch vụ</a>
                </article>
                <?php endforeach; ?>
                <?php if (
                  !$devices
                ): ?><p class="font-body-md text-body-md text-on-surface-variant">Tài khoản chưa có thiết bị.</p><?php endif; ?>
              </div>
            </section>
            <section class="w-full bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md md:p-space-lg flex flex-col gap-space-md">
              <div><h2 class="font-headline-md text-headline-md text-primary">Lịch Sử Sửa Chữa &amp; Phiếu Kỹ Thuật</h2><p class="font-body-sm text-body-sm text-on-surface-variant">Các phiếu đặt lịch và tiến độ lấy từ hồ sơ MySQL.</p></div>
              <div class="overflow-x-auto"><table class="w-full text-left min-w-[700px]"><thead><tr class="bg-surface-container-low font-label-sm text-label-sm text-on-surface-variant"><th class="p-2">Mã phiếu</th><th class="p-2">Thiết bị &amp; lỗi</th><th class="p-2">Ngày hẹn</th><th class="p-2">Chi nhánh</th><th class="p-2">Trạng thái</th></tr></thead><tbody class="divide-y divide-surface-container font-body-sm text-body-sm">
                <?php foreach ($histories as $history):

                  $history_media = json_decode(
                    $history["media_paths"] ?? "[]",
                    true,
                  );
                  if (!is_array($history_media)) {
                    $history_media = [];
                  }
                  ?><tr><td class="p-2 font-mono text-secondary"><a class="hover:underline" href="tra-cuu-tien-do.php?booking=<?php echo urlencode(
  $history["booking_code"],
); ?>"><?php echo htmlspecialchars(
  $history["booking_code"],
); ?></a></td><td class="p-2"><strong class="text-primary block"><?php echo htmlspecialchars(
  $history["device_name"],
); ?></strong><span class="text-on-surface-variant"><?php echo htmlspecialchars(
  $history["error_description"],
); ?></span><?php
if (
  !empty($history["imei_serial"])
): ?><span class="block text-xs text-on-surface-variant">Serial/IMEI: <?php echo htmlspecialchars(
  $history["imei_serial"],
); ?></span><?php endif;
if ($history_media): ?><div class="flex flex-wrap gap-2 mt-2"><?php foreach (
  $history_media
  as $media_path
):
  $media_url = htmlspecialchars($media_path, ENT_QUOTES, "UTF-8");
  if (
    strtolower(pathinfo($media_path, PATHINFO_EXTENSION)) === "mp4"
  ): ?><video class="w-28 rounded border border-surface-container" controls preload="metadata" src="<?php echo $media_url; ?>"></video><?php else: ?><a class="block w-16 h-16 overflow-hidden rounded border border-surface-container" href="<?php echo $media_url; ?>" target="_blank" rel="noopener"><img class="w-full h-full object-cover" src="<?php echo $media_url; ?>" alt="Ảnh hiện trạng thiết bị" loading="lazy"/></a><?php endif;
endforeach; ?></div><?php endif;
?></td><td class="p-2"><?php echo htmlspecialchars(
  $history["appointment_date"] . " " . $history["appointment_time"],
); ?></td><td class="p-2"><?php echo htmlspecialchars(
  $history["branch_name"],
); ?></td><td class="p-2 text-primary"><?php echo htmlspecialchars(
  $history["status"],
); ?></td></tr><?php
                endforeach; ?>
                <?php if (
                  !$histories
                ): ?><tr><td class="p-2 text-on-surface-variant" colspan="5">Chưa có phiếu sửa chữa.</td></tr><?php endif; ?></tbody></table></div>
            </section>
          </section>
          <?php endif; ?>
          <div class="legacy-device-view">
          <!-- 1. Header & Page Title -->
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm pb-2 border-b border-surface-container">
            <div>
              <h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary tracking-tight">
                Thiết Bị Của Tôi &amp; Lịch Sử Sửa Chữa
              </h1>
              <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
                Quản lý sổ bảo hành điện tử và theo dõi hồ sơ kỹ thuật các thiết bị của bạn.
              </p>
            </div>
            <button class="inline-flex items-center gap-space-xs h-9 px-space-md bg-primary-container hover:bg-secondary text-on-primary font-label-md text-label-md rounded-lg shadow-sm transition-all self-start sm:self-auto" data-auth-private type="button">
              <span class="material-symbols-outlined text-[18px]">
                add
              </span>
              <span>
                + Thêm thiết bị
              </span>
            </button>
          </div>
          <!-- 2. Minimal Customer Account Info -->
          <div class="w-full bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex flex-col sm:flex-row sm:items-center justify-between gap-space-md" data-auth-private>
            <div class="flex items-center gap-space-md">
              <div class="w-12 h-12 rounded-full bg-primary-fixed text-primary font-headline-sm flex items-center justify-center shrink-0 font-bold">
                NM
              </div>
              <div class="flex flex-col">
                <div class="flex items-center gap-2">
                  <span class="font-headline-sm text-headline-sm text-primary font-bold">
                    Nguyễn Hoàng Minh
                  </span>
                  <span class="inline-flex items-center gap-0.5 text-xs text-secondary bg-surface-container px-2 py-0.5 rounded-full font-medium">
                    <span class="material-symbols-outlined text-[13px]" style="font-variation-settings: 'FILL' 1;">
                      verified
                    </span>
                    Đã xác thực
                  </span>
                </div>
                <div class="flex items-center gap-1 font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                  <span class="material-symbols-outlined text-[15px] text-outline">
                    smartphone
                  </span>
                  <span>
                    SĐT:
                    <strong class="text-on-surface">
                      0918 293 847
                    </strong>
                    (OTP Active)
                  </span>
                </div>
              </div>
            </div>
            <div class="flex items-center gap-space-md self-end sm:self-auto bg-surface-container-low px-space-md py-space-xs rounded-lg">
              <span class="font-label-md text-label-md text-on-surface-variant">
                Thiết bị đang sở hữu:
              </span>
              <span class="font-headline-md text-headline-md text-primary font-bold">
                04
                <span class="font-body-sm text-body-sm text-on-surface-variant font-normal">
                  máy
                </span>
              </span>
            </div>
          </div>
          <div class="w-full bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex items-center gap-space-sm" data-auth-guest>
            <span class="material-symbols-outlined text-secondary text-[24px]">lock</span>
            <div>
              <p class="font-headline-sm text-headline-sm text-primary font-semibold">
                Thông tin khách hàng đang được bảo mật
              </p>
              <p class="font-body-sm text-body-sm text-on-surface-variant">
                Đăng nhập để xem thông tin tài khoản và số thiết bị đã đăng ký.
              </p>
            </div>
          </div>
          <!-- 3. Smart Maintenance Reminder Alert (1 brief notification) -->
          <div class="w-full bg-surface-container-low border-l-4 border-secondary rounded-r-xl p-space-md flex flex-col sm:flex-row sm:items-center justify-between gap-space-md" data-auth-private>
            <div class="flex items-center gap-space-sm">
              <span class="material-symbols-outlined text-secondary text-[24px] shrink-0" style="font-variation-settings: 'FILL' 1;">
                notifications_active
              </span>
              <p class="font-body-md text-body-md text-on-surface">
                <strong class="text-primary font-semibold">
                  Nhắc lịch bảo dưỡng:
                </strong>
                Thiết bị
                <strong class="text-primary">
                  MacBook Pro 14"
                </strong>
                đã đến chu kỳ 6 tháng vệ sinh buồng quạt &amp;
                <strong class="text-primary">
                  iPhone 15 Pro Max
                </strong>
                sắp hết hạn bảo hành AppleCare+ (còn 28 ngày).
              </p>
            </div>
            <a class="inline-flex items-center gap-1 shrink-0 text-secondary hover:text-primary font-label-md text-label-md font-semibold transition-colors" data-path="dat-lich-hen" href="dat-lich-hen.php">
              <span>
                Đặt lịch hẹn ngay
              </span>
              <span class="material-symbols-outlined text-[16px]">
                arrow_forward
              </span>
            </a>
          </div>
          <!-- 4. Electronic Warranty Book (Clean compact device cards) -->
          <div class="flex flex-col gap-space-sm">
            <div class="flex items-center justify-between">
              <h2 class="font-headline-md text-headline-md text-primary">
                Sổ Bảo Hành Điện Tử
              </h2>
                <span class="font-body-sm text-body-sm text-on-surface-variant" data-auth-private>
                4 thiết bị
              </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md" data-auth-private>
              <!-- Device 1 -->
              <div class="bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex flex-col justify-between hover:border-secondary/50 transition-colors">
                <div class="flex flex-col gap-space-sm">
                  <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-600">
                      </span>
                      Còn hạn
                    </span>
                    <span class="font-label-sm text-label-sm text-outline">
                      Còn 268 ngày
                    </span>
                  </div>
                  <div class="flex items-center gap-space-sm pt-1">
                    <div class="w-12 h-12 rounded bg-surface-container-low p-1 shrink-0 flex items-center justify-center">
                      <img class="w-full h-full object-contain rounded" data-alt="MacBook Pro" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCobh-FEO3aaX4PnYqNZ1UkIQ_9gCZwDC17bO8xI9DusRGNUTNMmI9ljRFGdR3mM3Aui4EF8sEzWBQZGkqI196MMcWw3eYy4YqenpykO5X3P2wtD_xPcpStbWRT9U99EPPGBtiDetK2GhxP3Vqs8xSVqW35NtN7-ftXJCfRj9daQsgd_YznwSk44wjJ0QQrEByMhOsS0vyYyVmbMfHOFLwhKn9LfiDnJh43jjPW1VdD0zgXGNWHOUqnJA"/>
                    </div>
                    <div class="min-w-0">
                      <h3 class="font-headline-sm text-headline-sm text-primary truncate" title="MacBook Pro 14 M2 Pro">
                        MacBook Pro 14" M2
                      </h3>
                      <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Model: A2779 (2023)
                      </p>
                    </div>
                  </div>
                  <div class="bg-surface-container-low rounded-lg p-2 flex flex-col gap-1 font-body-sm text-body-sm">
                    <div class="flex justify-between text-outline text-[11px]">
                      <span>
                        Serial:
                      </span>
                      <span class="font-mono text-on-surface font-medium">
                        C02GG3VCMD6R
                      </span>
                    </div>
                    <div class="flex justify-between text-[12px]">
                      <span class="text-on-surface-variant">
                        Hết hạn:
                      </span>
                      <span class="text-primary font-semibold">
                        24/11/2025
                      </span>
                    </div>
                  </div>
                </div>
                <div class="pt-space-xs mt-space-xs border-t border-surface-container flex items-center justify-between">
                  <a class="text-secondary font-label-sm text-label-sm hover:underline flex items-center gap-0.5" data-path="tra-cuu-tien-do" href="#">
                    <span class="material-symbols-outlined text-[14px]">
                      track_changes
                    </span>
                    Xem RMA mở
                  </a>
                  <button class="text-on-surface-variant hover:text-primary font-label-sm text-label-sm flex items-center gap-0.5" type="button">
                    <span class="material-symbols-outlined text-[14px]">
                      file_download
                    </span>
                    Tải sổ
                  </button>
                </div>
              </div>
              <!-- Device 2 -->
              <div class="bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex flex-col justify-between hover:border-secondary/50 transition-colors">
                <div class="flex flex-col gap-space-sm">
                  <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded">
                      <span class="w-1.5 h-1.5 rounded-full bg-amber-600">
                      </span>
                      Sắp hết hạn
                    </span>
                    <span class="font-label-sm text-label-sm text-outline">
                      Còn 28 ngày
                    </span>
                  </div>
                  <div class="flex items-center gap-space-sm pt-1">
                    <div class="w-12 h-12 rounded bg-surface-container-low p-1 shrink-0 flex items-center justify-center">
                      <img class="w-full h-full object-contain rounded" data-alt="iPhone 15 Pro Max" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAdRhvtgd3ACSPQ1s-2vimAb9PJcfHRQhqY9yZcho1Znf-cuHRLaAtyu32GFIgWZ28nOXTqwOJh13z-anZfbKscBOakgo6RnwfnPmWi8BUw7NFCDRKuQUqPfgcya6uSPglyacN7WHAgbLk8n7lBX5-rl37G6xpW8tjg3AbGomwr6MI8gmUmDMeoBmY8ZlhEqtFAI666mSAlydAmqGyfwXhBAogJJgqtc1wLsW_qK43rEyGRWoCNIMRAfQ"/>
                    </div>
                    <div class="min-w-0">
                      <h3 class="font-headline-sm text-headline-sm text-primary truncate" title="iPhone 15 Pro Max">
                        iPhone 15 Pro Max
                      </h3>
                      <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Model: A3106 (256GB)
                      </p>
                    </div>
                  </div>
                  <div class="bg-surface-container-low rounded-lg p-2 flex flex-col gap-1 font-body-sm text-body-sm">
                    <div class="flex justify-between text-outline text-[11px]">
                      <span>
                        IMEI:
                      </span>
                      <span class="font-mono text-on-surface font-medium">
                        354891238918291
                      </span>
                    </div>
                    <div class="flex justify-between text-[12px]">
                      <span class="text-on-surface-variant">
                        Hết hạn:
                      </span>
                      <span class="text-primary font-semibold">
                        15/09/2024
                      </span>
                    </div>
                  </div>
                </div>
                <div class="pt-space-xs mt-space-xs border-t border-surface-container flex items-center justify-between">
                  <a class="text-secondary font-label-sm text-label-sm hover:underline flex items-center gap-0.5" data-path="dat-lich-hen" href="dat-lich-hen.php">
                    <span class="material-symbols-outlined text-[14px]">
                      bolt
                    </span>
                    Gia hạn BH
                  </a>
                  <button class="text-on-surface-variant hover:text-primary font-label-sm text-label-sm flex items-center gap-0.5" type="button">
                    <span class="material-symbols-outlined text-[14px]">
                      file_download
                    </span>
                    Tải sổ
                  </button>
                </div>
              </div>
              <!-- Device 3 -->
              <div class="bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex flex-col justify-between hover:border-secondary/50 transition-colors">
                <div class="flex flex-col gap-space-sm">
                  <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-600">
                      </span>
                      Còn hạn
                    </span>
                    <span class="font-label-sm text-label-sm text-outline">
                      Còn 390 ngày
                    </span>
                  </div>
                  <div class="flex items-center gap-space-sm pt-1">
                    <div class="w-12 h-12 rounded bg-surface-container-low p-1 shrink-0 flex items-center justify-center">
                      <img class="w-full h-full object-contain rounded" data-alt="iPad Pro 11 M2" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAOKJafNT1_BchXfBln3Q80y3SXnh8fd-R_cPyY_2n0JpgojRoUyTiPZpw93WMhGBkcirbiOs5qJkpn0Kqc9vEpSvjJKc0OgD2Dg__dquH9OlU8xaPEjfdcMnB5AMpvgsInsz1HwW7qOq4Jt2dx2KHWazNbUxTZgahckhl0pXhPleFNe6h1lhdjUS-UsCyIVXZ_zkE5UWXyThgft67-S8A71h8tmkEDYrqvFGZjbT7UnVgbeifDPV0sMQ"/>
                    </div>
                    <div class="min-w-0">
                      <h3 class="font-headline-sm text-headline-sm text-primary truncate" title="iPad Pro 11 M2">
                        iPad Pro 11" M2
                      </h3>
                      <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Model: A2759 (128GB)
                      </p>
                    </div>
                  </div>
                  <div class="bg-surface-container-low rounded-lg p-2 flex flex-col gap-1 font-body-sm text-body-sm">
                    <div class="flex justify-between text-outline text-[11px]">
                      <span>
                        Serial:
                      </span>
                      <span class="font-mono text-on-surface font-medium">
                        H4KD8190P102
                      </span>
                    </div>
                    <div class="flex justify-between text-[12px]">
                      <span class="text-on-surface-variant">
                        Hết hạn:
                      </span>
                      <span class="text-primary font-semibold">
                        05/01/2026
                      </span>
                    </div>
                  </div>
                </div>
                <div class="pt-space-xs mt-space-xs border-t border-surface-container flex items-center justify-between">
                  <a class="text-secondary font-label-sm text-label-sm hover:underline flex items-center gap-0.5" data-path="dat-lich-hen" href="dat-lich-hen.php">
                    <span class="material-symbols-outlined text-[14px]">
                      cleaning_services
                    </span>
                    Vệ sinh máy
                  </a>
                  <button class="text-on-surface-variant hover:text-primary font-label-sm text-label-sm flex items-center gap-0.5" type="button">
                    <span class="material-symbols-outlined text-[14px]">
                      file_download
                    </span>
                    Tải sổ
                  </button>
                </div>
              </div>
              <!-- Device 4 -->
              <div class="bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex flex-col justify-between hover:border-secondary/50 transition-colors opacity-85">
                <div class="flex flex-col gap-space-sm">
                  <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                      <span class="w-1.5 h-1.5 rounded-full bg-slate-400">
                      </span>
                      Hết hạn
                    </span>
                    <span class="font-label-sm text-label-sm text-outline">
                      10/01/2024
                    </span>
                  </div>
                  <div class="flex items-center gap-space-sm pt-1">
                    <div class="w-12 h-12 rounded bg-surface-container-low p-1 shrink-0 flex items-center justify-center">
                      <img class="w-full h-full object-contain rounded" data-alt="Dyson Purifier Cool TP07" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA2GODPK9cBEMJlb3yAP0IcOISZmCW8Ii70G5uGB4f67n08qSca6VwqRNV42DParDk4HhQpmVw1lkdNrgpi_oLN4q91TyAq_72vrAUO7cmuHwFUanS8a6x3e0o2DddJaFE2QfckQUel0rAbmNhspMrseWOsQNRUY0rudvg1Ha06oCvmVmoQl0L3wadb73ycHnvVL6hIgM35XDQM7Ejxu3Z6eonsH6MWZ4fXCnpWl4eIyWpnwbLz9eH11Q"/>
                    </div>
                    <div class="min-w-0">
                      <h3 class="font-headline-sm text-headline-sm text-primary truncate" title="Dyson Cool TP07">
                        Dyson Cool TP07
                      </h3>
                      <p class="font-body-sm text-body-sm text-on-surface-variant">
                        Model: TP07 Purifier
                      </p>
                    </div>
                  </div>
                  <div class="bg-surface-container-low rounded-lg p-2 flex flex-col gap-1 font-body-sm text-body-sm">
                    <div class="flex justify-between text-outline text-[11px]">
                      <span>
                        Serial:
                      </span>
                      <span class="font-mono text-on-surface font-medium">
                        DY-88219401
                      </span>
                    </div>
                    <div class="flex justify-between text-[12px]">
                      <span class="text-on-surface-variant">
                        Hết hạn:
                      </span>
                      <span class="text-outline font-semibold">
                        10/01/2024
                      </span>
                    </div>
                  </div>
                </div>
                <div class="pt-space-xs mt-space-xs border-t border-surface-container flex items-center justify-between">
                  <a class="text-secondary font-label-sm text-label-sm hover:underline flex items-center gap-0.5" data-path="dat-lich-hen" href="dat-lich-hen.php">
                    <span class="material-symbols-outlined text-[14px]">
                      build
                    </span>
                    Đặt sửa chữa
                  </a>
                  <button class="text-on-surface-variant hover:text-primary font-label-sm text-label-sm flex items-center gap-0.5" type="button">
                    <span class="material-symbols-outlined text-[14px]">
                      file_download
                    </span>
                    Tải sổ
                  </button>
                </div>
              </div>
            </div>
            <div class="w-full bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md flex items-center gap-space-sm" data-auth-guest>
              <span class="material-symbols-outlined text-secondary text-[24px]">devices</span>
              <div>
                <p class="font-headline-sm text-headline-sm text-primary font-semibold">
                  Sổ bảo hành điện tử
                </p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Đăng nhập để xem các thiết bị và thời hạn bảo hành của bạn.
                </p>
              </div>
            </div>
          </div>
          <!-- 5. Repair History (Lịch sử sửa chữa gọn gàng, rõ ràng) -->
          <div class="w-full bg-surface-container-lowest rounded-xl border border-surface-container-high/60 p-space-md md:p-space-lg flex flex-col gap-space-md">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm pb-2 border-b border-surface-container">
              <div>
                <h2 class="font-headline-md text-headline-md text-primary">
                  Lịch Sử Sửa Chữa &amp; Phiếu Kỹ Thuật
                </h2>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Hồ sơ can thiệp kỹ thuật, linh kiện thay thế và hóa đơn VAT điện tử
                </p>
              </div>
              <div class="flex items-center gap-2" data-auth-private>
                <button class="inline-flex items-center gap-1 h-8 px-space-sm bg-surface-container hover:bg-surface-variant text-primary font-label-sm text-label-sm rounded transition-colors" type="button">
                  <span class="material-symbols-outlined text-[16px]">
                    download
                  </span>
                  <span>
                    Xuất tất cả hóa đơn (.ZIP)
                  </span>
                </button>
              </div>
            </div>
            <div class="overflow-x-auto w-full" data-auth-private>
              <table class="w-full text-left border-collapse min-w-[760px]">
                <thead>
                  <tr class="bg-surface-container-low font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                    <th class="py-2.5 px-3 rounded-l-lg">
                      Ngày &amp; Mã phiếu
                    </th>
                    <th class="py-2.5 px-3">
                      Thiết bị &amp; Lỗi ghi nhận
                    </th>
                    <th class="py-2.5 px-3">
                      Linh kiện thay thế
                    </th>
                    <th class="py-2.5 px-3">
                      KTV xử lý
                    </th>
                    <th class="py-2.5 px-3">
                      Chi phí
                    </th>
                    <th class="py-2.5 px-3">
                      Trạng thái
                    </th>
                    <th class="py-2.5 px-3 rounded-r-lg text-right">
                      Chứng từ
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-surface-container font-body-sm text-body-sm">
                  <!-- History 1 -->
                  <tr class="hover:bg-surface-container-low/60 transition-colors">
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-mono text-secondary font-semibold block">
                        RMA-2025-8892
                      </span>
                      <span class="text-outline text-xs">
                        25/10/2025
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top max-w-[220px]">
                      <strong class="text-primary block font-medium">
                        MacBook Pro 14" M2
                      </strong>
                      <span class="text-on-surface-variant text-xs line-clamp-2">
                        Chớp sọc tím màn hình khi gập mở; chạm cáp eDP.
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top">
                      <span class="text-on-surface font-medium block">
                        Cáp eDP OEM + Keo MX-4
                      </span>
                      <span class="text-xs text-outline">
                        Linh kiện mới 100%
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="text-on-surface">
                        Trần Minh Hoàng
                      </span>
                      <span class="text-outline text-xs block">
                        Bàn KT 03
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-headline-sm text-headline-sm text-primary font-bold">
                        1.450.000 đ
                      </span>
                      <span class="text-[11px] text-outline block">
                        Gồm VAT
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold text-secondary bg-surface-container-high">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse">
                        </span>
                        Đang sửa chữa
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top text-right whitespace-nowrap">
                      <a class="inline-flex items-center gap-1 text-xs font-medium text-secondary hover:underline" data-path="tra-cuu-tien-do" href="#">
                        <span class="material-symbols-outlined text-[15px]">
                          sensors
                        </span>
                        Tiến độ
                      </a>
                    </td>
                  </tr>
                  <!-- History 2 -->
                  <tr class="hover:bg-surface-container-low/60 transition-colors">
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-mono text-primary font-semibold block">
                        RMA-2024-5412
                      </span>
                      <span class="text-outline text-xs">
                        18/10/2024
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top max-w-[220px]">
                      <strong class="text-primary block font-medium">
                        MacBook Pro 14" M2
                      </strong>
                      <span class="text-on-surface-variant text-xs line-clamp-2">
                        Nóng nhanh khi render, quạt tản nhiệt rít do khô trục.
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top">
                      <span class="text-on-surface font-medium block">
                        Cụm quạt cánh kép OEM
                      </span>
                      <span class="text-xs text-secondary font-medium">
                        CO/CQ: VN-2024
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="text-on-surface">
                        Trần Minh Hoàng
                      </span>
                      <span class="text-outline text-xs block">
                        Senior Tech
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-headline-sm text-headline-sm text-primary font-bold">
                        850.000 đ
                      </span>
                      <span class="text-[11px] text-emerald-600 block">
                        Đã thanh toán
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold text-emerald-700 bg-emerald-50">
                        <span class="material-symbols-outlined text-[13px]">
                          check_circle
                        </span>
                        Hoàn thành
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top text-right whitespace-nowrap">
                      <button class="inline-flex items-center gap-1 px-2 py-1 bg-surface-container hover:bg-surface-variant text-primary rounded text-xs transition-colors" title="Tải hóa đơn VAT" type="button">
                        <span class="material-symbols-outlined text-[14px] text-secondary">
                          download
                        </span>
                        <span>
                          Hóa đơn VAT
                        </span>
                      </button>
                    </td>
                  </tr>
                  <!-- History 3 -->
                  <tr class="hover:bg-surface-container-low/60 transition-colors">
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-mono text-primary font-semibold block">
                        RMA-2024-2109
                      </span>
                      <span class="text-outline text-xs">
                        04/05/2024
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top max-w-[220px]">
                      <strong class="text-primary block font-medium">
                        iPhone 15 Pro Max
                      </strong>
                      <span class="text-on-surface-variant text-xs line-clamp-2">
                        Pin chai còn 78%, sập nguồn đột ngột khi quay 4K.
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top">
                      <span class="text-on-surface font-medium block">
                        Pin OEM + Ron kháng nước IP68
                      </span>
                      <span class="text-xs text-outline">
                        Bảo hành 12 tháng
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="text-on-surface">
                        Nguyễn Quốc Huy
                      </span>
                      <span class="text-outline text-xs block">
                        Senior Tech
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-headline-sm text-headline-sm text-primary font-bold">
                        1.250.000 đ
                      </span>
                      <span class="text-[11px] text-emerald-600 block">
                        Đã thanh toán
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold text-emerald-700 bg-emerald-50">
                        <span class="material-symbols-outlined text-[13px]">
                          check_circle
                        </span>
                        Hoàn thành
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top text-right whitespace-nowrap">
                      <button class="inline-flex items-center gap-1 px-2 py-1 bg-surface-container hover:bg-surface-variant text-primary rounded text-xs transition-colors" title="Tải hóa đơn VAT" type="button">
                        <span class="material-symbols-outlined text-[14px] text-secondary">
                          download
                        </span>
                        <span>
                          Hóa đơn VAT
                        </span>
                      </button>
                    </td>
                  </tr>
                  <!-- History 4 -->
                  <tr class="hover:bg-surface-container-low/60 transition-colors">
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-mono text-primary font-semibold block">
                        RMA-2023-0981
                      </span>
                      <span class="text-outline text-xs">
                        24/11/2023
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top max-w-[220px]">
                      <strong class="text-primary block font-medium">
                        MacBook Pro 14" M2
                      </strong>
                      <span class="text-on-surface-variant text-xs line-clamp-2">
                        Kích hoạt e-Care &amp; dán bảo vệ màn hình 3M cao cấp.
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top">
                      <span class="text-on-surface font-medium block">
                        Phim 3M Pro
                      </span>
                      <span class="text-xs text-outline">
                        Gói theo máy
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="text-on-surface">
                        Lê Đức Duy
                      </span>
                      <span class="text-outline text-xs block">
                        KTV Kỹ thuật
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="font-headline-sm text-headline-sm text-secondary font-bold">
                        0 đ
                      </span>
                      <span class="text-[11px] text-outline block">
                        Miễn phí
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top whitespace-nowrap">
                      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-semibold text-emerald-700 bg-emerald-50">
                        <span class="material-symbols-outlined text-[13px]">
                          check_circle
                        </span>
                        Hoàn thành
                      </span>
                    </td>
                    <td class="py-3 px-3 align-top text-right whitespace-nowrap">
                      <button class="inline-flex items-center gap-1 px-2 py-1 bg-surface-container hover:bg-surface-variant text-primary rounded text-xs transition-colors" title="Xem biên lai" type="button">
                        <span class="material-symbols-outlined text-[14px] text-secondary">
                          receipt
                        </span>
                        <span>
                          Biên lai
                        </span>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="w-full bg-surface-container-low rounded-xl border border-surface-container-high/60 p-space-md flex items-center gap-space-sm" data-auth-guest>
              <span class="material-symbols-outlined text-secondary text-[24px]">history</span>
              <div>
                <p class="font-headline-sm text-headline-sm text-primary font-semibold">
                  Lịch sử sửa chữa được bảo mật
                </p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">
                  Đăng nhập để xem lịch sử sửa chữa, phiếu kỹ thuật và chứng từ.
                </p>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Minimal Footer -->
    <footer class="site-footer w-full bg-surface-container-lowest border-t border-surface-container py-space-md">
      <div class="max-w-[1280px] mx-auto px-margin-mobile md:px-margin flex flex-col sm:flex-row items-center justify-between gap-space-sm font-body-sm text-body-sm text-on-surface-variant">
        <div class="flex items-center gap-2">
          <img alt="ReliantCare" class="site-logo h-5 w-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFQit0nSEGzWIX2Hs1fbneLlx7PZPUL5u44rQddKG3LZzxBRtLbh6Oj0JO8t2fv-8peBpQi_ccVp7l5NLJqj3_Gunplze4QcWNvFpTUW1OJG-V4gILP0YsiG3En89FCd2w5OtxM9i_2V1MIZ8-frYYOhSI0Q1dpzawU_-ge9PoygpMMNkvQLt8MnCCJRqRq2IoPlgkMt3QpR5Bw224matMkjgJXNwrtslv8qSmYURpTJlE6gGlU6DpIg"/>
          <span class="font-medium text-primary">
            ReliantCare Việt Nam
          </span>
          <span>
            • Tổng đài hỗ trợ miễn cước:
            <a class="text-secondary font-semibold hover:underline" href="tel:18006868">
              1800 6868
            </a>
          </span>
        </div>
        <div>
          © 2025 ReliantCare. Bảo lưu mọi quyền.
        </div>
      </div>
    </footer>
  </body>
</html>
