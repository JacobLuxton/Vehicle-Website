<?php 

    session_start();

    //get validations file and make sure user is logged in
    require_once 'validations.php';
    require_login();

    //connect to db
    require_once 'database.php';
    $conn = db_connect();

    $errors = [];

    if($_SERVER["REQUEST_METHOD"] == 'POST')
    {
        //make input into variables and sanitize to desired input
        $make = trim(filter_var($_POST['make'], FILTER_SANITIZE_STRING));
        $model = trim(filter_var($_POST['model'], FILTER_SANITIZE_STRING));
        $year = trim(filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT));
        $colour = trim($_POST['colour']);

        //Associative array to hold values of each field of what user has input
        $new_vehicle = [];
        $new_vehcile['make'] = $make;
        $new_vehcile['model'] = $model;
        $new_vehcile['year'] = $year;
        $new_vehcile['colour'] = $colour;

        //use validate function to fill array erros if there are errors
        $errors = validate_vehicle($new_vehcile);

        if(empty($errors))
        {
            try {

                //start sql insert command
                $sql = "INSERT INTO Vehicles (carMake, carModel, carYear, colour) VALUES (:make, :model, :year, :colour)";
        
                //command to fill parameters with the form values
                $cmd = $conn->prepare($sql);
                $cmd -> bindParam(':make', $make, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':model', $model, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':year', $year, PDO::PARAM_INT);
                $cmd -> bindParam(':colour', $colour, PDO::PARAM_STR, 10);
        
                $cmd -> execute();

                header("Location: front-page.php");
            } catch (Exception $e) {
                header("location: error.php");
            }
        
        }

    }
?>


<?php
    $page_title = "Add Vehicle";
    require_once 'shared/top.php';
?>

<body>
    <h1 class="text-center text-font">Add a Vehicle</h1>
    <div class="container">
        <form class="justify-content-center text-font fs-3" method="POST" novalidate>
            <div class="mb-2 text-center">
                <label for="make">Make</label>
                <div class="container" style="width: 50%;">
                    <input required class="<?= (isset($errors['make']) ? 'is-invalid ' : ''); ?> form-control" type="text" name="make" value="<?= $make ?? ''; ?>"></input>
                    <p class="text-danger"><?= $errors['make'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-2 text-center">
                <label for="model">Model</label>
                <div class="container" style="width: 50%;">
                    <input required type="text" class="<?= (isset($errors['model']) ? 'is-invalid ' : ''); ?> form-control" name="model" value="<?= $model ?? ''; ?>"></input>
                    <p class="text-danger"><?= $errors['model'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-3 text-center">
                <label for="year">Year</label>
                <div class="container" style="width: 50%;">
                    <input inputmode="numeric" class="<?= (isset($errors['year']) ? 'is-invalid ' : ''); ?> form-control" pattern="[0-9]{4}" type="text" name="year" value="<?= $year ?? ''; ?>"></input>
                    <p class="text-danger"><?= $errors['year'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-2 text-center">
                <div class>
                    <label class="me-5" for="colour" class="<?= (isset($errors['colour']) ? 'is-invalid ' : ''); ?> form-control" value="<?= $colour ?? ''; ?>">Colour</label>
                    <select name="colour">
                        <?php
                            $sql = "SELECT Colour FROM Colours ORDER BY Colour";
                            $colours = db_queryAll($sql, $conn);

                            foreach ($colours as $colour) {
                                echo "<option value=" . $colour["Colour"] . ">" . $colour["Colour"] .  "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mt-5 justify-content-center">
                    <button class="btn btn-info fs-3">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    include_once 'shared/footer.php';
    ?>



