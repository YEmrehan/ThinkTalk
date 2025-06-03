<?php
include 'db.php';
session_start();

if (isset($_POST['konu_id'])) {
    $konu_id = $_POST['konu_id'];

    $yorum_stmt = $conn->prepare("DELETE FROM yorumlar WHERE konu_id = ?");
    $yorum_stmt->bind_param("i", $konu_id);
    $yorum_stmt->execute();

    $stmt = $conn->prepare("DELETE FROM konular WHERE id = ?");
    $stmt->bind_param("i", $konu_id);
    $stmt->execute();

    header('Location: admin.php');
    exit();
} else {
    echo "Konu ID'si bulunamadı.";
}