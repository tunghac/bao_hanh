<?php
$host = "localhost";
$dbname = "reliantcare_db";
$username = "root";
$password = "123456"; // Mặc định XAMPP là rỗng

try {
  $pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $username,
    $password,
  );
  // Bật chế độ báo lỗi exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec("CREATE TABLE IF NOT EXISTS booking_requests (
        booking_id INT AUTO_INCREMENT PRIMARY KEY,
        booking_code VARCHAR(30) NOT NULL UNIQUE,
        customer_id INT NOT NULL,
        device_id INT NOT NULL,
        device_type VARCHAR(60) NOT NULL,
        branch_name VARCHAR(150) NOT NULL,
        error_description TEXT NOT NULL,
        appointment_date DATE NOT NULL,
        appointment_time VARCHAR(30) NOT NULL,
        status VARCHAR(40) NOT NULL DEFAULT 'Đã tiếp nhận',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_booking_customer (customer_id),
        INDEX idx_booking_device (device_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
  $media_column = $pdo
    ->query("SHOW COLUMNS FROM booking_requests LIKE 'media_paths'")
    ->fetch();
  if (!$media_column) {
    $pdo->exec(
      "ALTER TABLE booking_requests ADD COLUMN media_paths TEXT NULL AFTER error_description",
    );
  }
} catch (PDOException $e) {
  die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>
