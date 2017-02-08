<?php
session_start();
ini_set('display_errors', 1);

$link = new mysqli('engr-cpanel-mysql.engr.illinois.edu', 'challeng_root', 'challeng_root', 'challeng_chalme');
if (mysqli_connect_errno()) {
    echo 'failure';
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


$username = "";
$user_id = $_GET['user_id'];
$age = -1;
$email = "";
$points = -1;
$points_wagered = -1;
$query = "SELECT * FROM users WHERE users.user_id = '$user_id'";
if($row=mysqli_query($link, $query)) {
    //echo "Queried data";
    $result_data = $row->fetch_assoc();
    //echo count($result_data);
    $username = $result_data['name'];
    $age = $result_data['age'];
    $email = $result_data['email'];
    $points = $result_data['points'];
    $points_wagered = $result_data['points_wagered'];
}

?>
<!DOCTYPE html>
<html>

<head>

    <style> /*Table properties as seen at: http://www.w3schools.com/html/tryit.asp?filename=tryhtml_table_id2*/
        table {
            width:100%;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        table#t01 tr:nth-child(even) {
            background-color: #eee;
        }
        table#t01 tr:nth-child(odd) {
           background-color:#fff;
        }
        table#t01 th    {
            background-color: black;
            color: white;
        }
        #footer { /* Footer properties as seen at: http://www.w3schools.com/html/tryit.asp?filename=tryhtml_layout_divs*/
            background-color:black;
            color:white;
            clear:both;
            text-align:center;
            padding:5px;      
        }
    </style>


	<title><?php echo $username ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

</head>

<body>


<div class="container">
    <div id = "section">
        <h4>Your Profile</h4>
            <table id="t01">
                <tr>
                    <th>Name </th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Points Wagered</th>
                </tr>
            <?php
                $add_points = "add_points.php?user_id=".$user_id;
                $edit_profile = "edit_profile.php?user_id=".$user_id;
                $delete_profile = "delete_profile.php?user_id=".$user_id;
                $users = "users.php?user_id=".$user_id;
                $create_challenge = "create_challenge.php?user_id=".$user_id."&points=".$points."&points_wagered=".$points_wagered; 
                $logout = "logout.php?user_id=".$user_id;
                $add_friend = "add_friend.php?user_id=".$user_id;
                $view_comments = "view_comments.php?user_id=".$user_id;
            ?>

            <tr>
                <td> Name: <?php echo $username ?> </td>
                <td> Age: <?php echo $age ?> </td>
                <td> Email: <?php echo $email ?> </td>
                <td> Points: <?php echo $points ?> </td>
                <td> Points Wagered: <?php echo $points_wagered ?> </td>
            </tr>
            </table>  
            <a href =<?php echo $edit_profile ?>><button class="btn btn-lg btn-primary btn-block" type="submit">Edit Profile</button></a>
            <a href =<?php echo $delete_profile ?>><button class="btn btn-lg btn-primary btn-block" type="submit">Delete Profile</button></a>
            <a href =<?php echo $users ?>><button class="btn btn-lg btn-primary btn-block" type="submit">View Users</button></a>
            <a href =<?php echo $create_challenge ?>><button class="btn btn-lg btn-primary btn-block" type="submit">Create Challenge</button></a>
            <a href =<?php echo $logout ?>><button class="btn btn-lg btn-primary btn-block" type="submit">Logout</button></a>
            <a href =<?php echo $add_points ?>><button class="btn btn-lg btn-primary btn-block" type="submit">Add Points</button></a>
            <a href =<?php echo $add_friend ?>><button class="btn btn-lg btn-primary btn-block" type="submit">Add Friend</button></a>
            <a href =<?php echo $view_comments ?>><button class="btn btn-lg btn-primary btn-block" type="submit">View Comments</button></a>
          
    </div>
</div>

