<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'" )
                 or die('query failed');
                if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                }
                ?>
                <h3><?php echo $fetch['name']?></h3>
                <h4> Full Name : <?php echo $fetch['fname'] ." ". $fetch['lname'] ?></h4>
                <h4>Email : <?php echo $fetch['email'] ?></h4>
                <h4>Phone Number : <?php echo $fetch['phone'] ?></h4>
               <button class="btn"> <a href="update_profile.php">Update Profile</a></button>
                <button class="delete-btn"><a href="home.php?logout=<?php echo $user_id;?>">Log Out</a></button>
                <p>New <a href="login.php">Login</a> or <a href="register.php">Register</a></p>
        </div>
    </div>
</body>
</html>