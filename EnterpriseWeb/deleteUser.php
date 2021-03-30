<?php
session_start();
	include("DatabaseConfig/dbConfig.php");
if (isset($_GET['user_id'])) {
    $uID=$_GET['user_id'];
    $query = "DELETE FROM user WHERE user_id = '$uID'";
    $prep = $conn->prepare($query);
    $prep->execute();
    header("Location: AdminHome.php");
    die("You've selected the post for publication <a href=' AdminHome.php'>click here</a> to continue.");
}
?>