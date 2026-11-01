<?php

include('dbcon.php');

if (isset($_POST['register_btn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $f_name = mysqli_real_escape_string($connection, $_POST['f_name']);
    $l_name = mysqli_real_escape_string($connection, $_POST['l_name']);
    $mi = mysqli_real_escape_string($connection, $_POST['mi']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $status = "denied";

    $query = "INSERT INTO customer_table (id, f_name, l_name, mi, email, role, username, password, status) VALUES ('$id', '$f_name', '$l_name', '$mi', '$email', '$role', '$username', '$password', '$status')";
    $result = mysqli_query($connection, $query);


    if (!$result) {
        die("Insert failed!");
    } else {
       header("Location: index.php");
    }
}

?>