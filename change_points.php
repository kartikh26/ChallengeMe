<?php
	session_start();
	ini_set('display_errors', 1);

	$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
	if (mysqli_connect_errno()) {
		echo 'failure';
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$points = $_POST['points'];
	//echo $points;
	$user_id = $_GET['user_id'];
	$curr_points = $_GET['curr_points'];
	$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id."&curr_points=".$curr_points;
	$total_points = $curr_points + $points;
	$query = "UPDATE users SET points = '$total_points' WHERE user_id = '$user_id' ";

	if ($rows=mysqli_query($link, $query)) {
		header($profile);
	}

	

?>