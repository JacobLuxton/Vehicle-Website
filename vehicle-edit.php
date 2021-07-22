<?php 

    session_start();

    //get validations file and make sure user is logged in
    require_once 'validations.php';
    require_login();
    //connect to db
    require_once 'database.php';
    $conn = db_connect();

    $page_title = "Edit Vehicle";
    require_once 'shared/top.php';

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        try{

            //make input into variables and sanitize to desired input
            $make = trim(filter_var($_POST['make'], FILTER_SANITIZE_STRING));
            $model = trim(filter_var($_POST['model'], FILTER_SANITIZE_STRING));
            $year = trim(filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT));
            $colour = trim(filter_var($_POST['colour'], FILTER_SANITIZE_STRING));
            $id = trim(filter_var($_POST['carNumber'], FILTER_SANITIZE_URL));

            $edit_vehicle = [];
            $edit_vehicle['make'] = $make;
            $edit_vehicle['model'] = $model;
            $edit_vehicle['year'] = $year;
            $edit_vehicle['colour'] = $colour;

            $errors = validate_vehicle($edit_vehicle);

            if(empty($errors))
            {
                    // create update statement
                $sql = "UPDATE Vehicles SET carMake=:make,";
                $sql .= "carModel=:model, carYear=:year, colour=:colour ";
                $sql .= "WHERE carNumber=:id";

                // bind each column of record
                $cmd = $conn->prepare($sql);
                $cmd -> bindParam(':make', $make, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':model', $model, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':year', $year, PDO::PARAM_INT);
                $cmd -> bindParam(':colour', $colour, PDO::PARAM_STR, 10);
                $cmd -> bindParam(':id', $id, PDO::PARAM_STR, 10);

                $cmd -> execute();

                header("Location: vehicles.php");
            }
        } catch (Exception $e) {
            header("location: error.php");
        }
    } else if($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {

            // get value for id
            $id = filter_var($_GET['carNumber'], FILTER_SANITIZE_NUMBER_INT);

            //choose record where id matches
            $sql = "SELECT * FROM Vehicles WHERE carNumber=" . $id;
    
            // get data from this particular record
            $vehicle = db_queryOne($sql, $conn);
    
            //set variables for each part of array
            $make = $vehicle['carMake'];
            $model = $vehicle['carModel'];
            $year = $vehicle['carYear'];
            $colour = $vehicle['colour'];
        } catch (Exception $e) {
            header("location: error.php");
        }
    }

?>

<h1 class="text-center text-font">Edit Vehicle</h1>
    <div class="container">
        <form class="justify-content-center text-font fs-3" action="vehicle-edit.php" method="POST" novalidate>
            <div class="mb-2 text-center">
                <label for="make">Make</label>
                <div class="container" style="width: 50%;">
                    <input required class="<?= (isset($errors['make']) ? 'is-invalid ' : ''); ?> form-control form-control-lg" type="text" name="make" value="<?php echo $make ?>"></input>
                    <p class="text-danger"><?= $errors['make'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-2 text-center">
                <label for="model">Model</label>
                <div class="container" style="width: 50%;">
                    <input required class="<?= (isset($errors['model']) ? 'is-invalid ' : ''); ?> form-control" type="text" name="model" value="<?php echo $model ?>"></input>
                    <p class="text-danger"><?= $errors['model'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-3 text-center">
                <label for="year">Year</label>
                <div class="container" style="width: 50%;">
                    <input inputmode="numeric" class="<?= (isset($errors['year']) ? 'is-invalid ' : ''); ?> form-control" pattern="[0-9]{4}" type="text" name="year" value="<?php echo $year ?>"></input>
                    <p class="text-danger"><?= $errors['year'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-2 text-center">
                <div class>
                    <label class="me-5" for="colour">Colour</label>
                    <select name="colour">
                        <?php
                            $sql = "SELECT Colour FROM Colours ORDER BY Colour";
                            $colours = db_queryAll($sql, $conn);

                            foreach ($colours as $eachColour) {
                                echo "<option " . (($eachColour["Colour"] == ($colour)) ? 'selected' : '') . " value=" . $eachColour["Colour"] . ">" . ucfirst($eachColour["Colour"]) .  "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mt-5 justify-content-center">
                <input readonly type="hidden" name="carNumber" value="<?php echo $id; ?>">
                    <button class="btn btn-info fs-3">Submit</button>
                </div>
            </div>
        </form>
    </div>

<?php

include_once 'shared/footer.php';

?>