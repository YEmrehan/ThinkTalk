<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// .env'den veritabanı bilgilerini al
$servername = $_ENV['SERVERR_NAME'];
$username   = $_ENV['MYSQL_USER'];
$password   = $_ENV['MYSQL_PASSWORD'];
$dbname     = $_ENV['MYSQL_DATABASE'];

// Veritabanı bağlantısı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Türkçe karakterler için charset ayarı
$conn->set_charset("utf8mb4");

// Kullanıcı yetkisini kontrol eden fonksiyon
function kullaniciYetkisiniKontrolEt($userId, $conn) {
    $stmt = $conn->prepare("SELECT yetki FROM kullanicilar WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['yetki'] ?? null;
}