<?php 
    include("DatabaseConfig/dbConfig.php");

    if(!isset($_SESSION['id'])){
        echo "<script>window.open('login.php','_self')</script>";

    }else{
        $coordinator_session = $_SESSION['id'];


        $get_coordinator = "select * from user where username = '$coordinator_session'";
        $run_coordinator = mysqli_query($conn,$get_coordinator);
        $row_coordinator = mysqli_fetch_array($run_coordinator);

        $coordinator_name = $row_coordinator['username'];
        $coordinator_id = $row_coordinator['user_id'];
        $coordinator_role = $row_coordinator['user_role'];
        $coordinator_email = $row_coordinator['user_email'];
                $coordinator_faculty = $row_coordinator['faculty_id'];
                if($coordinator_role!='Coordinator'){
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
    <link rel="stylesheet" href="css/style2.css">

</head>

<body>

    <!-- Navigation -->

    <!-- Content -->
    <div class="container">
        <!-- Right Content -->
        <div class="content">
            <div class="content-stuff">
                <h2>Mark Submission:</h2>
                <a href="" style="font-size: 1.2rem;"><i class="far fa-file-alt"></i> Submission.txt </a>
                <div class="form-group my-2">
                    <input type="grade" class="form-control" placeholder="Current Grade: 0/100">
                </div>
                <button type="button" class="btn btn-primary my-1"><i class="fas fa-upload"></i> Upload
                    Grade</button>
                <a href="submit-student.html" class="btn btn-danger my-1 ml-1"><i class="far fa-trash-alt"></i> Remove
                    Grade</a>
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
                    if(isset($_GET['submit-coordinator'])){
                        $post_id = $_GET['submit-coordinator'];
                        $get_post = "select * from post where post_id = '$post_id'";
                        $run_post = mysqli_query($conn, $get_post);
                        $row_post = mysqli_fetch_array($run_post);

                        $p_id = $row_post['post_id'];
                        $p_document = $row_post['post_file'];
                        $p_user = $row_post['user_id'];
                    }
                    else
                    {
                        echo"something wrong";
                    } 
                ?>
                    <?php 
                        if(isset($_POST['submit'])){
                            $comment = $_POST['comment'];
                            
                            $insert_comment = $conn->prepare("insert into comment (`user_id`, `post_id`, `comment_content`) values ('$coordinator_id', '$post_id', '$comment')");
                            $insert_comment->bind_param('iis', $coordinator_id, $post_id, $comment );
                            $insert_comment->execute();
                            $insert_comment->close();
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


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php } ?>
