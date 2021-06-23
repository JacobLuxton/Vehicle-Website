<?php 
    //connect to db
    require_once 'database.php';
    $conn = db_connect();

    // if the request method is get then filter the car number and select data from that record
    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        try{

            $id = filter_var($_GET['carNumber'], FILTER_SANITIZE_NUMBER_INT);

            $sql = "SELECT * FROM Vehicles WHERE carNumber=" . $id;

            // get data from this particular record
            $vehicle = db_queryOne($sql, $conn);

            //set variables for each part of array
            $make = $vehicle['carMake'];
            $model = $vehicle['carModel'];
            $year = $vehicle['carYear'];
            $colour = $vehicle['colour'];

            // attach top.php
            include_once 'shared/top.php';
            // add HTML to delete page
        } catch (Exception $e) {
            header("location: error.php");
        }
?>
    <h1 class="text-center mt-5 display-1 text-danger"><i class="bi bi-exclamation-diamond-fill"></i></h1>
    <h1 class="text-center text-font">Are you sure you want to delete this Vehicle?</h1>
    <div class="container">
        <form class="justify-content-center text-font fs-3" method="POST">
            <div class="mb-2 text-center">
                <label for="make">Make</label>
                <div>
                    <input readonly type="text" name="make" value="<?php echo $make; ?>">
                </div>
            </div>
            <div class="mb-2 text-center">
                <label for="model">Model</label>
                <div>
                    <input readonly type="text" name="model" value="<?php echo $model; ?>">
                </div>
            </div>
            <div class="mb-3 text-center">
                <label for="year">Year</label>
                <div>
                    <input readonly type="text" name="year" value="<?php echo $year; ?>">
                </div>
            </div>
            <div class="mb-2 text-center">
                <div class>
                    <label class="me-5" for="colour">Colour</label>
                    <input readonly type="text" name="colour" value="<?php echo $colour; ?>">
                </div>
                <div class="mt-5 justify-content-center">
                    <input readonly type="hidden" name="carNumber" value="<?php echo $id; ?>">
                    <button class="btn btn-info fs-3">Delete</button>
                </div>
            </div>
        </form>
    </div>

<?php 

    // else if the request method is post filter the carNumber and delete it from the database
    } else if($_SERVER['REQUEST_METHOD'] == 'POST') {

        try {
        
            $id = filter_var($_POST['carNumber'], FILTER_SANITIZE_NUMBER_INT);
            echo "id is $id";
            // run command to delete in database
            $sql = "DELETE FROM Vehicles WHERE carNumber = " . $id;

            //prepare and execute
            $cmd = $conn->prepare($sql);
            $cmd -> execute();

            // return to vehicles page
            header("Location: vehicles.php");
        } catch (Exception $e) {
            header("location: error.php");
        }
    }