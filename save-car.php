<?php

try {

    //make input into variables and sanitize to desired input
    $make = trim(filter_var($_POST['make'], FILTER_SANITIZE_STRING));
    $model = trim(filter_var($_POST['model'], FILTER_SANITIZE_STRING));
    $year = trim(filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT));
    $colour = trim($_POST['colour']);
} catch (Exception $e) {
    header("location: error.php");
}

//variable to know whether form is valid or not
$is_valid_form = true;
 //check for blanks for all required fields
if(empty($make)) {
    echo "Please enter a valid make of car <br>";
    $is_valid_form = false;
}
if(empty($model)) {
    echo "Please enter a valid model of car <br>";
    $is_valid_form = false;
}
//attach file
require 'db.php';
// create regular expression for year field
$year_regex = "/[0-9]{4}/";

if($year < 0 || strlen($year) != 4 || !preg_match($year_regex, $year)) {
    echo "Please enter a valid year <br>";
    $is_valid_form = false;
}

//if form is valid, enter info into database
if($is_valid_form) {

    try {

        $sql = "INSERT INTO Vehicles (carMake, carModel, carYear, colour) VALUES (:make, :model, :year, :colour)";

        $cmd = $conn->prepare($sql);
        $cmd -> bindParam(':make', $make, PDO::PARAM_STR, 15);
        $cmd -> bindParam(':model', $model, PDO::PARAM_STR, 15);
        $cmd -> bindParam(':year', $year, PDO::PARAM_INT);
        $cmd -> bindParam(':colour', $colour, PDO::PARAM_STR, 10);

        $cmd -> execute();
    } catch (Exception $e) {
        header("location: error.php");
    }

    $conn = null;

    echo "Submitted";
}

?>