<!-- 1. Get all the requests for this users from the requested_users table that match this user's id.
2. Display each request's created users, points needed, accept button, decline button.  -->
<div class="container">
    <div id = "section">
        <h4> Challenge Requests: </h4>
            <table id="t01">
                <tr>
                    <th>Created By</th>
                    <th>Points Needed</th>
                    <th>Accept Challenge</th>
                    <th>Decline Challenge</th>
                </tr>
                <?php 
                    $query = "SELECT * FROM requested_users WHERE '$user_id' = requested_users.requested_user_id";  //Go through all requested users with this id      
                    if($rows=mysqli_query($link, $query)) {
                        while ($row = mysqli_fetch_row($rows)) { 
                            $chalme_id = $row[1];
                            $accept_challenge = "";
                            $query2 = "SELECT * FROM current WHERE '$chalme_id' = current.chalme_id"; //Get the challenge associated with this id from current so we can display all the challenges
                            if ($arr=mysqli_query($link, $query2)) {
                                $result_data = $arr->fetch_assoc();
                                $created_user_id = $result_data['created_user'];
                                $points_needed = $result_data['points_wagered'];

                                //echo $points_needed;
                                $query3 = "SELECT name FROM users WHERE '$created_user_id' = users.user_id";
                                 ?><tr><?php
                                if ($arr2=mysqli_query($link, $query3)) {
                                    $result_data2 = $arr2->fetch_assoc();
                                    $name = $result_data2['name'];
                                  
                                    ?>
                                   
                                        <td> <?php echo $name ?> </td>
                                        <td> <?php echo $points_needed ?> </td>
                                        <?php 
                                        $accept_challenge = "accept_challenge.php?user_id=".$user_id."&points_needed=".$points_needed."&chalme_id=".$chalme_id;
                                        $decline_challenge = "decline_challenge.php?user_id=".$user_id."&points_needed=".$points_needed."&chalme_id=".$chalme_id;
                                        //echo $decline_challenge;
                                }
                            }
                            ?> 
                                    <td><a href =<?php echo $accept_challenge?>><button class="btn btn-lg btn-primary btn-block" type="submit">Accept Challenge</button></a></td>
                                    <td><a href =<?php echo $decline_challenge?>><button class="btn btn-lg btn-primary btn-block" type="submit">Decline Challenge</button></a><br></td>
                            </tr>

                            <?php
                        }
                    }
                ?>
            </table>
    </div>
</div>

<div class="container">
    <div id = "section">
        <h4> Current Challenges I Created: </h4>
            <table id="t01">
                <tr> 
                    <th>Challenge Number</th>
                    <th>Category</th>
                    <th>Points Needed</th>
                    <th>Date Created </th>
                    <th>Date Ends</th>
                    <th>Request Still Pending For</th>
                    <th>Currently Participating</th>
                    <th>Proposed Winner</th>
                </tr> 
                <?php 
                    $query = "SELECT * FROM current WHERE '$user_id' = current.created_user";
                    $count = 1;
                    if ($rows=mysqli_query($link, $query)) {
                        while ($row = mysqli_fetch_row($rows)) {
                            $chalme_id = $row[0]; 
                            $category = $row[5];
                            $points_needed = $row[1];
                            $date_created = $row[3];
                            $date_ends = $row[4];
                            $proposed_winner = "proposed_winner.php?proposed_winner_id=".$user_id."&chalme_id=".$chalme_id;
                            ?>
                            <tr>
                                <td><?php echo $chalme_id ?></td>
                                <td><?php echo $category ?> </td>
                                <td> <?php echo $points_needed ?> </td>
                                <td> <?php echo $date_created ?> </td>
                                <td> <?php echo $date_ends ?> </td>


                                <?php 
                                    //Find whom the request is still pending for - check the requested_users table for this chalme_id
                                    $requested_people_str = "";
                                    $query2 = "SELECT name FROM users INNER JOIN requested_users ON users.user_id = requested_users.requested_user_id WHERE requested_users.chalme_id = '$chalme_id'";  
                                    
                                    if ($rows2=mysqli_query($link, $query2)) {
                                        $temp_count = mysqli_num_rows($rows2);
                                        //echo $temp_count;
                                        $i = 0;
                                        while ($row2 = mysqli_fetch_row($rows2)) {
                                            if ($i < $temp_count - 1) {
                                                $requested_people_str = $requested_people_str."".$row2[0].",  ";
                                            }
                                            else {
                                                $requested_people_str = $requested_people_str."".$row2[0];   
                                            }
                                            $i++;
                                        }
                                    }    

                                    $participants_str = "";
                                    //Find who already accepted the request - check the participants table for this chalme_id
                                    $query3 = "SELECT name FROM users INNER JOIN participants ON users.user_id = participants.participant_user_id WHERE participants.chalme_id = '$chalme_id'";

                                     if ($rows3=mysqli_query($link, $query3)) {
                                        $temp_count = mysqli_num_rows($rows3);
                                        //echo $temp_count;
                                        $i = 0;
                                        while ($row3 = mysqli_fetch_row($rows3)) {
                                            if ($i < $temp_count - 1) {
                                                $participants_str = $participants_str."".$row3[0].",  ";
                                            }
                                            else {
                                                $participants_str = $participants_str."".$row3[0];   
                                            }
                                            $i++;
                                        }
                                    }   

                                    //Optional: Who declined the request - have to create a new declined table and then move stuff into there then query that table for the chalme_id

                                ?>

                                <td> <?php echo $requested_people_str ?> </td>
                                <td><?php echo $participants_str ?> </td>
                                <td><a href =<?php echo $proposed_winner ?>><button class="btn btn-lg btn-primary btn-block" type="submit">I Win</button></a></td>
                            </tr>
                            <?php
                            $count++;
                        }
                    }
                ?>
            </table>
    </div>
