<?php
session_start();
require_once "../config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $users = mysqli_fetch_assoc($result);

    if ($users && password_verify($password, $users['password'])) {
        $_SESSION['user_id'] = $users['id'];
        $_SESSION['email'] = $users['email'];
        $_SESSION['username'] = $users['username'];

        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: login.php?error=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - welcome back</title>
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
                        <a href="register.php" class="btn">Daftar</a>
                        <a href="login.php" class="btn-outline">Login</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <form class="form-box" action="" method="post">
                <h1>Hi Programer</h1>
                <p>Welcome Back Master</p>

                <?php if (isset($_GET['error'])): ?>
                    <div class="error-msg" style="color: red; margin-bottom: 10px; font-size: 14px;">
                        <i class="fa-solid fa-circle-exclamation"></i> Email atau Password salah!
                    </div>
                <?php endif ?>

                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required><br>
                <div class="forgot">
                    <a rel="noopener noreferrer" href="">Forgot Password ?</a>
                </div>

                <button type="submit" class="login">Login</button>


                <div class="sosial-login">
                    <button class="btn-sosial">
                        <i class="fa-brands fa-google"></i>
                        Login with Google
                    </button>

                    <button class="btn-sosial">
                        <i class="fa-brands fa-github"></i>
                        Login with Github
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>