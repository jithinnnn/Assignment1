    <?php
    include 'config.php';


    if(isset($_POST['submit'])){
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$password'" ) or die('query failed');

        if(mysqli_num_rows($select) > 0){
            $message[] = "user already exists";
        }else{
            if($password != $cpassword){
                $message[]="Confirm Password not matching";
            }else{
                $insert = mysqli_query($conn , "INSERT INTO `user_form` (fname,lname,name, email,phone, password) VALUES('$fname','$lname','$name','$email','$phone','$password')") or die ('query failed');

                if($insert){
                    $message[] = 'registered successfully';
                    header('location:login.php');
                }
                else{
                    $message[] = "registration failed";
                }
            }
        }
    }
    ?>






    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="register.css">

    </head>
    <body>
        <div class="form-container">
            <form action="" method="post">
                <h2>Register Now</h2>
                <?php 
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                    }
                }
                ?>
                <input oninput=" this.value = this.value.replace(/[0-9]/g,'')" type="text" name="fname" placeholder="Enter First Name" class="box" required>
                <input oninput=" this.value = this.value.replace(/[0-9]/g,'')" type="text" name="lname" placeholder="Enter Last Name" class="box" required>
                <input type="text" name="name" placeholder="Enter Username" class="box" required> 
                <input type="email" name="email" placeholder="Enter Email" class="box" required> 
                <input type="number" name="phone" placeholder="Enter Phone Number" class="box" required>
                <input type="password" name="password" placeholder="Enter Password" class="box" required>
                <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required>
                <input class="btn btn-primary" name="submit" type="submit" value="Register" class="btn">
                <p>Already have an account? <a href="login.php">Login Now!</a></p>
            </form>
        </div>
    </body>
    </html> 