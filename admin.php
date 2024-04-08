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

            $query = "SELECT * FROM `user_form`";
            $query_run = mysqli_query($conn,$query);
        ?>
    <table class="table table-bordered" id="dataTable" width="100%">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(mysqli_num_rows($query_run) > 0 ){
        while($row = mysqli_fetch_assoc($query_run)){
          
            ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['password']; ?></td>
      <td><form action="edit.php" method="post">
        <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
            <button name="edit_btn" class="btn btn-primary">EDIT</button>
         </form></td>
      <td><form action="code.php" method="post">
        <input type="hidden" name="delete_id" value="<?php echo $row['id'];  ?>">
        <button type="submit" name="delete_btn" class="btn btn-danger">DELETE</button>
    </form></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
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
</body>
</html>