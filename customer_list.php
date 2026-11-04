<?php
    session_start();
    if(!isset($_SESSION['logged-in'])){
        echo "<script>
            alert('You must log in first!');
            window.location.href = 'index.php';
        </script>";
    }

?>

<?php include ('dbcon.php'); ?>
<?php include('header.php'); ?>

<body>

<div class="container-fluid">
    <div class="row">

        <?php include('sidebar.php'); ?>

        <main class="col-lg-10 col-md-9 p-4">
    
<h1 class = "text-center text-success" >Customer List </h1>

<form class = "container">

 <table class="table table-hover table-bordered table-striped" style="--bs-table-hover-bg: pink;">
    <thead Class = "table-dark">
        <tr class = "text-center">
            <th>ID</th>
            <th>First Name</th> 
            <th>Last Name</th>
            <th>MI</th>
            <th>Email</th>
            <th>Username</th>
            <th>Password</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $query = "select * from customer_table";
        $result = mysqli_query($connection, $query);
        
        if(!$result){
            die("Select failed! ");

        } else {
            while($row = mysqli_fetch_assoc($result)){
                ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['f_name']; ?></td>
            <td><?php echo $row['l_name']; ?></td>
            <td class = "text-center"><?php echo $row['mi']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><a href = "customer_display.php?id=<?php echo($row ['id']);?>" name = "Update_customer" class = "btn btn-success">UPDATE</td>
            <td><a href = "delete.php?id=<?php echo($row ['id']);?>" name = "delete_customer" class = "btn btn-danger" onclick = "return confirm('Are you sure you want to delete this customer?');">DELETE</td>

        </tr>

        <?php

            }
        }

        ?>

    </tbody>

 </table>
 </form>

</main>
</div>
</div>  
</body>

</html>