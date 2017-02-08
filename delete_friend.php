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
//echo $user_id;	
$friend_id = $_GET['friend_id'];
//echo $friend_id;
//echo "HEHREHRHHR";
$query = "DELETE FROM friends WHERE (friends.friend_that_added ='$friend_id' AND friends.friend_that_accepted='$user_id') OR (friends.friend_that_accepted ='$friend_id' AND friends.friend_that_added='$user_id')";
if($rows=mysqli_query($link, $query)) {
	header("location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id);
}

?>