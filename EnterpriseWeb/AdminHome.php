<?php 
	session_start();
	include("DatabaseConfig/dbConfig.php");

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

	
 ?>
<!DOCTYPE html>
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
        <div class="sidebar">
            <div class="text-center">
                <img src="img/avatar.png" class="rounded avatar mx-auto img-fluid" alt="...">
                <h2><?php echo"Name: ", $admin_name ?></h2>
                <div>DOB: 11/1/2011</div>
                <div><?php echo"Email: ",$admin_email ?></div>
                <div>Phone Number: 923874239</div>
                <a href="logout.php">Log out</a>
            </div>
        </div>
        <div class="content">
            <div class="content-stuff">
                <!-- Tab Titles-->
                <ul class="nav nav-tabs row">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#student">Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#coordinator">Coordinator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#manager">Manager</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#term">Term</a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <div id="student" class="container tab-pane active"><br>
                        <h2>Manage Student:</h2>
                        <div class=""></div>
                        <a href="add-student.php" class="btn btn-primary btn-add"><i class="fas fa-plus"></i> Add New Student</a>
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Faculty</th>
                                    <th>Email</th>
                                    <th>Edit post</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
            <?php
                $get_student = "select * from user where user_role = 'Student' ";
                $run_student = mysqli_query($conn,$get_student);
                while($student_row = mysqli_fetch_array($run_student)){
                    $student_id = $student_row['user_id'];
                    $student_name = $student_row['username'];
                    $student_faculty_id = $student_row['faculty_id'];
                    $student_email=$student_row['user_email'];
                    $get_faculty = "select faculty_name from faculty where faculty_id = $student_faculty_id ";
                                    $run_faculty = mysqli_query($conn,$get_faculty);
                                    $result_faculty = $run_faculty->fetch_assoc();
                                    $faculty_name=$result_faculty['faculty_name'];
            ?>
                                <tr>
                                    <td><?php echo $student_name ?></td>
                                    <td>
                                        <?php
                                        echo $faculty_name;
                                        ?>
                                    </td>
                                    <td><?php echo $student_email ?> </td>
                                    <td>
                                        <a href="manage-student.php?user_id=<?php echo $student_id; ?>" class="btn btn-outline-dark btn-sm"><i
                                                class="fas fa-edit"></i></a></td>
                                    <td><a href="deleteUser.php?user_id=<?php echo $student_id; ?>" class="btn btn-outline-danger btn-sm"><i
                                            onclick="return confirmDeleted();"    class="fas fa-trash-alt"></i></a></td>
            <?php } ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="coordinator" class="container tab-pane fade"><br>
                        <h2>Manage Coordinator:</h2>
                        <a href="add-coordinator.php" class="btn btn-primary btn-add"><i class="fas fa-plus"></i> Add New Coordinator</a>
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Coordinator Name</th>
                                    <th>Coordinator Faculty</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
            <?php
                $get_coordinator = "select * from user where user_role = 'Coordinator' ";
                $run_coordinator = mysqli_query($conn,$get_coordinator);
                while($coordinator_row = mysqli_fetch_array($run_coordinator)){
                    $coordinator_id = $coordinator_row['user_id'];
                    $coordinator_name = $coordinator_row['username'];
                    $coordinator_faculty_id = $coordinator_row['faculty_id'];
                    $coordinator_email=$coordinator_row['user_email'];
                    $get_coordinator_faculty = "select faculty_name from faculty where faculty_id = $coordinator_faculty_id ";
                                    $run_coordinator_faculty = mysqli_query($conn,$get_coordinator_faculty);
                                    $result_coordinator = $run_coordinator_faculty->fetch_assoc();
                                    $coordinator_faculty_name=$result_coordinator['faculty_name'];
            ?>
                                <tr>
                                    <td><?php echo $coordinator_name ?></td>
                                    <td>
                                        <?php
                                        echo $coordinator_faculty_name;
                                        ?>
                                    </td>
                                    <td><?php echo $coordinator_email ?> </td>
                                    <td><a href="manage-coordinator.php?user_id=<?php echo $coordinator_id; ?>" class="btn btn-outline-dark btn-sm"><i
                                                class="fas fa-edit"></i></a></td>
                                    <td><a href="deleteUser.php?user_id=<?php echo $coordinator_id; ?>" class="btn btn-outline-danger btn-sm"><i
                                          onclick="return confirmDeleted();"       class="fas fa-trash-alt"></i></a></td>
            <?php } ?>               
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="manager" class="container tab-pane fade"><br>
                        <h2>Manage Manager:</h2>
                        <a href="add-manager.php" class="btn btn-primary btn-add"><i class="fas fa-plus"></i> Add New Manager</a>
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Manager Name</th>
                                    <th>Faculty</th>
                                    <th>Email</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
            <?php
                $get_manager = "select * from user where user_role = 'Manager' ";
                $run_manager = mysqli_query($conn,$get_manager);
                while($manager_row = mysqli_fetch_array($run_manager)){
                    $manager_id = $manager_row['user_id'];
                    $manager_name = $manager_row['username'];
                    $manager_faculty_id = $manager_row['faculty_id'];
                    $manager_email=$manager_row['user_email'];
                    $get_manager_faculty = "select faculty_name from faculty where faculty_id = $manager_faculty_id ";
                                    $run_manager_faculty = mysqli_query($conn,$get_manager_faculty);
                                    $result_manager = $run_manager_faculty->fetch_assoc();
                                    $manager_faculty_name=$result_manager['faculty_name'];
            ?>
                                <tr>
                                    <td><?php echo $manager_name ?></td>
                                    <td><?php echo $manager_faculty_name ?></td>
                                    <td><?php echo $manager_email ?></td>
                                    <td><a href="manage-manager.php?user_id=<?php echo $manager_id; ?>" class="btn btn-outline-dark btn-sm"><i
                                                class="fas fa-edit"></i></a></td>
                                    <td><a href="deleteUser.php?user_id=<?php echo $manager_id; ?>" class="btn btn-outline-danger btn-sm"><i
                                           onclick="return confirmDeleted();"    class="fas fa-trash-alt"></i></a></td>
                                </tr>
            <?php } ?>
                            </tbody>

                        </table>
                    </div>
                    <div id="term" class="container tab-pane fade"><br>
                        <h2>Manage terms:</h2>
                        <a href="add-term.php" class="btn btn-primary btn-add"><i class="fas fa-plus"></i> Add New Term</a>
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Term deadline</th>
                                    <th>Term description</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
            <?php
                $get_term = "select * from term";
                $run_term = mysqli_query($conn,$get_term);
                while($term_row = mysqli_fetch_array($run_term)){
                    $term_id = $term_row['term_id'];
                    $term_deadline = $term_row['term_deadline'];
                    $term_description=$term_row['term_description'];
                
            ?>                
                            <tbody>
                                <tr>
                                    <td><?php echo $term_deadline ?></td>
                                    <td><?php echo $term_description ?></td>
                                    <td><a href="manage-term.php?term_id=<?php echo $term_id; ?>" class="btn btn-outline-dark btn-sm"><i
                                                class="fas fa-edit"></i></a></td>
                                    <td><a href="deleteTerm.php?term_id=<?php echo $term_id; ?>" class="btn btn-outline-danger btn-sm"><i
                                        onclick="return confirmDeleteTerm();"        class="fas fa-trash-alt"></i></a></td>
                                </tr>
            <?php } ?> 
                            </tbody>
                        </table>
                    </div>
                </div>

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
    <script>
        function confirmDeleted() {
            var r = confirm("Are you sure you would like to delete this user ?");
            if (r) {
                return true;
            } else {
                return false;
            }
        }
        function confirmDeleteTerm() {
            var r = confirm("Are you sure you would like to delete this user ?");
            if (r) {
                return true;
            } else {
                return false;
            }
        }
   </script>
</body>
</html>
<?php } ?>