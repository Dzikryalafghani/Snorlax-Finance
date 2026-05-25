<?php
session_start();
require_once "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

$d_query = mysqli_query($conn, "SELECT * FROM dompet WHERE user_id = '$user_id'");
$d = mysqli_fetch_assoc($d_query);

$trx = mysqli_query($conn, "SELECT * FROM transaksi WHERE user_id = '$user_id' ORDER BY tanggal DESC LIMIT 3");

$daftar_hari = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$tanggal_sekarang = $daftar_hari[date('l')] . ", " . date('d M Y');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Snorlax Finance - keuangan</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/img/logotitle.png">
</head>

<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="logo">
                <img src="../assets/img/logo.png" alt="Logo">
            </div>
            <nav class="menu">
                <a href="../auth/dashboard.php" class="active"><i class="fa-solid fa-house"></i></a>
                <a href="../fitur/riwayat.php"><i class="fa-solid fa-receipt"></i></a>
                <a href="../fitur/vault.php"><i class="fa-solid fa-vault"></i></a>
                <a href="../fitur/setting.php"><i class="fa-solid fa-gear"></i></a>
            </nav>
            <div class="sidebar-bottom">
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <form action="../fitur/riwayat.php" method="GET" class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="cari" placeholder="Cari transaksi...">
                </form>

                <div class="date-center">
                    <span><?php echo $tanggal_sekarang; ?></span>
                </div>

                <div class="topbar-right">
                    <div class="icons">
                        <i class="fa-solid fa-comment-dots"></i>
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div class="user-profile">
                        <img src="../assets/img/profile.jpg" alt="Avatar">
                        <div class="user-info">
                            <strong><?php echo $_SESSION['username']; ?></strong>
                            <small>Si Paling Master</small>
                        </div>
                    </div>
                </div>
            </header>

            <h2 class="page-title">Ringkasan Keuangan</h2>

            <div class="middle-section">
                <div class="hero-card">
                    <div class="hero-text">
                        <h1>Halo, <?php echo $_SESSION['username']; ?>!</h1>
                        <p>Udah nyatet jajan hari ini belom? Jangan boros mulu lah</p>
                        <div class="hero-checklist">
                            <a href="#modal-tambah"><i class="fa-solid fa-circle-plus"></i> Catat Cuan</a>
                            <a href="#modal-tambah"><i class="fa-solid fa-circle-minus"></i> Pengeluaran</a>
                            <a href="#modal-tambah"><i class="fa-solid fa-vault"></i> Update Tabungan</a>
                            <a href="#modal-tambah"><i class="fa-solid fa-shield-heart"></i> Dana Darurat</a>
                        </div>
                    </div>
                    <div class="hero-img">
                        <img src="../assets/img/maskot.png" alt="Snorlax">
                    </div>
                </div>

                <div class="notifications-section">
                    <div class="notif-header">
                        <h3><i class="fa-solid fa-clock-rotate-left"></i> Jejak Duit</h3>
                        <a href="../fitur/riwayat.php" class="btn-jejak">Lihat semua</a>
                    </div>
                    <div class="notif-list">
                        <?php while ($row = mysqli_fetch_assoc($trx)):
                            if ($row['tipe'] == 'pemasukan') {
                                $icon_detail = 'fa-arrow-trend-up';
                                $warna_bg    = 'green';
                            } elseif ($row['tipe'] == 'pengeluaran') {
                                $icon_detail = 'fa-arrow-trend-down';
                                $warna_bg    = 'red';
                            } elseif ($row['tipe'] == 'tabungan') {
                                $icon_detail = 'fa-vault';
                                $warna_bg    = 'blue';
                            } elseif ($row['tipe'] == 'dana_darurat') {
                                $icon_detail = 'fa-shield-heart';
                                $warna_bg    = 'yellow';
                            } else {
                                $icon_detail = 'fa-receipt';
                                $warna_bg    = 'blue';
                            }
                        ?>
                            <div class="notif-item">
                                <div class="notif">
                                    <div class="notif-icon <?php echo $warna_bg; ?>">
                                        <i class="fa-solid <?php echo $icon_detail; ?>"></i>
                                    </div>
                                    <div class="notif-text">
                                        <strong><?php echo $row['judul']; ?></strong>
                                        <small><?php echo formatRupiah($row['nominal']); ?></small>
                                    </div>
                                </div>

                                <div class="crud-btns">
                                    <a href="edit.php?id=<?= $row['id'] ?>" style="color:var(--primary-blue);"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin mau diapus jejak ini?')" style="color:#ff6b6b;"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="card-icon green"><i class="fa-solid fa-arrow-down"></i></div>
                    <p>Total Cuan</p>
                    <h3><?php echo formatRupiah($d['pemasukan'] ?? 0); ?></h3>
                </div>
                <div class="stat-card">
                    <div class="card-icon red"><i class="fa-solid fa-arrow-up"></i></div>
                    <p>Total Pengeluaran</p>
                    <h3><?php echo formatRupiah($d['pengeluaran'] ?? 0); ?></h3>
                </div>
                <div class="stat-card">
                    <div class="card-icon blue"><i class="fa-solid fa-vault"></i></div>
                    <p>Total Tabungan</p>
                    <h3><?php echo formatRupiah($d['tabungan'] ?? 0); ?></h3>
                </div>
                <div class="stat-card">
                    <div class="card-icon yellow"><i class="fa-solid fa-shield-heart"></i></div>
                    <p>Dana Darurat</p>
                    <h3><?php echo formatRupiah($d['dana_darurat'] ?? 0); ?></h3>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-tambah" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Catat Duit</h3>
                <a href="dashboard.php" class="close-btn">&times;</a>
            </div>
            <form action="tambah.php" method="POST" class="modal-form">
                <label>Jajan apa / Cuan apa?</label>
                <input type="text" name="judul" placeholder="Contoh: Seblak" required>
                <label>Nominal</label>
                <input type="number" name="nominal" placeholder="Angkanya aja" required>
                <label>Pilih Tipe</label>
                <select name="tipe">
                    <option value="pemasukan">Cuan Masuk</option>
                    <option value="pengeluaran">Pengeluaran</option>
                    <option value="tabungan">Simpenan (Nabung)</option>
                    <option value="dana_darurat">Dana Darurat</option>
                </select>
                <button type="submit" name="simpan" class="btn-simpan">Simpan!</button>
            </form>
        </div>
    </div>
</body>

</html>