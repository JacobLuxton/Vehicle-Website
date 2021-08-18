<?php
    session_start();
    //get validations file and make sure user is logged in
    require_once 'validations.php';
    //connect to the database
    require_once 'database.php';
    $conn = db_connect();

    $page_title = "Vehicle List";
    include_once 'shared/top.php';

    $sql = "SELECT * FROM Vehicles";
    $vehicles = db_queryAll($sql, $conn);

    $word_list = [];

    if(!empty($keywords)) 
    {

    $sql .= " WHERE ";

    //split the multiple keywords into an array using php explode
    $word_list = explode(" ", trim($keywords));

    //loop through word list array and add each word to where clause
    foreach($word_list as $key => $word)
    {
        $word_list[$key] = "%" . $word . "%";
        
        //but for the first word, omit the word OR
        if($key == 0)
        {
        $sql .= " carMake LIKE ?";
        } else
        {
            $sql .= "OR carMake LIKE ?";
        }
    }
    }

    $vehicles = db_queryAll($sql, $conn, $word_list);
?>

<div class="container">
    <table class=" sortable table table-dark table-bordered border-info fs-4">
    <thead class="text-font">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Make</th>
        <th scope="col">Model</th>
        <th scope="col">Year</th>
        <th scope="col">Colour</th>
        <?php if(is_logged_in()) { ?>
        <th scope="col" class="col-1 sorttable_nosort">Edit</th>
        <th scope="col" class="col-1 sorttable_nosort">Delete</th>
        <?php } ?>
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

            <?php if(is_logged_in()) { ?>

                <td><a href="vehicle-edit.php?carNumber= <?php echo $vehicle['carNumber'];?>" class="btn btn-secondary">Edit<i class="bi bi-pencil-square"></i></a></td>
                <td><a href="vehicle-delete.php?carNumber= <?php echo $vehicle['carNumber'];?>" class="btn btn-warning">Delete<i class="bi bi-trash2-fill"></i></a></td>

            <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
    </table>
</div>
<?php

$t = filter_var($_GET['t'] ?? '', FILTER_SANITIZE_STRING);
$msg = filter_var($_GET['msg'] ?? '', FILTER_SANITIZE_STRING);
display_toast($t, $msg);
include_once 'shared/footer.php';

?>