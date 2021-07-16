<?php

//start the session
session_start();

//uset the session data
session_unset();
session_destroy();

//redirect to login page
header("Location:login.php");

?>