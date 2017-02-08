<?php
session_start();
ini_set('display_errors', 1);

//Form as seen here: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_form_input&stacked=h
//Textbox as seen here: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_form_textarea&stacked=h


$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
if (mysqli_connect_errno()) {
    echo 'failure';
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$user_id = $_GET['user_id'];
$comment_id = $_GET['comment_id'];

$query = "DELETE FROM comments WHERE '$comment_id' = comments.comment_id";
if ($rows = mysqli_query($link, $query)) {
	// echo "Deleted from comments";
	header("location: https://web.engr.illinois.edu/~challengeme/view_comments.php?user_id=".$user_id);	
}




?>