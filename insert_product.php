<?php
    session_start();
    include('dbcon.php');
    include('header.php');
?>

<body>
    <div class = "container-fluid">
        <div class = "row">
        <?php include('sidebar.php'); ?>

        <main class="col-lg-10 col-md-9 ms-sm-auto p-4">

<form class = "container" action = "insert_product.php" method = "POST" enctype="multipart/form-data">
        <h2 class = " text text-center">PRODUCT REGISTRATION</h2>
        <div>
            <img id="output"
            src="images/<?php echo $row['image']; ?>"
            style="margin-top:10px; width:200px; height:200px; object-fit:contain; border:1px; solid #ccc; border-radius:10px; display:none;">
        </div>

    <table class = "table table-bordered table-striped table-hover">
        <tr>
            <td><label>IMAGE</label></td>
            <td><input type = "file" name = "image" onchange="previewImage(event)"></td>
        </tr>

         <tr>
            <td>PRODUCT CODE</td>
            <td><input type = "text" placeholder = "Product code" name = "prod_id"></td>
        </tr>

         <tr>
            <td>PRODUCT NAME</td>
            <td><input type = "text" placeholder = "Product name" name = "prod_name"></td>
        </tr> 
        
         <tr>
            <td>DESCRIPTION</td>
            <td><input type = "text" placeholder = "Description" name = "description"></td>
        </tr> 

         <tr>
            <td>PRICE</td>
            <td><input type = "text" placeholder = "Price" name = "price"></td>
        </tr> 

         <tr>
            <td>QUANTITY</td>
            <td><input type = "text" placeholder = "Quantity" name = "quantity"></td>
        </tr> 
    </table>

    <input type = "submit" class = "btn btn-success" name = "btn-product_entry" value = "Register">
</form>

<script>
    function previewImage(event){

        const output = document.getElementByURL("output");

        output.src=URL.createObjectURL(event.target.files[0]);
        output.style.display = "block";

        output.onload=function (){
            URL.revokeObjectURL(output.src);
        }
    }

</script>
<?php
    if(isset($_POST['btn-product_entry'])){
        $prod_id = $_POST['prod_id'];
        $prod_name = $_POST['prod_name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $image = $_FILES['image'];
        
          $image = $_FILES['image']['name'];
          $tmp_image = $_FILES['image']['tmp_name'];

           move_uploaded_file($tmp_image, "images/" . $image);

        $query = "INSERT INTO product_table(prod_id,prod_name,description,price,quantity,image) VALUES ('$prod_id', '$prod_name', '$description', '$price', '$quantity', '$image')";
        $result = mysqli_query($connection, $query);

        if(!$result){
            die("Insert Failed". mysqli_error($connection));// apilon
        } else{

            echo "<script>
            alert('Insert Successful!');
            window.location = 'homepage.php';          
           </script>";
        }
}

?>
</main>
</div>
</div>
</body>