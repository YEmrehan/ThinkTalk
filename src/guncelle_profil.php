<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: giris.php');
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hakkinda = $_POST['hakkinda'];

    $stmt = $conn->prepare("UPDATE kullanicilar SET hakkinda = ? WHERE id = ?");
    $stmt->bind_param("si", $hakkinda, $userId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: profil.php?guncelle=ok');
    } else {
        header('Location: profil.php?guncelle=no');
    }
    exit();
}