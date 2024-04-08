<?php 
include "config.php";
session_start();

if(isset($_POST['updatebtn'])){

    $id = $_POST['editid'];
    $email = $_POST['editemail'];

    $query = "UPDATE `user_form` SET email='$email' WHERE id = '$id'";
    $query_run = mysqli_query($conn,$query);

    if($query_run){
        $_SESSION['success'] = "Your Data is Updated";
        header('Location: admin.php');

    }else{
        $_SESSION['status'] = "Your Data is NOT Updated";
        header('Location: admin.php');

    }
}


if(isset($_POST['delete_btn'])){

    $id = $_POST['delete_id'];  

    $query = "DELETE FROM `user_form` WHERE id = '$id'";
    $query_run = mysqli_query($conn,$query);

    if($query_run){

            $_SESSION['success'] = 'your data is deleted';
            header('Location: admin.php');
    }else{
            $_SESSION['status'] = 'your data is not deleted';
            header('Location: admin.php');
    }
}



?>