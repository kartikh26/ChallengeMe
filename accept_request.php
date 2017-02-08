<?php
session_start();
ini_set('display_errors', 1);

$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
if (mysqli_connect_errno()) {
    echo 'failure';
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$user_id = $_GET['user_id'];	
$requester_id = $_GET['requester_id'];

$query = "DELETE FROM requested_friendships WHERE (requested_friendships.requester_id='$requester_id' AND requested_friendships.requestee_id='$user_id')";
if($rows=mysqli_query($link, $query)) {
	//echo "HERE";
	$add_query = "INSERT INTO friends(friend_that_added, friend_that_accepted) VALUES ('$requester_id', '$user_id')";
	if ($rows2=mysqli_query($link, $add_query)) {
		header("location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id);
	}		
}



?>