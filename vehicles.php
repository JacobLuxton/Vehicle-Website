<?php

    //connect to the database
    require_once 'database.php';
    $conn = db_connect();

    include_once 'shared/top.php';

    $sql = "SELECT * FROM Vehicles";
    $vehicles = db_queryAll($sql, $conn);
?>

<div class="container">
    <table class="table table-dark table-bordered border-info fs-4">
    <thead class="text-font">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Make</th>
        <th scope="col">Model</th>
        <th scope="col">Year</th>
        <th scope="col">Colour</th>
        <th scope="col" class="col-1">Edit</th>
        <th scope="col" class="col-1">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach ($vehicles as $vehicle) {  ?>
            <tr>
            <th scope="row"><?php echo $i; $i=$i+1;  ?></th>
            <td><?php echo $vehicle['carMake']; ?></td>
            <td><?php echo $vehicle['carModel']; ?></td>
            <td><?php echo $vehicle['carYear']; ?></td>
            <td><?php echo $vehicle['colour']; ?></td>
            <td><a href="vehicle-edit.php?carNumber= <?php echo $vehicle['carNumber'];?>" class="btn btn-secondary">Edit<i class="bi bi-pencil-square"></i></a></td>
            <td><a href="vehicle-delete.php?carNumber= <?php echo $vehicle['carNumber'];?>" class="btn btn-warning">Delete<i class="bi bi-trash2-fill"></i></a></td>
            </tr>
        <?php } ?>
    </tbody>
    </table>
</div>
<?php

include_once 'shared/footer.php';

?>