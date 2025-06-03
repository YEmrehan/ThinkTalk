<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT parola FROM kullanicilar WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($current_password, $user['parola'])) {
            if ($new_password === $confirm_password) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                $update_stmt = $conn->prepare("UPDATE kullanicilar SET parola = ? WHERE id = ?");
                $update_stmt->bind_param("si", $hashed_new_password, $userId);
                $update_stmt->execute();

                echo '<div style="text-align: center; margin-top: 50px;">';
                echo '<h3>Şifre başarıyla değiştirildi.</h3>';
                echo '<p>3 saniye içinde ana sayfaya yönlendirileceksiniz...</p>';
                echo '</div>';

                echo '<script type="text/javascript">
                        setTimeout(function() {
                            window.location.href = "anasayfa.php";
                        }, 3000);
                      </script>';
                exit();
            } else {
                $error_message = "Yeni şifreler eşleşmiyor.";
            }
        } else {
            $error_message = "Mevcut şifre hatalı.";
        }
    } else {
        $error_message = "Kullanıcı bulunamadı.";
    }

    if (isset($error_message)) {
        echo '<div style="text-align: center; margin-top: 50px;">';
        echo '<h3>' . $error_message . '</h3>';
        echo '<p>3 saniye içinde profil sayfasına yönlendirileceksiniz...</p>';
        echo '</div>';

        echo '<script type="text/javascript">
                setTimeout(function() {
                    window.location.href = "profil.php";
                }, 3000);
              </script>';
        exit();
    }
}