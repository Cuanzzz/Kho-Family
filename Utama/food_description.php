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
    <link rel="stylesheet" href="food.css" />
</head>

<body>
    <div id="container">
        <?php
            include 'Utils/header.php';
            echo '<link rel="stylesheet" href="Utils/header.css"/>';
        ?>

<?php
if (isset($_GET['id'])) {

    $kon = mysqli_connect("localhost", "root", "", "kho_family");

if (!$kon) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
    $foodId = $_GET['id'];

    $query = "SELECT * FROM menu WHERE id_makanan = $foodId";

    $result = mysqli_query($kon, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        echo '<div class="food-details">';
        echo '<img src="gambar_menu/' . $row['gambar_makanan'] . '" alt="' . $row['nama_makanan'] . '">';
        echo '<h2>' . $row['nama_makanan'] . '</h2>';
        echo '<p>Deskripsi:<br> ' . $row['deksripsi_makanan'] . '</p>';
        echo '<p>Kategori:<br> ' . $row['kategori_menu'] . '</p>';
        echo '<p>Harga:<br> Rp ' . number_format($row['harga_makanan']) . '</p>';
        echo '</div>';
    } else {
        echo "Makanan tidak ditemukan.";
    }
}
?>

    </div>

        <?php
            include 'Utils/footer.html';
            echo '<link rel="stylesheet" href="Utils/footer.css"/>';
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>
