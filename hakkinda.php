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

    $stmt = $conn->prepare("SELECT id, kullanici_adi, hakkinda FROM kullanicilar");
    $stmt->execute();
    $result = $stmt->get_result();

    if (isset($_GET['id'])) {
        $profileUserId = (int)$_GET['id'];
        $stmt = $conn->prepare("SELECT kullanici_adi, hakkinda FROM kullanicilar WHERE id = ?");
        $stmt->bind_param("i", $profileUserId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        } else {
            echo "Kullanıcı bilgileri alınamadı.";
            exit();
        }
    } else {
        echo "Kullanıcı seçilmedi.";
        exit();
    }
    ?>

    <h1>ThinkTalk</h1>
    <h5><?php echo htmlspecialchars($user['kullanici_adi']); ?> Hakkında</h5>
    
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

    <div class="mt-4 card">
        <div class="card-header"><h5>Kullanıcı Hakkında</h5></div>
        <div class="card-body"><p><?php echo htmlspecialchars($user['hakkinda']); ?></p></div>
    </div>

    <div class="div2" id="notification">
        Profiliniz
    </div>

    <script src="bootstrap/jquery-3.7.1.min.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="main.js"></script>
</div>
</body>

</html>
