<?php
session_start();
	include("DatabaseConfig/dbConfig.php");
if (isset($_GET['term_id'])) {
    $tID=$_GET['term_id'];
    $query = "DELETE FROM term WHERE term_id = '$tID'";
    $prep = $conn->prepare($query);
    $prep->execute();
    header("Location: AdminHome.php");
    die("You've deleted a term <a href=' AdminHome.php'>click here</a> to continue.");
}
?>