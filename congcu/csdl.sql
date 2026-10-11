CREATE TABLE accounts (
    account_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('customer', 'technician', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT UNIQUE, -- Khóa ngoại nối sang accounts
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) UNIQUE NOT NULL,
    address VARCHAR(255),
    FOREIGN KEY (account_id) REFERENCES accounts(account_id) ON DELETE CASCADE
);

CREATE TABLE technicians (
    tech_id INT AUTO_INCREMENT PRIMARY KEY,
    tech_code VARCHAR(20) UNIQUE NOT NULL, -- Mã KTV
    full_name VARCHAR(100) NOT NULL,       -- Tên KTV
    expertise VARCHAR(255) NOT NULL        -- Nghiệp vụ chuyên môn
);

CREATE TABLE devices (
    device_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    device_name VARCHAR(150) NOT NULL,
    imei_serial VARCHAR(100) UNIQUE,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

CREATE TABLE parts (
    part_id INT AUTO_INCREMENT PRIMARY KEY,
    part_code VARCHAR(50) UNIQUE NOT NULL, -- Mã linh kiện
    part_name VARCHAR(150) NOT NULL,       -- Tên linh kiện
    price DECIMAL(12,2) NOT NULL           -- Giá
);

CREATE TABLE repairs (
    repair_id INT AUTO_INCREMENT PRIMARY KEY,
    device_id INT NOT NULL,
    tech_id INT NOT NULL,               -- KTV chịu trách nhiệm chính
    received_date DATE NOT NULL,        -- Ngày ghi nhận
    damage_level ENUM('Nhẹ', 'Trung bình', 'Nặng', 'Hư hỏng toàn phần') NOT NULL, -- Mức độ
    status ENUM('Đã tiếp nhận', 'Đang sửa', 'Chờ linh kiện', 'Hoàn thành') DEFAULT 'Đã tiếp nhận', -- Trạng thái
    progress_percent INT DEFAULT 0 CHECK (progress_percent >= 0 AND progress_percent <= 100),     -- Tiến độ (%)
    total_cost DECIMAL(12,2) DEFAULT 0, -- Chi phí tổng
    FOREIGN KEY (device_id) REFERENCES devices(device_id) ON DELETE CASCADE,
    FOREIGN KEY (tech_id) REFERENCES technicians(tech_id)
);

CREATE TABLE repair_parts_usage (
    usage_id INT AUTO_INCREMENT PRIMARY KEY,
    repair_id INT NOT NULL,
    part_id INT NOT NULL,
    used_by_tech_id INT NOT NULL, -- Cụ thể KTV nào đã xuất/dùng linh kiện này
    quantity INT DEFAULT 1,
    FOREIGN KEY (repair_id) REFERENCES repairs(repair_id) ON DELETE CASCADE,
    FOREIGN KEY (part_id) REFERENCES parts(part_id),
    FOREIGN KEY (used_by_tech_id) REFERENCES technicians(tech_id)
);


INSERT INTO accounts (username, password_hash, role) VALUES 
('khachhang1', 'hash_pass_123', 'customer'),
('khachhang2', 'hash_pass_456', 'customer'),
('khachhang3', 'hash_pass_789', 'customer');

-- 2. Thêm 3 Khách hàng (Nối với account_id tương ứng)
INSERT INTO customers (account_id, full_name, phone, address) VALUES 
(1, 'Nguyễn Hoàng Minh', '0918293847', 'Cầu Giấy, Hà Nội'),
(2, 'Lê Thị Mai', '0988111222', 'Đống Đa, Hà Nội'),
(3, 'Trần Văn Nam', '0909555666', 'Quận 1, TP.HCM');

INSERT INTO technicians (tech_code, full_name, expertise) VALUES 
('KTV-001', 'Trần Minh Hoàng', 'Phần cứng Apple (MacBook, iPhone)'),
('KTV-002', 'Phạm Quốc Bảo', 'Phần mềm & Unlock thiết bị di động'),
('KTV-003', 'Ngô Thanh Tuấn', 'Điện tử vi mạch, sửa mainboard');

INSERT INTO devices (customer_id, device_name, imei_serial) VALUES 
(1, 'iPad Pro 11-inch (M2)', 'DLX89123891'),
(1, 'Samsung Galaxy S23 Ultra', '359988776655443'),
(2, 'Apple Watch Series 8 45mm', 'GY34X8911C'),
(2, 'Asus Zenbook 14 OLED', 'AS99123841'),
(3, 'iPhone 13 Pro 256GB', '351122334455667'),
(3, 'Lenovo ThinkPad T14 Gen 3', 'PF123456');

INSERT INTO parts (part_code, part_name, price) VALUES 
('LK-IP-03', 'Màn hình iPhone 14 Pro Max (Zin tháo máy)', 4500000),
('LK-IP-04', 'Cụm Camera sau iPhone 13 Pro', 1800000),
('LK-SS-01', 'Màn hình Samsung Galaxy S23 Ultra', 5200000),
('LK-SS-02', 'Pin Samsung Galaxy Note 20 Ultra Chính hãng', 650000),
('LK-MAC-02', 'Bàn phím MacBook Air M1 (Layout US)', 1200000),
('LK-MAC-03', 'Pin MacBook Pro 15-inch 2019', 1850000),
('LK-DL-04', 'Bàn phím Dell Inspiron 5000 Series', 350000),
('LK-AS-01', 'Bản lề Asus ROG Strix G15', 400000),
('LK-GEN-01', 'Ổ cứng SSD Samsung 980 NVMe 500GB', 1100000),
('LK-GEN-02', 'RAM Kingston Fury 16GB DDR4 3200MHz', 950000),
('LK-AW-01', 'Mặt kính Apple Watch Series 8 45mm', 850000);accounts

INSERT INTO repairs (device_id, tech_id, received_date, damage_level, status, progress_percent, total_cost) VALUES 
(1, 1, '2026-09-10', 'Trung bình', 'Đang sửa', 50, 600000),     -- KTV 1 sửa máy của Khách 1
(2, 2, '2026-09-15', 'Nhẹ', 'Hoàn thành', 100, 1350000),        -- KTV 2 sửa máy của Khách 2
(3, 3, '2026-09-17', 'Nặng', 'Chờ linh kiện', 10, 0);           -- KTV 3 sửa máy của Khách 3

INSERT INTO repair_parts_usage (repair_id, part_id, used_by_tech_id, quantity) VALUES 
(1, 1, 1, 1), -- Ca sửa 1, dùng cáp MacBook, do KTV Hoàng thực hiện
(2, 2, 2, 1), -- Ca sửa 2, dùng Pin iPhone, do KTV Bảo thực hiện
(3, 3, 3, 2); -- Ca sửa 3, dùng 2 Quạt tản nhiệt, do KTV Tuấn thực hiện