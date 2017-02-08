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
	$username = $_SESSION['username'];

	$query = "DELETE FROM users WHERE name='$username'";
    
    if($rows=mysqli_query($link, $query))
    {
    	session_start();
    	session_destroy();
    	header("location: https://web.engr.illinois.edu/~challengeme/index.html");
        //header("location: https://web.engr.illinois.edu/~khegde2/index.html");
    }
	
?>