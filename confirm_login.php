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

	$username = $_POST["username"];
	$password = $_POST["password"];
	
	$query = "SELECT * FROM users WHERE BINARY  name = '$username' AND password = '$password'";

	if($rows=mysqli_query($link, $query))
	{
		$result_data = $rows->fetch_assoc();
		$user_id = $result_data['user_id'];
		$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id;
		if (mysqli_num_rows($rows) == 1){
	
			session_start();
			$_SESSION['login'] = "1";
			$_SESSION['username'] = $username;
			header($profile);
		}
		else {
			echo "Incorrect Username and Password";
			session_start();
    		session_destroy();
			$_SESSION['username'] = '';
			$_SESSION['login'] = '';
		}
	}
	
?>