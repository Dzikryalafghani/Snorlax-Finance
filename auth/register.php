<?php
session_start();
require_once "../config/koneksi.php";

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $nama     = $_POST['username'];
    $pass     = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($pass !== $confirm) {
        $error_msg = "Woi, password ama konfirmasinya beda! Fokus dong.";
    } else {
        $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($cek_user) > 0) {
            $error_msg = "Email ini udah ada yang punya, pake yang lain gih.";
        } else {
            $password_acak = password_hash($pass, PASSWORD_DEFAULT);

            $query_user = "INSERT INTO users (username, email, password, nama_lengkap) 
                           VALUES ('$username', '$email', '$password_acak', '$nama')";

            if (mysqli_query($conn, $query_user)) {
                $user_id = mysqli_insert_id($conn);

                mysqli_query($conn, "INSERT INTO dompet (user_id, tabungan, pengeluaran, pemasukan, dana_darurat) 
                                     VALUES ('$user_id', 0, 0, 0, 0)");

                header("Location: login.php?success=1");
                exit;
            } else {
                $error_msg = "Aduh, ada yang error pas nyimpen data nih";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - les't join</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../assets/img/logotitle.png">
</head>

<body>
    <div class="container">
        <div class="left">
            <img src="../assets/img/background.png" alt="bacground snorlax">

            <div class="overlay">
                <div class="top">
                    <span><b>Selected Works</b></span>
                    <div class="buttons">
                        <a href="register.php" class="btn-outline">Daftar</a>
                        <a href="login.php" class="btn">Login</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <form class="form-box" action="" method="post">
                <h1>let's join</h1>
                <p>Create your account</p>

                <?php if ($error_msg != ""): ?>
                    <p style="color: red; font-size: 13px; margin-bottom: 10px;"><?php echo $error_msg; ?></p>
                <?php endif; ?>

                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>

                <div class="space"></div>

                <button type="submit" class="login">Daftar</button>

                <div class="sosial-login">
                    <button type="button" class="btn-sosial">
                        <i class="fa-brands fa-google"></i>
                        Google
                    </button>

                    <button type="button" class="btn-sosial">
                        <i class="fa-brands fa-github"></i>
                        Github
                    </button>
                </div>

                <p style="font-size: 12px; margin-top: 15px;">
                    Already have an account? <a href="login.php" style="color: #3c5081; text-decoration: none; font-weight: bold;">Login here</a>
                </p>
            </form>
        </div>
    </div>
</body>

</html>