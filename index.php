<?php
include 'config.php';

$message = array();

if (isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

  
    if (checkPasswordStrength($password) === 'Weak') {
        $message[] = "Error: Password is weak. Please choose a stronger password.";
    } else {
        $password = md5($password); 
        $cpassword = md5($cpassword); 

        $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select) > 0) {
            $message[] = "User already exists";
        } else {
            if ($password != $cpassword) {
                $message[] = "Confirm Password not matching";
            } else {
                $insert = mysqli_query($conn, "INSERT INTO `user_form` (fname,lname,name, email,phone, password,status) VALUES('$fname','$lname','$name','$email','$phone','$password','pending')") or die('query failed');
                $message[] = "Pending for Approval";
            }
        }
    }
}


function checkPasswordStrength($password) {
    $strongRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    $mediumRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/';

    if (preg_match($strongRegex, $password)) {
        return 'Strong';
    } elseif (preg_match($mediumRegex, $password)) {
        return 'Medium';
    } else {
        return 'Weak';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .weak-password {
            color: red;
        }

        .strong-password {
            color: green;
        }

        .password-match {
            color: green;
        }

        .password-no-match {
            color: red;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="form-container">
        <form action="" method="post" id="registerForm">
            <h2>Register Now</h2>
            <?php
            if (!empty($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            ?>
            <input oninput="this.value = this.value.replace(/[0-9]/g,'')" type="text" name="fname"
                placeholder="Enter First Name" class="box" required>
            <input oninput="this.value = this.value.replace(/[0-9]/g,'')" type="text" name="lname"
                placeholder="Enter Last Name" class="box" required>
            <input type="text" name="name" placeholder="Enter Username" class="box" required>
            <input type="email" name="email" placeholder="Enter Email" class="box" required>
            <input type="number" name="phone" id="phone" placeholder="Enter Phone Number" class="box" required>
            <input type="password" name="password" id="password" placeholder="Enter Password" class="box"
                required>
            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" class="box"
                required>
            <div id="passwordStrength"></div>
            <div id="matchMessage"></div>
            <input class="btn btn-primary" name="submit" type="submit" value="Register" class="btn">
            <p>Already have an account? <a href="login.php">Login Now!</a></p>
        </form>
    </div>
    <script>
        document.getElementById("phone").addEventListener("input", function () {
            var phone = document.getElementById("phone").value;
            if (phone.length > 10) {
                document.getElementById("phone").value = phone.slice(0, 10);
            }
        });

        document.getElementById("password").addEventListener("input", function () {
            var password = document.getElementById("password").value;
            var strength = document.getElementById("passwordStrength");
            if (password === '') {
                strength.innerHTML = '';
                return;
            }
            var strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var mediumRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/;
            if (strongRegex.test(password)) {
                strength.innerHTML = '<span class="strong-password">Strong password</span>';
            } else if (mediumRegex.test(password)) {
                strength.innerHTML = '<span class="weak-password">Medium password</span>';
            } else {
                strength.innerHTML = '<span class="weak-password">Weak password</span>';
            }
            checkPasswordMatch(); // Check password match after input change
        });

        document.getElementById("cpassword").addEventListener("input", function () {
            checkPasswordMatch(); // Check password match after input change
        });

        // Function to check if password and confirm password match
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("cpassword").value;
            var matchMessage = document.getElementById("matchMessage");

            if (password === '' && confirmPassword === '') {
                matchMessage.innerHTML = ''; // Clear message if both fields are empty
                return;
            }
            if ( confirmPassword === '') {
                matchMessage.innerHTML = ''; 
                return;
            }



            if (password === confirmPassword) {
                matchMessage.innerHTML = '<span class="password-match">Passwords match</span>';
            } else {
                matchMessage.innerHTML = '<span class="password-no-match">Passwords do not match</span>';
            }
        }
    </script>
</body>

</html>
