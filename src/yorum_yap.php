<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: giris.php');
    exit();
}

$userId = $_SESSION['user_id'];
$yetki = kullaniciYetkisiniKontrolEt($userId, $conn);
if ($yetki == 1) {
    echo "Bu işlemi gerçekleştirme yetkiniz yok.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $konu_id = $_POST['konu_id'];
    $yorum = $_POST['yorum'];
    $kullanici_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO yorumlar (konu_id, kullanici_id, yorum) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $konu_id, $kullanici_id, $yorum);
    if ($stmt->execute()) {
        header("Location: konubak.php?id=" . $konu_id);
        exit();
    } else {
        echo "Yorum kaydedilemedi.";
    }
}