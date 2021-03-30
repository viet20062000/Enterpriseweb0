<?php 
    session_start();
        include ('sendMail.php');
    include("DatabaseConfig/dbConfig.php");

    if(!isset($_SESSION['id'])){
        echo "<script>window.open('login.php','_self')</script>";

    }else{
        $student_session = $_SESSION['id'];

        $get_student = "select * from user where username = '$student_session'";
        $run_student = mysqli_query($conn,$get_student);
        $row_student = mysqli_fetch_array($run_student);

        $student_name = $row_student['username'];
        $student_id = $row_student['user_id'];
        $student_role = $row_student['user_role'];
        $student_email = $row_student['user_email'];

        $get_post = "select * from post where user_id = '$student_id'";
        $run_post = mysqli_query($conn,$get_post);
        $row_post = mysqli_fetch_array($run_post);

        $post_id = $row_post['post_id'];

        $id = $row_student['user_id'];
                $student_faculty = $row_student['faculty_id'];
                if($student_role!='Student'){
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

    <title>Student Page</title>

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
                <h2><?php echo"Name: ",$student_name ?></h2>
                <div>DOB: 11/1/2011</div>
                <div><?php echo"Email: ", $student_email ?></div>
                <div><?php echo $id  ?></div>
                <div><?php echo"Faculty ID : ", $student_faculty  ?></div>
                <div>Phone Number: 923874239</div>
                <a href="logout.php">Log out</a>
            </div>
        </div>
        <!-- Right Content -->
        <div class="content">
            <div class="content-stuff">
                <h2>View Your Submission:</h2>
                <a href="" style="font-size: 1.2rem;"><i class="far fa-file-alt"></i> Submission.txt </a>
                <br>
                <a href="StudentHome.php" class="btn btn-primary my-2"><i class="fas fa-upload"></i> Re-upload
                    Submission</a>
                <a href="submit-student.html" class="btn btn-danger my-2 ml-1"><i class="far fa-trash-alt"></i> Delete
                    Submission</a>
            </div>
            <hr>
            <!-- Comment Section -->
            <div class="comment-section">
                <h2>Comment Section:</h2>
                <div class="form-group">
                    <form method="post">
                    <textarea name="comment" class="form-control" placeholder="Leave your comment here..." rows="3"></textarea>
                    <button type="submit" value="submit" name="submit" id="submit" class="btn btn-outline-primary my-2"><i class="fa fa-paper-plane"></i>
                        Submit</button>
                    </form>
                    <?php 
                        if(isset($_POST['submit'])){
                            $comment = $_POST['comment'];
                            $insert_comment = "insert into comment (`user_id`, `post_id`, `comment_content`, `time`) values ('$student_id', '$post_id', '$comment', CURRENT_TIMESTAMP)";
                            mysqli_query($conn,$insert_comment);
                        }
                    ?>
                    <div class="card">
                        
                        <div class="card-header">Recent Comments</div>
                        <?php 
                            $get_comment = "select * from comment where post_id = '$post_id' ";
                            $run_comment = mysqli_query($conn,$get_comment);
                            while($row_comment = mysqli_fetch_array($run_comment)){
                              $user_id = $row_comment['user_id'];
                              $get_user = "select * from user where user_id = '$user_id'";
                              $run_user = mysqli_query($conn,$get_user);
                              $row_user = mysqli_fetch_array($run_user);
                              $user_name = $row_user['username'];
                              $user_role = $row_user['user_role'];
                              $comment = $row_comment['comment_content'];
                        ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-1"><img src="http://placehold.it/80" class="rounded-circle img-fluid"
                                        alt="" /></div>
                                <div class="col-11">
                                    <div class="font-weight-bold cmt-header"><?php echo $user_role, " : ", $user_name ?></div>
                                    <div><?php echo $comment ?></div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    </div>

                        
                        
                    </div>
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

</body>

</html>

<?php } ?>