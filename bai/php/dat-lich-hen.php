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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="../js/script.js?v=20260917-php-routes"></script>
  </head>
  <body class="bg-surface font-body-md text-body-md text-on-surface antialiased">
    <header class="site-header fixed top-0 w-full z-50 bg-surface/95 backdrop-blur-md border-b border-surface-container">
      <div class="h-16 max-w-[1280px] mx-auto px-4 sm:px-6 flex items-center justify-between gap-4">
        <div class="flex items-center gap-6">
          <a class="flex items-center gap-2" data-path="trang-chu" href="trang-chu.php">
            <img alt="ReliantCare Logo" class="site-logo h-7 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBFQit0nSEGzWIX2Hs1fbneLlx7PZPUL5u44rQddKG3LZzxBRtLbh6Oj0JO8t2fv-8peBpQi_ccVp7l5NLJqj3_Gunplze4QcWNvFpTUW1OJG-V4gILP0YsiG3En89FCd2w5OtxM9i_2V1MIZ8-frYYOhSI0Q1dpzawU_-ge9PoygpMMNkvQLt8MnCCJRqRq2IoPlgkMt3QpR5Bw224matMkjgJXNwrtslv8qSmYURpTJlE6gGlU6DpIg"/>
            <div class="flex flex-col">
              <span class="font-headline-sm text-[16px] text-primary tracking-tight font-bold">
                ReliantCare
              </span>
              <span class="site-brand-subtitle text-[10px] text-on-surface-variant uppercase tracking-wider -mt-0.5">
                <span class="material-symbols-outlined" aria-hidden="true">build</span>
                <span>Bảo hành &amp; Sửa chữa</span>
              </span>
            </div>
          </a>
          <nav class="site-nav hidden xl:flex items-center gap-1">
            <a class="px-3 py-1.5 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="trang-chu" href="trang-chu.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">search</span>
              <span>Tra cứu</span><link href="trang-chu.php"/>
            </a>
            <a aria-current="page" class="px-3 py-1.5 rounded-lg font-label-md text-label-md bg-primary-container text-on-primary font-semibold shadow-sm" data-path="dat-lich-hen" href="dat-lich-hen.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">build</span>
              <span>Bảo hành &amp; Sửa chữa</span><link href="dat-lich-hen.php"/>
            </a>
            <a class="px-3 py-1.5 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="tra-cuu-tien-do" href="tra-cuu-tien-do.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">track_changes</span>
              <span>Theo dõi</span><link href="tra-cuu-tien-do.php"/>
            </a>
            <a class="px-3 py-1.5 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="so-bao-hanh-dien-tu" href="thiet-bi-lich-su.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">devices</span>
              <span>Thiết bị</span><link href="so-bao-hanh-dien-tu.php"/>
            </a>
            <a class="px-3 py-1.5 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="tra-cuu-chi-nhanh" href="tra-cuu-chi-nhanh.php">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">location_on</span>
              <span>Chi nhánh</span><link href="tra-cuu-chi-nhanh.php"/>
            </a>
          </nav>
        </div>
        <div class="site-actions flex items-center gap-3">
          <a class="hidden sm:flex items-center gap-1.5 px-3 py-1 rounded-lg bg-surface-container text-primary font-label-sm font-semibold hover:bg-surface-container-high transition-colors" href="tel:18006868">
            <span class="material-symbols-outlined text-[18px] text-secondary">
              support_agent
            </span>
            <span>
              1800 6868
            </span>
          </a>
          <a class="site-action-link inline-flex items-center gap-1.5 h-10 px-3 bg-primary hover:bg-secondary text-on-primary font-label-md text-label-md rounded-lg shadow-sm transition-all" data-path="dat-lich-hen" href="dat-lich-hen.php">
            <span class="material-symbols-outlined text-[18px]">calendar_month</span>
            <span>Đặt lịch</span>
          </a>
          <a class="site-account" data-auth-action="logout" data-path="tai-khoan" href="#" aria-label="Đăng nhập" title="Đăng nhập">
            <span class="material-symbols-outlined text-[20px]">person</span>
          </a>
        </div>
      </div>
    </header>
    <main class="w-full pt-16 bg-surface">
      <div class="max-w-[1280px] mx-auto px-4 sm:px-6 py-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 pb-5 border-b border-surface-container">
          <div>
            <h1 class="font-headline-lg text-[26px] md:text-[30px] text-primary tracking-tight font-bold">
              Đặt Lịch Sửa Chữa / Bảo Hành
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">
              Tiếp nhận nhanh qua Kiosk Fast-Track, miễn phí kiểm tra &amp; báo giá minh bạch.
            </p>
          </div>
          <div class="flex items-center gap-2 self-start md:self-auto px-3 py-1.5 rounded-full bg-surface-container text-primary font-label-sm text-label-sm">
            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse">
            </span>
            <span>
              Ưu tiên phục vụ không cần xếp hàng
            </span>
          </div>
        </div>
        <!-- Streamlined 2-Column Booking Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mt-6">
          <!-- LEFT COLUMN (70%): Clear 4-Step Form Flow -->
          <div class="lg:col-span-8 flex flex-col gap-5">
            <form id="booking-form" action="xu_ly_dat_lich.php" method="POST" enctype="multipart/form-data">
            <section class="bg-surface-container-lowest rounded-xl p-5 border border-surface-container shadow-xs flex flex-col gap-4">
              <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-primary text-on-primary flex items-center justify-center font-label-sm text-xs font-bold">
                  1
                </span>
                <h2 class="font-headline-sm text-headline-sm text-primary font-semibold">
                  Chọn Thiết Bị Cần Tiếp Nhận
                </h2>
              </div>
              <!-- Quick Category Selector -->
              <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                <button class="device-option group flex flex-col items-center justify-center p-3 rounded-lg border border-surface-container hover:border-primary-container bg-surface-container-low/40 hover:bg-surface-container transition-all" data-device-type="Điện thoại" type="button">
                  <span class="material-symbols-outlined text-[26px] text-on-surface-variant group-hover:text-primary mb-1">
                    smartphone
                  </span>
                  <span class="font-label-md text-on-surface">
                    Điện thoại
                  </span>
                </button>
                <button class="device-option group flex flex-col items-center justify-center p-3 rounded-lg border border-surface-container hover:border-primary-container bg-surface-container-low/40 hover:bg-surface-container transition-all" data-device-type="Laptop/PC" type="button">
                  <div class="device-check hidden absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-secondary text-on-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[12px]">
                      check
                    </span>
                  </div>
                  <span class="material-symbols-outlined text-[26px] text-on-surface-variant group-hover:text-primary mb-1">
                    laptop_mac
                  </span>
                  <span class="font-label-md text-on-surface">
                    Laptop / PC
                  </span>
                </button>
                <button class="device-option group flex flex-col items-center justify-center p-3 rounded-lg border border-surface-container hover:border-primary-container bg-surface-container-low/40 hover:bg-surface-container transition-all" data-device-type="Máy tính bảng" type="button">
                  <span class="material-symbols-outlined text-[26px] text-on-surface-variant group-hover:text-primary mb-1">
                    tablet_mac
                  </span>
                  <span class="font-label-md text-on-surface">
                    Máy tính bảng
                  </span>
                </button>
                <button class="device-option group flex flex-col items-center justify-center p-3 rounded-lg border border-surface-container hover:border-primary-container bg-surface-container-low/40 hover:bg-surface-container transition-all" data-device-type="Gia dụng thông minh" type="button">
                  <span class="material-symbols-outlined text-[26px] text-on-surface-variant group-hover:text-primary mb-1">
                    vacuum
                  </span>
                  <span class="font-label-md text-on-surface">
                    Gia dụng thông minh
                  </span>
                </button>
              </div>
              <input id="device-type" name="device_type" required type="hidden" value=""/>
              <!-- Input Model & Serial -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                <div>
                  <label class="block font-label-sm text-label-sm text-on-surface mb-1">
                    Tên máy / Model
                    <span class="text-error">
                      *
                    </span>
                  </label>
                  <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">
                      laptop
                    </span>
                    <input id="model-name" class="w-full h-10 pl-9 pr-3 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary" name="model_name" required type="text" value=""/>
                  </div>
                </div>
                <div>
                  <label class="block font-label-sm text-label-sm text-on-surface mb-1">
                    Số Serial / IMEI (Tùy chọn tra cứu bảo hành)
                  </label>
                  <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">
                      qr_code_scanner
                    </span>
                    <input id="serial-imei" class="w-full h-10 pl-9 pr-20 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-on-surface uppercase focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary" name="serial_imei" placeholder="Ví dụ: C02G99XZMD6R" type="text" value=""/>
                    <button class="absolute right-1.5 top-1/2 -translate-y-1/2 px-2 py-1 bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-xs rounded" type="button">
                      Kiểm tra
                    </button>
                  </div>
                </div>
              </div>
              <div class="flex items-center gap-1.5 text-xs text-secondary font-medium hidden" id="warranty-status">
                <span class="material-symbols-outlined text-[16px]">
                  verified
                </span>
                <span>
                  Đã nhận diện: AppleCare+ còn hiệu lực đến tháng 11/2025
                </span>
              </div>
            </section>
            <!-- BƯỚC 2: MÔ TẢ LỖI -->
            <section class="bg-surface-container-lowest rounded-xl p-5 border border-surface-container shadow-xs flex flex-col gap-4">
              <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-primary text-on-primary flex items-center justify-center font-label-sm text-xs font-bold">
                  2
                </span>
                <h2 class="font-headline-sm text-headline-sm text-primary font-semibold">
                  Mô Tả Lỗi &amp; Hình Ảnh Hiện Trạng
                </h2>
              </div>
              <!-- Quick Common Errors -->
              <div class="flex flex-col gap-1.5">
                <label class="font-label-sm text-label-sm text-on-surface">
                  Chọn nhanh lỗi phổ biến:
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                  <label class="issue-option flex items-center gap-2 p-2.5 rounded-lg border border-surface-container hover:bg-surface-container-low cursor-pointer">
                    <input class="rounded text-secondary focus:ring-0" name="common_issues[]" type="checkbox" value="Vỡ / Sọc màn hình"/>
                    <span class="font-label-sm text-on-surface">
                      Vỡ / Sọc màn hình
                    </span>
                  </label>
                  <label class="issue-option flex items-center gap-2 p-2.5 rounded-lg border border-surface-container hover:bg-surface-container-low cursor-pointer">
                    <input class="rounded text-secondary focus:ring-0" name="common_issues[]" type="checkbox" value="Chai pin / Phồng pin"/>
                    <span class="font-label-sm text-on-surface">
                      Chai pin / Phồng pin
                    </span>
                  </label>
                  <label class="issue-option flex items-center gap-2 p-2.5 rounded-lg border border-surface-container hover:bg-surface-container-low cursor-pointer">
                    <input class="rounded text-secondary focus:ring-0" name="common_issues[]" type="checkbox" value="Không lên nguồn"/>
                    <span class="font-label-sm text-on-surface">
                      Không lên nguồn
                    </span>
                  </label>
                  <label class="issue-option flex items-center gap-2 p-2.5 rounded-lg border border-surface-container hover:bg-surface-container-low cursor-pointer">
                    <input class="rounded text-secondary focus:ring-0" name="common_issues[]" type="checkbox" value="Lỗi sạc / Cổng Type-C"/>
                    <span class="font-label-sm text-on-surface">
                      Lỗi sạc / Cổng Type-C
                    </span>
                  </label>
                </div>
              </div>
              <!-- Description Textarea -->
              <div>
                <label class="block font-label-sm text-label-sm text-on-surface mb-1">
                  Mô tả biểu hiện lỗi thực tế
                </label>
                <textarea id="error-description" class="w-full p-2.5 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary leading-relaxed" name="error_description" rows="2"></textarea>
              </div>
              <!-- Media Upload -->
              <div class="flex flex-col gap-2">
                <label for="issue-media" class="flex items-center gap-3 p-3 rounded-lg border border-dashed border-outline hover:border-secondary bg-surface-container-low/40 cursor-pointer">
                  <span class="material-symbols-outlined text-[24px] text-secondary">
                    cloud_upload
                  </span>
                  <div class="flex flex-col">
                    <span class="font-label-sm font-medium text-primary">
                      Chọn ảnh/video hiện trạng
                    </span>
                    <span class="text-[11px] text-on-surface-variant">
                      JPG, PNG, WEBP, MP4; tối đa 5 tệp, 50MB mỗi tệp
                    </span>
                  </div>
                  <input class="sr-only" id="issue-media" name="issue_media[]" type="file" accept="image/jpeg,image/png,image/webp,video/mp4" multiple/>
                </label>
                <div class="hidden flex flex-wrap gap-2" id="issue-media-list" aria-live="polite"></div>
              </div>
            </section>
            <!-- BƯỚC 3: CHI NHÁNH & GIỜ HẸN -->
            <section class="bg-surface-container-lowest rounded-xl p-5 border border-surface-container shadow-xs flex flex-col gap-4">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <span class="w-6 h-6 rounded-md bg-primary text-on-primary flex items-center justify-center font-label-sm text-xs font-bold">
                    3
                  </span>
                  <h2 class="font-headline-sm text-headline-sm text-primary font-semibold">
                    Chọn Chi Nhánh &amp; Khung Giờ Hẹn
                  </h2>
                </div>
                <button class="inline-flex items-center gap-1 text-xs font-medium text-secondary hover:underline" type="button">
                  <span class="material-symbols-outlined text-[16px]">
                    near_me
                  </span>
                  <span>
                    Gợi ý qua GPS
                  </span>
                </button>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label class="block font-label-sm text-label-sm text-on-surface mb-1">
                    Tỉnh / Thành phố
                  </label>
                  <select class="w-full h-10 px-3 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-on-surface focus:outline-none focus:border-secondary">
                    <option selected="">
                      Hà Nội (18 Trung tâm)
                    </option>
                    <option>
                      TP. Hồ Chí Minh (24 Trung tâm)
                    </option>
                    <option>
                      Đà Nẵng (6 Trung tâm)
                    </option>
                  </select>
                </div>
                <div>
                  <label class="block font-label-sm text-label-sm text-on-surface mb-1">
                    Trung tâm tiếp nhận
                  </label>
                  <select class="w-full h-10 px-3 rounded-lg border border-secondary bg-primary-fixed/40 font-body-md text-primary font-medium focus:outline-none" name="branch_id" required>
                    <option selected="" value="1">
                      Hub 124 Thái Hà, Q. Đống Đa (Gần bạn nhất)
                    </option>
                    <option value="2">
                      Trụ Sở Keangnam Landmark 72, Nam Từ Liêm
                    </option>
                    <option value="3">
                      Điểm tiếp nhận Cầu Giấy
                    </option>
                  </select>
                </div>
              </div>
              <!-- Date and Time Compact Row -->
              <div>
                <label class="block font-label-sm text-label-sm text-on-surface mb-1.5">
                  Ngày hẹn &amp; Giờ tiếp nhận:
                </label>
                <div class="grid grid-cols-4 gap-2 mb-2.5" id="date-options"></div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" id="time-options">
                  <button class="time-option py-2 px-2 rounded-lg border border-surface-container bg-surface-container-low text-center font-label-sm text-on-surface hover:bg-surface-container" data-time="09:00 - 09:30" type="button">
                    09:00 - 09:30
                  </button>
                  <button class="time-option py-2 px-2 rounded-lg border border-surface-container bg-surface-container-low text-center font-label-sm text-on-surface hover:bg-surface-container" data-time="10:30 - 11:00" type="button">
                    10:30 - 11:00
                  </button>
                  <button class="time-option py-2 px-2 rounded-lg border border-surface-container bg-surface-container-low text-center font-label-sm text-on-surface hover:bg-surface-container" data-time="14:00 - 14:30" type="button">
                    14:00 - 14:30
                  </button>
                  <button class="time-option py-2 px-2 rounded-lg border border-surface-container bg-surface-container-low text-center font-label-sm text-on-surface hover:bg-surface-container" data-time="16:30 - 17:00" type="button">
                    16:30 - 17:00
                  </button>
                </div>
                <input id="appointment-date" class="w-full h-10 mt-2 px-3 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-on-surface focus:outline-none focus:border-secondary" name="appointment_date" required type="date"/>
                <input id="appointment-time" name="appointment_time" required type="hidden" value=""/>
              </div>
            </section>
            <!-- BƯỚC 4: THÔNG TIN KHÁCH HÀNG -->
            <section class="bg-surface-container-lowest rounded-xl p-5 border border-surface-container shadow-xs flex flex-col gap-4">
              <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-primary text-on-primary flex items-center justify-center font-label-sm text-xs font-bold">
                  4
                </span>
                <h2 class="font-headline-sm text-headline-sm text-primary font-semibold">
                  Thông Tin Khách Hàng
                </h2>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label class="block font-label-sm text-label-sm text-on-surface mb-1">
                    Họ và tên
                    <span class="text-error">
                      *
                    </span>
                  </label>
                  <input id="full-name" class="w-full h-10 px-3 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-on-surface focus:outline-none focus:border-secondary" name="full_name" required type="text" value=""/>
                </div>
                <div>
                  <label class="block font-label-sm text-label-sm text-on-surface mb-1">
                    Số điện thoại
                    <span class="text-error">
                      *
                    </span>
                  </label>
                  <input id="phone" class="w-full h-10 px-3 rounded-lg border border-outline-variant bg-surface-container-lowest font-body-md text-on-surface focus:outline-none focus:border-secondary" name="phone" required type="tel" value=""/>
                </div>
              </div>
              <div>
                <label class="block font-label-sm text-label-sm text-on-surface mb-1.5">
                  Phương thức nhận mã phiếu hẹn &amp; QR Fast-Track:
                </label>
                <div class="flex flex-wrap gap-4">
                  <label class="flex items-center gap-2 cursor-pointer">
                    <input checked="" class="text-secondary focus:ring-0" name="notify_method" type="radio"/>
                    <span class="font-label-sm text-primary font-semibold">
                      Zalo OA (ZNS kèm QR)
                    </span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer">
                    <input class="text-secondary focus:ring-0" name="notify_method" type="radio"/>
                    <span class="font-label-sm text-on-surface">
                      Tin nhắn SMS
                    </span>
                  </label>
                </div>
              </div>
            </section>
            </form>
          </div>
          <!-- RIGHT COLUMN (30%): Sticky Compact Summary & Fast-Track QR Card -->
          <div class="lg:col-span-4 sticky top-20 flex flex-col gap-4">
            <!-- BƯỚC 5 / TÓM TẮT: THẺ XÁC NHẬN ĐẶT LỊCH KÈM MÃ QR FAST-TRACK -->
            <div class="bg-surface-container-lowest rounded-xl p-5 border border-surface-container shadow-xs flex flex-col gap-4">
              <div class="flex items-center justify-between pb-2 border-b border-surface-container">
                <div class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-secondary text-[20px]">
                    receipt_long
                  </span>
                  <h3 class="font-headline-sm text-headline-sm text-primary font-bold">
                    Xác Nhận Đặt Lịch
                  </h3>
                </div>
                <span class="px-2 py-0.5 rounded bg-primary-fixed text-primary font-label-sm text-xs font-semibold">
                  Bước 5
                </span>
              </div>
              <!-- Summary Info List -->
              <div class="flex flex-col gap-2.5 text-sm">
                <div class="flex justify-between py-1 border-b border-surface-container-low">
                  <span class="text-on-surface-variant">
                    Thiết bị:
                  </span>
                  <span class="font-semibold text-on-surface text-right" id="summary-device">
                    Chưa chọn
                  </span>
                </div>
                <div class="flex justify-between py-1 border-b border-surface-container-low">
                  <span class="text-on-surface-variant">
                    Vấn đề:
                  </span>
                  <span class="font-medium text-on-surface text-right" id="summary-issue">
                    Chưa nhập
                  </span>
                </div>
                <div class="flex justify-between py-1 border-b border-surface-container-low">
                  <span class="text-on-surface-variant">
                    Địa điểm:
                  </span>
                  <span class="font-medium text-on-surface text-right" id="summary-branch">
                    Chưa chọn
                  </span>
                </div>
                <div class="flex justify-between py-1 border-b border-surface-container-low">
                  <span class="text-on-surface-variant">
                    Thời gian:
                  </span>
                  <span class="font-bold text-secondary text-right" id="summary-time">
                    Chưa chọn
                  </span>
                </div>
                <div class="flex justify-between py-1 border-b border-surface-container-low">
                  <span class="text-on-surface-variant">
                    Khách hàng:
                  </span>
                  <span class="font-medium text-on-surface text-right" id="summary-customer">
                    Chưa nhập
                  </span>
                </div>
                <div class="flex justify-between py-1">
                  <span class="text-on-surface-variant">
                    Phí kiểm tra ban đầu:
                  </span>
                  <span class="font-bold text-primary text-right" id="summary-fee">
                    0 VNĐ (Miễn phí)
                  </span>
                </div>
              </div>
              <!-- Fast-Track QR Digital Pass Box -->
              <div class="p-4 rounded-xl bg-gradient-to-b from-primary-container to-primary text-on-primary flex flex-col items-center text-center gap-2">
                <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-secondary text-[11px] font-bold uppercase tracking-wider text-on-secondary">
                  <span class="material-symbols-outlined text-[14px]">
                    qr_code
                  </span>
                  <span>
                    Mã Fast-Track
                  </span>
                </div>
                <div class="w-32 h-32 bg-surface-container-lowest p-2 rounded-lg shadow-sm flex items-center justify-center" id="booking-qr">
                  <span class="material-symbols-outlined text-5xl text-primary">qr_code_2</span>
                </div>
                <div class="font-headline-sm text-base font-bold text-on-primary tracking-wider" id="booking-qr-code">
                  Chưa có mã
                </div>
                <span class="text-[11px] text-primary-fixed">
                  Quét mã tại Kiosk quầy tiếp nhận để nhận số ưu tiên
                </span>
              </div>
              <!-- Confirm Booking CTA Button -->
              <button class="w-full h-11 rounded-lg bg-primary hover:bg-secondary text-on-primary font-label-md font-bold flex items-center justify-center gap-2 shadow transition-all" form="booking-form" type="submit">
                <span class="material-symbols-outlined text-[20px]">
                  check_circle
                </span>
                <span>
                  Hoàn Tất Đặt Lịch Hẹn
                </span>
              </button>
              <div class="flex items-center justify-center gap-1 text-[12px] text-on-surface-variant text-center">
                <span class="material-symbols-outlined text-[15px] text-secondary">
                  info
                </span>
                <span>
                  Có thể đổi hoặc hủy lịch miễn phí qua hotline 1800 6868
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Minimal Streamlined Footer -->
    <footer class="w-full bg-surface-container-lowest border-t border-surface-container py-6 mt-12">
      <div class="max-w-[1280px] mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-on-surface-variant">
        <div class="flex items-center gap-2">
          <span class="font-semibold text-primary">
            ReliantCare Việt Nam
          </span>
          <span>
            •
          </span>
          <span>
            Hệ thống tiếp nhận sửa chữa &amp; bảo hành tiêu chuẩn
          </span>
        </div>
        <div class="flex items-center gap-4">
          <span>
            Tổng đài miễn phí:
            <strong class="text-primary font-bold">
              1800 6868
            </strong>
          </span>
          <span>
            •
          </span>
          <span>
            © 2025 ReliantCare. Bảo lưu mọi quyền.
          </span>
        </div>
      </div>
    </footer>
  </body>
</html>
