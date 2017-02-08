<?php
session_start();
ini_set('display_errors', 1);

$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
if (mysqli_connect_errno()) {
    echo 'failure';
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$chalme_id = $_GET['chalme_id'];
$my_id = $_GET['my_id'];
$proposed_winner_id = $_GET['proposed_winner_id'];
$points = $_GET['points'];

//Delete from pending table for this chalme_id and participant_id (i.e my_id)
$query = "DELETE FROM pending_table WHERE pending_table.chalme_id = '$chalme_id' AND pending_table.participant_id = '$my_id'"; 
if ($rows = mysqli_query($link, $query)) {
	// echo "deleted from pending_table";
}


$get_points = "SELECT points_wagered FROM users WHERE users.user_id = '$my_id'";
$points_wagered = -1;
if ($rows = mysqli_query($link, $get_points)) {
	$result_data = $rows->fetch_assoc();
	$points_wagered = $result_data['points_wagered'];
}

$points_winner_has = -1;
$winner_query = "SELECT points FROM users WHERE users.user_id = '$proposed_winner_id'";
if ($rows2 = mysqli_query($link, $winner_query)) {
	$result_data = $rows2->fetch_assoc();
	$points_winner_has = $result_data['points'];
}

$update_query = "UPDATE users SET users.points_wagered = '$points_wagered' - '$points' WHERE users.user_id = '$my_id'";
if ($rows2 = mysqli_query($link, $update_query)) {
	// echo "updated points";
}

$update_query2 = "UPDATE users SET users.points = '$points_winner_has' + '$points' WHERE users.user_id = '$proposed_winner_id'";
if ($rows3 = mysqli_query($link, $update_query2)) {
	// echo "updated points the other person has";
}

$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$my_id;
header($profile);
?>