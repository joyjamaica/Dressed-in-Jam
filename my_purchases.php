<?php
    session_start();

    if (!isset($_SESSION['logged-in'])) {
        header("Location: index.php");
        exit();
    }

    include('dbcon.php');
    include('header.php');

    $id = $_SESSION['id'];
?>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include('sidebar.php'); ?>

        <main class="col-lg-10 col-md-9 p-4">

            <h2 class="text-center mb-4">MY PURCHASES</h2>

            <table class="table table-bordered table-striped table-hover">

                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Purchase ID</th>
                        <th>Date</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Image</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    $query = "SELECT
                                m.purchase_id,
                                m.pdate,
                                d.prod_id,
                                d.pqty,
                                p.prod_name,
                                p.image
                              FROM purchase_master AS m
                              INNER JOIN purchase_details AS d
                              ON m.purchase_id = d.purchase_id
                              INNER JOIN product_table AS p
                              ON d.prod_id = p.prod_id
                              WHERE m.id = '$id'
                              ORDER BY m.purchase_id DESC";

                    $result = mysqli_query($connection, $query);

                    if (!$result) {
                        die("Select failed: " . mysqli_error($connection));
                    }

                    if (mysqli_num_rows($result) == 0) {
                        echo "<tr>
                                <td colspan='6' class='text-center'>
                                    You have no purchases yet.
                                </td>
                              </tr>";
                    }

                    while ($row = mysqli_fetch_assoc($result)) {

                    ?>

                    <tr class="text-center">

                        <td><?php echo $row['purchase_id']; ?></td>

                        <td><?php echo $row['pdate']; ?></td>

                        <td><?php echo $row['prod_id']; ?></td>

                        <td><?php echo $row['prod_name']; ?></td>

                        <td><?php echo $row['pqty']; ?></td>

                        <td>
                            <img src="images/<?php echo $row['image']; ?>"
                                 width="70" height="70"
                                 style="object-fit: contain;">
                        </td>

                    </tr>

                    <?php
                    }
                    ?>

                </tbody>

            </table>

        </main>

    </div>
</div>

</body>
</html>