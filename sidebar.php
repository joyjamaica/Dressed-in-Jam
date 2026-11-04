<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="col-lg-2 col-md-3 bg-white text-dark min-vh-100 p-3">
<div class="position-sticky top-0 vh-100 p-3 overflow-y-auto">
            <h4 class="text-center mb-4  text-muted ">
                Jam's Apparel
            </h4>

            <hr>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="homepage.php" class="nav-link text-dark">
                        🏠 Home
                    </a>
                </li>

                <?php
                if($_SESSION['role'] == 'customer'){?>
                <li class="nav-item mb-2">
                    <a href="cart_list.php" class="nav-link text-dark">
                        🛒 My Cart
                    </a> 
                </li>
                <?php
                }
                ?>

                <?php
                if($_SESSION['role'] == 'customer'){?>
                <li class="nav-item mb-2">
                    <a href="my_purchases.php" class="nav-link text-dark">
                        <i class="bi bi-bag-check-fill me-2"></i>
                        My Purchases
                    </a>
                </li>
                <?php
                }
                ?>

                <?php
                if($_SESSION['role'] == "owner"){?>
                    <li class="nav-item mb-2">
                        <a href="insert_product.php" class="nav-link text-dark">
                            🛒 Add Product
                        </a>
                    </li>
                <?php
                }
                ?>

                <?php
                if($_SESSION['role'] == 'admin'){?>
                <li class="nav-item mb-2">
                    <a href="customer_list.php" class="nav-link text-dark">
                        🛒 User List
                    </a>
                </li>
                <?php
                }?>
                <?php
                if($_SESSION['role'] == "admin"){?>
                <li class="nav-item mb-2">
                  <a href="manage_user.php" class="nav-link text-dark">
                  <i class="bi bi-people-fill me-2"></i>
                         Manage Users
                  </a>
                </li>
                <?php
                }
                ?>

            </ul>

            <hr>

            <div class="d-grid">
                <a href="index.php" 
                   class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to logout?');">
                    Logout
                </a>
            </div>

        </div>
</div>
