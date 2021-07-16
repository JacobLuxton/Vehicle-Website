<?php
session_start();

//get validations file and make sure user is logged in
require_once 'validations.php';
require_login();
//connect to db
require_once 'database.php';
$conn = db_connect();

include_once 'shared/top.php';

?>
<div class="container">
    <img src="img/Bugatti.jpg" class="img-fluid" alt="bugatti">
</div>
    
<?php

include_once 'shared/footer.php';

?>