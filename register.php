
<?php include('header.php'); ?>
<body>
    <h1>Customer Registration</h1>

    <form class = "container" action="insert.php" method="POST">
    <table class="table table-hover table-bordered table-striped" style="--bs-table-hover-bg: pink;">
        <tr>
            <td><label>ID</label></td>
            <td><input type="text" name="id" placeholder="Enter ID"></td>
        </tr>
        
         <tr>
            <td><label>First Name</label></td>
            <td><input type="text" name="f_name"  placeholder="First Name"></td>
        </tr>

       <tr>
            <td><label>Last Name</label></td>
            <td><input type="text" name="l_name" placeholder="Last Name"></td>
        </tr>

                <tr>
            <td><label>MI</label></td>
            <td><input type="text" name="mi"  placeholder="Middle Initial"></td>
        </tr>

         <tr>
            <td><label>Email</label></td>
            <td><input type="text" name="email" placeholder="Email"></td>
        </tr>   

        <tr>
            <td><label>Role</label></td>
            <td>
            <select id="role" name="role">
                <option value="" disabled selected>-- Select role --</option>
                <option value="customer">customer</option>
                <option value="owner">owner</option>
             </select>
            </td>
        </tr>

        <tr>
            <td><label>Username</label></td>
            <td><input type="text" name="username" placeholder="Username"></td>
        </tr>

        <tr>
            <td><label>Password</label></td>
            <td><input type="text" name="password"  placeholder="Password"></td>
        </tr>

</table>
<input type="submit" name="register_btn"  class="btn btn-primary">
</form>

</body>