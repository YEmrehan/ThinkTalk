<?php
include 'db.php';
session_start();
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
        <h5>Ana Sayfa</h5>

        <div class="d-flex justify-content-between align-items-center">
            <div class="position-absolute" style="top: 0; right: 0px; margin: 20px;">
                <a href="kayit.php" class="btn btn-dark">Kayıt ol</a>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div class="position-absolute" style="top: 0; right: 100px; margin: 20px;">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="cikis.php" class="btn btn-dark">Çıkış Yap</a>
                <?php else: ?>
                    <a href="giris.php" class="btn btn-dark">Giriş yap</a>
                <?php endif; ?>
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

        <div class="container mt-4">
            <h2>Tartışma Başlıkları</h2>
            <div class="list-group">
                <?php
                $konu_stmt = $conn->prepare("SELECT baslik FROM konular ORDER BY created_at DESC LIMIT 2");
                $konu_stmt->execute();
                $konu_result = $konu_stmt->get_result();

                while ($konu = $konu_result->fetch_assoc()) {
                    echo "<a href='konubak.php' class='list-group-item list-group-item-action'>" . htmlspecialchars($konu['baslik']) . "</a>";
                }
                ?>
            </div>

            <div class="mt-4">
                <h2>Yeni Tartışma Başlığı Oluştur</h2>
                <a href="konuac.php" class="btn btn-primary">Yeni Başlık Oluştur</a>
            </div>
        </div>

        <div class="div2" id="notification">
            Forumumuza Hoşgeldiniz!
        </div>

        <script src="bootstrap/jquery-3.7.1.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
        <script src="main.js"></script>
    </div>
</body>

</html>