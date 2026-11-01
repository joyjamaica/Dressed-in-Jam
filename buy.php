<?php
    session_start();

    if (!isset($_SESSION['logged-in'])) {
        header("Location: index.php");
        exit();
    }

    include('dbcon.php');

    $id = $_SESSION['id'];

    if (isset($_POST['cart_id']) && isset($_POST['prod_id'])) {

        $cart_id = $_POST['cart_id'];
        $prod_id = $_POST['prod_id'];

        // Start transaction
        mysqli_begin_transaction($connection);

        // Get the selected cart product and available stock
        $query = "SELECT c.cqty, p.quantity
                  FROM cart_details AS c
                  INNER JOIN cart_master AS m ON c.cart_id = m.cart_id
                  INNER JOIN product_table AS p ON c.prod_id = p.prod_id
                  WHERE c.cart_id = '$cart_id'
                  AND c.prod_id = '$prod_id'
                  AND m.id = '$id'
                  FOR UPDATE";

        $result = mysqli_query($connection, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            mysqli_rollback($connection);
            die("Product not found in your cart!");
        }

        $row = mysqli_fetch_assoc($result);

        $pqty = $row['cqty'];
        $stock = $row['quantity'];

        // Check available stock
        if ($pqty > $stock) {
            mysqli_rollback($connection);
            die("Not enough product stock!");
        }

        // Create purchase master record
        $query = "INSERT INTO purchase_master (pdate, id)
                  VALUES (CURDATE(), '$id')";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            mysqli_rollback($connection);
            die("Purchase failed: " . mysqli_error($connection));
        }

        $purchase_id = mysqli_insert_id($connection);

        // Record purchased product
        $query = "INSERT INTO purchase_details
                  (purchase_id, prod_id, pqty)
                  VALUES ('$purchase_id', '$prod_id', '$pqty')";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            mysqli_rollback($connection);
            die("Purchase details failed: " . mysqli_error($connection));
        }

        // Deduct purchased quantity from product stock
        $query = "UPDATE product_table
                  SET quantity = quantity - '$pqty'
                  WHERE prod_id = '$prod_id'
                  AND quantity >= '$pqty'";

        $result = mysqli_query($connection, $query);

        if (!$result || mysqli_affected_rows($connection) != 1) {
            mysqli_rollback($connection);
            die("Failed to update product quantity!");
        }

        // Remove purchased product from cart
        $query = "DELETE FROM cart_details
                  WHERE cart_id = '$cart_id'
                  AND prod_id = '$prod_id'";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            mysqli_rollback($connection);
            die("Failed to remove product from cart!");
        }

        // Save all changes
        mysqli_commit($connection);

        echo "<script>
                alert('Purchase successful!');
                window.location.href = 'my_purchases.php';
              </script>";

    } else {
        header("Location: cart_list.php");
        exit();
    }
?>