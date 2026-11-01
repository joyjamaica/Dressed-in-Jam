<?php
session_start();
include('dbcon.php');

// Ensure user is logged in
if (!isset($_SESSION['logged-in'])) {
    echo "<script>
            alert('Login first to load this page!');
            window.location.href = 'index.php';
          </script>";
    exit();
}

// Process update request
if (isset($_POST['update'])) {
    $cart_id = mysqli_real_escape_string($connection, $_POST['cart_id']);
    $prod_id = mysqli_real_escape_string($connection, $_POST['prod_id']);
    $cqty = mysqli_real_escape_string($connection, $_POST['cqty']);

    $update_query = "UPDATE cart_details 
                     SET cqty = '$cqty' 
                     WHERE cart_id = '$cart_id' AND prod_id = '$prod_id'";

    $update_result = mysqli_query($connection, $update_query);

    if ($update_result) {
        if (mysqli_affected_rows($connection) > 0) {
            echo "<script>
                    alert('Quantity updated successfully!');
                    window.location.href = 'cart_list.php';
                  </script>";
        } else {
            echo "<script>
                    alert('No changes were made to the quantity.');
                    window.location.href = 'cart_list.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Failed to update quantity due to a database error!');
                window.location.href = 'cart_list.php';
              </script>";
    }
    exit();
} else {
    // If accessed directly without submitting form, redirect back
    header('Location: cart_list.php');
    exit();
}