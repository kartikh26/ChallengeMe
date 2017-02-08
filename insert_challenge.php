<?php
session_start();
	ini_set('display_errors', 1);
	$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
	if (mysqli_connect_errno()) {
		echo 'failure';
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}
//	mysqli_select_db('khegde2_chalme');
	$created_user = $_SESSION["username"];
	$user_id_main = $_GET['user_id'];
	$points = $_GET['points'];
	$points_wagered = $_GET['points_wagered']; 
	$points_required = $_POST['points_required']; //Must matched "name=" on input form 
	$category = $_POST["category"];
	$num_days = $_POST["num_days"];
	
	
	// $query = "UPDATE users SET name = '$changed_username', password = '$password', age = '$age', email = '$email' WHERE name = '$curr_user' ";
	//echo $created_user;
	//echo $points_wagered;
	//echo $category;



	//Find correct date
	date_default_timezone_set('UTC');
	$date_c  = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
	$date_e = mktime(0, 0, 0, date("m")  , date("d") + $num_days, date("Y"));
	
	$date_created = date("Y-m-d", $date_c);
	$date_ends = date("Y-m-d", $date_e);
	//echo $date_created;
	//echo $date_ends;

	//$count = 0;
	$name_query = "SELECT user_id FROM users WHERE '$created_user' = users.name";
	if($row=mysqli_query($link, $name_query)) {
		//echo "Queried data";
		//$result_data = $row->fetch_assoc();
		//echo count($result_data);
		//$user_id = $result_data['user_id'];

		$query = "";
		if ($points >= $points_required) {
			//TODO: Find the id of the user using SELECT user_id FROM users WHERE created_user = users.username?
			$query = "INSERT INTO current (created_user, points_wagered, date_created, date_ends, category) VALUES ('$user_id_main', '$points_required', '$date_created', '$date_ends', '$category')"; 
			$query2 = "UPDATE users SET points=$points-$points_required WHERE '$user_id_main'=users.user_id"; //TODO:: Change
			$query3 = "UPDATE users SET points_wagered=$points_wagered + $points_required WHERE '$user_id_main'=users.user_id";
			//$count++;
			if($rows=mysqli_query($link, $query)) {
				if($rows=mysqli_query($link, $query2)) {
					if($rows=mysqli_query($link, $query3)) {
						//echo "Entered data AGAIN";
						$id_query = "SELECT * FROM current ORDER BY chalme_id DESC LIMIT 1"; //Get the id of the latest chalme event (used for select users)

						if($id_object=mysqli_query($link, $id_query)) {

							//echo "HERE";
							$row = $id_object->fetch_assoc();
							$id = $row['chalme_id'];
							//echo $id;

							$query_participant = "INSERT INTO participants (chalme_id, participant_user_id) VALUES ('$id', '$user_id_main')";
							if($rows=mysqli_query($link, $query_participant)) { 
								$header = "location: https://web.engr.illinois.edu/~challengeme/select_users.php?chalme_id=".$id."&user_id=".$user_id_main;
								//echo $header;
								header($header);
							}
						}
					}
				}
			}
		}
		else {
			//Do nothing
			$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id_main;
			header($profile);
		}

	}

	

	

	
?>

