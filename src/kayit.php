<?php
include 'db.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: anasayfa.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kullanici_adi = $_POST['kullanici_adi'];
    $email = $_POST['email'];
    $parola = password_hash($_POST['parola'], PASSWORD_DEFAULT);
    $cinsiyet = $_POST['cinsiyet'];

    $sql = "INSERT INTO kullanicilar (kullanici_adi, email, parola, cinsiyet, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Sorgu hatası: " . $conn->error);
    }

    $stmt->bind_param("ssss", $kullanici_adi, $email, $parola, $cinsiyet);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        header('Location: anasayfa.php');
        exit();
    } else {
        echo "Kayıt hatası: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="tr-TR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThinkTalk</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body>
    <div class="container">


        <h1>ThinkTalk</h1>
        <h5>Kayıt Ol</h5>

        <div class="d-flex justify-content-between align-items-center">
            <div class="position-absolute" style="top: 0; right: 0px; margin: 20px;">
                <a href="giris.php" class="btn btn-dark">Giriş yap</a>
            </div>
        </div>
        <br>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="anasayfa.php"><i class="fas fa-home"></i> Ana Sayfa</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php"><i class="fas fa-user"></i> Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="konuac.php"><i class="fas fa-plus"></i> Konu aç</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="konubak.php"><i class="fas fa-eye"></i> Konulara bak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php"><i class="fas fa-cog"></i> Admin</a>
                    </li>
                </ul>
            </div>
        </nav>

        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputUsername">Kullanıcı Adı</label>
                    <input type="text" name="kullanici_adi" class="form-control" id="inputUsername"
                        placeholder="Kullanıcı Adı" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail1">Mail Adresi</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4"
                        placeholder="example@gmail.com" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword1">Parola</label>
                    <input type="password" name="parola" class="form-control" id="inputPassword4"
                        placeholder="Parola giriniz" required>
                </div>
            </div>
            <div>
                <label>Cinsiyet</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cinsiyet" value="erkek" required>
                    <label class="form-check-label">Erkek</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="cinsiyet" value="kadın" required>
                    <label class="form-check-label">Kadın</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
        </form>

        <div class="div2" id="notification">
            Kayıt Sayfamızdasınız!
        </div>

        <script src="bootstrap/jquery-3.7.1.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
        <script src="main.js"></script>
    </div>
</body>

</html>