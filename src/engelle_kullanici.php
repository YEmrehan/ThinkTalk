<?php
include 'db.php';
session_start();
if (isset($_POST['kullanici_id'])) {
    $kullanici_id = $_POST['kullanici_id'];

    $stmt = $conn->prepare("UPDATE kullanicilar SET yetki = CASE WHEN yetki = 0 THEN 1 ELSE 0 END WHERE id = ?");
    $stmt->bind_param("i", $kullanici_id);
    $stmt->execute();

    header('Location: kullanicilar.php');
    exit();
}