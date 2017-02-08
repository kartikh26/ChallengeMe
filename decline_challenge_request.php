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
$requester_id = $_GET['requester_id'];

$query2 = "DELETE FROM request_to_join WHERE '$chalme_id' = request_to_join.chalme_id AND '$requester_id' = request_to_join.user_requesting_id";

if ($rows2 = mysqli_query($link, $query2)) {
	// echo "deleted from request to join";
}

$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id;
header($profile);

?>