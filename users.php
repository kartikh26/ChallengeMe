<?php
ini_set('display_errors', 1);
session_start();
?>

<!DOCTYPE html>
<html>

<head>

	<title>The ChallengeMe Community</title>

<style>
#header {
    background-color:black;
    color:white;
    text-align:center;
    padding:5px;
}
#nav {
    line-height:30px;
    background-color:#eeeeee;
    height:300px;
    width:100px;
    float:left;
    padding:5px;	      
}
#section {
    width:350px;
    float:left;
    padding:10px;	 	 
}
#footer {
    background-color:black;
    color:white;
    clear:both;
    text-align:center;
   padding:5px;	 	 
}
</style>
</head>

<body>

<div id="header">
<h1>User List</h1>
</div>

<!-- <div id="nav">
x<br>
</div> -->

<div id="section">

<?php
    $link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
    if (mysqli_connect_errno()) {
        echo 'failure';
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $username = $_SESSION['username'];
    $user_id = $_GET['user_id'];
    $profile = "profile.php?user_id=".$user_id;

    $query = "SELECT * FROM users";
        if($rows=mysqli_query($link, $query))
        {
            while ($row = mysqli_fetch_row($rows)) {
                $user_id = $row[0];
                $name = $row[1];
                $email = $row[3];
                $age = $row[4];
                ?>
                <p>
                    <?php echo $user_id; 
                            echo "\r\n";
                           echo $name;
                            echo "\r\n";
                            echo $email; 
                            echo "\r\n";
                            echo $age; 
                            echo "\r\n";
                    ?>
                </p>
                <?php
            }
        }
?>

<a href =<?php echo $profile ?>><button class="btn btn-lg btn-primary btn-block" type="submit">Go Back</button></a>
</div>

<div id="footer">ChallengeMe</div>

</body>
</html>
