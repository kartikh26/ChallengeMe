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
$created_user_id = $_GET['created_user_id'];
$user_requesting_id = $_GET['user_id'];

$query = "INSERT INTO request_to_join (chalme_id, created_user_id, user_requesting_id) VALUES ('$chalme_id', '$created_user_id', '$user_requesting_id')";
if ($rows = mysqli_query($link, $query)) {
	// echo "Added to request_to_join";

	$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_requesting_id;
	header($profile);
	
	/*$query2 = "DELETE FROM recommended_challenges WHERE '$chalme_id' = recommended_challenges.chalme_id AND '$user_requesting_id' = recommended_challenges.user_requesting_id";
	if ($rows2 = mysqli_query($link, $query2)) {
		// echo "deleted from recommended challenges";
		$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id;
		if ($rows=mysqli_query($link, $profile)) {
			header($profile);
		}
	}*/
}

?>