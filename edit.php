


<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
         -webkit-appearance: none;
            margin: 0;
}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Details</title>
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="form-container">
    <?php
    include 'config.php';

    if(isset($_POST['edit_btn'])){
        $id = $_POST['edit_id'];
        $query = "SELECT * FROM `user_form` WHERE id = '$id'";
        $query_run = mysqli_query($conn,$query);

        foreach($query_run as $row)
        {
            ?>

    
       <form action="code.php" method="POST">
        <h2>Edit User Details</h2>
        <input type="hidden" name="editid" value="<?php echo $row['id'] ?>">
        <input type="text" value="<?php echo $row['fname'] ?>" name="editfname" placeholder="Enter First Name" class="box"> <br>
        <input type="text" value="<?php echo $row['lname'] ?>" name="editlname" placeholder="Enter Last Name" class="box"> <br>
            <input type="text" value="<?php echo $row['name'] ?>" name="editname" placeholder="Enter Username" class="box" readonly> <br>
                    <input type="email" value="<?php echo $row['email'] ?>" name="editemail" placeholder="Enter Email" class="box" required> <br> 
                    <input type="number"  step="0.01" value="<?php echo $row['phone'] ?>" name="editphone" placeholder="Enter Phone Number" class="box"> <br>  
                    <input  type="password" value="<?php echo $row['password'] ?>" name="editpassword" placeholder="Enter Password" class="box" readonly><br>
                    <a href="admin.php" class="btn btn-danger">Cancel</a>
                    <button type="submit" name="updatebtn" class="btn btn-success">Update</button>
                    <?php
        }
    }

    ?>  
       </form>
    </div>
</body>
</html>