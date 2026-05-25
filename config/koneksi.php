<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "keuangan_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function formatRupiah(int $angka)
{
    return "Rp " . number_format($angka, 0, ',', '.');
}
