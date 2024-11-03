<?php
session_start();
$kon = mysqli_connect("localhost", "root", "", "kho_family");
if (!$kon) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_POST['submit_order'])) {
    $quantities = $_POST['quantity'];

    $_SESSION['order_quantities'] = $quantities;

    header("Location: confirmation.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHO FAMILY - Menu Makanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="order.css" />
</head>
<body>
    <div id="container">
        <?php
        include 'Utils/header.php';
        echo '<link rel="stylesheet" href="Utils/header.css"/>';
        ?>

        <h2><center>Menu Makanan</center></h2>

        <div id="menu">
            <br>
            <form method="post" action="order.php">
                <?php
                $categoryQuery = "SELECT DISTINCT kategori_menu FROM menu";
                $categoryResult = mysqli_query($kon, $categoryQuery);
                $categories = [];

                while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                    $categories[] = $categoryRow['kategori_menu'];
                }

                if (isset($_POST['category']) && $_POST['category'] != 'all') {
                    $selectedCategory = $_POST['category'];
                    $query = "SELECT * FROM menu WHERE kategori_menu = '$selectedCategory'";
                } else {
                    $query = "SELECT * FROM menu";
                }

                $result = mysqli_query($kon, $query);

                echo '<div class="menu-cards">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="card" data-aos="fade-up">';
                    echo '<img src="gambar_menu/' . $row['gambar_makanan'] . '" alt="' . $row['nama_makanan'] . '">';
                    echo '<h3>' . $row['nama_makanan'] . '</h3>';
                    echo '<p>' . $row['deksripsi_makanan'] . '</p>';
                    echo '<p>Kategori: ' . $row['kategori_menu'] . '</p>';
                    echo '<p>Harga: Rp ' . number_format($row['harga_makanan']) . '</p>';
                    echo '<input type="number" name="quantity[' . $row['id_makanan'] . ']" value="0" min="0">';
                    echo '</div>';
                }
                echo '</div>';
                ?>
                <div id="button">
                    <button id="orderr" type="submit" name="submit_order" class="btn btn-primary">Pesan</button>
                </div>
            </form>
        </div>

        <?php
        include 'Utils/footer.html';
        echo '<link rel="stylesheet" href="Utils/footer.css"/>';
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</body>
</html>

<?php
mysqli_close($kon);
?>
