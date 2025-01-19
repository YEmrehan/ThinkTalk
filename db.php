<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

function kullaniciYetkisiniKontrolEt($userId, $conn) {
    $stmt = $conn->prepare("SELECT yetki FROM kullanicilar WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['yetki'];
}