<?php
include 'db.php';
session_start();

if (isset($_POST['yorum_id'])) {
    $yorum_id = $_POST['yorum_id'];

    $stmt = $conn->prepare("DELETE FROM yorumlar WHERE id = ?");
    $stmt->bind_param("i", $yorum_id);
    $stmt->execute();

    header('Location: admin.php');
    exit();
} else {
    echo "Yorum ID'si bulunamadı.";
}