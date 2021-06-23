<?php
//connect to db
require_once 'database.php';
$conn = db_connect();

require_once 'shared/top.php';

?>

<main class="container">    
    <div class="row">
        <div class="col">
            <h1 class="mt-5 pt-5"> Ummmm, What happened? </h1>
            <p>We apologize but something unexpected happened. We will work on fixing this issue</p>
            <a href="front-page.php" class="btn btn-outline-secondary">Back to Homepage</a>
        </div>
        <div class="col">
            <img src="img/accident.jpg" alt="error" style="width: 800px">
        </div>
    </div>
</main>

<?php

include_once 'shared/footer.php';

?>