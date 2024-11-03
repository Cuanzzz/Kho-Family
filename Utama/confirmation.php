<?php
session_start();
$kon = mysqli_connect("localhost", "root", "", "kho_family");
if (!$kon) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_SESSION['order_quantities'])) {
    $username = $_SESSION['username'];
    $quantities = $_SESSION['order_quantities'];

    if (isset($_POST['confirm_order'])) {
        foreach ($quantities as $menu_id => $quantity) {
            if ($quantity > 0) {
                $query = "INSERT INTO pesanan (username, makanan_id, total_kuantitas) VALUES ('$username', $menu_id, $quantity)";
                if (mysqli_query($kon, $query)) {
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($kon);
                }
            }
        }

        unset($_SESSION['order_quantities']);

        header("Location: index.php");
        exit;
    }
} else {
    header("Location: order.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHO FAMILY - Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="confirm.css" />
</head>
<body>
    <div id="container">
        <?php
        include 'Utils/header.php';
        echo '<link rel="stylesheet" href="Utils/header.css"/>';
        ?>

            <h2><center>Konfirmasi Pesanan</center></h2>
            <h3><center>Detail Pesanan Anda:</center></h3>

        <div id="menu">
            <form method="post" action="confirmation.php">
                <?php
                $totalHarga = 0;

                echo "<table id='menu'>";
                echo "<tr><th>No</th><th>Gambar</th><th>Nama Makanan</th><th>Harga</th><th>Kuantitas</th></tr>";

                $counter = 1;

                foreach ($quantities as $menu_id => $quantity) {
                    if ($quantity > 0) {
                        $query = "SELECT * FROM menu WHERE id_makanan = $menu_id";
                        $result = mysqli_query($kon, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);

                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td><img src='gambar_menu/" . $row['gambar_makanan'] . "' alt='" . $row['nama_makanan'] . "'></td>";
                            echo "<td>" . $row['nama_makanan'] . "</td>";
                            echo "<td>Rp " . number_format($row['harga_makanan']) . "</td>";
                            echo "<td>" . $quantity . "</td>";
                            echo "</tr>";

                            $totalHarga += $row['harga_makanan'] * $quantity;

                            $counter++;
                        }
                    }
                }

                echo "<tr><th colspan='4'>Total Harga</th><td>Rp " . number_format($totalHarga) . "</td></tr>";
                echo "</table>";
                ?>
                <div id="button">
                    <button id="orderr" type="submit" name="confirm_order" class="btn btn-primary">Konfirmasi Pemesanan</button>
                </div>
            </form>
        </div>

        <?php
        include 'Utils/footer.html';
        echo '<link rel="stylesheet" href="Utils/footer.css"/>';
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

<?php
mysqli_close($kon);
?>
