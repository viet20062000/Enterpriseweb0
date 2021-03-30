<?php 
	session_start();
        include ('sendMail.php');
	include("DatabaseConfig/dbConfig.php");
    define('DBINFO', 'mysql:host=localhost;dbname=comp1640');
    define('DBUSER','root');
    define('DBPASS','');

    function fetchAll($query){
        $con = new PDO(DBINFO, DBUSER, DBPASS);
        $stmt = $con->query($query);
        return $stmt->fetchAll();
    }
    function performQuery($query){
        $con = new PDO(DBINFO, DBUSER, DBPASS);
        $stmt = $con->prepare($query);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
	if(!isset($_SESSION['id'])){
		echo "<script>window.open('login.php','_self')</script>";

	}else{
		$student_session = $_SESSION['id'];

		$get_student = "select * from user where username = '$student_session'";
		$run_student = mysqli_query($conn,$get_student);
		$row_student = mysqli_fetch_array($run_student);

		$student_name = $row_student['username'];
		$student_role = $row_student['user_role'];
		$student_email = $row_student['user_email'];
		$id = $row_student['user_id'];
                $student_faculty = $row_student['faculty_id'];
                if($student_role!='Student'){
                        session_start();
                        session_destroy();
                        echo "<h1>Restricted area, please go back to the login page</h1>";
                        echo "<script>window.open('login.php','_self')</script>";
                }
        $ImageError="";
        $FileError="";
        $AgreeError="";
        $msg="";
        $deadlineMsg="";
        $term_deadline="";
        $get_deadline = "select * from term ";
        $run_deadline = mysqli_query($conn,$get_deadline);
    while ($row_deadline = mysqli_fetch_array($run_deadline)){  
        $term_id=$row_deadline['term_id'];
        $term_deadline=$row_deadline['term_deadline'];
        $term_description=$row_deadline['term_description'];
    }
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date_now=date("Y-m-d H:i:s");
        $now= strtotime($date_now);
        $deadline= strtotime($term_deadline);
    
    $dupcheck = "select * from post where user_id = '$id' and term_id=$term_id";
    $run_dupcheck = mysqli_query($conn,$dupcheck);
    if(!$row_dupcheck = mysqli_fetch_array($run_dupcheck)){
        $IsDup=false;
    }else{
        $IsDup=true;
        $msg="<p>Warning!You have submitted before, any changes you made here will delete your previous submit";
    }
if(isset($_POST['submit'])){
    $ImageFile = $_FILES['imageFile']['name'];
    $DocuFile = $_FILES['documentFile']['name'];
    // This lines of codes gets the details of the file been uploaded
    $ImageTempLocation= $_FILES['imageFile']['tmp_name'];
    $DocuTempLocation = $_FILES['documentFile']['tmp_name'];
    $ImageSize = $_FILES['imageFile']['size'];
    $DocuSize = $_FILES['documentFile']['size'];
    $ImageUploadStatus=$_FILES['imageFile']['error'];
    $DocutUploadStatus=$_FILES['documentFile']['error'];
    $ImageNameExpload = explode('.', $ImageFile);
    $DocuNameExpload = explode('.', $DocuFile);
    $ImageExt = strtolower(end($ImageNameExpload));
    $DocuExt = strtolower(end($DocuNameExpload));
    $ImageClear=false;
    $DocuClear=false;
    $UploadClear=false;
    $AgreeClear=false;
    // Type of file supported
    $supportedImgFormat = array('jpg', 'jpeg', 'png');
    $supportedFileFormat = array('pdf', 'txt', 'docx','doc','zip','rar');
        if( in_array($ImageExt, $supportedImgFormat)){
            if($ImageUploadStatus===0){
                if($ImageSize<50000000){
                    $realImageFile=$ImageFile;
                    $ImagePath="img/$realImageFile";
                    move_uploaded_file($ImageTempLocation, $ImagePath);
                    $ImageClear=true;
                    }
                else{
                     $ImageError= "<p>The file size is too big</p>";
                     
                }
            }else{
                $ImageError="<p>There is an error</p>";
            }
        } elseif(empty ($ImageFile)){
            $ImageError="<p>Please insert a image file</p>";
        }else{
            $ImageError="<p>The file is not supported</p>";
        }

        
    
    if (in_array($DocuExt, $supportedFileFormat)) {
            if($DocutUploadStatus===0){
               if($DocuSize<50000000){
                    $realDocuFile=$DocuFile;
                    $DocuPath="img/$realDocuFile";
                    move_uploaded_file($DocuTempLocation, $DocuPath);
                    $DocuClear=true;
                    }  
                else{
                    $FileError="<p>The file size is too big</p>";
                   }      
               }else{
                   $FileError="<p>There is an error</p>";
                   
               }
        } elseif(empty ($DocuFile)) {
            $FileError="<p>Please insert a document file</p>";
        } else{
            $FileError="<p>The document is not supported</p>";
        }
    if (isset($_POST['check'])) {
        $AgreeClear=true;
    } else {
        $AgreeError="<p>Please agree to the term and service before uploading</p>";
    } 
    if($ImageClear==true&&$DocuClear==true&&$AgreeClear==true&&$IsDup==false){//Upload new post within deadline
            $sql = "INSERT INTO `post`(`user_id`,`term_id`,`faculty_id`, `post_image`,`post_file`, `submit_date`) VALUES ( '$id','$term_id','$student_faculty', '$realImageFile','$realDocuFile', CURRENT_TIMESTAMP)";
            $prep = $conn->prepare($sql);
            $prep->execute();                  
            $UploadClear=true;         
        }elseif($ImageClear==true&&$DocuClear==true&&$AgreeClear==true&&$IsDup==true){//Edit a post within deadline
            $sql = "UPDATE post SET post_image = '$realImageFile', post_file = '$realDocuFile' , submit_date = CURRENT_TIMESTAMP WHERE user_id = '$id'";
            $prep = $conn->prepare($sql);
            $prep->execute();                  
            $UpdateClear=true;
        }
    if($UploadClear===true){
        $title='New post';
        $message="Student".$student_name." have uploaded a new post";
        $query ="select * from user where faculty_id = '$student_faculty' and user_role='Coordinator'";
        $result = mysqli_query($conn,$query);
        foreach(fetchAll($query) as $i){
                sendMail($title, $message,$i['username'] ,$i['user_email']);    
        }
        echo "<script>window.open('StudentHome.php','_self')</script>";
    } 
    if($UpdateClear===true){
        $title='New post';
        $message="Student".$student_name." have updated their post";
        $query ="select * from user where faculty_id = '$student_faculty' and user_role='Coordinator'";
        $result = mysqli_query($conn,$query);
        foreach(fetchAll($query) as $i){
                sendMail($title, $message,$i['username'] ,$i['user_email']);    
        }
        echo "<script>window.open('StudentHome.php','_self')</script>";
    }
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
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

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
        <h2><?php echo"Name: ",$student_name ?></h2>
        <div>DOB: 11/1/2011</div>
        <div><?php echo"Email: ", $student_email ?></div>
        <div><?php echo $id  ?></div>
        <div><?php echo"Faculty ID : ", $student_faculty  ?></div>
        <div>Phone Number: 923874239</div>
        <a href="logout.php">Log out</a>
      </div>
    </div>
    <div class="content">
      <div class="content-stuff">
      	<form id="upload_form" method="post" enctype="multipart/form-data">
            <?php 
                 if (($now) < ($deadline)){
                    
                 ?>
	        <h2>Submit your work:</h2>
                <?php echo $msg; ?>
                <?php echo "<h5>Deadline is ".$term_deadline."<br> Description:".$term_description."</h5>"; ?>
                <input type="hidden" name="termId" value="<?php echo $term_id ?>" />
	        <h5>Submit your image:</h5>
                <input type="file" name="imageFile" class="btn btn-outline-primary" id="file" accept="image/*">
                <?php echo $ImageError; ?>
	        <h5>Submit your document:</h5>
	         <input type="file" name="documentFile" class="btn btn-outline-primary" id="file" accept=".pdf,.docx,.doc,.zip,.rar">
                 <?php echo $FileError; ?>
	        <div class="form-group form-check">
	          <label class="form-check-label">
	            <input class="form-check-input" name="check" type="checkbox"> Agree to the <span style="text-decoration: underline"><a> term and services</a> </span>before uploading your work
	          <?php echo $AgreeError; ?>
                  </label>
	        </div>
         
	        <button type="submit" value="submit" name="submit" id="submit" class="btn btn-primary">Upload your submission</button>
                <?php
                 }else{
                    $deadlineMsg="<p>You have missed the deadline</p>";  
                }
                    echo $deadlineMsg;
                 ?>                
          <a href="submit-student.php" class="btn btn-outline-primary">View Your Submission</a>
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