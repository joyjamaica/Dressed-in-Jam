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
        <div class = "container-fluid">
        <div class = "row">
        <?php include('sidebar.php'); ?>

        <main class="col-lg-10 col-md-9 ms-sm-auto p-4">
            
<h1 class = "text-center text-success" >USER VERIFICATION PAGE</h1>

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
            <th>Approval</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $query = "SELECT * FROM customer_table WHERE status != 'Approved' OR status IS NULL OR status = ''";        
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
            <td><a href = "approval.php?id=<?php echo($row ['id']);?>" name = "approval" class = "btn btn-success">Approved</td>

        </tr>

        <?php

            }
        }

        ?>
<main>
</div>
</div>

    </tbody>

 </table>
 </form>


</body>

</html>