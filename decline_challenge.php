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
$chalme_id = $_GET['chalme_id'];
$query = "DELETE FROM requested_users WHERE (requested_users.requested_user_id='$user_id' AND requested_users.chalme_id = '$chalme_id')";
if($rows=mysqli_query($link, $query)) {
	header("location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id);		
}

?>
