<?php
include 'config.php';
session_start();

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));


    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$password'" ) or die('query failed');

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
}
else{
    $message[]='incorrect email or password!';
}
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="register.css">

</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <h2>Login Now</h2>
            <?php 
            if(isset($message)){
                foreach($message as $message){
                    echo '<div class="message">'.$message.'</div>';
                }
            }
            ?>  
            <input type="email" name="email" placeholder="Enter Email" class="box" required> 
            <input type="password" name="password" placeholder="Enter Password" class="box" required>
            <input class="btn btn-primary" name="submit" type="submit" value="Login" class="btn">
            <p>Don't have an account? <a href="register.php">Register Now!</a></p>
        </form>
    </div>
</body>
</html> 