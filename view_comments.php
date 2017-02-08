<?php
session_start();
ini_set('display_errors', 1);

//Form as seen here: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_form_input&stacked=h
//Textbox as seen here: http://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_form_textarea&stacked=h


$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
if (mysqli_connect_errno()) {
    echo 'failure';
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$user_id = $_GET['user_id'];
$add_comment = "add_comment.php?user_id=".$user_id;


function display_comment($user_id, $link, $comment_id, $comment_user_id, $comment_text, $parent_comment_id, $inc_value) {
	
	$query4 = "SELECT * FROM comments WHERE comments.parent_comment_id = '$comment_id'";
	$num_rows = 0;
	if ($rows4=mysqli_query($link, $query4)) {
		$num_rows = mysqli_num_rows($rows4);
	}
	print_comment($user_id, $link, $comment_id, $comment_user_id, $comment_text, $parent_comment_id, $num_rows, $inc_value); 
	

	if ($num_rows == 0) { //If this comment has no children, then do not print anything 
		return;
	} 
	else {
		while ($row4 = mysqli_fetch_row($rows4)) {
			$comm_id = $row4[0];
			$comm_user_id = $row4[1]; 
			$comm_text = $row4[2];
			$par_comment_id = $row4[3]; 
			display_comment($user_id, $link, $comm_id, $comm_user_id, $comm_text, $par_comment_id, $inc_value + 100);
		}
	}
	


}

function print_comment($user_id, $link, $comment_id, $comment_user_id, $comment_text, $parent_comment_id, $num_rows, $inc_value) { //if replies = 1 print replies otherwise don't
		$name = "";
		//echo $inc_value;
		$query3 = "SELECT name FROM users WHERE users.user_id = '$comment_user_id'";
		if ($rows3 = mysqli_query($link, $query3)) {
			$result_data3 = $rows3->fetch_assoc();
			$name = $result_data3['name'];
		}

		$delete_comment = "delete_comment.php?comment_id=".$comment_id."&user_id=".$user_id;
		$padding_left = "padding-left:".$inc_value."px;";
		
	?>
		<div style=<?php echo $padding_left?>>
			<p><?php echo $comment_id.". ".$name; ?> </p>
			<p>Comment: <?php echo $comment_text ?> </p>
		
		

		<?php 
			if ($user_id == $comment_user_id) { ?>
				<a href =<?php echo $delete_comment?>><button class="btn" type="submit">Delete Comment</button></a> 
				<?php
			}
		if ($num_rows > 0) {
			$replies_to_comment = "Replies to Comment ".$comment_id.": ";
			?>
			<p> <?php echo $replies_to_comment ?> </p>
			<?php
		}
		?>
		</div>
		<?php
}

?>


<!DOCTYPE html>
<html lang="en">
	<head>
	    <title>View Comments</title>
	    <meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  		<script src="js/bootstrap.min.js"></script>    
  	</head>
  	<header>
		<?php
			$profile = "profile.php?user_id=".$user_id;
		?>
		<a href =<?php echo $profile ?>><button class="btn-primary" type="submit">Profile</button></a>
	</header>
	<body>
		<div class="container">
			<h2>Add Comment</h2>
			<p>Please enter your comment below</p>
			<form role="form" action=<?php echo $add_comment?> method="post">
				<div class="form-group">
					<label for="rep">Reply To Comment:</label>
					<input name = "reply" type="number" class="form-control" id="reply" placeholder="Leave blank if the comment is not a reponse to a thread">
					
					<label for="com">Comment:</label>
					<textarea class="form-control" name = "comment" type="text" rows="5" id="comment" placeholder="Write your comment here..."></textarea>
				</div>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Enter</button>    
			</form>
		</div>

		<div class="container">
			<h2> View Comments </h2>
			<?php
				$query2 = "SELECT * FROM comments WHERE comments.parent_comment_id = -1";
				$inc_value = 0;
				if ($rows2 = mysqli_query($link, $query2)) {
					while ($row2 = mysqli_fetch_row($rows2)) {
						$comment_id = $row2[0];
						$comment_user_id = $row2[1];
						$comment_text = $row2[2];
						$parent_comment_id = $row2[3];
						display_comment($user_id, $link, $comment_id, $comment_user_id, $comment_text, $parent_comment_id, $inc_value);
					}	
				}

				
			?>


			
		</div>
	</body>


</html>