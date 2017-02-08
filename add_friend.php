<?php
session_start();
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>Add a Friend</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	
	<div class="container">

<?php
	$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
	if (mysqli_connect_errno()) {
	    echo 'failure';
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}


	$user_id = $_GET['user_id']; 
	$url = "insert_friend.php?user_id=".$user_id;

	?>
	
     <h2>Add a Friend</h2>
      <p> Please Type the Name of a Friend to Add: </p>
      <form role="form" action=<?php echo $url ?> method="post">
      <div class="form-group">
        <label for="name">Name of Friend:</label>
        <input name = "name" type="text" class="form-control" id="nm" placeholder="Name">
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Add Friend</button>    
    </form>
    

