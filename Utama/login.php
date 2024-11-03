<?php
session_start();

function generateRandomCaptcha($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $captcha = '';
    for ($i = 0; $i < $length; $i++) {
        $captcha .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $captcha;
}

if (!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = generateRandomCaptcha();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputCaptcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';

    if ($inputCaptcha === $_SESSION['captcha']) {
        echo 'CAPTCHA cocok! Anda bisa melanjutkan.';
    } else {
        echo 'CAPTCHA tidak cocok. Silakan coba lagi.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHO FAMILY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css"/>
</head>

<body>
    <div id="container">

        <?php
            include 'Utils/header.php';
            echo '<link rel="stylesheet" href="Utils/header.css"/>';
        ?>

        <div id="login">
            <form action="login_process.php" method="POST">
                <p id="kotak1"><b>Login</b></p>
                <input id="kotak" type="text" name="txtUname" placeholder="Username"><br><br>
                <input id="kotak" type="password" name="txtPass" placeholder="Password"><br>
                <input id="submit" type="submit" value="Login">
                <div id="captcha">
                    <label id="kotak" for="captcha">CAPTCHA: <?= $_SESSION['captcha'] ?></label>
                    <br>
                    <input id="kotak" type="text" name="captcha" required>
                </div>
            </form>
        </div>

        <div id="login">
            <p>Belum Punya Akun?</p>
            <a href="register.php">Daftar Sekarang</a><br><br><br>
        </div>

        <?php
        if (isset($_GET['login_error']) && $_GET['login_error'] == 1) {
            echo "Login gagal: Password salah atau pengguna tidak ditemukan.";
        }
        ?>

        <?php
            include 'Utils/footer.html';
            echo '<link rel="stylesheet" href="Utils/footer.css"/>';
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>
