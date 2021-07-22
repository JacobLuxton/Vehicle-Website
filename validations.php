<?php


    function validate_vehicle($vehicle)
    {
        $errors = [];

                //check for blanks for all required fields
        if(empty($vehicle['make'])) {
            $errors['make'] = "Please enter a valid make of car <br>";
            
        }
        if(empty($vehicle['model'])) {
            $errors['model'] = "Please enter a valid model of car <br>";
            
        }
        //attach file
        require 'db.php';
        // create regular expression for year field
        $year_regex = "/[0-9]{4}/";
        $year = $vehicle['year'];

        if($year < 0 || strlen($year) != 4 || !preg_match($year_regex, $year)) {
            $errors['year'] =  "Please enter a valid year <br>";
            
        }

        return $errors;
    }
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }

    function require_login() {
        if(!is_logged_in()){
            header("Location:login.php");
            exit;
        }
    }
    
    function validate_registration($user, $conn) {
        $errors = [];

        //if email is empty return message
        if(empty(trim($user['email']))) {
            $errors['email'] = "Email cannot be blank";
        }

        //create an email regex
        $email_regex ="/.+\@.+\..+/";

        //if email does not match regex return message
        if(!preg_match($email_regex, $user['email'])) {
            $errors['email'] = "Username must be a valid email address";
        }

        //if passwords do not match notify user
        if(!(trim($user['new-password']) == trim($user['confirm-password']))) {
            $errors['password'] = "passwords do not match";
            $errors['confirm'] = "passwords do not match";
        }
        //if password is empty return messsage
        if(empty(trim($user['new-password']))) {
            $errors['password'] = "password cannot be blank";
        }

        //if confirmation password is empty return message
        if(empty(trim($user['confirm-password']))) {
            $errors['confirm'] = "password cannot be blank";
        }

        //see if username is already taken
        $sql = "SELECT * FROM web_users WHERE username='" . $user['email'] . "'";
        $cmd = $conn -> prepare($sql);
        $cmd -> execute();
        $found_username = $cmd -> fetch();

        //if username alredy taken notify user
        if($found_username) {
            $errors['email'] = 'Username already taken';
        }

        return $errors;
    }

?>