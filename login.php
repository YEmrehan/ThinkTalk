<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $parola = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, parola FROM kullanicilar WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($parola, $user['parola'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: anasayfa.php');
            exit();
        } else {
            echo "Giriş bilgileri hatalı!";
        }
    } else {
        echo "Giriş bilgileri hatalı!";
    }
}