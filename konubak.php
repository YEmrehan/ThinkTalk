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
    <h5>Konu Başlıkları</h5>
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

    <?php 
    include 'db.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: giris.php');
        exit();
    }

    $userId = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT kullanici_adi, email FROM kullanicilar WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Kullanıcı bilgileri alınamadı.";
        exit();
    }

    $konu_stmt = $conn->
    prepare("SELECT k.*, u.kullanici_adi AS konuyu_acan FROM konular k JOIN kullanicilar u ON k.kullanici_id = u.id ORDER BY k.created_at DESC");

    $konu_stmt->execute();
    $konu_result = $konu_stmt->get_result();

    while ($konu = $konu_result->fetch_assoc()) {
        echo "<div class='card mb-3'>";
        echo "<div class='card-header'><h5><a href='hakkinda.php?id=" . 
        $konu['kullanici_id'] . "'>" . htmlspecialchars($konu['baslik']) . 
        "</a></h5><small> (Açan: <a href='hakkinda.php?id=" . $konu['kullanici_id'] . "'>" . 
        htmlspecialchars($konu['konuyu_acan']) . "</a>)</small></div>";
        
        echo "<div class='card-body'><p>" . htmlspecialchars($konu['aciklama']) . "</p></div>";

        $yorum_stmt = $conn->
        prepare("SELECT y.*, u.kullanici_adi AS yorum_yapan FROM yorumlar y 
        JOIN kullanicilar u ON y.kullanici_id = u.id WHERE konu_id = ? ORDER BY y.created_at DESC");

        $yorum_stmt->bind_param("i", $konu['id']);
        $yorum_stmt->execute();
        $yorum_result = $yorum_stmt->get_result();

        echo "<div class='comments'><h6>Yorumlar:</h6><ul class='list-group'>";
        while ($yorum = $yorum_result->fetch_assoc()) {
            echo "<li class='list-group-item'>" . 
            htmlspecialchars($yorum['yorum_yapan']) . 
            "<br> (" . $yorum['created_at'] . ")<br>" . 
            htmlspecialchars($yorum['yorum']) . "</li>";
        }
        echo "</ul></div>";

        echo "<div class='mt-3'>
                <form method='POST' action='yorum_yap.php'>
                    <input type='hidden' name='konu_id' value='" . $konu['id'] . "'>
                    <input type='text' class='form-control' name='yorum' placeholder='Yorum yapın...' required>
                    <button type='submit' class='btn btn-primary mt-2'>Yorum Yap</button>
                </form>
              </div>";
        echo "</div>";
    }
    ?>
</div>
<div class="div2" id="notification">
    Yeni Başlık Oluşturun
</div>

<script src="bootstrap/jquery-3.7.1.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>
<script src="main.js"></script>
</body>
</html>
