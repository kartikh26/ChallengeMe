<?php
session_start();
ini_set('display_errors', 1);

$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
if (mysqli_connect_errno()) {
    echo 'failure';
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//echo "HERE";

$chalme_id = $_GET['chalme_id'];
$user_id = $_GET['user_id'];
//echo $chalme_id;
$checks = $_POST['check'];


$length = count($checks);
//echo $length;

//Get chalme id
for ($i = 0; $i < $length; $i++) {
	$requested_user_name = $checks[$i];
	//echo $requested_user_name;
	$name_query = "SELECT user_id FROM users WHERE '$requested_user_name' = users.name";
	if($row=mysqli_query($link, $name_query)) {
		//echo "Queried data";
		$result_data = $row->fetch_assoc();
		//echo count($result_data);
		$requested_user_id = $result_data['user_id'];
		//echo "requested user id:";
		//echo $requested_user_id; 
		$query = "INSERT INTO requested_users (chalme_id, requested_user_id) VALUES ('$chalme_id', '$requested_user_id')";
		if($rows=mysqli_query($link, $query)) {
			//echo "Entered data AGAIN";

		}
	}
	else {
		//echo "HERE";
	}
	
}

header("location: https://web.engr.illinois.edu/~challengeme/profile.php?user_id=".$user_id);

?>