<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: giris.php');
    exit();
}

$userId = $_SESSION['user_id'];
$profileUserId = isset($_GET['id']) ? (int) $_GET['id'] : $userId;

$stmt = $conn->prepare("SELECT kullanici_adi, email, hakkinda FROM kullanicilar WHERE id = ?");
$stmt->bind_param("i", $profileUserId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Kullanıcı bilgileri alınamadı.";
    exit();
}

if (isset($_GET['guncelle'])): ?>
    <div class="alert alert-<?php echo $_GET['guncelle'] == 'ok' ? 'success' : 'danger'; ?>" role="alert">
        <?php echo $_GET['guncelle'] == 'ok' ? 'Profil başarıyla güncellendi.' : 'Profil güncellenemedi.'; ?>
    </div>
<?php endif;
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
        <h5>Profilim</h5>
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
            <div class="card">
                <div class="card-header">
                    <h5>Kullanıcı Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="guncelle_profil.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="username" value="<?php
                            echo htmlspecialchars($user['kullanici_adi']); ?>" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" class="form-control" id="email" value="<?php
                            echo htmlspecialchars($user['email']); ?>" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Hakkında</label>
                            <textarea class="form-control" id="bio" name="hakkinda" rows="3"
                                placeholder="Kendiniz hakkında bir şeyler yazın..."><?php
                                echo htmlspecialchars($user['hakkinda']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Güncelle</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h5>Şifre Değiştir</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="sifre_degistir.php">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mevcut Şifre</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Yeni Şifre</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Yeni Şifre (Tekrar)</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-danger">Şifreyi Değiştir</button>
                    </form>
                </div>
            </div>
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