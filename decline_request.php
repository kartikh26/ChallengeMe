
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
$requester_id = $GET['requester_id'];
$query = "DELETE FROM requested_friendships WHERE (requested_friendships.requester_id='$requester_id' AND requested_friendships.requestee_id='$user_id')";
if($rows=mysqli_query($link, $query)) {
	header("location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id);
}

?>