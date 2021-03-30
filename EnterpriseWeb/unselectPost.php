<?php
session_start();
	include("DatabaseConfig/dbConfig.php");
if (isset($_POST['checkSelected'])) {
    $post_id=$_POST['postId'];
    $query = "UPDATE post SET selected = '0' WHERE post_id = '$post_id'";
    $prep = $conn->prepare($query);
    $prep->execute();
    header("Location: CoordinatorHome.php");
    die("You've unselected the post for publication <a href=' CoordinatorHome.php'>click here</a> to continue.");
}
?>