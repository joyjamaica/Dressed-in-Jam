<?php
    session_set_cookie_params(0);
    session_start();
    include('dbcon.php');
?>

<?php include('header.php'); ?>

<body class = "d-flex justify-content-center align-items-center vh-100">
        <div class = "card p-4" style = "width: 350px;">
            <form class = "container" method = "POST" action = "index.php">
                <h4 class = "text text-center text-primary">USER LOGIN</h4>

            <table class = "table table-centered table-hover table-striped">
                <tr>
                    <td>Username</td>
                    <td><input type = "text" name = "username" placeholder = "Enter Username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type = "password" name = "password" placeholder = "Enter Password"></td>
                </tr>

            </table>
        <div class = "text-center mt-3">
            <input type = "submit" class = "btn btn-primary" name = "login-btn" value = 'LOGIN'> 
        </div>

        <label> If not registered, </lable>
        <a href = "register.php">Click Here!</a>

            </form>
        </div>

    <?php

    if(isset($_POST['login-btn'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = "SELECT * FROM customer_table 
                  WHERE username = '$username' 
                  AND password = '$password'";

        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0){

            $row = mysqli_fetch_assoc($result);

            // Check if account is approved
            if($row['status'] == 'denied'){

                echo "<script>
                        alert('Your account is waiting for admin approval.');
                        window.location.href = 'index.php';
                      </script>";
                exit();

            } else {

                $_SESSION['id'] = $row['id'];
                $_SESSION['f_name'] = $row['f_name'];
                $_SESSION['l_name'] = $row['l_name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['logged-in'] = true;
                $_SESSION['status'] = 0;

                unset($_SESSION['purchase_id']);

                header("Location: homepage.php");
                exit();

            }

        } else {

            echo "<script>
                    alert('Incorrect username or password.');
                    window.location.href = 'index.php';
                  </script>";
            exit();

        }
    }

?>

</body>