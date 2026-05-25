<?php
session_start();
require_once "../config/koneksi.php";

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id = '$id'"));

if (isset($_POST['update'])) {
    $judul_baru   = $_POST['judul'];
    $nominal_baru = $_POST['nominal'];
    $tipe_baru    = $_POST['tipe'];

    $nom_lama = $data['nominal'];
    $tip_lama = $data['tipe'];

    mysqli_query($conn, "UPDATE dompet SET $tip_lama = $tip_lama - $nom_lama WHERE user_id = '$user_id'");

    mysqli_query($conn, "UPDATE transaksi SET judul='$judul_baru', tipe='$tipe_baru', nominal='$nominal_baru' WHERE id='$id'");

    mysqli_query($conn, "UPDATE dompet SET $tipe_baru = $tipe_baru + $nominal_baru WHERE user_id = '$user_id'");

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Jejak Duit</title>
    <link rel="stylesheet" href="../css/edit.css">
    <link rel="icon" type="image/png" href="../assets/img/logotitle.png">
</head>

<body>
    <div class="container">
        <h3>Edit Jejak, Master!</h3>
        <form method="POST">
            <input type="text" name="judul" value="<?= $data['judul'] ?>" required>
            <input type="number" name="nominal" value="<?= $data['nominal'] ?>" required>

            <select name="tipe">
                <option value="pemasukan" <?= ($data['tipe'] == 'pemasukan') ? 'selected' : '' ?>>Cuan Masuk</option>
                <option value="pengeluaran" <?= ($data['tipe'] == 'pengeluaran') ? 'selected' : '' ?>>Pengeluaran</option>
                <option value="tabungan" <?= ($data['tipe'] == 'tabungan') ? 'selected' : '' ?>>Tabungan</option>
                <option value="dana_darurat" <?= ($data['tipe'] == 'dana_darurat') ? 'selected' : '' ?>>Dana Darurat</option>
            </select>

            <button type="submit" name="update" class="btn-update">Update Data!</button>
            <br><br>
            <a href="dashboard.php" class="btn-batal">Gak jadi, balik aja</a>
        </form>
    </div>
</body>

</html>