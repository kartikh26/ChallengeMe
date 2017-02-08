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
$points_needed = $_GET['points_needed'];
$points = -1;
$chalme_id = $_GET['chalme_id'];
// echo "user_id: ";
// echo $user_id;
// echo "chalme_id: ";
// echo $chalme_id;
// echo "points_needed";
// echo $points_needed;
$query = "SELECT points, points_wagered FROM users WHERE '$user_id' = users.user_id"; //Get points from the users table so we can alter it
if($rows=mysqli_query($link, $query)) { 
	$result_data = $rows->fetch_assoc();
	$points = $result_data['points'];
	$points_wagered = $result_data['points_wagered'];
	if ($points >= $points_needed) {
		
		$query2 = "UPDATE users SET points=$points-$points_needed WHERE '$user_id'=users.user_id";
		$query3 = "UPDATE users SET points_wagered=$points_wagered + $points_needed WHERE '$user_id'=users.user_id";
		if($rows2=mysqli_query($link, $query2)) {
			//echo "CURRENT POINTS SET!!";
			if($rows3=mysqli_query($link, $query3)) {
				//echo "POINTS WAGERED SET!!";
				//Note that requested_user_id is the id of the user that has been challenged
				$query4 = "DELETE FROM requested_users WHERE (requested_users.requested_user_id='$user_id' AND requested_users.chalme_id = '$chalme_id')";
				if($rows4=mysqli_query($link, $query4)) {
					//echo "DELETED FROM REQUESTED USERS";
					//echo $chalme_id;
					//echo $user_id;
					$query5 = "INSERT INTO participants (chalme_id, participant_user_id) VALUES ('$chalme_id', '$user_id')";
					if($rows5=mysqli_query($link, $query5)) {
						//echo "ADDED TO PARTICIPANTS";
						header("location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id);
					}
				}
			}
		
		}
		
	}
	else {
		
		header("location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id);
	}	
}

?>