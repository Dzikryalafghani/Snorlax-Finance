<?php
session_start();
require_once "../config/koneksi.php";

$id = $_GET['id'];
$id_user = $_SESSION['user_id'];

$query_lama = mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id' AND user_id='$id_user'");
$data = mysqli_fetch_assoc($query_lama);

if ($data) {
    $nominal_lama = $data['nominal'];
    $tipe_lama = $data['tipe'];

    $sql_update = "UPDATE dompet SET $tipe_lama = $tipe_lama - $nominal_lama WHERE user_id='$id_user'";
    mysqli_query($conn, $sql_update);

    mysqli_query($conn, "DELETE FROM transaksi WHERE id='$id' AND user_id='$id_user'");
}

header("Location: dashboard.php");
exit;
