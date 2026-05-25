<?php
session_start();
require_once "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

if (isset($_POST['update_profile'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $query = "UPDATE users SET username = '$new_username' WHERE id = '$user_id'";
    if (mysqli_query($conn, $query)) {
        $_SESSION['username'] = $new_username; // Update session biar nama di topbar ganti
        $success_msg = "Mantap! Nama baru lu udah kesimpen.";
    }
}

if (isset($_POST['update_password'])) {
    $pass_baru = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($pass_baru !== $confirm_pass) {
        $error_msg = "Woi, password baru ama konfirmasinya beda!";
    } else {
        $password_hash = password_hash($pass_baru, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = '$password_hash' WHERE id = '$user_id'";
        if (mysqli_query($conn, $query)) {
            $success_msg = "Password lu udah diganti!";
        }
    }
}

$daftar_hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
$tanggal_sekarang = $daftar_hari[date('l')] . ", " . date('d M Y');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Setelan - Snorlax Finance</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/img/logotitle.png">
</head>

<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="logo"><img src="../assets/img/logo.png" alt="Logo"></div>
            <nav class="menu">
                <a href="../auth/dashboard.php"><i class="fa-solid fa-house"></i></a>
                <a href="riwayat.php"><i class="fa-solid fa-receipt"></i></a>
                <a href="vault.php"><i class="fa-solid fa-vault"></i></a>
                <a href="settings.php" class="active"><i class="fa-solid fa-gear"></i></a>
            </nav>
            <div class="sidebar-bottom"><a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="search-box"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari setelan..."></div>
                <div class="date-center"><span><?php echo $tanggal_sekarang; ?></span></div>
                <div class="topbar-right">
                    <div class="user-profile">
                        <img src="../assets/img/profile.jpg" alt="Avatar">
                        <div class="user-info"><strong><?php echo $_SESSION['username']; ?></strong><small>Si Paling Master</small></div>
                    </div>
                </div>
            </header>

            <h2 class="page-title">Atur Gaya</h2>

            <?php if ($success_msg): ?>
                <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?= $success_msg ?></div>
            <?php endif; ?>
            <?php if ($error_msg): ?>
                <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error_msg ?></div>
            <?php endif; ?>

            <div class="settings-grid">
                <div class="profile-card-big">
                    <img src="../assets/img/profile.jpg" alt="Profile">
                    <h3><?= $_SESSION['username'] ?></h3>
                    <p style="color: var(--text-gray); font-size: 13px;">Member Sejak: <?= date('Y') ?></p>
                    <hr style="margin: 25px 0; border: none; border-top: 1px solid #f4f7fe;">
                    <div style="text-align: left; font-size: 12px; color: var(--text-gray);">
                        <p><i class="fa-solid fa-envelope" style="margin-right: 10px;"></i> <?= $_SESSION['email'] ?></p>
                        <p style="margin-top: 10px;"><i class="fa-solid fa-shield-halved" style="margin-right: 10px;"></i> Akun Terverifikasi</p>
                    </div>
                </div>

                <div class="form-card">
                    <form action="" method="POST" class="form-section">
                        <h4><i class="fa-solid fa-user-pen"></i> Ganti Nama </h4>
                        <div class="input-box">
                            <label>Username Baru</label>
                            <input type="text" name="username" value="<?= $_SESSION['username'] ?>" required>
                        </div>
                        <button type="submit" name="update_profile" class="btn-update">Simpan Nama Baru</button>
                    </form>

                    <hr style="margin: 30px 0; border: none; border-top: 1px solid #f4f7fe;">

                    <form action="" method="POST" class="form-section">
                        <h4><i class="fa-solid fa-lock"></i> Ganti Kunci Password</h4>
                        <div class="input-box">
                            <label>Password Baru</label>
                            <input type="password" name="new_password" placeholder="Bikin yang susah ditebak" required>
                        </div>
                        <div class="input-box">
                            <label>Ulangi Password Baru</label>
                            <input type="password" name="confirm_password" placeholder="Samain sama yang di atas" required>
                        </div>
                        <button type="submit" name="update_password" class="btn-update">Ganti Password Sekarang</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>