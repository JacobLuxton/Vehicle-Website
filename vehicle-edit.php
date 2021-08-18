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

            //get variables for picture
            $name = $_FILES['pic']['name'];
            $tmp_name = $_FILES['pic']['tmp_name'];
            if($tmp_name != null)
            {
                $type = mime_content_type($tmp_name);
                $edit_vehicle['type'] = $type;
            }
            $size = $_FILES['pic']['size']; 

            $edit_vehicle['name'] = $name;
            $edit_vehicle['tmp_name'] = $tmp_name;
            $edit_vehicle['size'] = $size;

            $errors = validate_vehicle($edit_vehicle);

            if(empty($errors))
            {

                //if errors pic is empty and type has been set 
                //move file to uploads and create name for database
                if(empty($errors['pic']) && isset($type))
                {
                    move_uploaded_file($tmp_name, "uploads/" . substr(session_id(), 5, 10) . $name);
                    $pic_name = substr(session_id(), 5, 10) . $name;
                }
                //otherwise find photo that is set in database and keep it as that photo
                //if there is no photo then it will stay set as nothing
                else
                {
                    $sql = "SELECT * FROM Vehicles WHERE carNumber=" . $id;
                    $game = db_queryONE($sql, $conn);
                    $pic_name = $game['photo'];
                }

                    // create update statement
                $sql = "UPDATE Vehicles SET carMake=:make,";
                $sql .= "carModel=:model, carYear=:year, colour=:colour ,photo=:photo ";
                $sql .= "WHERE carNumber=:id";

                // bind each column of record
                $cmd = $conn->prepare($sql);
                $cmd -> bindParam(':make', $make, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':model', $model, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':year', $year, PDO::PARAM_INT);
                $cmd -> bindParam(':colour', $colour, PDO::PARAM_STR, 10);
                $cmd -> bindParam(':id', $id, PDO::PARAM_STR, 10);
                $cmd -> bindParam(':photo', $pic_name, PDO::PARAM_STR, 100);

                $cmd -> execute();

                $name = $make . ' ' . $model;
                header("Location: vehicles.php?t=2&msg=$name");
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
            $pic = $vehicle['photo'];

        } catch (Exception $e) {
            header("location: error.php");
        }
    }

?>

<h1 class="text-center text-font">Edit Vehicle</h1>
    <div class="container">
        <form class="justify-content-center text-font fs-3" action="vehicle-edit.php" method="POST" novalidate enctype="multipart/form-data">
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
            <div class="mb-5 text-center">
                <label for="year">Year</label>
                <div class="container" style="width: 50%;">
                    <input inputmode="numeric" class="<?= (isset($errors['year']) ? 'is-invalid ' : ''); ?> form-control" pattern="[0-9]{4}" type="text" name="year" value="<?php echo $year ?>"></input>
                    <p class="text-danger"><?= $errors['year'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-2 text-center">
                <div class>
                    <label class="mb-5" for="colour">Colour</label>
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
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-3 mb-5">
                        <img id="cover" src="<?= isset($pic) ? 'uploads/' . $pic : 'https://dummyimage.com/300x225'; ?>" class="card-img-top" alt="game cover">
                        <div class="card-body">
                            <input id="choosefile" type="file" name="pic" class="form-control">
                        </div>
                        <p class="px-3 pb-2 text-danger"><?= $errors['pic'] ?? ''; ?></p>
                    </div>
                </div>

                <div class="mt-5 justify-content-center">
                <input readonly type="hidden" name="carNumber" value="<?php echo $id; ?>">
                    <button class="btn btn-info fs-3">Update Vehicle</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        function handlefileSelect(evt) {
            const reader = new FileReader();

            reader.addEventListener('load', (e) => {
                cover.src = e.target.result;
                console.log(e.target.result);
            })
            reader.readAsDataURL(evt.target.files[0]);
        }
        choosefile.addEventListener('change', handlefileSelect) 
    </script>
<?php

include_once 'shared/footer.php';

?>