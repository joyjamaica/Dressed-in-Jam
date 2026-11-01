<?php
    session_start();

    if(!isset($_SESSION['logged-in'])){
        echo "<script>
            alert('You must log in first!');
            window.location.href = 'index.php';
        </script>";
        exit();
    }

    include('dbcon.php');
    include('header.php');
?>

<body class="pb-5">
    <div class = "container-fluid">
        <div class = "row">
    <?php include('sidebar.php'); ?>

    <main class="col-lg-10 col-md-9 ms-sm-auto p-4">

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <p class="text-uppercase text-muted small mb-0">Jam's Collection</p>
            <h1 class="home-title font-serif title-primary h2 mb-0">Featured Dresses</h1>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
        <?php
            $query = "SELECT * FROM product_table";
            $result = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100 glass-card">
                
                <div class="card-img-wrapper">
                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" 
                         alt="<?php echo htmlspecialchars($row['prod_name']); ?>">
                </div>

                <div class="card-body d-flex flex-column">
                    <h5 class="font-serif title-primary h6 mb-2">
                        <?php echo htmlspecialchars($row['prod_name']); ?>
                    </h5>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">₱<?php echo number_format($row['price'], 2); ?></span>
                        <span class="stock-badge">Stock: <?php echo htmlspecialchars($row['quantity']); ?></span>
                    </div>

                    <p class="text-muted small flex-grow-1 mb-3">
                        <?php echo htmlspecialchars(substr($row['description'], 0, 60)); ?>...
                    </p>

                    <a href="add_cart.php?prod_id=<?php echo $row['prod_id']; ?>" class="btn-elegant">
                        Add to Cart
                    </a>
                </div>

            </div>
        </div>
        <?php } ?>
    </div>
</div>
 </div>
</div>
</body>
</html>