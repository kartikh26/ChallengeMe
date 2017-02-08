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
$parent_comment_id = 0;


if (empty($_POST['reply'])) {
	$parent_comment_id = -1;
}
else {
	$parent_comment_id = $_POST['reply'];
}

//echo $parent_comment_id;

$comment = $_POST['comment'];
//echo $comment;

$query = "SELECT * FROM comments WHERE comments.comment_id = '$parent_comment_id'";

if ($rows =mysqli_query($link, $query)) {
	//echo "HERE";
	if (mysqli_num_rows($rows) == 0 && $parent_comment_id != -1) {
		echo "Comment does not exist";
	}
	else {
		//echo "HEREfreiuf";
		$query2 = "INSERT INTO comments (user_id, comment_text, parent_comment_id) VALUES ('$user_id', '$comment', '$parent_comment_id')";
		if ($rows2 =mysqli_query($link, $query2)) {
			//echo "inserted comment";
			header("location: https://web.engr.illinois.edu/~challengeme/view_comments.php?user_id=".$user_id);	
		}
	}
}



?>