</div>


<!-- Query the records in participants and see what challanges this participants belongs too -->
<div class="container">
    <div id = "section">
        <h4> Challenges I'm Involved In: </h4>
            <table id="t01"> 
                <tr>
                    <th>Challenge Number </th>
                    <th>Created By </th>
                    <th>Category </th>
                    <th>Points Needed</th>
                    <th>Date Created </th>
                    <th>Date Ends </th>
                    <th>Participants</th>
                    <th>Proposed Winner</th>
                </tr>
                <?php    
                    $query = "SELECT DISTINCT chalme_id FROM users INNER JOIN participants ON '$user_id' = participants.participant_user_id"; //This will give you a list of chalme_ids that the user is involved in
                    $count = 0;
                    if ($rows=mysqli_query($link, $query)) {
                        while ($row = mysqli_fetch_row($rows)) {
                            $chalme_id = $row[0];
                            $query2 = "SELECT * FROM current WHERE current.chalme_id = '$chalme_id'";
                            if ($rows2=mysqli_query($link, $query2)) {
                                $result_data = $rows2->fetch_assoc();
                                $points_wagered = $result_data['points_wagered'];
                                $created_user_id = $result_data['created_user'];
                                $created_username = "";
                                $query3 = "SELECT name FROM users WHERE '$created_user_id' = users.user_id";
                                if ($rows3=mysqli_query($link, $query3)) {
                                    $result_data2 = $rows3->fetch_assoc();
                                    $created_username = $result_data2['name'];
                                }
                                $date_created = $result_data['date_created'];
                                $date_ends = $result_data['date_ends'];
                                $category = $result_data['category'];
                                $count++;
                                $proposed_winner = "proposed_winner.php?proposed_winner_id=".$user_id."&chalme_id=".$chalme_id;

                                $participants_str = "";
                                //Find who already accepted the request - check the participants table for this chalme_id
                                $query3 = "SELECT name FROM users INNER JOIN participants ON users.user_id = participants.participant_user_id WHERE participants.chalme_id = '$chalme_id'";

                                 if ($rows3=mysqli_query($link, $query3)) {
                                    $temp_count = mysqli_num_rows($rows3);
                                    //echo $temp_count;
                                    $i = 0;
                                    while ($row3 = mysqli_fetch_row($rows3)) {
                                        if ($i < $temp_count - 1) {
                                            $participants_str = $participants_str."".$row3[0].",  ";
                                        }
                                        else {
                                            $participants_str = $participants_str."".$row3[0];   
                                        }
                                        $i++;
                                    }
                                }  
                                ?>
                                <tr>
                                    <td><?php echo $chalme_id ?></td>
                                    <td><?php echo $created_username ?></td>
                                    <td><?php echo $category ?></td>
                                    <td><?php echo $points_wagered ?></td>
                                    <td><?php echo $date_created ?></td>
                                    <td><?php echo $date_ends ?></td>
                                    <td><?php echo $participants_str ?></td>
                                    <td><a href =<?php echo $proposed_winner ?>><button class="btn btn-lg btn-primary btn-block" type="submit">I Win</button></a></td>
                                </tr>
                                <?php

                            }
                        }
                    }   
                ?>
            </table>
    </div>
