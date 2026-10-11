<?php
require "db.php";
session_start();
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  echo json_encode([
    "success" => false,
    "message" => "Phương thức không được hỗ trợ.",
  ]);
  exit();
}

$payload = json_decode(file_get_contents("php://input"), true) ?: $_POST;
$mode = $payload["mode"] ?? "login";
$mode = trim((string) $mode);
if ($mode === "logout") {
  $_SESSION = [];
  session_destroy();
  echo json_encode(["success" => true]);
  exit();
}
$account = trim((string) ($payload["account"] ?? ""));
$password = (string) ($payload["password"] ?? "");

if ($account === "" || $password === "") {
  http_response_code(422);
  echo json_encode([
    "success" => false,
    "message" => "Vui lòng nhập tài khoản và mật khẩu.",
  ]);
  exit();
}

try {
  if ($mode === "register") {
    $full_name = trim((string) ($payload["full_name"] ?? ""));
    $phone = trim((string) ($payload["phone"] ?? ""));
    if ($full_name === "" || $phone === "") {
      throw new RuntimeException("Vui lòng nhập họ tên và số điện thoại.");
    }
    $pdo->beginTransaction();
    $stmt = $pdo->prepare(
      'INSERT INTO accounts (username, password_hash, role) VALUES (?, ?, \'customer\')',
    );
    $stmt->execute([$account, password_hash($password, PASSWORD_DEFAULT)]);
    $account_id = (int) $pdo->lastInsertId();
    $stmt = $pdo->prepare(
      "INSERT INTO customers (account_id, full_name, phone) VALUES (?, ?, ?)",
    );
    $stmt->execute([$account_id, $full_name, $phone]);
    $pdo->commit();
  } else {
    $stmt = $pdo->prepare(
      "SELECT account_id, username, password_hash, role FROM accounts WHERE username = ? LIMIT 1",
    );
    $stmt->execute([$account]);
    $user = $stmt->fetch();
    if (!$user || !password_verify($password, $user["password_hash"])) {
      throw new RuntimeException("Tài khoản hoặc mật khẩu không đúng.");
    }
    $account_id = (int) $user["account_id"];
  }

  session_regenerate_id(true);
  $_SESSION["account_id"] = $account_id;
  echo json_encode(["success" => true, "account_id" => $account_id]);
} catch (Throwable $error) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  http_response_code(422);
  echo json_encode(["success" => false, "message" => $error->getMessage()]);
}
