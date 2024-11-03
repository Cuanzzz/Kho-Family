<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHO FAMILY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="crud.css" />
</head>

<body>
    <div id="container">

        <?php
            include 'Utils/header.php';
            echo '<link rel="stylesheet" href="Utils/header.css"/>';
        ?>

        <?php
        if (isset($_SESSION['username'])) {
            $kon = mysqli_connect("localhost", "root", "", "kho_family");
            $username = $_SESSION['username'];

            $query = "SELECT role FROM ms_user WHERE username = '$username'";
            $result = mysqli_query($kon, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $role = $row['role'];

                if ($role !== "admin") {
                    header("Location: index.php"); 
                    exit();
                }
            } else {
                header("Location: index.php"); 
                exit();
            }
        } else {
            header("Location: login.php");
            exit();
        }
        ?>

        <div class="search">
            <form method="get" action="crud.php">
                <input type="text" name="search" placeholder="cari nama makanan">
                <button type="submit">cari</button>
            </form>
        </div>

        <div class="tambah">
            <h2>Add New Food Item</h2>
            <form method="post" action="crud.php" enctype="multipart/form-data">
                <div>
                    <label for="image">Food Image:</label>
                    <input type="file" name="gambar_makanan" required>
                </div>
                <div>
                    <label for="name">Food Name:</label>
                    <input type="text" name="nama_makanan" required>
                </div>
                <div>
                    <label for="description">Food Description:</label>
                    <textarea name="deksripsi_makanan" required></textarea>
                </div>
                <div>
                    <label for="category">Food Category:</label><br>
                    <input type="radio" name="kategori_menu" value="Appetizer" /> Appetizer<br><br>
                    <input type="radio" name="kategori_menu" value="Dessert" /> Dessert<br><br>
                    <input type="radio" name="kategori_menu" value="Main Course" /> Main Course<br><br>
                    <input type="radio" name="kategori_menu" value="Drink" /> Drink<br><br>
                    <input type="radio" name="kategori_menu" value="Vegetables" /> Vegetables<br><br>
                    <input type="radio" name="kategori_menu" value="Sea Food" /> Sea food<br><br>

                </div>

                <div>
                    <label for="price">Food Price:</label>
                    <input type="text" name="harga_makanan" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit_add">tambhkan makanan</button>
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
            $kon = mysqli_connect("localhost", "root", "", "kho_family");

            if (isset($_POST['submit_add'])) {
                $gambar_makanan = isset($_FILES['gambar_makanan']['name']) ? $_FILES['gambar_makanan']['name'] : "";
                $nama_makanan = isset($_POST['nama_makanan']) ? $_POST['nama_makanan'] : "";
                $deksripsi_makanan = isset($_POST['deksripsi_makanan']) ? $_POST['deksripsi_makanan'] : "";
                $kategori_menu = isset($_POST['kategori_menu']) ? $_POST['kategori_menu'] : "";
                $harga_makanan = isset($_POST['harga_makanan']) ? $_POST['harga_makanan'] : "";

                $target_dir = "D:\\XAMPP\\htdocs\\Proweb\\UTS\\Utama\\gambar_menu\\";
                $target_file = $target_dir . basename($_FILES["gambar_makanan"]["name"]);

                move_uploaded_file($_FILES["gambar_makanan"]["tmp_name"], $target_file);

                $query = "INSERT INTO menu (gambar_makanan, nama_makanan, deksripsi_makanan, kategori_menu, harga_makanan) 
                            VALUES ('$gambar_makanan', '$nama_makanan', '$deksripsi_makanan', '$kategori_menu', '$harga_makanan')";

                if (mysqli_query($kon, $query)) 
                {
                    echo "Gambar Berhasil ditambahkan";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($kon);
                }
            }
        }

        $kon = mysqli_connect("localhost", "root", "", "kho_family");

        if (!$kon) {
            die("Koneksi database gagal: " . mysqli_connect_error());
        }

        if (isset($_GET['hapus'])) {
            $id_makanan = $_GET['hapus'];
            $delete_pesanan_query = "DELETE FROM pesanan WHERE makanan_id = $id_makanan";
            if (mysqli_query($kon, $delete_pesanan_query)) {
                $delete_menu_query = "DELETE FROM menu WHERE id_makanan = $id_makanan";
                if (mysqli_query($kon, $delete_menu_query)) {
                    echo "<div class='deleted-message'>Data berhasil dihapus.</div>";
                } else {
                    echo "Error: " . $delete_menu_query . "<br>" . mysqli_error($kon);
                }
            } else {
                echo "Error: " . $delete_pesanan_query . "<br>" . mysqli_error($kon);
            }
        }
        

        if(isset($_GET['edit'])) {
            $id_makanan = $_GET['edit'];
            $query = "SELECT * FROM menu WHERE id_makanan = $id_makanan";
            $result = mysqli_query($kon, $query);

            if (mysqli_num_rows($result) > 0) 
            {
                $row = mysqli_fetch_assoc($result);
                $edit_id = $row['id_makanan'];
                $edit_nama_makanan = $row['nama_makanan'];
                $edit_deksripsi_makanan = $row['deksripsi_makanan'];
                $edit_kategori_menu = $row['kategori_menu'];
                $edit_harga_makanan = $row['harga_makanan'];
            }

            echo "
            <div class='edit'>
                <h2>Edit Food Item</h2>
                <form method='post' action='crud.php' enctype='multipart/form-data'>
                    <div>
                        <label for='name'>Food Name:</label>
                        <input type='text' name='edit_nama_makanan' value='$edit_nama_makanan' required>
                    </div>
                    <div>
                        <label for='description'>Food Description:</label>
                        <textarea name='edit_deksripsi_makanan' required>$edit_deksripsi_makanan</textarea>
                    </div>
                    <div>
                        <label for='category'>Food Category:</label>
                        <input type='radio' name='edit_kategori_menu' value='Appetizer' ".($edit_kategori_menu == 'Appetizer' ? 'checked' : '')." /> Appetizer<br><br>
                        <input type='radio' name='edit_kategori_menu' value='Dessert' ".($edit_kategori_menu == 'Dessert' ? 'checked' : '')." /> Dessert<br><br>
                        <input type='radio' name='edit_kategori_menu' value='Main Course' ".($edit_kategori_menu == 'Main Course' ? 'checked' : '')." /> Main Course<br><br>
                        <input type='radio' name='edit_kategori_menu' value='Drink' ".($edit_kategori_menu == 'Drink' ? 'checked' : '')." /> Drink<br><br>
                        <input type='radio' name='edit_kategori_menu' value='Vegetables' ".($edit_kategori_menu == 'Vegetables' ? 'checked' : '')." /> Vegetables<br><br>
                        <input type='radio' name='edit_kategori_menu' value='Sea Food' ".($edit_kategori_menu == 'Sea Food' ? 'checked' : '')." /> Sea Food<br><br>
                    </div>
                    <div>
                        <label for='price'>Food Price:</label>
                        <input type='text' name='edit_harga_makanan' value='$edit_harga_makanan' required>
                    </div>
                    <input type='hidden' name='edit_id' value='$edit_id'>
                    <button type='submit' class='btn btn-primary' name='submit_edit'>Save Changes</button>
                </form>
            </div>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit'])) {
            $edit_id = $_POST['edit_id'];
            $edit_nama_makanan = $_POST['edit_nama_makanan'];
            $edit_deksripsi_makanan = $_POST['edit_deksripsi_makanan'];
            $edit_kategori_menu = $_POST['edit_kategori_menu'];
            $edit_harga_makanan = $_POST['edit_harga_makanan'];

            $query = "UPDATE menu SET nama_makanan = '$edit_nama_makanan', deksripsi_makanan = '$edit_deksripsi_makanan', kategori_menu = '$edit_kategori_menu', harga_makanan = '$edit_harga_makanan' WHERE id_makanan = $edit_id";
            if (mysqli_query($kon, $query)) {
                echo "Data berhasil diperbarui.";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($kon);
            }
        }

        $query = "SELECT * FROM menu";
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $query = "SELECT * FROM menu WHERE nama_makanan LIKE '%$search%'";
        } else {
            $query = "SELECT * FROM menu";
        }

        $result = mysqli_query($kon, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<div class="menu-cards">';
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';
                echo '<img src="gambar_menu/' . $row['gambar_makanan'] . '" alt="' . $row['nama_makanan'] . '">';
                echo '<h3>' . $row['nama_makanan'] . '</h3>';
                echo '<p>' . $row['deksripsi_makanan'] . '</p>';
                echo '<p>Kategori: ' . $row['kategori_menu'] . '</p>';
                echo '<p>Harga: Rp ' . number_format($row['harga_makanan']) . '</p>';
                echo "<div class='buttons'>";
                echo '<a id="hapus" href="?edit=' . $row['id_makanan'] . '">Edit</a>';
                echo '<a href="?hapus=' . $row['id_makanan'] . '">Hapus</a>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            
        } else {
            echo "Tidak ada data makanan yang ditemukan.";
        }
        mysqli_close($kon);
        ?>
        <br>
        <?php
        include 'Utils/footer.html';
        echo '<link rel="stylesheet" href="Utils/footer.css"/>';
        ?>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="index.js"> </script>

</body>
</html>
