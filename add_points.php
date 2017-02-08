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

    <title>Add Points</title>

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
    $username = $_SESSION['username'];
    $user_id = $_GET['user_id'];
    $curr_points = -1;
    $query = "SELECT * FROM users WHERE users.user_id = '$user_id'";
    if($rows=mysqli_query($link, $query))
    {
        while ($row = mysqli_fetch_row($rows)) {
            $name = $row[1];
            $email = $row[3];
            $age = $row[4];
            $curr_points = $row[7];
        }
        
    }
    $change_points = "change_points.php?user_id=".$user_id."&curr_points=".$curr_points;
?>
    <h2>Add Points</h2>
      <p> Please Enter a Number: </p>
      <form role="form" action=<?php echo $change_points ?> method="post">
      <div class="form-group">
        <label for="points">Number of Points:</label>
        <input name = "points" type="number" class="form-control" id="points" placeholder="Numeric Value">
      </div>
      <button class="btn btn-primary" type="submit">Update Points</button>    
    </form>

    </div>

