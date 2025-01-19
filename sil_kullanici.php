<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: giris.php');
    exit();
}

$userId = $_SESSION['user_id'];
$yetki_stmt = $conn->prepare("SELECT yetki FROM kullanicilar WHERE id = ?");
$yetki_stmt->bind_param("i", $userId);
$yetki_stmt->execute();
$yetki_result = $yetki_stmt->get_result();
$yetki = $yetki_result->fetch_assoc()['yetki'];

if ($yetki != 2) {
    header('Location: anasayfa.php');
    exit();
}

if (isset($_POST['kullanici_id'])) {
    $kullanici_id = $_POST['kullanici_id'];

    $delete_yorum_stmt = $conn->prepare("DELETE FROM yorumlar WHERE kullanici_id = ?");
    if (!$delete_yorum_stmt) {
        die("Hata: " . $conn->error);
    }
    $delete_yorum_stmt->bind_param("i", $kullanici_id);
    $delete_yorum_stmt->execute();

    $konular_stmt = $conn->prepare("SELECT id FROM konular WHERE kullanici_id = ?");
    $konular_stmt->bind_param("i", $kullanici_id);
    $konular_stmt->execute();
    $konular_result = $konular_stmt->get_result();

    if ($konular_result->num_rows > 0) {
        $delete_yorum_konu_stmt = $conn->prepare("DELETE FROM yorumlar WHERE konu_id IN (SELECT id FROM konular WHERE kullanici_id = ?)");
        $delete_yorum_konu_stmt->bind_param("i", $kullanici_id);
        $delete_yorum_konu_stmt->execute();

        $delete_konu_stmt = $conn->prepare("DELETE FROM konular WHERE kullanici_id = ?");
        if (!$delete_konu_stmt) {
            die("Hata: " . $conn->error);
        }
        $delete_konu_stmt->bind_param("i", $kullanici_id);
        $delete_konu_stmt->execute();
    }

    $delete_stmt = $conn->prepare("DELETE FROM kullanicilar WHERE id = ?");
    if (!$delete_stmt) {
        die("Hata: " . $conn->error);
    }
    $delete_stmt->bind_param("i", $kullanici_id);
    if ($delete_stmt->execute()) {
        $_SESSION['message'] = "Kullanıcı ve ilgili veriler başarıyla silindi.";
        header('Location: kullanicilar.php');
    } else {
        die("Kullanıcı silme işlemi başarısız: " . $delete_stmt->error);
    }
    exit();
} else {
    header('Location: kullanicilar.php?msg=Geçersiz işlem.');
    exit();
}