</div>


<div class="container">
    <div id = "section">
        <h4> Friend Requests: </h4>
        <table id="t01">
            <tr>
                <th> Name </th>
                <th> Accept Request </th>
                <th> Decline Request </th>
            </tr>
            <?php 
                $query = "SELECT * FROM requested_friendships WHERE '$user_id' = requested_friendships.requestee_id"; //Find all the requests for which you are a requestee
                $count = 0;
                $accept_request = "";
                $decline_request = "";
                if ($rows=mysqli_query($link, $query)) {
                    while ($row = mysqli_fetch_row($rows)) { 
                        $requester_id = $row[1];
                        $accept_request = "accept_request.php?user_id=".$user_id."&requester_id=".$requester_id;
                        $decline_request = "decline_request.php?user_id=".$user_id."&requester_id=".$requester_id;
                        $name = "";
                        $query2 = "SELECT name FROM users WHERE '$requester_id' = users.user_id";
                        if ($rows2=mysqli_query($link, $query2)) {
                            $result_data2 = $rows2->fetch_assoc();
                            $name = $result_data2['name'];
                        }
                        $count++;
                        ?>
                        <tr>
                            <td><p> <?php echo $name ?> </p></td>
                            <td><a href =<?php echo $accept_request?>><button class="btn btn-lg btn-primary btn-block" type="submit">Accept</button></a></td>
                            <td><a href =<?php echo $decline_request?>><button class="btn btn-lg btn-primary btn-block" type="submit">Decline</button></a></td>
                        </tr>
                        <?php 
                    }
                }
            ?>
        <table>
    </div>
</div>

<div class="container">
    <div id = "section">
        <h4> Friends: </h4>
            <table id="t01">
                <tr>
                    <th> Name </th>
                    <th> Unfriend </th>
                </tr>
                <?php 
                    $query = "SELECT * FROM friends WHERE '$user_id' = friends.friend_that_added OR '$user_id' = friends.friend_that_accepted"; //Find all records in which you appear
                    $count = 0;
                    $delete_friend = "";
                    if ($rows=mysqli_query($link, $query)) {
                        while ($row = mysqli_fetch_row($rows)) { 
                            $friend_that_added = $row[1];
                            $friend_that_accepted = $row[2];
                            $friend_id = -1;
                            if ($friend_that_added != $user_id) { //friend_that_added stores the friend's id
                                $friend_id = $friend_that_added;
                                $delete_friend = "delete_friend.php?user_id=".$user_id."&friend_id=".$friend_that_added;
                            }
                            else if ($friend_that_accepted != $user_id) { //friend_that_accepted stores the friend's id
                                $friend_id = $friend_that_accepted;
                                $delete_friend = "delete_friend.php?user_id=".$user_id."&friend_id=".$friend_that_accepted;
                            }
                            $name = "";
                            $query2 = "SELECT name FROM users WHERE '$friend_id' = users.user_id";
                            if ($rows2=mysqli_query($link, $query2)) {
                                $result_data2 = $rows2->fetch_assoc();
                                $name = $result_data2['name'];
                            }
                            $count++;
                            ?>
                            <tr>
                                <td><p> <?php echo $name ?> </p></td>
                                <td><a href =<?php echo $delete_friend?>><button class="btn btn-lg btn-primary btn-block" type="submit">Unfriend</button></a></td>
                            </tr>
                            <?php 
                        }
                    }
                ?>
            </table>
    </div>
</div>


