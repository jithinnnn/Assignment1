<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){
     
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    mysqli_query($conn,  "UPDATE `user_form` SET name ='$update_name',email='$update_email' WHERE id = '$user_id'") or die('query failed');


    $old_pass = $_POST['old_pass'];
    $update_pass  = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass  = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass  = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

    if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
        if($update_pass != $old_pass){
            $message[] = 'Old Password not matched';
        }elseif($new_pass != $confirm_pass){
            $message[] = 'Confirm Password not matched';
        }else{
            mysqli_query($conn,  "UPDATE `user_form` SET password ='$confirm_pass' WHERE id = '$user_id'") or die('query failed');
            $message[] = ' Password updated sucessfully!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="update-profile">
    <?php
                $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'" )
                 or die('query failed');
                if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                }
                ?>

        <form action="" method="post">
            <div class="flex">
                <div class="inputBox">
                <?php
                  if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
            ?>
                    <span>Username :</span>
                    <input type="text" name="update_name" class="box" value="<?php echo $fetch['name'] ?>">
                    <span>Email :</span>
                    <input type="email" name="update_email" class="box" value="<?php echo $fetch['email'] ?>">
                </div>
                <div class="inputBox">
                    <input type="hidden" value="<?php echo $fetch['password'] ?>" name="old_pass" id="">
                    <span>Old Password</span>
                    <input class="box" type="password" name="update_pass" placeholder="Enter previous Password">
                    <span>New Password</span>
                    <input class="box" type="password" name="new_pass" placeholder="Enter new Password">
                    <span>Confirm Password</span>
                    <input class="box" type="password" name="confirm_pass" placeholder="Confirm New Password">
                </div>
            </div>
            <input type="submit" class="btn " value="Update Profile" name="update_profile">
            <button class="delete-btn"><a href="home.php">Go Back </a></button>
        </form>
    </div>
</body>
</html>
