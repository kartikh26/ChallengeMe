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
$person_id = 0;
$name = $_POST['name'];
$count = 0;

$user_exists_query = "SELECT * FROM users where users.name = '$name'";

if ($rows_exists=mysqli_query($link, $user_exists_query)) {
	if (mysqli_num_rows($rows_exists) == 0) {
		echo "User not found";
	}


	else {
		//echo "HERE";
		$result_data = $rows_exists->fetch_assoc();
        $person_id = $result_data['user_id'];

        if ($person_id == $user_id){ 
        	echo "You can't add yourself!";
        }
        else {

			//Check if friend is already requested of has been requested. (Query from requested_friendships) 
			$query = "SELECT * FROM requested_friendships WHERE requested_friendships.requester_id = '$user_id' OR requested_friendships.requestee_id = '$user_id'"; //Get the requested_friendships in which we are present

			if ($rows=mysqli_query($link, $query)) {
				while ($row = mysqli_fetch_row($rows)) {
					$requester_id = $row[1];
					$requestee_id = $row[2];

					$query2 = "SELECT user_id FROM users WHERE '$name' = users.name"; //Get the user_id of the name
					if ($rows2=mysqli_query($link, $query2)) {
						$result_data = $rows2->fetch_assoc();
						$person_id = $result_data['user_id']; 
						if ($person_id == $requester_id) { //If the id of the person we are trying to add is the requester, ignore the add
							$count++;
							echo "You have already been requested by ".$name;	
						}
						else if ($person_id == $requestee_id) {
							$count++;
							echo "You have already sent a request to ".$name; //If the id of the person is the requestee, then we have already sent a request to this person.
						}	
					}
				}
			}

			//Check if already your friend. (Query from friends)
			$query2 = "SELECT * FROM friends WHERE friends.friend_that_added = '$user_id' OR friends.friend_that_accepted = '$user_id'"; //Get the records from friends in which we are present
			if ($rows2=mysqli_query($link, $query2)) {
				while ($row2 = mysqli_fetch_row($rows2)) {
					$friend_that_added_id = $row2[1];
					$friend_that_accepted_id = $row2[2];

					$query3 = "SELECT user_id FROM users WHERE '$name' = users.name"; //Get the user_id of the name
					if ($rows3=mysqli_query($link, $query3)) {
						$result_data = $rows3->fetch_assoc();
						$person_id = $result_data['user_id']; 
						if ($person_id == $friend_that_added_id) {
							$count++;
							echo "You are already friends with ".$name;	
						}
						else if ($person_id == $friend_that_accepted_id) {
							$count++;
							echo "You are already friends with ".$name;	 
						}	
					}
				}
			}


			if ($count == 0) { //If count is zero, there is no request that associates both of us in any way AND we are not friends already, so it is safe to send the user a friend request
				$insert_query = "INSERT INTO requested_friendships(requester_id, requestee_id) VALUES ('$user_id', '$person_id')";
				if ($rows2=mysqli_query($link, $insert_query)) {
					
				}
				$profile = "location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id;
				header($profile);
				
			}
		}
	}
}


?>