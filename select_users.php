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

    <title>Select Users</title>

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
/*$username = $_SESSION['username'];

$query = "SELECT * FROM users WHERE name = '$username'";
    if($rows=mysqli_query($link, $query))
    {
        while ($row = mysqli_fetch_row($rows)) {
            $name = $row[1];
            $email = $row[3];
            $age = $row[4];
        }
        
    }*/
    $chalme_id = $_GET['chalme_id'];
    $user_id_main = $_GET['user_id'];
    $url = "insert_users.php?chalme_id=".$chalme_id."&user_id=".$user_id_main;

?>

            <h3>Step 2: Select Users!<h3>
                <form action=<?php echo $url; ?> method="post">
                    <!-- <input type="checkbox" name="check[]" value="3" /> -->
                    <?php
                        $query = "SELECT * FROM users";
                        if($rows=mysqli_query($link, $query))
                        {
                            while ($row = mysqli_fetch_row($rows)) {
                                $user_id = $row[0];
                                $name = $row[1];
                                $email = $row[3];
                                $age = $row[4];
                                if ($name != $_SESSION['username']) { ?>
                                    <input type="checkbox" name="check[]" value="<?php echo $name; ?>"><?php echo $name; ?></input><br>
                                <?php 
                                }
                            }
                        }
                    ?>
                    <input type="submit" name="sub" value="Submit" /><br>
                </form >    
		      

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>