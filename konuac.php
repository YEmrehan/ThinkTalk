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
    <?php 
    include 'db.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: giris.php');
        exit();
    }

    $userId = $_SESSION['user_id'];
    $yetki = kullaniciYetkisiniKontrolEt($userId, $conn);
    if ($yetki == 1) {
        echo "Bu işlemi gerçekleştirme yetkiniz yok.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $baslik = $_POST['title'];
        $aciklama = $_POST['description'];
        $kullanici_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO konular (kullanici_id, baslik, aciklama) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $kullanici_id, $baslik, $aciklama);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header('Location: konubak.php');
            exit();
        } else {
            echo "Konu oluşturulamadı.";
        }
    }
    ?>

    <h1>ThinkTalk</h1>
    <h5>Yeni Konu Başlığı Oluştur</h5>
    <br>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="anasayfa.php"><i class="fas fa-home"></i> Ana Sayfa</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Konu Başlığı</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Başlık girin..." required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Açıklama girin..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Oluştur</button>
        </form>
    </div>
    <div class="div2" id="notification">
        Konu Açın
    </div>
    <script src="bootstrap/jquery-3.7.1.min.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="main.js"></script>
</div>
</body>

</html>