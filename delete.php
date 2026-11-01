<?php
 include ('dbcon.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM customer_table WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Delete failed! " . mysqli_error($connection));
    } else {
        header("Location: customer_list.php");
        exit();
    }
}
?>