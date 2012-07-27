<?php 
    /*
        Copyright Sujevo Software, 2012. All Rights Reserved.
        http://sujevo.com
        
        Usage of this software is allowed with expressed written
        permission of the owner. This source may not be modified
        or built upon without expressed written permission from
        the copyright holder.
        This software is provided "AS IS" and at no time is the
        developer or distributor of this software liable for
        any damage caused by the use or misuse of the this
        software.
    */
    
    if (isset($_GET['user']))
    {
        require_once('admin/includes/mysql_connection.php');
        require_once('admin/includes/auxiliaryFunctions.php');
        $user = stripslashes($_GET['user']);
        $user = mysqli_real_escape_string($dbc, $user);
        
        $usernameQuery = "SELECT * FROM members WHERE members.user_id = '" . $user . "' LIMIT 1";
        $userNameResult = @mysqli_query($dbc, $usernameQuery) OR die ("Error: " . mysqli_error($dbc));
        $myUserInfo = mysqli_fetch_array($userNameResult);
        $numberOfUsers = mysqli_num_rows($userNameResult);
        
        if (isset($_GET['follow']))
        {
        	$userFollowers = "SELECT following FROM members WHERE user_id = '" . XiON_getUserIDFromSession($dbc) . "'";
        	$userFollowersResult = @mysqli_query($dbc, $userFollowers);
        	$myUserData = mysqli_fetch_array($userFollowersResult);
        	
        	$myFollowers = explode(",", $myUserData[0]);
        	$error = 0;
            
            foreach ($myFollowers as $myUser)
            {
	            if ($myUser == $user || XiON_getUserIDFromSession($dbc) == $user)
	            {
		            $error = 1;
	            }
            }
        	
        	if ($error == 0)
        	{
		        $newFollower = "UPDATE members SET followers='" . $myUserInfo['followers'] . "," . XiON_getUserIDFromSession($dbc) . "' WHERE members.user_id = '" . $user . "' LIMIT 1";
		        $newFollowerResult = @mysqli_query($dbc, $newFollower);
		        $newFollower = "UPDATE members SET following='" . $myUserData[0] . "," . $user . "' WHERE members.user_id = '" . XiON_getUserIDFromSession($dbc) . "' LIMIT 1";
		        $newFollowerResult = @mysqli_query($dbc, $newFollower);
		    }
	        
	        header("location: profile.php?user=" . $user);
        }
        
        if ($numberOfUsers == 1)
        {
            include("includes/header.php");
            include("includes/menubar.php");
            
            $myFollowers = explode(",", $myUserInfo['followers']);
            $totalFollowers = 0;
            
            foreach ($myFollowers as $myUser)
            {
	            if (is_numeric($myUser))
	            {
		            $totalFollowers++;
	            }
            }
            
            
            echo "            <div id=\"content\" class=\"clearfix\">
                <div class=\"profile\">
                    <div class=\"avatar\">\n";
            
            if (file_exists("./imgs/avatars/" . $user . ".png"))
            {
                echo "                        <img src=\"./imgs/avatars/" . $user . ".png\" width=\"200\" height=\"200\">";
            }
            else if (file_exists("./imgs/avatars/" . $user . ".jpeg"))
            {
                echo "                        <img src=\"./imgs/avatars/" . $user . ".jpeg\" width=\"200\" height=\"200\">";
            }
            else if (file_exists("./imgs/avatars/" . $user . ".jpg"))
            {
                echo "                        <img src=\"./imgs/avatars/" . $user . ".jpg\" width=\"200\" height=\"200\">";
            }
            else
            {
                echo "                        <img src=\"./imgs/avatars/none.gif\" width=\"200\" height=\"200\">";
            }
            
            echo "\n                    </div><!-- End .avatar -->

                    <div class=\"information\">
                        <h2>";
            
            echo XiON_getUserProfileStylized($dbc, XiON_getUsernameFromID($dbc, $user), 0);
            echo "</h2>\n                        " . $myUserInfo['rank'] . "
                        <br /><br />";
            
            if (!empty($myUserInfo['first_name']))
            {
	            echo "\n                        <strong>Real Name</strong>: " . $myUserInfo['first_name'] . " " . $myUserInfo['last_name'] . "<br />";
            }
            
            if (!empty($myUserInfo['job']))
            {
	            echo "\n                        <strong>Job</strong>: " . $myUserInfo['job'] . "<br />";
            }
            
            if (!empty($myUserInfo['hobbies']))
            {
	            echo "\n                        <strong>Hobbies</strong>: " . $myUserInfo['hobbies'] . "<br />";
            }
            
            if ($myUserInfo['gender'] == "M")
            {
	            echo "\n                        <strong>Gender</strong>: Male<br />";
            }
            else if ($myUserInfo['gender'] == "F")
            {
	            echo "\n                        <strong>Gender</strong>: Female<br />";
            }
            
            if (!empty($myUserInfo['birthday']))
            {
	            echo "\n                        <strong>Birthday</strong>: " . $myUserInfo['birthday'] . "<br />";
            }
            
            if (!empty($myUserInfo['registration_date']))
            {
	            echo "\n                        <strong>Member Since</strong>: " . $myUserInfo['registration_date'] . "<br />";
            }
            
            if (!empty($myUserInfo['bio']))
            {
	            echo "\n                        <strong>Biography</strong>: <p>" . $myUserInfo['bio'] . "</p><br />";
            }
            
			echo "\n                    </div><!-- End .information -->";
			
			if (session_is_registered(ns_username))
			{
				echo "\n\n                    <div class=\"message\">
	                <a href=\"" . $_SERVER['REQUEST_URI'] . "&follow=$user\" class=\"download_button orange\">Follow</a>
			<a href=\"\" class=\"download_button orange\">Message</a>
                        <br />
                        <br />
                        <br />\n";
			}
			
			echo "                        <center><h1>" . $totalFollowers . "</h1><strong>Followers</strong></center>";
			
			echo "\n                    </div> <!-- End .message -->
	        </div> <!-- End .profile -->
            </div> <!-- End .content -->\n";
            
            include("includes/footer.php");
        }
        else
        {
            header("location: missing.html");
        }
    }
    else
    {
        //TODO change to real 404 page
        header("location: missing.html");
    }
    
?>