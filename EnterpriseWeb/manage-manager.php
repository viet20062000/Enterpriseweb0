<?php 
	session_start();
	include("DatabaseConfig/dbConfig.php");
        $error = $msg = "";
	if(!isset($_SESSION['id'])){
		echo "<script>window.open('login.php','_self')</script>";

	}else{
		$user_session = $_SESSION['id'];

		$get_user = "select * from user where username = '$user_session'";
		$run_user = mysqli_query($conn,$get_user);
		$row_user = mysqli_fetch_array($run_user);

		$admin_name = $row_user['username'];
		$admin_role = $row_user['user_role'];
                $admin_email = $row_user['user_email'];
                if($admin_role!='Admin'){
                        session_start();
                        session_destroy();
                        echo "<h1>Restricted area, please go back to the login page</h1>";
                        echo "<script>window.open('login.php','_self')</script>";
                }
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
            //Load the current data to that batch
        $query = "SELECT * FROM user WHERE user_id = '$user_id'";
        $run_query = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($run_query);
        if ($row) {
        $faculty_id = $row['faculty_id'];
        $username = $row['username'];
        $password = $row['password'];
        $email=$row['user_email'];
        
        }
    }
    if(isset($_POST['submit'])) {
        $newUserId=$_POST['user_id'];
        $newUsername = $_POST['username'];
        $newPass = $_POST['password'];
        $newEmail=$_POST['email'];
        $newFID=$_POST['faculty'];
        $query="select * from user where username = '$newUsername'and user_email='$newEmail' ";
        $checkdup = mysqli_query($conn, $query);
            if (!$nodup = $checkdup->fetch_assoc()) {          
                $sql = "UPDATE user SET faculty_id = '$newFID', username = '$newUsername', password = '$newPass' , user_email ='$newEmail' WHERE user_id = '$newUserId'";
                $result = mysqli_query($conn,$sql);
                if (!$result) {
                $error = "<br>Can't update user, please try again";
                } else {
                    $msg = "Upadated $username successfully!";
                    header("Location:AdminHome.php?successfulUpdated");
                }
            }
    }
	
               
	
 ?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
        type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#">Academy</a>
            <i class="fas fa-user-alt"></i>
        </div>
    </nav>

    <!-- Content -->
    <div class="grid-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="text-center">
                <img src="img/avatar.png" class="rounded avatar mx-auto img-fluid" alt="...">
                <h2><?php echo"Name: ", $admin_name ?></h2>
                <div>DOB: 11/1/2011</div>
                <div><?php echo"Email: ",$admin_email ?></div>
                <div>Phone Number: 923874239</div>
            </div>
        </div>
        <!-- Right Content -->
        <div class="content">
            <h2>Manage Manager Information</h2>
            <form action="manage-manager.php" method ="POST" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $user_id; ?>" name="user_id"/>
                <div class="form-group">
                    <label for="name">Username:</label>
                    <input type="text" class="form-control" name="username" required value="<?php echo $username; ?>" id="username">
                </div>
                <div class="form-group">
                    <label for="faculty">Faculty:</label>
                    <select class="form-control" id="faculty" required value="<?php echo $faculty_id; ?>"  name="faculty">
                <?php
                    $query = "SELECT * FROM faculty";
                    $faculties = mysqli_query($conn,$query);
                        while ($faculty= mysqli_fetch_array($faculties)) {
                        $fId = $faculty['0'];
                        $fName = $faculty['1'];
                            if ($fId==$faculty_id){
                                echo "<option value='$faculty_id' selected='selected'>$fName</option>";
                            }else{
                                echo "<option value='$fId'>$fName</option>";
                        }
                    }
                ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required value="<?php echo $password; ?>" id="password">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required value="<?php echo $email; ?>" id="email">
                </div>
                   <div><?php echo $msg; ?></div>
                <button type="submit" value="update" name="submit" class="btn btn-primary"><i class="far fa-save"></i> Save</button>
                <a href="AdminHome.php" class="btn btn-info"><i class="fas fa-home"></i> Back</a>
            </form>

        </div>
    </div>
    </div>


    <!-- Footer -->
    <footer class="footer bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item">
                            <a href="#">About</a>
                        </li>
                        <li class="list-inline-item"> </li>
                        <li class="list-inline-item">
                            <a href="#">Contact</a>
                        </li>
                        <li class="list-inline-item"> </li>
                        <li class="list-inline-item">
                            <a href="#">Terms of Use</a>
                        </li>
                        <li class="list-inline-item"> </li>
                        <li class="list-inline-item">
                            <a href="#">Privacy Policy</a>
                        </li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-facebook fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-instagram fa-2x fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php } ?>