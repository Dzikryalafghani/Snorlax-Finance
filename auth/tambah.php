<?php
session_start();
require_once "../config/koneksi.php";

if (isset($_POST['simpan'])) {
    $user_id = $_SESSION['user_id'];
    $judul   = mysqli_real_escape_string($conn, $_POST['judul']);
    $nominal = $_POST['nominal'];
    $tipe    = $_POST['tipe'];

    $query_trx = "INSERT INTO transaksi (user_id, judul, tipe, nominal) 
                  VALUES ('$user_id', '$judul', '$tipe', '$nominal')";

    $simpan_trx = mysqli_query($conn, $query_trx);

    if ($simpan_trx) {
        $query_dompet = "UPDATE dompet SET $tipe = $tipe + $nominal WHERE user_id = '$user_id'";

        $update_dompet = mysqli_query($conn, $query_dompet);

        if ($update_dompet) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Gagal update dompet: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal simpan transaksi: " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard.php");
    exit;
}
