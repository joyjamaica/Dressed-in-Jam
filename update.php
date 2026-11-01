<?php
 include ('dbcon.php');

if (isset($_POST['update_btn'])) {
    $id = $_POST['id'];
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $mi = $_POST['mi'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "UPDATE customer_table SET f_name='$f_name', l_name='$l_name', mi='$mi', email='$email',
             username='$username', password='$password'  WHERE id='$id'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Update failed! ");
    } else {
       header("Location: customer_list.php");
        exit();
          }
    
}
?>