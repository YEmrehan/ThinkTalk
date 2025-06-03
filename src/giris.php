<?php
include 'db.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: anasayfa.php');
    exit();
}
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
        <h5>Giriş Yap</h5>

        <div class="d-flex justify-content-between align-items-center">
            <div class="position-absolute" style="top: 0; right: 0px; margin: 20px;">
                <a href="kayit.php" class="btn btn-dark">Kayıt ol</a>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div class="position-absolute" style="top: 0; right: 100px; margin: 20px;">
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

        <form action="login.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail1">Mail Adresi</label>
                    <input type="email" class="form-control" name="email" id="inputEmail1"
                        placeholder="example@gmail.com" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword1">Parola</label>
                    <input type="password" class="form-control" name="password" id="inputPassword1"
                        placeholder="parola giriniz" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Giriş yap</button>
        </form>

        <div class="div2" id="notification">
            Giriş Sayfamızdasınız!
        </div>

        <script src="bootstrap/jquery-3.7.1.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
        <script src="main.js"></script>
    </div>
</body>

</html>