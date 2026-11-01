<?php include('header.php')?>
 <?php include('dbcon.php');?>

<body>
    <form class = "container" method="POST" action="update.php">
        <h1 class = "text text-center text-primary">CUSTOMER RECORD FOR UPDATE</h1>

        <table class = "table table-hover table-bordered table-striped" style="--bs-table-hover-bg: pink;">
            <?php
                if(isset($_GET['id'])){
                     $id = $_GET['id'];
                     $query = "select * from customer_table where id = $id";
                     $result = mysqli_query($connection, $query);

                    
                     
                     if (!$result){
                        die("Retrieve failed! " .mysqli_error($connection));
                     } else {
                        $row = mysqli_fetch_assoc($result);
                     
                }
            }
                
                ?>

          <tr>
            <td>ID</td>
            <td><input type = "text" value = "<?php echo $row['id']; ?>" name = "id"></td>
          </tr>

          <tr>
            <td>First Name</td>
            <td><input type = "text" value = "<?php echo $row['f_name']; ?>" name = "f_name"></td>
          </tr>

          <tr>
            <td>Last Name</td>
            <td><input type = "text" value = "<?php echo $row['l_name']; ?>" name = "l_name"></td>
          </tr>

           <tr>
            <td>MI</td>
            <td><input type = "text" value = "<?php echo $row['mi']; ?>" name = "mi"></td>
          </tr>

          <tr>
            <td>Email</td>
            <td><input type = "text" value = "<?php echo $row['email']; ?>" name = "email"></td>
          </tr>

            <tr>
            <td>Username</td>
            <td><input type = "text" value = "<?php echo $row['username']; ?>" name = "username"></td>
          </tr>

         <tr>   
            <td>Password</td>
            <td><input type = "text" value = "<?php echo $row['password']; ?>" name = "password"></td>
          </tr>


        </table>

        <input type = "submit" name = "update_btn" class = "btn btn-success" value = "UPDATE RECORD">
        </form>
</body>