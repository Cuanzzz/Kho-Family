<?php
session_start();

$kon = mysqli_connect("localhost", "root", "", "kho_family");

if (isset($_POST['txtUname'])) {
    $username = mysqli_real_escape_string($kon, $_POST['txtUname']);
    $password = mysqli_real_escape_string($kon, $_POST['txtPass']);
    $inputCaptcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';

    if ($inputCaptcha === $_SESSION['captcha']) {
        $stmt = $kon->prepare("SELECT username, password, role FROM ms_user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dbUsername, $dbPassword, $dbRole);
            $stmt->fetch();

            if ($password === $dbPassword) {
                $_SESSION['username'] = $username;

                if ($dbRole === 'admin') {
                    header("Location: index.php");
                } elseif($dbRole === 'user') {
                    header("Location: index.php");
                }

                exit();
            } else {
                header("Location: login.php?login_error=1");
                exit();
            }
        } else {
            header("Location: login.php?login_error=1");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: login.php?login_error=2");
        exit();
    }
}
?>
