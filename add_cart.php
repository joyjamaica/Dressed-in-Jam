<?php
session_set_cookie_params(0);
session_start();

if (!isset($_SESSION['logged-in'])) {
    echo "<script>
            alert('Login first to load this page!');
            window.location.href = 'index.php';
          </script>";
    exit();
}

include "header.php";
include "dbcon.php";

if (isset($_GET['prod_id'])) {
    $prod_id = mysqli_real_escape_string($connection, $_GET['prod_id']);
    $id = $_SESSION['id'];
    $cart_id = null;

    // 2. Check if the user already has an active cart master record
    if (!isset($_SESSION['status']) || $_SESSION['status'] == 0) {
        
        // Look up if user already has an active cart in database first
        $check_master = "SELECT cart_id FROM cart_master WHERE id = '$id' ORDER BY cart_id DESC LIMIT 1";
        $master_result = mysqli_query($connection, $check_master);

        if (mysqli_num_rows($master_result) > 0) {
            $master_row = mysqli_fetch_assoc($master_result);
            $cart_id = $master_row['cart_id'];
            $_SESSION['status'] = 1; // Mark session as having an active cart
        } else {
            // No existing cart found, create a new master cart
            $query = "INSERT INTO cart_master(cdate, id) VALUES(NOW(), '$id')";
            $result = mysqli_query($connection, $query);
            if ($result) {
                $cart_id = mysqli_insert_id($connection);
                $_SESSION['status'] = 1; // Update status so subsequent adds reuse this cart
            } else {
                echo "ADD ERROR: " . mysqli_error($connection);
                exit();
            }
        }

    } else {
        // Fetch the active cart_id for this user
        $query3 = "SELECT cart_id FROM cart_master WHERE id = '$id' ORDER BY cart_id DESC LIMIT 1";
        $result3 = mysqli_query($connection, $query3);
        
        if ($row3 = mysqli_fetch_assoc($result3)) {
            $cart_id = $row3['cart_id'];
        } else {
            // Fallback if status was 1 but record was manually deleted
            $query = "INSERT INTO cart_master(cdate, id) VALUES(NOW(), '$id')";
            mysqli_query($connection, $query);
            $cart_id = mysqli_insert_id($connection);
        }
    }   

    // 3. Process cart details with established cart_id
    if ($cart_id) {
        $check_query = "SELECT * FROM cart_details WHERE cart_id = '$cart_id' AND prod_id = '$prod_id'";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Product exists in active cart -> Increment quantity
            $query2 = "UPDATE cart_details SET cqty = cqty + 1 WHERE cart_id = '$cart_id' AND prod_id = '$prod_id'";
        } else {
            // Product is new to active cart -> Insert new row
            $query2 = "INSERT INTO cart_details(cart_id, prod_id, cqty) VALUES('$cart_id', '$prod_id', 1)";
        }

        $result2 = mysqli_query($connection, $query2);

        if ($result2) {
            echo "<script>
                    alert('ADD TO CART SUCCESSFUL!');
                    window.location.href = 'cart_list.php';
                  </script>";
            exit();
        } else {
            echo "ADD ERROR: " . mysqli_error($connection);
        }
    }
}
?>