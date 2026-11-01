<?php
session_start();

// Change the session value
$_SESSION['status'] = 1;

// Redirect to homepage
header("Location: homepage.php");
exit();
?>