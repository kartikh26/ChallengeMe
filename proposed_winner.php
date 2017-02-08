<?php
session_start();
ini_set('display_errors', 1);

$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
if (mysqli_connect_errno()) {
    echo 'failure';
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$proposed_winner_id = $_GET['proposed_winner_id'];
//echo $proposed_winner_id;
$chalme_id = $_GET['chalme_id'];

$store_info_about_challenge_query = "SELECT * FROM current WHERE current.chalme_id = '$chalme_id'";

$store_rows = NULL;
if ($store_rows=mysqli_query($link, $store_info_about_challenge_query)) {
	$result_data = $store_rows->fetch_assoc();
	//$chalme_id = //
	$points_needed = $result_data['points_wagered'];
	$created_user_id = $result_data['created_user'];
	$date_created = $result_data['date_created'];
	$date_ends = $result_data['date_ends'];
	//$proposed_winner_id =;
	$category = $result_data['category'];


	$rows = NULL;
	$query = "DELETE FROM current WHERE current.chalme_id = '$chalme_id'";
	if ($rows = mysqli_query($link, $query)) {
		//echo "Deleted chalme_id ".$chalme_id;
	}

	$rows2 = NULL;
	$query2 = "INSERT INTO archived (chalme_id, points_wagered, created_user, date_created, date_ends, winner, category) VALUES ('$chalme_id', '$points_needed', '$created_user_id', '$date_created', '$date_ends', '$proposed_winner_id', '$category')";
	if ($rows2 = mysqli_query($link, $query2)) {
		//echo "Inserted into archived";
	}

	$rows3 = NULL;
	$query3 = "INSERT INTO winner (chalme_id, user_id) VALUES ('$chalme_id', '$proposed_winner_id')";
	if ($rows3 = mysqli_query($link, $query3)) {
		//echo "Inserted into winner";
	}

	//Get points and points_wagered for this user.
	$player_rows = "SELECT points, points_wagered FROM users WHERE users.user_id = '$proposed_winner_id'";
	if ($player_rows = mysqli_query($link, $player_rows)) {
		$result_data = $player_rows->fetch_assoc();
		$points = $result_data['points'];
		$points_wagered = $result_data['points_wagered'];

		//echo "POINTS I HAVE";
		//echo $points;
		//echo "POINTS WAGERED";
		//echo $points_wagered;

		$rows4 = NULL;
		$query4 = "UPDATE users SET users.points = '$points' + '$points_needed' WHERE users.user_id = '$proposed_winner_id'";
		if ($rows4 = mysqli_query($link, $query4)) {
			//echo "updated winner's points";
		}

		$rows5 = NULL;
		$query5 = "UPDATE users SET users.points_wagered = '$points_wagered' - '$points_needed' WHERE '$proposed_winner_id' = users.user_id";
		if ($rows5 = mysqli_query($link, $query5)) {
			//echo "updated winner's points_wagered";
		}
	}

	$query6 = "SELECT participant_user_id FROM participants WHERE participants.chalme_id = '$chalme_id'";

	$rows6 = NULL;
	if ($rows6 = mysqli_query($link, $query6)) { //Get all the participants with the chalme_id
		//echo "HERE";
		while ($row6 = mysqli_fetch_row($rows6)) { //Delete from the participants table and for all users that are not this user_id move to another past_participants and pending_table
			//echo "HERE2";
			$partic_id = $row6[0];
			if ($partic_id == $proposed_winner_id) {
				
				$query8 = "INSERT INTO past_participants (chalme_id, participant_user_id) VALUES ('$chalme_id', '$partic_id')";
				if ($row8 = mysqli_query($link, $query8)) {
					//echo "Inserted into past_participants";
				}
				
			}
			else {
				//echo "participant != winner";
				$query8 = "INSERT INTO past_participants (chalme_id, participant_user_id) VALUES ('$chalme_id', '$partic_id')";
				$query9 = "INSERT INTO pending_table (chalme_id, proposed_winner_id, participant_id) VALUES ('$chalme_id', '$proposed_winner_id', '$partic_id')";
			
				$rows8 = NULL;
				$rows9 = NULL;

				if ($row8 = mysqli_query($link, $query8)) {
					//echo "Inserted into past_participants";
				}

				if ($row9 = mysqli_query($link, $query9)) {
					//echo "Inserted into pending_table";
				}

			}
		}
	}

	//echo $proposed_winner_id;
	$query7 = "DELETE FROM participants WHERE participants.chalme_id = '$chalme_id'";
	$rows7 = NULL;
	if ($row7 = mysqli_query($link, $query7)) {
		//echo "deleted from participants";
		$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$proposed_winner_id;
		header($profile);
	}
}




?>

