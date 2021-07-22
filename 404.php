<?php 

    session_start();

    //get validations file and make sure user is logged in
    require_once 'validations.php';
    require_login();
    //connect to db
    require_once 'database.php';
    $conn = db_connect();

    $page_title = "404";
    require_once 'shared/top.php';
?>

<main class="container">    
    <div class="row">
        <div class="col">
            <h1 class="mt-5 pt-5"> Nothing To See Here </h1>
            <p>It looks like the page you are looking for does not exist or cannot be found. Page may have been moved or renamed.</p>
            <a href="front-page.php" class="btn btn-outline-secondary">Back to Homepage</a>
        </div>
        <div class="col">
            <img src="img/car.png" alt="404 error" style="width: 800px">
        </div>
    </div>
</main>