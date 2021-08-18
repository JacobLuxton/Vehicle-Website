<?php
$keywords = '';
if(isset($_GET['K'])) {
    $keywords = filter_var($_GET['K'], FILTER_SANITIZE_STRING);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

</head>
<body>
    <div class="container">
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
                <div class="container-fluid">
                    <a class="navbar-brand fs-2 text-font" href="#">Cars <i class="bi bi-tools"></i></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 fs-4">
                            <li class="nav-item">
                                <a class="nav-link active text-font" aria-current="page" href="front-page.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active text-font" href="vehicles.php">List</a>
                            </li>
                            <?php if(is_logged_in()) { ?>
                                <li class="nav-item">
                                    <a class="nav-link active text-font" href="page.php">Add Vehicle</a>
                                </li>
                            <?php } ?>
                            
                        </ul>
                        <form class="d-flex pe-5" action="vehicles.php" method="GET">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="K" value="<?= $keywords ?>">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                        <form class="d-flex">
                            <?php if(is_logged_in()) { ?>
                                <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>  <?= $_SESSION['username']; ?>
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="logout.php">Logout <i class="bi bi-door-closed-fill"></i></a></li>
                                </ul>
                            </div>
                            <?php } else { ?>
                                <li class="nav-item">
                                <a class="nav-link display btn btn-light" href="login.php">Login</a>
                                </li>
                                <li></li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-info" href="register.php">Register</a>
                                </li>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </nav>
        </header>
    </div>
