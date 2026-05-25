<?php
session_start();
require_once "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$q_dompet = mysqli_query($conn, "SELECT tabungan, dana_darurat FROM dompet WHERE user_id = '$user_id'");
$d = mysqli_fetch_assoc($q_dompet);

$total_tabungan = $d['tabungan'] ?? 0;
$total_darurat  = $d['dana_darurat'] ?? 0;
$total_duit_dingin = $total_tabungan + $total_darurat;

$q_trx = mysqli_query($conn, "SELECT * FROM transaksi 
    WHERE user_id = '$user_id' 
    AND tipe IN ('tabungan', 'dana_darurat') 
    ORDER BY tanggal DESC");

$daftar_hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
$tanggal_sekarang = $daftar_hari[date('l')] . ", " . date('d M Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vault - Snorlax Finance</title>
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
                <a href="vault.php" class="active"><i class="fa-solid fa-vault"></i></a>
                <a href="setting.php"><i class="fa-solid fa-gear"></i></a>
            </nav>
            <div class="sidebar-bottom"><a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a></div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari simpenan...">
                </div>
                <div class="date-center"><span><?php echo $tanggal_sekarang; ?></span></div>
                <div class="topbar-right">
                    <div class="user-profile">
                        <img src="../assets/img/profile.jpg" alt="Avatar">
                        <div class="user-info">
                            <strong><?php echo $_SESSION['username']; ?></strong>
                            <small>Si Paling Master</small>
                        </div>
                    </div>
                </div>
            </header>

            <h2 class="page-title">Brangkas Duit Dingin</h2>

            <div class="vault-hero">
                <div class="vault-total">
                    <p>Total Duit Dingin Master</p>
                    <h1><?php echo formatRupiah($total_duit_dingin); ?></h1>
                </div>
                <div class="vault-img">
                    <i class="fa-solid fa-piggy-bank" style="font-size: 80px; opacity: 0.3;"></i>
                </div>
            </div>

            <div class="vault-grid">
                <div class="v-card">
                    <div class="v-icon blue-bg"><i class="fa-solid fa-vault"></i></div>
                    <div class="v-info">
                        <p>Total Tabungan</p>
                        <h2><?php echo formatRupiah($total_tabungan); ?></h2>
                    </div>
                </div>
                <div class="v-card">
                    <div class="v-icon yellow-bg"><i class="fa-solid fa-shield-heart"></i></div>
                    <div class="v-info">
                        <p>Dana Darurat</p>
                        <h2><?php echo formatRupiah($total_darurat); ?></h2>
                    </div>
                </div>
            </div>

            <div class="notifications-section">
                <div class="notif-header">
                    <h3>Riwayat Brangkas</h3>
                </div>
                <div class="notif-list">
                    <?php if (mysqli_num_rows($q_trx) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($q_trx)): ?>
                            <div class="notif-item">
                                <div class="notif">
                                    <div class="notif-icon <?php echo ($row['tipe'] == 'tabungan') ? 'blue' : 'yellow'; ?>">
                                        <i class="fa-solid <?php echo ($row['tipe'] == 'tabungan') ? 'fa-vault' : 'fa-shield-heart'; ?>"></i>
                                    </div>
                                    <div class="notif-text">
                                        <strong><?php echo $row['judul']; ?></strong>
                                        <small><?php echo formatRupiah($row['nominal']); ?> • <?php echo date('d M Y', strtotime($row['tanggal'])); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p style="text-align:center; padding:20px; color:var(--text-gray);">Belum ada isi brangkas nih.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>

</html>