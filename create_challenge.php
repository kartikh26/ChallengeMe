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

    <title>Create a Challenge</title>

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
$points = $_GET['points'];
$points_wagered = $_GET['points_wagered'];
$insert_challenge = "insert_challenge.php?user_id=".$user_id."&points=".$points."&points_wagered=".$points_wagered;;
?>


        <h2>Create a Challenge!</h2> 
            <h3>Step 1: Enter the Options</h3>
            <form role="form" action=<?php echo $insert_challenge ?> method="post">
		      <div class="form-group">
			  <label for="points_wagered">Points (Please specify a number):</label>
			  <input name = "points_required" type="number" class="form-control" id="pts" placeholder="Number of Points">
			</div>
			<div class="form-group">
			  <label for="num_days">Date Until Challenge Ends (Number of Days): </label>
			  <input name = "num_days" type="number" id="dt" class="form-control" placeholder="Number of Days" required autofocus>
			</div>
            <div class="form-group">
              <label for="category">Category</label>
              <input name = "category" type="text" id="cate" class="form-control" placeholder="Category" required autofocus>
            </div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Create Challenge!</button>		
		      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>