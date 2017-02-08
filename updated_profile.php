<?php
session_start();
	ini_set('display_errors', 1);
	$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
	if (mysqli_connect_errno()) {
		echo 'failure';
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
//	mysqli_select_db('khegde2_chalme');
	$curr_user = $_SESSION["username"];
	$user_id = $_GET['user_id'];
	$changed_username = $_POST["username"]; //TODO: remove
	$password = $_POST["password"];
	$age = $_POST["age"];
	$email = $_POST["email"];
	$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id;
	
	$query = "UPDATE users SET name = '$changed_username', password = '$password', age = '$age', email = '$email' WHERE name = '$curr_user' ";

	$rows=mysqli_query($link, $query);

	$_SESSION['username'] = $changed_username;
	header($profile);

	
?>