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
        $user = stripslashes($_GET['user']);
        $user = mysqli_real_escape_string($dbc, $user);
        
        $usernameQuery = "SELECT * FROM members WHERE members.user_id = '" . $user . "' LIMIT 1";
        $userNameResult = @mysqli_query($dbc, $usernameQuery) OR die ("Error: " . mysqli_error($dbc));
        $myUserInfo = mysqli_fetch_array($userNameResult);
        $numberOfUsers = mysqli_num_rows($userNameResult);
        
        $userColorQuery = "SELECT * FROM groups WHERE groups.userType = '" . $myUserInfo[1] . "' LIMIT 1";
        $userColorResult = @mysqli_query($dbc, $userColorQuery) OR die ("Error: " . mysqli_error($dbc));
        $userColor = mysqli_fetch_array($userColorResult);
        
        if ($numberOfUsers == 1)
        {
            include("includes/header.php");
            include("includes/menubar.php");
            
            echo "            <div id=\"content\">
                <div class=\"profile\">\n";
            
            if (file_exists("./imgs/avatars/" . $user . ".png"))
            {
                echo "                   <img class=\"avatar\" src=\"./imgs/avatars/" . $user . ".png\" width=\"200\" height=\"200\">";
            }
            else if (file_exists("./imgs/avatars/" . $user . ".jpeg"))
            {
                echo "                   <img class=\"avatar\" src=\"./imgs/avatars/" . $user . ".jpeg\" width=\"200\" height=\"200\">";
            }
            else if (file_exists("./imgs/avatars/" . $user . ".jpg"))
            {
                echo "                   <img class=\"avatar\" src=\"./imgs/avatars/" . $user . ".jpg\" width=\"200\" height=\"200\">";
            }
            else
            {
                echo "                   <img class=\"avatar\" src=\"./imgs/avatars/none.gif\" width=\"200\" height=\"200\">";
            }
            
            echo "\n                   <span class=\"name\">
                       <h2 style=\"color: $userColor[1]\">$myUserInfo[2]</h2>
                       $myUserInfo[7]
                   </span>
                </div>
            </div>";
            
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