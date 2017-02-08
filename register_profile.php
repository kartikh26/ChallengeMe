<?php
session_start();
	ini_set('display_errors', 1);
	//echo "hereeeee";
	$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
	if (mysqli_connect_errno()) {
		echo 'failure';
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
//	mysqli_select_db('khegde2_chalme');
	$curr_user = $_POST["username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$age = $_POST["age"];
	$zero = 0;
	$query = "INSERT INTO users (name, password, email, age, points) VALUES ('$curr_user', '$password', '$email', '$age', '$zero')";

	if($rows=mysqli_query($link, $query))
	{
			
			header("location: https://web.engr.illinois.edu/~challengeme/index.html");
		
	}



	
?>