<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php 
    session_start();
    if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
        echo '<h2 class="bg-primary"> '.$_SESSION['success'].'</h2>';
        unset($_SESSION['success']);
    }
    if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
        echo '<h2 class="bg-danger"> '.$_SESSION['status'].'</h2>';
        unset($_SESSION['status']);
    }
    ?>

    <div class="table-responsive">
        <?php 
            include 'config.php';

            $query = "SELECT * FROM `user_form` WHERE status='pending' ORDER BY id ASC";
            $query_run = mysqli_query($conn,$query);
        ?>
    <table class="table table-bordered" id="dataTable" width="100%">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Phone </th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($query_run) > 0 ){
        while($row = mysqli_fetch_assoc($query_run)){
          
            ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['fname']; ?></td>
      <td><?php echo $row['lname']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['phone']; ?></td>
    <td><form action="admin-approval.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input class="btn btn-success" type="submit" name="approve" value="Approve">
        <input class="btn btn-danger" type="submit" name="deny" value="Deny">
    </form></td>
    </tr>   
    <?php
        }
    }
    else{
        echo 'No record found';
    }
    
    ?>
  </tbody>
</table>
    </div>

    <?php
        if(isset($_POST['approve'])){
            $id = $_POST["id"];

            $select = "UPDATE `user_form` SET status = 'approved' WHERE id = '$id'";
            $result = mysqli_query($conn,$select);

            echo '<script type = "text/javascript">';
            echo 'alert("User Approved!");';
            echo 'window.location.href = "admin-approval.php"';
            echo '</script>';

        }

        if(isset($_POST['deny'])){
            $id = $_POST["id"];

            $select = "DELETE FROM `user_form` WHERE id = '$id'";
            $result = mysqli_query($conn,$select);

            echo '<script type = "text/javascript">';
            echo 'alert("User Denied!");';
            echo 'window.location.href = "admin-approval.php"';
            echo '</script>';

        }
    ?>
</body>
</html>