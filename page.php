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
        $new_vehicle['make'] = $make;
        $new_vehicle['model'] = $model;
        $new_vehicle['year'] = $year;
        $new_vehicle['colour'] = $colour;

         //get variables for picture
        $name = $_FILES['pic']['name'];
        $tmp_name = $_FILES['pic']['tmp_name'];
        if($tmp_name != null)
        {
            $type = mime_content_type($tmp_name);
            $new_vehicle['type'] = $type;
        }
        $size = $_FILES['pic']['size']; 

        $new_vehicle['name'] = $name;
        $new_vehicle['tmp_name'] = $tmp_name;
        $new_vehicle['size'] = $size;

        //use validate function to fill array erros if there are errors
        $errors = validate_vehicle($new_vehicle);

        if(empty($errors))
        {
            //if no errors in 'pic' and type is set
            //move photo to uploads and set name of photo in db
            if(empty($errors['pic']) && isset($type))
            {
                move_uploaded_file($tmp_name, "uploads/" . substr(session_id(), 5, 10) . $name);
                $pic_name = substr(session_id(), 5, 10) . $name;
            }
            try {

                //start sql insert command
                $sql = "INSERT INTO Vehicles (carMake, carModel, carYear, colour, photo) VALUES (:make, :model, :year, :colour, :photo)";
        
                //command to fill parameters with the form values
                $cmd = $conn->prepare($sql);
                $cmd -> bindParam(':make', $make, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':model', $model, PDO::PARAM_STR, 15);
                $cmd -> bindParam(':year', $year, PDO::PARAM_INT);
                $cmd -> bindParam(':colour', $colour, PDO::PARAM_STR, 10);
                $cmd -> bindParam(':photo', $pic_name, PDO::PARAM_STR, 100);

                $cmd -> execute();

                $name = $make . ' ' . $model;
                
                header("Location: vehicles.php?t=0&msg=$name");
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
        <form class="justify-content-center text-font fs-3" method="POST" novalidate enctype="multipart/form-data">
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
            <div class="mb-5 text-center">
                <label for="year">Year</label>
                <div class="container" style="width: 50%;">
                    <input inputmode="numeric" class="<?= (isset($errors['year']) ? 'is-invalid ' : ''); ?> form-control" pattern="[0-9]{4}" type="text" name="year" value="<?= $year ?? ''; ?>"></input>
                    <p class="text-danger"><?= $errors['year'] ?? ''; ?></p>
                </div>
            </div>
            <div class="mb-2 text-center">
                <div class>
                    <label class="mb-5" for="colour" class="<?= (isset($errors['colour']) ? 'is-invalid ' : ''); ?> form-control" value="<?= $colour ?? ''; ?>">Colour</label>
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
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-3 mb-5">
                    <img id="cover" src="https://dummyimage.com/300x225" class="card-img-top" alt="game cover">
                    <div class="card-body">
                        <input id="choosefile" type="file" name="pic" class="form-control">
                    </div>
                    <p class="px-3 pb-2 text-danger"><?= $errors['pic'] ?? ''; ?></p>
                </div>
            </div>

                <div class="mt-5 text-center">
                    <button class="btn btn-info fs-3">Submit</button>
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



