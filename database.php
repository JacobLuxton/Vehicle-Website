<?php

require_once 'db_cred.php';

// create function to return 
function db_queryAll($sql, $conn) {
    try{

        // run the query and store the results
        $cmd = $conn->prepare($sql);
        $cmd -> execute();
        $vehicle = $cmd->fetchAll();
        return $vehicle;
    } catch (Exception $e) {
        header("location: error.php");
    }
}

//create function to return one row / part of array
function db_queryOne($sql, $conn) {
    try {
    
        // run the query and store the results
        $cmd = $conn->prepare($sql);
        $cmd -> execute();
        $vehicle = $cmd->fetch();
        return $vehicle;
    } catch (Exception $e) {
        header("location: error.php");
    }
}
//get credentials for database and set to a variable
function db_connect() {
    $conn = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME,  DB_USER, DB_PASS);
    return $conn;
}

// create function to disconnect from database
function db_disconnect($conn) {
    if(isset($conn)) {
        // if $conn is set to something then disconnect
        $conn = null;
    }
}

?>