<div class="container">
    <div id = "section">
        <h4> Requests to Join Challenges I Created <h4> 
            <table id="t01">

                 <tr>
                    <th> Challenge Number </th>
                    <th> Requested By </th>
                    <th> Accept </th>
                    <th> Decline </th>
                </tr>

                <?php //Either accept or decline the challenge 
                        //Go through request_to_join and for all created_user_id's that match this user's id, display the challenge with an accept or decline button.
                        // If you accept, then delete this record from request_to_join and this user to participants and subtract from points and move to points_wagered the number of points of the challenge
                        // If you decline, then delete this record from request_to_join
                    $query = "SELECT * FROM request_to_join WHERE '$user_id' = request_to_join.created_user_id";
                    if ($rows = mysqli_query($link, $query)) {
                        while ($row = mysqli_fetch_row($rows)) {
                            $chalme_id = $row[1];
                            $created_user_id = $row[2];
                            $user_requesting_id = $row[3];

                            $created_username = "";
                            $requester_username = "";
                            $query2 = "SELECT name FROM users WHERE '$created_user_id' = users.user_id";
                            $query3 = "SELECT name FROM users WHERE '$user_requesting_id' = users.user_id";
                            if ($rows2 = mysqli_query($link, $query2)) {
                                $result_data = $rows2->fetch_assoc();
                                $created_username =  $result_data['name'];
                            }
                            if ($rows3 = mysqli_query($link, $query3)) {
                                $result_data2 = $rows3->fetch_assoc();
                                $requester_username =  $result_data2['name'];
                            }

                            $accept_challenge_request = "accept_challenge_request.php?chalme_id=".$chalme_id."&requester_id=".$user_requesting_id."&user_id=".$user_id;
                            $decline_challenge_request = "decline_challenge_request.php?chalme_id=".$chalme_id."&requester_id=".$user_requesting_id."&user_id=".$user_id;    
                            ?>
                            <tr>
                                <td> <?php echo $chalme_id?></td>
                                <td><?php echo $requester_username?></td>
                                <td><a href =<?php echo $accept_challenge_request?>><button class="btn btn-lg btn-primary btn-block" type="submit">Accept</button></a></td>
                                <td><a href =<?php echo $decline_challenge_request?>><button class="btn btn-lg btn-primary btn-block" type="submit">Decline</button></a></td>
                            </tr>
                            <?php
                        } 
                    }
                ?>
            </table>    
    </div>
</div>


<div class="container">
    <div id = "section">
        <h4> Pending Challenge Status: </h4>
           <table id="t01">
                <tr>
                    <th> Challenge Number </th>
                    <th> Category </th>
                    <th> Proposed Winner </th>
                    <th> Points You Lose </th>
                    <th> Date Created </th>
                    <th> Date Ends </th>
                    <th> Accept </th>
                    <th> Defeat </th>
                </tr>

                <?php 
                    $count = 1;
                    $query = "SELECT * FROM pending_table WHERE '$user_id' = pending_table.participant_id"; 
                    if ($rows = mysqli_query($link, $query)) {
                        //echo "HERE";
                        while ($row = mysqli_fetch_row($rows)) {
                            $chalme_id = $row[1];
                            $proposed_winner_id = $row[2];

                            $participant_id = $row[3];
                            $query2 = "SELECT points_wagered, category, date_created, date_ends FROM archived WHERE '$chalme_id' = archived.chalme_id";
                            $query3 = "SELECT name FROM users WHERE '$proposed_winner_id' = users.user_id";

                            $points = -1;
                            $category = "";
                            $date_created = "";
                            $date_ends = "";
                            if ($rows2 = mysqli_query($link, $query2)) {
                                $result_data = $rows2->fetch_assoc();
                                $points = $result_data['points_wagered'];
                                $category = $result_data['category'];
                                $date_created = $result_data['date_created'];
                                $date_ends = $result_data['date_ends'];
                            }

                            $proposed_winner_username = "";
                            if ($rows3 = mysqli_query($link, $query3)) {
                                $result_data = $rows3->fetch_assoc();
                                $proposed_winner_username = $result_data['name'];
                            }

                            $accept_defeat = "accept_defeat.php?chalme_id=".$chalme_id."&my_id=".$user_id."&proposed_winner_id=".$proposed_winner_id."&points=".$points;
                            $deny_defeat = "deny_defeat.php?chalme_id=".$chalme_id."&my_id=".$user_id."&points=".$points;
                            ?>

                            <tr>
                                <td> <?php echo $chalme_id?> </td>
                                <td> <?php echo $category?> </td>
                                <td> <?php echo $proposed_winner_username?> </td>
                                <td> <?php echo $points?> </td>
                                <td> <?php echo $date_created?> </td>
                                <td> <?php echo $date_ends?> </td>
                                <td> <a href =<?php echo $accept_defeat?>><button class="btn btn-lg btn-primary btn-block" type="submit">Accept</button></a> </td>
                                <td><a href =<?php echo $deny_defeat?>><button class="btn btn-lg btn-primary btn-block" type="submit">Deny</button></a> </td>
                            </tr>
                            <?php 
                            

                            $count++;
                        }
                    }
                ?>
            </table>
    </div>
