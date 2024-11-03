<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KHO FAMILY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="header.css" />
</head>

<body>
    <nav id="palingatas" class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a id="logo" class="navbar-brand" href="index.php">Website: Restoran IF330-KHO FAMILY</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div id="header">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu.php">Our Menu</a>
                        </li>
                        <li class="nav-item">
                            <?php
                            if (isset($_SESSION['username'])) {
                                echo '<a class="nav-link" href="order.php">Order Food</a>';
                            } else {
                                echo '<a class="nav-link" href="login.php">Order Food</a>';
                            }
                            ?>
                        </li>
                        <li class="nav-item dropdown">
                        <?php
                            if (isset($_SESSION['username'])) 
                            {
                                echo '<div id="test">';
                                echo '<a class="nav-link dropdown-toggle" href="#" id="UserDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Hallo, ' . $_SESSION['username'] . '
                                </a>';
                                
                                $kon = mysqli_connect("localhost", "root", "", "kho_family");
                                $username = $_SESSION['username'];
                                $query = "SELECT role FROM ms_user WHERE username = '$username'";
                                $result = mysqli_query($kon, $query);
                                
                                if (mysqli_num_rows($result) > 0) 
                                {
                                    $row = mysqli_fetch_assoc($result);
                                    $role = $row['role'];
                                    
                                    if ($role === "admin") 
                                    {
                                            echo '
                                            <div class="dropdown-menu" aria-labelledby="UserDropdown">
                                                <a class="dropdown-item" href="crud.php">CRUD</a>
                                                <a class="dropdown-item" href="logout.php">Logout</a>
                                            </div>';
                                    } else
                                    {
                                        echo '<div class="dropdown-menu" aria-labelledby="UserDropdown">
                                            <a class="dropdown-item" href="logout.php">Logout</a>
                                        </div>';
                                    }
                                }
                            } else 
                            {
                                echo '<a class="nav-link" href="login.php">Login</a>';
                                echo '</div>';
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>
