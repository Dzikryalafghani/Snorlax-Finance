<?php
session_start();
require_once "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$keyword = $_GET['cari'] ?? '';
$query = "SELECT * FROM transaksi WHERE user_id = '$user_id' AND judul LIKE '%$keyword%' ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

$daftar_hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
$tanggal_sekarang = $daftar_hari[date('l')] . ", " . date('d M Y');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jejak Duit - Snorlax Finance</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/riwayat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/img/logotitle.png">
    <style>

    </style>
</head>

<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="logo">
                <img src="../assets/img/logo.png" alt="Logo">
            </div>
            <nav class="menu">
                <a href="../auth/dashboard.php"><i class="fa-solid fa-house"></i></a>
                <a href="riwayat.php" class="active"><i class="fa-solid fa-receipt"></i></a>
                <a href="vault.php"><i class="fa-solid fa-vault"></i></a>
                <a href="setting.php"><i class="fa-solid fa-gear"></i></a>
            </nav>
            <div class="sidebar-bottom">
                <a href="../auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <form action="riwayat.php" method="GET" class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="cari" value="<?= $keyword ?>" placeholder="Cari transaksi...">
                </form>

                <div class="date-center">
                    <span><?php echo $tanggal_sekarang; ?></span>
                </div>

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

            <div class="riwayat-container">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h2 class="page-title" style="margin:0;">Semua Jejak Duit</h2>
                    <a href="../auth/dashboard.php#modal-tambah" class="btn-jejak" style="background:var(--primary-blue); color:white; padding:10px 20px; border-radius:15px; font-size:12px; font-weight:600;">+ Catat Baru</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <?php
                                $tipe = $row['tipe'];

                                $simbol = ($tipe == 'pemasukan') ? '+ ' : '- ';
                                if ($tipe == 'tabungan' || $tipe == 'dana_darurat') $simbol = '';
                                ?>
                                <tr>
                                    <td style="color:var(--text-gray);"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                    <td style="font-weight:600; color:var(--text-dark);"><?= $row['judul'] ?></td>

                                    <td>
                                        <span class="badge badge-<?= $tipe ?>">
                                            <?= str_replace('_', ' ', $tipe) ?>
                                        </span>
                                    </td>

                                    <td class="text-<?= $tipe ?>">
                                        <?= $simbol . formatRupiah($row['nominal']) ?>
                                    </td>

                                    <td>
                                        <a href="../auth/edit.php?id=<?= $row['id'] ?>" style="color:var(--primary-blue); margin-right:12px;"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="../auth/hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin mau diapus jejak ini, Master?')" style="color:#ff6b6b;"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding:60px; color:var(--text-gray);">
                                    <img src="../assets/img/maskot.png" style="width:100px; opacity:0.3; margin-bottom:15px;"><br>
                                    Belum ada jejak duit nih Master...
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>