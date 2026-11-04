
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

    // Get selected cart product and available stock
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

    // Check if a purchase ID already exists in this login session
    if (!isset($_SESSION['purchase_id'])) {

        // Create purchase master record only for the first purchase
        $query = "INSERT INTO purchase_master (pdate, id)
                  VALUES (CURDATE(), '$id')";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            mysqli_rollback($connection);
            die("Purchase failed: " . mysqli_error($connection));
        }

        // Get the newly created purchase ID
        $purchase_id = mysqli_insert_id($connection);

    } else {

        // Reuse the existing purchase ID
        $purchase_id = $_SESSION['purchase_id'];
    }

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

    // Remove purchased product from cart details
    $query = "DELETE FROM cart_details
              WHERE cart_id = '$cart_id'
              AND prod_id = '$prod_id'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        mysqli_rollback($connection);
        die("Failed to remove product from cart!");
    }
// Check if the cart still has remaining items
$query = "SELECT COUNT(*) AS total
          FROM cart_details
          WHERE cart_id = '$cart_id'";

$result = mysqli_query($connection, $query);

if (!$result) {
    mysqli_rollback($connection);
    die(mysqli_error($connection));
}

$row = mysqli_fetch_assoc($result);

// If cart is empty, delete cart master
if ($row['total'] == 0) {

    $query = "DELETE FROM cart_master
              WHERE cart_id = '$cart_id'
              AND id = '$id'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        mysqli_rollback($connection);
        die("Cart master deletion error: " . mysqli_error($connection));
    }

    if (mysqli_affected_rows($connection) == 0) {
        mysqli_rollback($connection);
        die("No cart master record was deleted. Check the cart_id and user ID.");
    }
}

    // Save all changes
    mysqli_commit($connection);

    // Save purchase ID for the rest of this login session
    $_SESSION['purchase_id'] = $purchase_id;

    echo "<script>
            alert('Purchase successful!');
            window.location.href = 'my_purchases.php';
          </script>";

} else {
    header("Location: cart_list.php");
    exit();
}
?>
