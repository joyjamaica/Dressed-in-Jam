<?php
    include('dbcon.php');

    if(isset($_GET['id'])){
        $id = $_GET['id'];

    }

    $status = "Approved";
    $query = "UPDATE customer_table set status = '$status' where id = '$id'";
    $result = mysqli_query($connection, $query);

    header("Location: manage_user.php");
    exit();
?>