<?php 

    session_start();

    //get validations file and make sure user is logged in
    require_once 'validations.php';
    require_login();

    //connect to db
    require_once 'database.php';
    $conn = db_connect();
?>
<?php
require_once 'shared/top.php';
?>

<body>
    <h1 class="text-center text-font">Add a Vehicle</h1>
    <div class="container">
        <form class="justify-content-center text-font fs-3" action="save-car.php" method="POST" novalidate>
            <div class="mb-2 text-center">
                <label for="make">Make</label>
                <div>
                    <input required type="text" name="make"></input>
                </div>
            </div>
            <div class="mb-2 text-center">
                <label for="model">Model</label>
                <div>
                    <input required type="text" name="model"></input>
                </div>
            </div>
            <div class="mb-3 text-center">
                <label for="year">Year</label>
                <div>
                    <input inputmode="numeric" pattern="[0-9]{4}" type="text" name="year"></input>
                </div>
            </div>
            <div class="mb-2 text-center">
                <div class>
                    <label class="me-5" for="colour">Colour</label>
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



