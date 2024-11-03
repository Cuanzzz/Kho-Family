<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHO FAMILY</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div id="container">
        <?php
            include 'Utils/header.php';
            echo '<link rel="stylesheet" href="Utils/header.css"/>';
        ?>

        <div class="banner" data-aos="fade-up">
            <h1 class="animated-text">Welcome to KHO FAMILY Restaurant</h1>
            <p class="animated-text">Discover a World of Flavors</p>
        </div>

        <div class="menu">
            <h2>Menu Makanan</h2>
            <div class="menu-cards">
                <?php
                $kon = mysqli_connect("localhost", "root", "", "kho_family");

                if (!$kon) {
                    die("Koneksi database gagal: " . mysqli_connect_error());
                }

                $query = "SELECT * FROM menu LIMIT 6";
                $result = mysqli_query($kon, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="card" data-aos="fade-up">';
                        echo '<a href="food_description.php?id=' . $row['id_makanan'] . '">';
                        echo '<img src="gambar_menu/' . $row['gambar_makanan'] . '" alt="' . $row['nama_makanan'] . '">';
                        echo '<h3>' . $row['nama_makanan'] . '</h3>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo "Tidak ada data makanan yang ditemukan.";
                }
                ?>
            </div>
        </div>

        <div class="center-buttons">
            <a href="menu.php" class="button">Menu Lengkap</a>

            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="order.php" class="button secondary">Tertarik Untuk Memesan?</a>';
            } else {
                echo '<a href="login.php" class="button secondary">Tertarik Untuk Memesan?</a>';
            }
            ?>
        </div>


        <?php
            include 'Utils/footer.html';
            echo '<link rel="stylesheet" href="Utils/footer.css"/>';
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
        AOS.refresh();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
