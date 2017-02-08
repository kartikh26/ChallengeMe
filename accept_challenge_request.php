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

$query = "INSERT INTO participants (chalme_id, participant_user_id) VALUES ('$chalme_id', '$requester_id')";
$query2 = "DELETE FROM request_to_join WHERE '$chalme_id' = request_to_join.chalme_id AND '$requester_id' = request_to_join.user_requesting_id";

if ($rows = mysqli_query($link, $query)) {
	// echo "inserted into participants";
}

if ($rows2 = mysqli_query($link, $query2)) {
	// echo "deleted from request to join";
}


$get_points = "SELECT points, points_wagered FROM users WHERE users.user_id = '$requester_id'";
$points_i_have = -1;
$points_wagered = -1;
if ($rows = mysqli_query($link, $get_points)) {
	$result_data = $rows->fetch_assoc();
	$points_i_have = $result_data['points'];
	$points_wagered = $result_data['points_wagered'];
}

$points = -1;
$query3 = "SELECT points_wagered FROM current WHERE current.chalme_id = '$chalme_id'";
if ($rows2 = mysqli_query($link, $query3)) {
	$result_data2 = $rows2->fetch_assoc();
	$points = $result_data2['points'];
}

if ($points <= $points_i_have) {
	$update_query = "UPDATE users SET users.points_wagered = '$points_wagered' + '$points' WHERE users.user_id = '$requester_id'";
	if ($rows2 = mysqli_query($link, $update_query)) {
		//echo "updated points wagered";
	}

	$update_query2 = "UPDATE users SET users.points = '$points_i_have' - '$points' WHERE users.user_id = '$requester_id'";
	if ($rows3 = mysqli_query($link, $update_query2)) {
		//echo "updated points I have";
	}
}

$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id;
header($profile);

?>