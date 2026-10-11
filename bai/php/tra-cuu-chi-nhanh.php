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
    <!-- HEADER / NAVIGATION (5 chuẩns) -->
    <header class="site-header fixed top-0 w-full z-50 bg-surface/90 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
      <div class="h-20 max-w-[1440px] mx-auto px-margin flex items-center justify-between gap-space-md">
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
          <nav class="site-nav hidden xl:flex items-center gap-space-xs">
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="trang-chu-tra-cuu" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">search</span>
              <span>Tra cứu</span><link href="trang-chu.php"/>
            </a>
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="dat-lich-sua-chua" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">build</span>
              <span>Bảo hành &amp; Sửa chữa</span><link href="dat-lich-hen.php"/>
            </a>
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="theo-doi-tien-do" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">track_changes</span>
              <span>Theo dõi</span><link href="tra-cuu-tien-do.php"/>
            </a>
            <a class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors" data-path="thiet-bi-lich-su" href="#">
              <span class="material-symbols-outlined text-[16px]" aria-hidden="true">devices</span>
              <span>Thiết bị</span><link href="thiet-bi-lich-su.php"/>
            </a>
            <a aria-current="page" class="px-space-sm py-space-xs rounded-lg font-label-md text-label-md bg-primary-container text-on-primary font-semibold shadow-sm" data-path="tra-cuu-chi-nhanh" href="#">
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
        <!-- Hero Intro Banner (Minimal & Modern) -->
        <section class="w-full bg-gradient-to-b from-surface-container/60 to-surface py-space-md border-b border-outline-variant/30">
          <div class="max-w-[1440px] mx-auto px-margin flex flex-col md:flex-row md:items-center justify-between gap-space-sm">
            <nav aria-label="Breadcrumb" class="flex items-center gap-space-xs text-body-sm font-body-sm text-on-surface-variant">
              <a class="hover:text-secondary transition-colors" href="#">
                Trang chủ
              </a>
              <span class="material-symbols-outlined text-[14px]">
                chevron_right
              </span>
              <span class="text-on-surface font-semibold">
                Tra cứu chi nhánh &amp; Hỗ trợ
              </span>
            </nav>
            <div class="flex items-center gap-space-sm text-body-sm text-on-surface-variant">
              <span class="flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-secondary">
                </span>
                48 trung tâm bảo hành toàn quốc
              </span>
              <span class="text-outline-variant">
                •
              </span>
              <span>
                Tổng đài trực: 1800 6868
              </span>
            </div>
          </div>
        </section>
        <!-- SECTION 1: TRA CỨU CHI NHÁNH & BẢN ĐỒ -->
        <section class="w-full py-space-lg bg-surface">
          <div class="max-w-[1440px] mx-auto px-margin">
            <div class="mb-space-md">
              <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">
                Hệ Thống Chi Nhánh &amp; Điểm Tiếp Nhận
              </h1>
              <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Tìm trung tâm dịch vụ gần nhất để được kiểm tra thiết bị trực tiếp và hỗ trợ kỹ thuật lấy ngay.
              </p>
            </div>
            <!-- Search & Filter Controls -->
            <div class="bg-surface-container-lowest p-space-sm md:p-space-md rounded-xl shadow-sm mb-space-md border border-outline-variant/20">
              <div class="grid grid-cols-1 md:grid-cols-12 gap-space-sm items-center">
                <!-- Text Search -->
                <div class="md:col-span-6 relative">
                  <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">
                    search
                  </span>
                  <input class="w-full h-11 pl-11 pr-space-md bg-surface-container-low rounded-lg font-body-md text-body-md text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:ring-2 focus:ring-secondary border-none" id="branch-search-input" placeholder="Tìm theo tên đường, quận/huyện hoặc chi nhánh..." type="text"/>
                </div>
                <!-- City Select -->
                <div class="md:col-span-3 relative">
                  <select class="w-full h-11 px-space-md bg-surface-container-low rounded-lg font-label-md text-label-md text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary appearance-none cursor-pointer border-none" id="city-filter">
                    <option value="all">
                      Tất cả Tỉnh / Thành phố
                    </option>
                    <option selected="" value="hn">
                      Hà Nội (18 chi nhánh)
                    </option>
                    <option value="hcm">
                      TP. Hồ Chí Minh (22 chi nhánh)
                    </option>
                    <option value="dn">
                      Đà Nẵng (4 chi nhánh)
                    </option>
                    <option value="ct">
                      Cần Thơ (2 chi nhánh)
                    </option>
                    <option value="hp">
                      Hải Phòng (2 chi nhánh)
                    </option>
                  </select>
                  <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[20px]">
                    expand_more
                  </span>
                </div>
                <!-- GPS Location Button -->
                <div class="md:col-span-3">
                  <button class="w-full h-11 px-space-md bg-surface-container hover:bg-surface-container-high text-primary font-label-md text-label-md rounded-lg flex items-center justify-center gap-space-xs transition-colors" id="btn-geolocation" type="button">
                    <span class="material-symbols-outlined text-secondary text-[18px]">
                      my_location
                    </span>
                    <span>
                      Định vị gần tôi (GPS)
                    </span>
                  </button>
                </div>
              </div>
            </div>
            <!-- 2-Column Split: Compact Branch List vs Map -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md items-start">
              <!-- Left: Gọn gàng hiển thị Danh sách Chi nhánh (5 cols) -->
              <div class="lg:col-span-5 flex flex-col gap-space-sm max-h-[600px] overflow-y-auto pr-1" id="branch-list-container">
                <!-- Chi nhánh 1 (Active) -->
                <div class="branch-card p-space-md bg-surface-container-lowest rounded-xl border-2 border-secondary shadow-sm transition-all hover:shadow-md cursor-pointer" data-branch="keangnam">
                  <div class="flex items-start justify-between gap-space-xs">
                    <div>
                      <div class="flex items-center gap-2">
                        <h3 class="font-headline-sm text-headline-sm text-primary">
                          Hub Keangnam Landmark 72
                        </h3>
                        <span class="px-2 py-0.5 rounded-full bg-surface-container text-secondary text-label-sm font-semibold">
                          1.2 km
                        </span>
                      </div>
                      <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                        Tầng 1 - Tháp A, Keangnam Landmark 72, Phạm Hùng, Nam Từ Liêm, Hà Nội
                      </p>
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-space-xs mt-space-sm pt-space-xs border-t border-outline-variant/15 text-body-sm">
                    <div class="flex items-center gap-1.5 text-on-surface">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        schedule
                      </span>
                      <span>
                        08:00 - 21:00 (T2 - CN)
                      </span>
                    </div>
                    <div class="flex items-center gap-1.5 text-primary font-semibold">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        call
                      </span>
                      <a class="hover:underline" href="tel:02473006868">
                        024.7300.6868
                      </a>
                    </div>
                  </div>
                  <div class="mt-space-sm flex items-center gap-space-xs">
                    <a class="flex-1 h-8 px-space-sm bg-primary hover:bg-secondary text-on-primary font-label-sm text-label-sm rounded-lg flex items-center justify-center gap-1 transition-colors shadow-sm" href="https://maps.google.com" rel="noopener" target="_blank">
                      <span class="material-symbols-outlined text-[15px]">
                        directions
                      </span>
                      <span>
                        Chỉ đường Google Maps
                      </span>
                    </a>
                    <button class="h-8 px-space-sm bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm rounded-lg flex items-center gap-1 transition-colors" type="button">
                      <span class="material-symbols-outlined text-[15px]">
                        calendar_month
                      </span>
                      <span>
                        Đặt lịch
                      </span>
                    </button>
                  </div>
                </div>
                <!-- Chi nhánh 2 -->
                <div class="branch-card p-space-md bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm transition-all hover:shadow-md hover:border-secondary cursor-pointer" data-branch="thaiha">
                  <div class="flex items-start justify-between gap-space-xs">
                    <div>
                      <div class="flex items-center gap-2">
                        <h3 class="font-headline-sm text-headline-sm text-primary">
                          Hub 124 Thái Hà
                        </h3>
                        <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant text-label-sm">
                          3.5 km
                        </span>
                      </div>
                      <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                        124 Phố Thái Hà, P. Trung Liệt, Q. Đống Đa, Hà Nội
                      </p>
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-space-xs mt-space-sm pt-space-xs border-t border-outline-variant/15 text-body-sm">
                    <div class="flex items-center gap-1.5 text-on-surface">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        schedule
                      </span>
                      <span>
                        08:00 - 21:30 (T2 - CN)
                      </span>
                    </div>
                    <div class="flex items-center gap-1.5 text-primary font-semibold">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        call
                      </span>
                      <a class="hover:underline" href="tel:02473008888">
                        024.7300.8888
                      </a>
                    </div>
                  </div>
                  <div class="mt-space-sm flex items-center gap-space-xs">
                    <a class="flex-1 h-8 px-space-sm bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm rounded-lg flex items-center justify-center gap-1 transition-colors" href="https://maps.google.com" rel="noopener" target="_blank">
                      <span class="material-symbols-outlined text-[15px]">
                        directions
                      </span>
                      <span>
                        Chỉ đường Google Maps
                      </span>
                    </a>
                    <button class="h-8 px-space-sm bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm rounded-lg flex items-center gap-1 transition-colors" type="button">
                      <span class="material-symbols-outlined text-[15px]">
                        calendar_month
                      </span>
                      <span>
                        Đặt lịch
                      </span>
                    </button>
                  </div>
                </div>
                <!-- Chi nhánh 3 -->
                <div class="branch-card p-space-md bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm transition-all hover:shadow-md hover:border-secondary cursor-pointer" data-branch="pasteur">
                  <div class="flex items-start justify-between gap-space-xs">
                    <div>
                      <div class="flex items-center gap-2">
                        <h3 class="font-headline-sm text-headline-sm text-primary">
                          Hub 180 Pasteur (TP.HCM)
                        </h3>
                        <span class="px-2 py-0.5 rounded-full bg-surface-container text-secondary text-label-sm font-semibold">
                          24/7
                        </span>
                      </div>
                      <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                        180 Pasteur, P. Bến Nghé, Quận 1, TP. Hồ Chí Minh
                      </p>
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-space-xs mt-space-sm pt-space-xs border-t border-outline-variant/15 text-body-sm">
                    <div class="flex items-center gap-1.5 text-on-surface">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        schedule
                      </span>
                      <span>
                        Mở cửa 24/7
                      </span>
                    </div>
                    <div class="flex items-center gap-1.5 text-primary font-semibold">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        call
                      </span>
                      <a class="hover:underline" href="tel:02873006868">
                        028.7300.6868
                      </a>
                    </div>
                  </div>
                  <div class="mt-space-sm flex items-center gap-space-xs">
                    <a class="flex-1 h-8 px-space-sm bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm rounded-lg flex items-center justify-center gap-1 transition-colors" href="https://maps.google.com" rel="noopener" target="_blank">
                      <span class="material-symbols-outlined text-[15px]">
                        directions
                      </span>
                      <span>
                        Chỉ đường Google Maps
                      </span>
                    </a>
                    <button class="h-8 px-space-sm bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm rounded-lg flex items-center gap-1 transition-colors" type="button">
                      <span class="material-symbols-outlined text-[15px]">
                        calendar_month
                      </span>
                      <span>
                        Đặt lịch
                      </span>
                    </button>
                  </div>
                </div>
                <!-- Chi nhánh 4 -->
                <div class="branch-card p-space-md bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm transition-all hover:shadow-md hover:border-secondary cursor-pointer" data-branch="danang">
                  <div class="flex items-start justify-between gap-space-xs">
                    <div>
                      <div class="flex items-center gap-2">
                        <h3 class="font-headline-sm text-headline-sm text-primary">
                          Hub 68 Nguyễn Văn Linh
                        </h3>
                        <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant text-label-sm">
                          Đà Nẵng
                        </span>
                      </div>
                      <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                        68 Nguyễn Văn Linh, P. Nam Dương, Q. Hải Châu, Đà Nẵng
                      </p>
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-space-xs mt-space-sm pt-space-xs border-t border-outline-variant/15 text-body-sm">
                    <div class="flex items-center gap-1.5 text-on-surface">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        schedule
                      </span>
                      <span>
                        08:00 - 20:30 (T2 - CN)
                      </span>
                    </div>
                    <div class="flex items-center gap-1.5 text-primary font-semibold">
                      <span class="material-symbols-outlined text-[16px] text-secondary">
                        call
                      </span>
                      <a class="hover:underline" href="tel:023673006868">
                        0236.7300.6868
                      </a>
                    </div>
                  </div>
                  <div class="mt-space-sm flex items-center gap-space-xs">
                    <a class="flex-1 h-8 px-space-sm bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm rounded-lg flex items-center justify-center gap-1 transition-colors" href="https://maps.google.com" rel="noopener" target="_blank">
                      <span class="material-symbols-outlined text-[15px]">
                        directions
                      </span>
                      <span>
                        Chỉ đường Google Maps
                      </span>
                    </a>
                    <button class="h-8 px-space-sm bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm rounded-lg flex items-center gap-1 transition-colors" type="button">
                      <span class="material-symbols-outlined text-[15px]">
                        calendar_month
                      </span>
                      <span>
                        Đặt lịch
                      </span>
                    </button>
                  </div>
                </div>
              </div>
              <!-- Right: Khung Bản đồ Trực Quan Rõ Ràng (7 cols) -->
              <div class="lg:col-span-7 h-[600px] rounded-2xl overflow-hidden shadow-sm border border-outline-variant/20 relative bg-surface-container-highest">
                <div class="w-full h-full bg-cover bg-center relative" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAmZK36vX_PDvm2RHxmLHxGbM5MmpToYdMtd2rPHa2HGDADww8DZ7-aXmLOd3t2otXMm8RVvviMYhibYoF5b7seDS9tWN9Rir34U7SF-q23INHxhAL49wcQ9eFi0PmBHjGy09DGIUep5Pd7F_qkI0hi35RaqJiwhsJQowXLTOBSRQWUHVDuD7ZuRSVmRaQRSW7AZ7fwhJcZieMBB6G6IYmlefmboUegM90D7jLXgEL7tS19WlDJOQ5IFw');">
                  <!-- Map Overlay Gradient -->
                  <div class="absolute inset-0 bg-gradient-to-t from-primary/20 via-transparent to-primary/5 pointer-events-none">
                  </div>
                  <!-- Map Controls -->
                  <div class="absolute top-space-md right-space-md z-10 flex flex-col bg-surface-container-lowest rounded-lg shadow-md overflow-hidden border border-outline-variant/20">
                    <button class="w-9 h-9 flex items-center justify-center text-on-surface hover:bg-surface-container transition-colors" title="Phóng to" type="button">
                      <span class="material-symbols-outlined text-[18px]">
                        add
                      </span>
                    </button>
                    <div class="h-[1px] bg-outline-variant/20">
                    </div>
                    <button class="w-9 h-9 flex items-center justify-center text-on-surface hover:bg-surface-container transition-colors" title="Thu nhỏ" type="button">
                      <span class="material-symbols-outlined text-[18px]">
                        remove
                      </span>
                    </button>
                  </div>
                  <!-- Pin Marker 1 (Selected Hub) -->
                  <div class="absolute top-[42%] left-[46%] -translate-x-1/2 -translate-y-full z-20 flex flex-col items-center">
                    <div class="bg-surface-container-lowest text-on-surface p-space-sm rounded-xl shadow-lg mb-1.5 w-60 border border-outline-variant/20">
                      <div class="flex items-center justify-between text-label-sm font-semibold text-secondary">
                        <span>
                          ĐANG MỞ CỬA
                        </span>
                        <span class="text-on-surface-variant font-normal">
                          Cách 1.2km
                        </span>
                      </div>
                      <h4 class="font-headline-sm text-headline-sm text-primary mt-0.5">
                        Hub Keangnam Landmark 72
                      </h4>
                      <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                        Phạm Hùng, Nam Từ Liêm, Hà Nội
                      </p>
                      <div class="mt-2 pt-1 border-t border-outline-variant/20 flex items-center justify-between">
                        <span class="text-primary font-semibold text-body-sm">
                          024.7300.6868
                        </span>
                        <a class="text-secondary font-label-sm text-label-sm hover:underline" href="https://maps.google.com" target="_blank">
                          Chỉ đường →
                        </a>
                      </div>
                    </div>
                    <div class="relative flex items-center justify-center">
                      <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center shadow-lg ring-4 ring-secondary/30">
                        <span class="material-symbols-outlined text-on-primary text-[20px]">
                          build
                        </span>
                      </div>
                      <div class="absolute inset-0 rounded-full bg-secondary animate-ping opacity-30">
                      </div>
                    </div>
                  </div>
                  <!-- Pin Marker 2 -->
                  <div class="absolute top-[52%] left-[64%] -translate-x-1/2 -translate-y-full z-10 flex flex-col items-center cursor-pointer group">
                    <div class="hidden group-hover:block mb-1 bg-surface-container-lowest px-2 py-0.5 rounded shadow text-label-sm text-primary whitespace-nowrap">
                      Hub Thái Hà (3.5km)
                    </div>
                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center shadow hover:scale-105 transition-transform">
                      <span class="material-symbols-outlined text-on-primary text-[16px]">
                        location_on
                      </span>
                    </div>
                  </div>
                  <!-- Bottom Map Information Capsule -->
                  <div class="absolute bottom-space-md left-space-md right-space-md z-10 bg-surface-container-lowest/95 backdrop-blur-md px-space-md py-2.5 rounded-xl shadow border border-outline-variant/20 flex items-center justify-between gap-space-sm">
                    <div class="flex items-center gap-2 text-body-sm text-on-surface">
                      <span class="material-symbols-outlined text-secondary text-[20px]">
                        navigation
                      </span>
                      <span>
                        Đang chọn:
                        <strong>
                          Hub Keangnam Landmark 72
                        </strong>
                        • Cách bạn ~1.2 km (4 phút di chuyển)
                      </span>
                    </div>
                    <a class="px-space-sm py-1.5 bg-primary hover:bg-secondary text-on-primary font-label-sm text-label-sm rounded-lg flex items-center gap-1 transition-colors shrink-0" href="https://maps.google.com" rel="noopener" target="_blank">
                      <span class="material-symbols-outlined text-[16px]">
                        open_in_new
                      </span>
                      <span>
                        Mở Google Maps
                      </span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- SECTION 2: ĐIỀU KHOẢN & CHÍNH SÁCH BẢO HÀNH (SÚC TÍCH, NGẮN GỌN) -->
        <section class="w-full py-space-xl bg-surface-container-low border-y border-outline-variant/20">
          <div class="max-w-[1440px] mx-auto px-margin">
            <div class="max-w-2xl mb-space-lg">
              <div class="inline-flex items-center gap-1 text-secondary font-label-md text-label-md mb-1">
                <span class="material-symbols-outlined text-[18px]">
                  verified
                </span>
                <span class="uppercase tracking-wider">
                  Minh Bạch &amp; Rõ Ràng
                </span>
              </div>
              <h2 class="font-headline-lg text-headline-lg text-primary tracking-tight">
                Quy Định &amp; Chính Sách Bảo Hành
              </h2>
              <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                Tóm lược điều kiện tiếp nhận bảo hành chuẩn hóa trên toàn bộ hệ thống ReliantCare.
              </p>
            </div>
            <!-- 2 Focused Policy Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md">
              <!-- Khối 1: Bảo hành miễn phí -->
              <div class="bg-surface-container-lowest p-space-lg rounded-2xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center gap-space-sm mb-space-md">
                  <div class="w-10 h-10 rounded-xl bg-surface-container-high flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-[24px]">
                      task_alt
                    </span>
                  </div>
                  <div>
                    <span class="font-label-sm text-label-sm text-secondary uppercase font-bold">
                      Quyền Lợi Miễn Phí 100%
                    </span>
                    <h3 class="font-headline-sm text-headline-sm text-primary">
                      Lỗi Được Bảo Hành Miễn Phí
                    </h3>
                  </div>
                </div>
                <ul class="space-y-space-sm text-body-md text-on-surface">
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">
                      check_circle
                    </span>
                    <div>
                      <strong>
                        Lỗi phần cứng do nhà sản xuất:
                      </strong>
                      Bo mạch chủ, lỗi chíp nguồn, lỗi RAM/SSD hàn chết, mất nguồn tự nhiên.
                    </div>
                  </li>
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">
                      check_circle
                    </span>
                    <div>
                      <strong>
                        Lỗi màn hình &amp; cảm ứng:
                      </strong>
                      Kẻ sọc tự nhiên, đốm sáng, điểm chết cụm &gt;3 điểm, loạn cảm ứng không do va đập.
                    </div>
                  </li>
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">
                      check_circle
                    </span>
                    <div>
                      <strong>
                        Pin &amp; Sạc chính hãng:
                      </strong>
                      Pin chai phồng quá 20% dung lượng trong kỳ hạn bảo hành, chập IC nhận sạc gốc.
                    </div>
                  </li>
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">
                      check_circle
                    </span>
                    <div>
                      <strong>
                        Cam kết 1 đổi 1 linh kiện:
                      </strong>
                      Đổi mới linh kiện thay thế ngay lập tức nếu phát sinh lỗi trong 12 tháng.
                    </div>
                  </li>
                </ul>
              </div>
              <!-- Khối 2: Từ chối bảo hành -->
              <div class="bg-surface-container-lowest p-space-lg rounded-2xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center gap-space-sm mb-space-md">
                  <div class="w-10 h-10 rounded-xl bg-surface-container-high flex items-center justify-center text-error">
                    <span class="material-symbols-outlined text-[24px]">
                      cancel
                    </span>
                  </div>
                  <div>
                    <span class="font-label-sm text-label-sm text-error uppercase font-bold">
                      Trường Hợp Loại Trừ
                    </span>
                    <h3 class="font-headline-sm text-headline-sm text-primary">
                      Trường Hợp Từ Chối Bảo Hành
                    </h3>
                  </div>
                </div>
                <ul class="space-y-space-sm text-body-md text-on-surface">
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-error text-[20px] shrink-0 mt-0.5">
                      error
                    </span>
                    <div>
                      <strong>
                        Vào nước &amp; Ẩm mốc:
                      </strong>
                      Quỳ tím chuyển đỏ, dấu vết chập cháy hoặc oxy hóa do chất lỏng xâm nhập.
                    </div>
                  </li>
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-error text-[20px] shrink-0 mt-0.5">
                      error
                    </span>
                    <div>
                      <strong>
                        Rơi vỡ &amp; Cấn móp vật lý:
                      </strong>
                      Màn hình nứt vỡ, cấn góc, cong vênh khung vỏ ngoài hoặc biến dạng vật lý.
                    </div>
                  </li>
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-error text-[20px] shrink-0 mt-0.5">
                      error
                    </span>
                    <div>
                      <strong>
                        Can thiệp trái phép:
                      </strong>
                      Mất tem niêm phong, ốc vít toét, máy đã từng qua sửa chữa tại cơ sở ngoài ủy quyền.
                    </div>
                  </li>
                  <li class="flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-secondary text-[20px] shrink-0 mt-0.5">
                      info
                    </span>
                    <div>
                      <em>
                        Chính sách trợ giá:
                      </em>
                      Thiết bị từ chối được hỗ trợ 30% - 50% chi phí sửa chữa thay thế linh kiện.
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </section>
        <!-- SECTION 3: KÊNH HỖ TRỢ NHANH & TICKET TINH GIẢN -->
        <section class="w-full py-space-xl bg-surface">
          <div class="max-w-[1440px] mx-auto px-margin">
            <!-- Fast Contact Channels Bar -->
            <div class="bg-primary text-on-primary rounded-2xl p-space-lg shadow-lg mb-space-lg">
              <div class="flex flex-col lg:flex-row items-center justify-between gap-space-md">
                <div>
                  <span class="font-label-sm text-label-sm text-surface-container-highest uppercase tracking-wider">
                    Kênh hỗ trợ trực tiếp 24/7
                  </span>
                  <h3 class="font-headline-md text-headline-md text-on-primary mt-0.5">
                    Cần Hỗ Trợ Kỹ Thuật Tức Thì?
                  </h3>
                  <p class="font-body-sm text-body-sm text-surface-container-high/90">
                    Kỹ thuật viên luôn sẵn sàng giải đáp thắc mắc và hướng dẫn xử lý sự cố khẩn cấp.
                  </p>
                </div>
                <!-- 3 Nút liên hệ trực tiếp -->
                <div class="flex flex-wrap items-center gap-space-sm w-full lg:w-auto">
                  <a class="h-11 px-space-md bg-secondary hover:bg-secondary-container text-on-secondary font-label-md text-label-md rounded-xl flex items-center gap-2 shadow-sm transition-colors" href="tel:18006868">
                    <span class="material-symbols-outlined text-[20px]">
                      call
                    </span>
                    <span>
                      Gọi 1800 6868
                    </span>
                  </a>
                  <a class="h-11 px-space-md bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-xl flex items-center gap-2 shadow-sm transition-colors" href="#" rel="noopener" target="_blank">
                    <span class="material-symbols-outlined text-secondary text-[20px]">
                      chat
                    </span>
                    <span>
                      Chat Zalo OA
                    </span>
                  </a>
                  <a class="h-11 px-space-md bg-surface-container-lowest hover:bg-surface-container text-primary font-label-md text-label-md rounded-xl flex items-center gap-2 shadow-sm transition-colors" href="#" rel="noopener" target="_blank">
                    <span class="material-symbols-outlined text-secondary text-[20px]">
                      forum
                    </span>
                    <span>
                      Chat Messenger
                    </span>
                  </a>
                </div>
              </div>
            </div>
            <!-- Ticket Section: Form tinh giản & Tra cứu Ticket nhanh -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md items-start">
              <!-- Form Gửi Ticket Tinh Giản (7 cols) -->
              <div class="lg:col-span-7 bg-surface-container-lowest p-space-lg rounded-2xl border border-outline-variant/20 shadow-sm">
                <div class="flex items-center justify-between mb-space-md">
                  <div>
                    <h3 class="font-headline-sm text-headline-sm text-primary">
                      Gửi Yêu Cầu Hỗ Trợ (Ticket)
                    </h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                      Điền thông tin để đội ngũ kỹ thuật tiếp nhận và liên hệ phản hồi trong 15 phút.
                    </p>
                  </div>
                  <span class="material-symbols-outlined text-secondary text-[24px]">
                    confirmation_number
                  </span>
                </div>
                <form class="space-y-space-sm" id="support-ticket-form">
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                    <div>
                      <label class="block font-label-sm text-label-sm text-on-surface mb-1" for="ticket-name">
                        Họ và tên
                        <span class="text-error">
                          *
                        </span>
                      </label>
                      <input class="w-full h-10 px-space-sm bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary border-none" id="ticket-name" placeholder="Ví dụ: Trần Long" required="" type="text"/>
                    </div>
                    <div>
                      <label class="block font-label-sm text-label-sm text-on-surface mb-1" for="ticket-phone">
                        Số điện thoại
                        <span class="text-error">
                          *
                        </span>
                      </label>
                      <input class="w-full h-10 px-space-sm bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary border-none" id="ticket-phone" placeholder="Ví dụ: 0912 345 678" required="" type="tel"/>
                    </div>
                  </div>
                  <div>
                    <label class="block font-label-sm text-label-sm text-on-surface mb-1" for="ticket-device-code">
                      Mã máy / Số Serial / Mã phiếu (RMA)
                    </label>
                    <input class="w-full h-10 px-space-sm bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary uppercase placeholder:normal-case border-none" id="ticket-device-code" placeholder="VD: RMA-2025-0812 hoặc C02F..." type="text"/>
                  </div>
                  <div>
                    <label class="block font-label-sm text-label-sm text-on-surface mb-1" for="ticket-content">
                      Nội dung cần hỗ trợ
                      <span class="text-error">
                        *
                      </span>
                    </label>
                    <textarea class="w-full p-space-sm bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary resize-none border-none" id="ticket-content" placeholder="Mô tả hiện trạng máy, lỗi phần cứng hoặc nội dung cần tư vấn..." required="" rows="3"></textarea>
                  </div>
                  <div class="pt-space-xs flex justify-end">
                    <button class="h-10 px-space-lg bg-primary hover:bg-secondary text-on-primary font-label-md text-label-md rounded-lg shadow-sm flex items-center justify-center gap-2 transition-colors w-full sm:w-auto" type="submit">
                      <span class="material-symbols-outlined text-[18px]">
                        send
                      </span>
                      <span>
                        Gửi Ticket Hỗ Trợ
                      </span>
                    </button>
                  </div>
                </form>
              </div>
              <!-- Tra Cứu Ticket Nhanh & Trạng Thái (5 cols) -->
              <div class="lg:col-span-5 flex flex-col gap-space-sm">
                <!-- Box Tra cứu Ticket -->
                <div class="bg-surface-container-lowest p-space-lg rounded-2xl border border-outline-variant/20 shadow-sm">
                  <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-secondary text-[22px]">
                      search_check
                    </span>
                    <h4 class="font-headline-sm text-headline-sm text-primary">
                      Tra Cứu Ticket Nhanh
                    </h4>
                  </div>
                  <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-sm">
                    Nhập mã ticket hoặc số điện thoại để xem trạng thái xử lý.
                  </p>
                  <div class="flex gap-space-xs">
                    <input class="flex-1 h-10 px-space-sm bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary border-none" placeholder="Nhập mã Ticket hoặc SĐT..." type="text"/>
                    <button class="h-10 px-space-md bg-secondary hover:bg-primary text-on-secondary font-label-sm text-label-sm rounded-lg transition-colors shrink-0" type="button">
                      Tra cứu
                    </button>
                  </div>
                  <!-- Ví dụ trạng thái Ticket mẫu -->
                  <div class="mt-space-md pt-space-md border-t border-outline-variant/15">
                    <div class="p-space-sm bg-surface-container-low rounded-xl">
                      <div class="flex items-center justify-between mb-1">
                        <span class="font-label-sm text-label-sm font-bold text-primary">
                          #TK-8821 • MacBook Pro
                        </span>
                        <span class="px-2 py-0.5 bg-surface-container-highest text-secondary rounded font-label-sm text-label-sm font-semibold">
                          Đang xử lý
                        </span>
                      </div>
                      <p class="font-body-sm text-body-sm text-on-surface-variant">
                        KTV Nguyễn Quốc Huy đã tiếp nhận và đang tiến hành chẩn đoán phần cứng.
                      </p>
                    </div>
                  </div>
                </div>
                <!-- Mini Security Guarantee Badge -->
                <div class="bg-surface-container-lowest p-space-md rounded-xl border border-outline-variant/20 flex items-center gap-space-sm">
                  <div class="w-9 h-9 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary shrink-0">
                    <span class="material-symbols-outlined text-[20px]">
                      shield
                    </span>
                  </div>
                  <p class="font-body-sm text-body-sm text-on-surface-variant">
                    Thông tin liên hệ và dữ liệu thiết bị của khách hàng được bảo mật tuyệt đối theo tiêu chuẩn ISO 27001.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Simple Script for interactions -->
      </div>
    </main>
    <!-- TỐI GIẢN FOOTER -->
    <footer class="w-full bg-surface-container-lowest py-space-md border-t border-outline-variant/20">
      <div class="max-w-[1440px] mx-auto px-margin flex flex-col md:flex-row items-center justify-between gap-space-sm font-body-sm text-body-sm text-on-surface-variant">
        <div class="flex items-center gap-space-sm">
          <span class="font-headline-sm text-headline-sm text-primary">
            ReliantCare
          </span>
          <span>
            © 2025 Hệ thống Trung tâm Dịch vụ Kỹ thuật &amp; Bảo hành Toàn quốc.
          </span>
        </div>
        <div class="flex items-center gap-space-md">
          <span>
            Hotline:
            <strong class="text-primary font-semibold">
              1800 6868
            </strong>
            (Miễn phí)
          </span>
          <span class="text-outline-variant">
            •
          </span>
          <span>
            support@reliantcare.vn
          </span>
        </div>
      </div>
    </footer>
  </body>
</html>
