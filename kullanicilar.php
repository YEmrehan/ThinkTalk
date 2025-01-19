<!DOCTYPE html>
<html lang="tr-TR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThinkTalk - Kayıtlı Kullanıcılar</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body>
<div class="container">
    <h1>ThinkTalk</h1>
    <h5>Kayıtlı Kullanıcılar</h5>
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
                <li class="nav-item">
                    <a class="nav-link" href="kullanicilar.php"><i class="fas fa-users"></i> Kayıtlı Kullanıcılar</a>
                </li>
            </ul>
        </div>
    </nav>

    <?php 
    include 'db.php';
    
    if (isset($_SESSION['message'])) {
        echo '<div class="div2" id="notification">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }

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

    $kullanici_stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE yetki != 2 ORDER BY id ASC");
    $kullanici_stmt->execute();
    $kullanici_result = $kullanici_stmt->get_result();

    if ($kullanici_result->num_rows > 0) {
        echo "<table class='table table-bordered mt-4'>";
        echo "<thead><tr><th>ID</th><th>Kullanıcı Adı</th><th>Email</th><th>İşlemler</th></tr></thead><tbody>";
        while ($kullanici = $kullanici_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($kullanici['id']) . "</td>
                    <td>" . htmlspecialchars($kullanici['kullanici_adi']) . "</td>
                    <td>" . htmlspecialchars($kullanici['email']) . "</td>
                    <td>
                        <form method='POST' action='sil_kullanici.php' style='display:inline;'>
                            <input type='hidden' name='kullanici_id' value='" . $kullanici['id'] . "'>
                            <button type='submit' class='btn btn-danger btn-sm'>Sil</button>
                        </form>
                        <form method='POST' action='engelle_kullanici.php' style='display:inline;'>
                            <input type='hidden' name='kullanici_id' value='" . $kullanici['id'] . "'>
                            <button type='submit' class='btn btn-warning btn-sm'>" . ($kullanici['yetki'] == 0 ? 'Engelle' : 'Engeli Kaldır') . "</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>"; 
    } else {
        echo "<p>Kayıtlı kullanıcı bulunamadı.</p>";
    }
    ?>
</div>
<div class="div2" id="notification">
    Admin, Kayıtlı Kullanıcılardasın
</div>
<script src="bootstrap/jquery-3.7.1.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>
<script src="main.js"></script>
</body>
</html>