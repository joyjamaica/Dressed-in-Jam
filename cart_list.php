<?php

session_start();

if (!isset($_SESSION['logged-in'])) {
    echo "<script>
            alert('Login first to load this page!');
            window.location.href = 'index.php';
          </script>";
    exit();
}

include('dbcon.php');
include('header.php');

$id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #FAF7F5 0%, #F3ECE7 100%);
            --accent-pink: #D48C95;
            --accent-pink-dark: #B86F78;
            --text-dark: #2B2625;
            --text-muted: #7E7775;
            --glass-bg: rgba(255, 255, 255, 0.65);
            --glass-border: rgba(255, 255, 255, 0.8);
        }

        body {
            background: var(--bg-gradient);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            padding-bottom: 4rem;
        }

        /* Header Section */
        .cart-header {
            text-align: center;
            padding: 2.5rem 1rem 1.5rem;
        }

        .cart-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .cart-subtitle {
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        /* Elegant Table Glass Container */
        .glass-table-wrapper {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            padding: 0.5rem;
            margin-bottom: 2rem;
        }

        .table-elegant {
            width: 100%;
            margin-bottom: 0;
            vertical-align: middle;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-elegant th {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            background-color: rgba(255, 255, 255, 0.4);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 1rem 0.75rem;
            text-align: center;
        }

        .table-elegant td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            font-size: 0.9rem;
            color: var(--text-dark);
            text-align: center;
        }

        .table-elegant tbody tr:last-child td {
            border-bottom: none;
        }

        .table-elegant tbody tr {
            transition: background 0.2s ease;
        }

        .table-elegant tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.45);
        }

        /* Table Column Specifics */
        .product-img-cell img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            background-color: #f7f7f7;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-title-cell {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1rem;
            text-align: left !important;
        }

        /* Quantity Custom Controls */
        .qty-control-wrapper {
            display: inline-flex;
            align-items: center;
            border: 1px solid rgba(0, 0, 0, 0.12);
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        .qty-btn {
            background: transparent;
            border: none;
            width: 28px;
            height: 28px;
            font-size: 0.85rem;
            color: var(--text-dark);
            transition: background 0.2s;
            cursor: pointer;
        }

        .qty-btn:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .qty-input {
            width: 36px;
            border: none;
            text-align: center;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-dark);
            outline: none;
        }

        /* Buttons */
        .btn-elegant {
            background-color: var(--accent-pink);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 0.45rem 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-elegant:hover {
            background-color: var(--accent-pink-dark);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(212, 140, 149, 0.35);
        }

        .btn-outline-custom {
            border: 1px solid rgba(0, 0, 0, 0.15);
            background: transparent;
            color: var(--text-dark);
            border-radius: 8px;
            padding: 0.35rem 0.75rem;
            font-size: 0.78rem;
            transition: all 0.25s ease;
        }

        .btn-outline-custom:hover {
            background: rgba(0, 0, 0, 0.05);
            color: var(--text-dark);
        }

        .btn-delete-custom {
            border: 1px solid rgba(217, 83, 79, 0.2);
            background: rgba(217, 83, 79, 0.05);
            color: #d9534f;
            border-radius: 8px;
            padding: 0.35rem 0.75rem;
            font-size: 0.78rem;
            text-decoration: none;
            transition: all 0.25s ease;
            display: inline-block;
        }

        .btn-delete-custom:hover {
            background: #d9534f;
            color: #ffffff;
        }

        /* Footer Summary Row */
        .table-footer-row td {
            background-color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            font-size: 1rem;
            border-top: 2px solid rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <?php include('sidebar.php'); ?>

        <main class="col-lg-10 col-md-9 ms-sm-auto p-4">

<div class="cart-header">
    <p class="cart-subtitle">Review Your Selection</p>
    <h1 class="cart-title">Shopping Cart</h1>
</div>

<div class="container mt-2">

    <div class="glass-table-wrapper">
        <div class="table-responsive">
            <table class="table-elegant">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product ID</th>
                        <th style="text-align: left;">Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sales</th>
                        <th>Update</th>
                        <th>Delete</th>
                        <th>Buy</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // GET CART PRODUCTS FOR LOGGED IN CUSTOMER
                    $query = "SELECT
                                b.cart_id,
                                b.cdate,
                                c.prod_id,
                                c.cqty,
                                d.prod_name,
                                d.price,
                                d.image,
                                (c.cqty * d.price) AS subtotal
                              FROM cart_master AS b
                              INNER JOIN cart_details AS c ON b.cart_id = c.cart_id
                              INNER JOIN product_table AS d ON c.prod_id = d.prod_id
                              WHERE b.id = '$id'";

                    $result = mysqli_query($connection, $query);

                    if (!$result) {
                        echo "<tr><td colspan='9' class='text-danger'>Error displaying cart: " . mysqli_error($connection) . "</td></tr>";
                    } else if (mysqli_num_rows($result) == 0) {
                        echo "<tr><td colspan='9' class='py-5 text-muted'>Your cart is currently empty.</td></tr>";
                    } else {
                        $grand_total = 0;

                        while ($row = mysqli_fetch_assoc($result)) {
                            $grand_total += $row['subtotal'];
                    ?>
                            <tr>
                                <!-- Image -->
                                <td class="product-img-cell">
                                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($row['prod_name']); ?>">
                                </td>

                                <!-- Product ID -->
                                <td class="text-muted">#<?php echo htmlspecialchars($row['prod_id']); ?></td>

                                <!-- Product Name -->
                                <td class="product-title-cell">
                                    <?php echo htmlspecialchars($row['prod_name']); ?>
                                </td>

                                <!-- Price -->
                                <td>₱<?php echo number_format($row['price'], 2); ?></td>

                                <!-- Form for Quantity Update -->
                                <form action="update_cart.php" method="POST">
                                    <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($row['cart_id']); ?>">
                                    <input type="hidden" name="prod_id" value="<?php echo htmlspecialchars($row['prod_id']); ?>">

                                    <!-- Quantity Control -->
                                    <td>
                                        <div class="qty-control-wrapper">
                                            <button type="button" class="qty-btn" onclick="decrement(this)">-</button>
                                            <input type="number" name="cqty" class="qty-input" value="<?php echo htmlspecialchars($row['cqty']); ?>" min="1" required>
                                            <button type="button" class="qty-btn" onclick="increment(this)">+</button>
                                        </div>
                                    </td>

                                    <!-- Sales / Subtotal -->
                                    <td class="fw-semibold">
                                        ₱<?php echo number_format($row['subtotal'], 2); ?>
                                    </td>

                                    <!-- Update Button -->
                                    <td>
                                        <button type="submit" name="update" class="btn-outline-custom">
                                            Update
                                        </button>
                                    </td>
                                </form>

                                <!-- Delete Link -->
                                <td>
                                    <a href="cart_list.php?delete_cart_id=<?php echo $row['cart_id']; ?>&delete_prod_id=<?php echo $row['prod_id']; ?>"
                                       class="btn-delete-custom"
                                       onclick="return confirm('Are you sure you want to remove this item from your cart?');">
                                        Remove
                                    </a>
                                </td>

                                <!-- Buy Button -->
                              <td>
                                 <form action="buy.php" method="POST">
                                     <input type="hidden" name="cart_id"
                                     value="<?php echo $row['cart_id']; ?>">

                                     <input type="hidden" name="prod_id"
                                     value="<?php echo $row['prod_id']; ?>">

                                     <button type="submit" class="btn-elegant">
                                        Buy
                                     </button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                        <!-- Summary Footer Row -->
                        <tr class="table-footer-row">
                            <td colspan="5" style="text-align: right; padding-right: 1.5rem;">Total:</td>
                            <td style="color: var(--text-dark);">₱<?php echo number_format($grand_total, 2); ?></td>
                            <td colspan="3"></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="d-flex justify-content-between align-items-center">
        <button class="btn-outline-custom py-2 px-3" onclick="goToHomepage()">
            &larr; Add Product to Cart
        </button>
    </div>

</div>
</main>
</div>
</div>

<script>
    function goToHomepage() {
        window.location.href = "homepage.php";
    }

    function increment(btn) {
        var input = btn.parentElement.querySelector('input');
        input.value = parseInt(input.value) + 1;
    }

    function decrement(btn) {
        var input = btn.parentElement.querySelector('input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>

</body>
</html>