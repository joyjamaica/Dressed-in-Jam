<?php
session_start();
include "dbcon.php"; 

if (!isset($_SESSION['logged-in']) || !isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_cart_id']) && isset($_GET['delete_prod_id'])) {

    $cart_id = mysqli_real_escape_string($connection, $_GET['delete_cart_id']);
    $prod_id = mysqli_real_escape_string($connection, $_GET['delete_prod_id']);

    // 1. Identify the primary/parent product for this cart (the very first product inserted into cart_details)
    $parent_query = "SELECT prod_id FROM cart_details 
                    WHERE cart_id = '$cart_id' 
                    ORDER BY c_id ASC LIMIT 1";
    $parent_result = mysqli_query($connection, $parent_query);
    $parent_row = mysqli_fetch_assoc($parent_result);

    $parent_prod_id = $parent_row['prod_id'] ?? null;

    // 2. Count total items currently in this cart
    $count_query = "SELECT COUNT(*) AS total_items FROM cart_details WHERE cart_id = '$cart_id'";
    $count_result = mysqli_query($connection, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);

    $total_items = $count_row['total_items'];

    // 3. Check rule: If target is the PARENT product AND other child items still exist
    if ($prod_id == $parent_prod_id && $total_items > 1) {
        
        echo "<script>
                alert('Cannot delete the main product because other products depend on it! Remove the other items first.');
                window.location.href = 'cart_list.php';
              </script>";
        exit();

    } else {

        // 4. Allowed to delete: It's either a child item, or the parent item with no remaining children
        $delete_query = "DELETE FROM cart_details WHERE cart_id = '$cart_id' AND prod_id = '$prod_id'";
        $delete_result = mysqli_query($connection, $delete_query);

        if ($delete_result) {
            echo "<script>
                    alert('Item deleted successfully!');
                    window.location.href = 'cart_list.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error deleting item: " . mysqli_real_escape_string($connection, mysqli_error($connection)) . "');
                    window.location.href = 'cart_list.php';
                  </script>";
            exit();
        }
    }

} else {
    header("Location: cart_list.php");
    exit();
}
?>