</div>

<div class="container">
    <div id = "section">
        <h4> Past Challenges: </h4>
        <table id="t01">
            <tr>
                <th> Challenge Number </th>
                <th> Created User </th>
                <th> Points Needed </th>
                <th> Category  </th>
                <th> Date Started </th>
                <th> Date Ends </th>
                <th> Winner </th>
            </tr>


        <?php //Go through past_participants 
            $query = "SELECT * FROM past_participants WHERE past_participants.participant_user_id = '$user_id'";
            $rows = NULL;
            $count = 1;
            if ($rows = mysqli_query($link, $query)){
                //Get information about the current challenge
                while ($row = mysqli_fetch_row($rows)) {
                    $chalme_id = $row[1];
                    $query2 = "SELECT * FROM archived WHERE archived.chalme_id = '$chalme_id'";
                    if ($rows2 = mysqli_query($link, $query2)){
                        $result_data = $rows2->fetch_assoc();
                        $created_user_id = $result_data['created_user'];
                        $points_needed = $result_data['points_wagered'];
                        $date_created = $result_data['date_created'];
                        $date_ends = $result_data['date_ends'];
                        $winner_id = $result_data['winner'];
                        $category = $result_data['category'];

                        $query3 = "SELECT name FROM users WHERE users.user_id = '$created_user_id'";
                        $query4 = "SELECT name FROM users WHERE users.user_id = '$winner_id'";

                        $created_username = "";
                        if ($rows3 = mysqli_query($link, $query3)) {
                            $result_data2 = $rows3->fetch_assoc();
                            $created_username = $result_data2['name'];
                        }

                        $winner_username = "";
                        if ($rows4 = mysqli_query($link, $query4)) {
                            $result_data3 = $rows4->fetch_assoc();
                            $winner_username = $result_data3['name'];  
                        }

                        ?>
                            <tr>
                                <td> <?php echo $chalme_id?> </td>
                                <td> <?php echo $created_username?> </td>
                                <td> <?php echo $points_needed?> </td>
                                <td> <?php echo $category?> </td>
                                <td> <?php echo $date_created?> </td>
                                <td> <?php echo $date_ends?> </td>
                                <td> <?php echo $winner_username?> </td>
                            </tr>
                        <?php
                    }
                    $count++;
                }
            }
        ?> 
        </table>
    </div> 
</div> 

