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

        if($vehicle['size'] > 1000000) {
            $errors['pic'] = "Image must be less than 1MB";
        }
        //if tmp_name is set (make sure that there is a 'type' to reference)
        if($vehicle['tmp_name'] != null)
        {
            //and type is set, and type does not match jpeg or png, show error
            if(!($vehicle['type'] == 'image/jpeg' || $vehicle['type'] == 'image/png')) {
                $errors['pic'] = "Image format must be .jpg or .png";
            }
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

    function display_toast($t, $msg) {

        if(!$t && !$msg) {
            return;
        }
        $msgs = [];
        $msgs['0'] = "Successfully Added";
        $msgs['1'] = "Successfully Deleted";
        $msgs['2'] = "Successfully Edited";
        
        echo <<<EOL
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-dark text-light">
            <strong class="me-auto">$msgs[$t]</strong>
            <small>now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
            $msg
            </div>
        </div>
        </div>
        <script>
        window.addEventListener('DOMContentLoaded', () => {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl)
            });
        toastList.forEach(toast => toast.show());
        });
        </script>
        EOL;
    }

?>