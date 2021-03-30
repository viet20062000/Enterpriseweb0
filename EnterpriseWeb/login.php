<?php
  session_start();
  include 'DatabaseConfig/dbConfig.php';  
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login page</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="css/login.css" rel="stylesheet">

</head>

<body>

  <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">

    <div class="container">
      <div class="card login-card">
        <div class="row no-gutters">
          <div class="col-md-5">
            <img src="img/login.jpg" alt="login" class="login-card-img">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <div class="brand-wrapper">
                <img src="img/logo.png" alt="logo" class="logo">
              </div>
              <p class="login-card-description">Sign into your account</p>
              <form action="#!" method ="POST">
                  <div class="form-group">
                        <label  class="sr-only">Username</label>
                        <input  name="username"  class="form-control" placeholder="Username">
                      </div>
                      <div class="form-group mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="***********">
                      </div>

                      <?php
                          if(isset($_POST['submit'])) {

                          $username = $_POST['username'];
                          $pass = $_POST['password'];

                          $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$pass'";
                          $result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

                          if (!$row = $result->fetch_assoc()) {
                            echo ' <div class="alert alert-danger alert-dismissible fade show ">
                              <small><strong>Error!</strong> Wrong account or password.</small>
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>';
                            
                          }
                        }
                      ?>
                   <input name="submit" type="submit" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">
                </form>
                <a href="#!" class="forgot-password-link">Forgot password?</a>
                <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
                <nav class="login-card-footer-nav">
                  <a href="#!">Terms of use.</a>
                  <a href="#!">Privacy policy</a>
                </nav>
            </div>
          </div>
        </div>
      </div>   

  </main>
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <?php
        if(isset($_POST['submit'])) {

          $username = $_POST['username'];
          $pass = $_POST['password'];

          $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$pass'";
          $result = mysqli_query($conn, $sql)  or die("Could not connect database " .mysqli_error($conn));

          if (!$row = $result->fetch_assoc()) {
            //echo '<script>alert("Username or Password is incorrect")</script>';
          } else {
            session_start();
        
            $_SESSION['id'] = $row['username'];
            $_SESSION['uid'] = $row['user_id'];

            if($row['user_role'] == 'Admin' || $row['user_role'] == 'Coordinator' || $row['user_role'] == 'Manager' || $row['user_role'] == 'Student' || $row['user_role'] == 'Guest') {

              $_SESSION['user_role'] = $row['user_role'];

              if(isset($_SESSION['user_role'])) {
                if($_SESSION['user_role'] == 'Admin') {
                  header("Location: AdminHome.php");
                }
                else if($_SESSION['user_role'] == 'Coordinator') {
                  header("Location: CoordinatorHome.php");
                }
                else if($_SESSION['user_role'] == 'Manager') {
                  header("Location:ManagerHome.php");
                }
                else if($_SESSION['user_role'] == 'Student') {
                  header("Location:StudentHome.php");
                }
                else if($_SESSION['user_role'] == 'Guest') {
                  header("Location:GuestHome.php");
                }
              }
            }
            else {
              echo "Role not found.";
            }
          }
        }
      ?>

</body>

</html>