<div class="container">
    <div id = "section">
        <h4> Recommended Challenges: </h4>
        <?php
            $table_name = "rating_table_".$user_id; //TODO: Need to create new table called recommended challenges
            $create_query = "CREATE TABLE $table_name (chalme_id int, rating int)";

                        
            if ($create_rows = mysqli_query($link, $create_query)){
                // echo "The table was created\n";
            }

            
            $view_name = "challenges_i_am_not_in_".$user_id; 
            $qu = "CREATE VIEW $view_name AS SELECT DISTINCT * FROM participants WHERE participants.participant_user_id != '$user_id'";
            $query = "SELECT DISTINCT * FROM participants WHERE participants.participant_user_id != '$user_id'";
            $query3 = "SELECT * FROM past_participants WHERE past_participants.participant_user_id = '$user_id'";

            $rows = NULL;
            //$rows2 = NULL;
            $rows3 = NULL;

            if ($r = mysqli_query($link, $qu)) { //View was created properly and contains all challenges I am not a part of
                // echo "View was created properly\n";

            }

            if ($rows = mysqli_query($link, $query)) {
                // echo "Got all the current challenges I am not a part of";
            }

            /*if ($rows2 = mysqli_query($link, $query2)) { //Found all current challenges I am not a participant in
                echo "Found all current challenges I am not a participant in\n";
            }*/

            if ($rows3 = mysqli_query($link, $query3)) { //Got all the challenges I have been a part of
                // echo "Got all the challenges I have been a part of\n";
            }
            
            

            $rating = 0;

            while ($row = mysqli_fetch_row($rows)) { //Outer while loop contains all the challenges I am not involved in 
                $outer_id = $row[1]; //chalme_id
                $outer_points_wagered = -1; //points_wagered
                $outer_created_user_id = -1; //created_user's id
                $outer_category = -1; //category


                $query4 = "SELECT points_wagered, created_user, category FROM current WHERE '$outer_id' = current.chalme_id";
                if ($rows4 = mysqli_query($link, $query4)) {
                    $result_data = $rows4->fetch_assoc();
                    $outer_points_wagered = $result_data['points_wagered']; //points_wagered
                    $outer_created_user_id = $result_data['created_user']; //created_user's id
                    $outer_category = $result_data['category'];; //category
                }

                $rating = 0;

                while ($row3 = mysqli_fetch_row($rows3)) { //Inner while loop contains all the challenges I am involved in
                    $inner_id = $row3[1]; //chalme_id
                    $inner_points_wagered = -1; //points_wagered
                    $inner_created_user_id = -1; //my id
                    $inner_category = -1; //category

                    $query5 = "SELECT points_wagered, created_user, category FROM archived WHERE '$inner_id' = archived.chalme_id";
                    if ($rows5 = mysqli_query($link, $query5)) {
                        $result_data = $rows5->fetch_assoc();
                        $inner_points_wagered = $result_data['points_wagered']; //points_wagered
                        $inner_created_user_id = $result_data['created_user']; //created_user's id
                        $inner_category = $result_data['category'];; //category
                    }

                    if ($inner_created_user_id != $user_id) {
                        // echo "Something is wrong.\n";
                    }

                    $query4 = "SELECT * FROM friends WHERE (friends.friend_that_added = '$inner_created_user_id' AND friends.friend_that_accepted = '$outer_created_user_id' ) OR (friends.friend_that_added = '$outer_created_user_id' AND friends.friend_that_accepted = '$inner_created_user_id')"; 
                    $query5 = "SELECT wins, losses FROM users WHERE '$inner_created_user_id' = users.user_id";
                    $query6 = "SELECT wins, losses FROM users WHERE '$outer_created_user_id' = users.user_id";

                    $rows4 = NULL;
                    $rows5 = NULL;
                    $rows6 = NULL;

                    if ($rows4 = mysqli_query($link, $query4)) { //Check if they are friends
                        
                        if (mysqli_num_rows($rows4) == 1){
                            // echo "they ARE friends and have only 1 row so nothing is wrong\n";
                            $rating += round(sqrt(abs(pow($inner_points_wagered, 2) - pow(($outer_points_wagered), 2))))* 7;
                        }
                        else if (mysqli_num_rows($rows4) == 0) {
                            //echo "outer_created_user_id and inner_created_user_id are NOT friends\n";
                            $rating += round(sqrt(abs(pow($inner_points_wagered, 2) - pow(($outer_points_wagered), 2))))* 3;
                        }
                        else {
                            // echo "More than 1 row: ERROR\n";
                        }
                    }

                    // echo "RATING";
                    // echo $rating;
                    
                    $my_win_loss_percentage = -1;
                    $outer_created_user_win_loss_percentage = -1;

                    if ($rows5 = mysqli_query($link, $query5)) { //Calculate win/loss percentage for me
                        $result_data = $rows5->fetch_assoc(); 
                        $my_win_loss_percentage = round(($result_data['wins'] + $result_data['losses']) / ($result_data['wins']+1)); 
                        //echo "Ready to calculate MY win/loss percentage\n";
                    }

                    if ($rows6 = mysqli_query($link, $query6)) { //Calculte win/loss percentage for other user
                        $result_data2 = $rows6->fetch_assoc(); 
                        $outer_created_user_win_loss_percentage =round(($result_data['wins'] + $result_data['losses']) / ($result_data['wins']+1));
                        //echo "Ready to calculate outer_created_user_id win/loss percentage\n";
                    }

                    if ($inner_category == $outer_category) {
                        $rating += round(sqrt(abs(pow($inner_points_wagered, 2) - pow($outer_points_wagered, 2))))* 5;
                    }

                    

                    if (abs($my_win_loss_percentage - $outer_created_user_win_loss_percentage) < 10) {
                        
                        $rating += round(sqrt(abs(pow($inner_points_wagered, 2) - pow($outer_points_wagered, 2)))) * 3;
                    }

                    
                    // echo $rating;
                    if ($inner_points_wagered - $outer_points_wagered == 0) {
                        
                        $rating += 10;
                    }
                    else {
                       
                        $rating += round(9 / abs($inner_points_wagered - $outer_points_wagered));
                    }

                    
                }

                // echo $rating;                

                $insert_query = "INSERT INTO $table_name (chalme_id, rating) VALUES ('$outer_id', '$rating')";
                if ($rows7 = mysqli_query($link, $insert_query)) {
                    // echo "Inserted rating into database for chalme_id ".$outer_id."\n";
                }
            }

            //Recommend the challenges to the user after sorting the ratings
            $view_name_2 = "challenges_to_recommend_to_".$user_id;
            $query8 = "CREATE VIEW $view_name_2 AS SELECT * FROM $table_name ORDER BY rating DESC LIMIT 3";
            if ($rows8 = mysqli_query($link, $query8)) {
                // echo "created view 2\n";

            }

            //$query9 = "SELECT DISTINCT current.chalme_id, current.points_wagered, current.created_user, current.category FROM current WHERE current.chalme_id = $view_name_2.chalme_id";
            $query9 = "SELECT * FROM $view_name_2";
            if ($rows9 = mysqli_query($link, $query9)) { //Get all the info about the challenge
                // echo "Got all the info about the challenge\n";
                $count = 1;
                while ($row9 = mysqli_fetch_row($rows9)) {
                    $chalme_id = $row9[0]; //chalme_id
                    $points_wagered = -1; //points_wagered
                    $created_user_id = -1; //created_user's id
                    $category = ""; //category

                    $cu_query = "SELECT points_wagered, created_user, category FROM current WHERE current.chalme_id = '$chalme_id'";
                    if ($cu_rows = mysqli_query($link, $cu_query)) {
                        $result_data = $cu_rows->fetch_assoc();
                        $points_wagered = $result_data['points_wagered'];
                        $created_user_id = $result_data['created_user'];
                        $category = $result_data['category'];
                    }

                    //$created_user_id = $row9[2]; //created_user's id
                    //$category = $row9[3]; //category

                    $request_to_join = "";
                    $name = "";
                    $query10 = "SELECT name FROM users WHERE '$created_user_id' = users.user_id";
                    if ($rows10 = mysqli_query($link, $query10)) {
                        $result_data = $rows10->fetch_assoc();
                        $name = $result_data['name'];
                        $request_to_join = "request_to_join.php?user_id=".$user_id."&chalme_id=".$chalme_id."&created_user_id=".$created_user_id;
                        ?>
                        <p>Recommended Challenge: <?php echo $chalme_id?><p>
                        <p>Created User: <?php echo $name?></p>
                        <p>Points Required: <?php echo $points_wagered?></p>
                        <p>Category: <?php echo $category?></p>
                        <a href =<?php echo $request_to_join?>><button class="btn btn-lg btn-primary btn-block" type="submit">Request to Join</button></a>
                        <?php
                    }
                    $count++;
                }
            }


            //Clean up
            $remove_query = "DROP VIEW $view_name";
            if ($rows9 = mysqli_query($link, $remove_query)) {
                // echo "Removed view 1\n";
            }

            $remove_query_2 = "DROP VIEW $view_name_2";
            if ($rows10 = mysqli_query($link, $remove_query_2)) {
                // echo "Removed view 2\n";
            }
            
            $delete_query = "DROP TABLE $table_name";
            if ($rows11 = mysqli_query($link, $delete_query)) {
                // echo "Deleted the table\n";
            }
        ?>
    </div> 
</div> 

<div id="footer">ChallengeMe</div>

</body>
</html>
