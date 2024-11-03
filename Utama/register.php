<?php
    include 'Utils/header.php';
    echo '<link rel="stylesheet" href="Utils/header.css"/>';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>KHO FAMILY</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="register.css"/>
    </head>

    <body>
        <div id="container">

            <div id="register">
                <form action="register.php" method="POST">
                    <br>
                    
                    <p id="kotak1"><b>Register</b></p>

                    <input id="kotak" type="text" name="txtFirst" placeholder="First Name"><br><br>
                    <input id="kotak" type="text" name="txtLast" placeholder="Last Name"><br><br>
                    <input id="kotak" type="text" name="txtUname" placeholder="Username"><br><br>
                    <input id="kotak" type="password" name="txtPass" placeholder="Password"><br><br>
                    <label id="dateep"><b>Tanggal Lahir</b></label> <br>
                    <input id="datee" type="date" name="date" placeholder="Username"><br><br>
                    <label id="dateep"><b>Jenis Kelamin :</b></label> <br>
                    <input id="genderr" type="radio" name="gender" value="m" />Male
                    <input type="radio" name="gender" value="f" />Female<br><br>

                    <input id="submit" type="submit" value="Daftar"  >
                </form>
            </div>
    
            <?php
                class CekUname extends Exception
                {
                    public function errorMessage()
                    {
                        return "Username Sudah terpakai, silahkan gunakan username lain.";
                    }
                }

                $kon = mysqli_connect("localhost", "root", "", "kho_family");

                try 
                {
                    if (isset($_POST['txtUname'])) 
                    {
                        $role = "user";

                        $checkQuery = "SELECT username FROM ms_user WHERE username = '".$_POST['txtUname']."'";
                        $hasil = mysqli_query($kon, $checkQuery);

                        if (mysqli_num_rows($hasil) > 0) 
                        {
                            throw new CekUname();
                        }

                        $q = "INSERT INTO ms_user (first_name, last_name, username, password, birthdate, gender, role)
                            VALUES
                            ('" . $_POST['txtFirst'] . "',
                            '" . $_POST['txtLast'] . "',
                            '" . $_POST['txtUname'] . "',
                            '".$_POST['txtPass']."',
                            '".$_POST['date']."',
                            '".$_POST['gender']."',
                            '$role')";

                        $query = mysqli_query($kon, $q);
                    }
                } catch (CekUname $e) 
                {
                    echo $e->errorMessage();
                }

            ?>

        </div>

        <?php
        include 'Utils/footer.html';
        echo '<link rel="stylesheet" href="Utils/footer.css"/>';
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    </body>

</html>
