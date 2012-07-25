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
    
    require_once("mysql_connection.php");
    session_start();
    
    /* To be Deprecated*/
    function getUserIP()
    { 
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $userIP = $_SERVER['REMOTE_ADDR'];
        }
    
        return trim($userIP);
    }
    
    function encryptPassword($username, $password)
    {
        $username = trim($username);
        $username = stripslashes($username);
        $password = trim($password);
        $password = stripslashes($password);
        
        $usernameArray = str_split($username);
        $myPassword = $usernameArray[0] . $password;
        
        for ($i = 1; $i < count($usernameArray); $i++)
        {
            $myPassword .= $usernameArray[$i];
        }
        
        $myPassword = sha1($myPassword);
        $passwordArray = str_split($myPassword);
        
        $myPassword = "";
        $myPassword .= $passwordArray[0];
        for ($i = 5; $i < count($passwordArray); $i++)
        {
            $myPassword .= $passwordArray[$i];
        }
        
        $myPassword .= $passwordArray[1];
        $myPassword .= $passwordArray[2];
        $myPassword .= $passwordArray[3];
        $myPassword .= $passwordArray[4];
        
        return $myPassword;
    }

    //$userID = getUserID();
    $userIP = getUserIP();
    $adminUserName = $_SESSION[xi_username];


    /*
        New API with XiON prefix for easy reference
    */
    
    /* =============================================
    
    	XiON_encryptPassword($username, $password)
    	
    	values
    		$username - (string)
    		$password - (string)
    	description
    		encrypt every single password with SHA1 and some manipulation
    */
    
    function XiON_encryptPassword($username, $password)
    {
    	//cleanse the strings
        $username = trim($username);
        $username = stripslashes($username);
        $password = trim($password);
        $password = stripslashes($password);
        
        $usernameArray = str_split($username); //get the first letter
        $myPassword = $usernameArray[0] . $password; //add the first letter of the username to the password
        
        for ($i = 1; $i < count($usernameArray); $i++)
        {
            $myPassword .= $usernameArray[$i]; //add the rest of the lettes
        }
        
        $myPassword = sha1($myPassword); //use SHA1 encryption
        $passwordArray = str_split($myPassword); //split up the encryption
        
        $myPassword = ""; //create password string to store the fina encrypted password
        $myPassword .= $passwordArray[0]; //keep the first value of the SHA1 encryption
        for ($i = 5; $i < count($passwordArray); $i++)
        {
            $myPassword .= $passwordArray[$i]; //build the password starting with character #5
        }
        
        //Add characters 1-4 to the end of the password
        $myPassword .= $passwordArray[1];
        $myPassword .= $passwordArray[2];
        $myPassword .= $passwordArray[3];
        $myPassword .= $passwordArray[4];
        
        return $myPassword;
    }
    
    /* =============================================
    
    	XiON_getUserIP()
    	
    	values
    		n/a
    	description
    		get the user's ip address
    */
    
    function XiON_getUserIP()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $userIP = $_SERVER['REMOTE_ADDR'];
        }
    
        return trim($userIP);
    }
    
    /* =============================================
    
    	XiON_getUsernameFromSession()
    	
    	values
    		n/a
    	description
    		get the user's username from their session
    */
    
    function XiON_getUsernameFromSession()
    {
    	return $_SESSION["ns_username"];
    }
    
    /* =============================================
    
    	XiON_getUserIDFromSession($mysql_connection)
    	
    	values
    		$mysql_connection - (mysqli_connect) the connection to our database
    	description
    		get the user's id number from the session
    */
    
    function XiON_getUserIDFromSession($mysql_connection)
    {
	    return XiON_getUserIDFromUsername($mysql_connection, XiON_getUsernameFromSession());
    }
    
    /* =============================================
    
    	XiON_getUserIDFromUsername($mysql_connection, $username)
    	
    	values
    		$mysql_connection - (mysqli_connect) the connection to our database
    		$username - (string) the username we're going to use for a query
    	description
    		we're going to query the database in order to get the user id from
    		only a username
    */
    
    function XiON_getUserIDFromUsername($mysql_connection, $username)
    {
	    $getUserIDQuery = "SELECT user_id FROM members WHERE username = '" . $username . "'";
	    $getUserIDResult =  @mysqli_query($mysql_connection, $getUserIDQuery) OR die ("Error: " . mysqli_error($mysql_connection));
	    $getUserID = mysqli_fetch_array($getUserIDResult);
	    
	    return $getUserID[0];
    }
    

    /* =============================================
    
    	XiON_getUsernameFromID($mysql_connection, $user_id)
    	
    	values
    		$mysql_connection - (mysqli_connect) the connection to our database
    		$user_id - (integer) the user id of a user which we're going to query
    	description
    		we're going to query the database in order to get the username from
    		only the user's id number
    */
    
    function XiON_getUsernameFromID($mysql_connection, $user_id)
    {
	    $getUsernameQuery = "SELECT username FROM members WHERE user_id = '" . $user_id . "'";
	    $getUsernameResult =  @mysqli_query($mysql_connection, $getUsernameQuery);
	    $getUsername = mysqli_fetch_array($getUsernameResult);
	    
	    return $getUsername[0];
    }

    /* =============================================
    
    	XiON_getUserProfileStylized($mysql_connection, $username, $hyperlink)
    	
    	values
    		$mysql_connection - (mysqli_connect) the connection to our database
    		$username - (string) the username we're going to use for the query
    		$hyperlink - (boolean) 0 or 1; return the username with a hyperlink
    					 to a profile or not
    	description
    		we're going to query a username and get the user's color and add a
    		hyperlink to the profile if requested
    		
    */
    
    function XiON_getUserProfileStylized($mysql_connection, $username, $hyperlink)
    {
	    $getUserTypeQuery = "SELECT * FROM members WHERE members.username='" . $username . "' LIMIT 1";
	    $getUserTypeResult = @mysqli_query($mysql_connection, $getUserTypeQuery) OR die ("Error: " . mysqli_error($mysql_connection));
	    $myUserType = mysqli_fetch_array($getUserTypeResult);
	
	    $getUserColorQuery = "SELECT * FROM groups WHERE groups.userType='" . $myUserType[1] . "'";
	    $getUserColorResult = @mysqli_query($mysql_connection, $getUserColorQuery) OR die ("Error: " . mysqli_error($mysql_connection));
	    $userTypeColor = mysqli_fetch_array($getUserColorResult);
	    
	    if ($hyperlink == 1)
	    {
	    	return "<a href=\"profile.php?user=" . XiON_getUserIDFromUsername($mysql_connection, $username) . "\" style=\"color: " . $userTypeColor[1] . "; text-decoration: none; font-weight: bold\">" . $username . "</a>";
	    }
	    else
	    {
	    	return "<span style=\"color: " . $userTypeColor[1] . "\">" . $username . "</span>";
	    }
    }

    /* =============================================
    
        XiON_getStarRating($rating)
        
        values
            $rating - (integer) the id of the recipe we're going to get the
                         star rating for
        description
            return the amount of stars that the recipe has recieved from users
            
    */

    function XiON_getStarRating($mysql_connection, $rating)
    {
        $fullStars = round($rating);
        $halfStars = $rating - $fullStars;
        if ($halfStars > 0)
        {
            $emptyStars = 4 - $fullStars;
        }
        else
        {
            $emptyStars = 5 - $fullStars;
        }
        
        $starRating = "";

        for ($s = 0; $s < $fullStars; $s++)
        {
            $starRating .= "\n                           <img src=\"./imgs/star_s.png\" />";
        }
        if ($halfStars > 0)
        {
            $starRating .= "\n                           <img src=\"./imgs/star_s_half.png\" />";
        }
        for ($s = 0; $s < $emptyStars; $s++)
        {
            $starRating .= "\n                           <img src=\"./imgs/star_s_empty.png\" />";
        }

        return $starRating;
    }

    /* =============================================
    
        XiON_getRating($mysql_connection, $recipeID)
        
        values
            $mysql_connection - (mysql_connect) the connectiong to the database
            $recipeID - (integer) the id of the recipe
        description
            returns the average rating of a recipe post
            
    */

    function XiON_getRating($mysql_connection, $recipeID)
    {
        $getRatingsQuery = "SELECT * FROM ratings WHERE recipe_id = '" . $recipeID . "'";
        $getRatingResults = @mysqli_query($mysql_connection, $getRatingsQuery) OR die ("Error: " . mysqli_error($mysql_connection));
        $getRatingsCount = mysqli_num_rows($getRatingResults);
        
        $totalRatings = 0;

        //Let's do some math... the joy
        for ($i = 0; $i < $getRatingsCount; $i++)
        {
            $rowValue = mysqli_fetch_array($getRatingResults);
            $totalRatings += $rowValue['value'];
        }
        if ($getRatingsCount == 0)
        {
            $totalAverage = 0.00;
        }
        else
        {
            $totalAverage = $totalRatings / $getRatingsCount;
            $totalAverage = round($totalAverage, 2);
        }

        return $totalAverage;
    }

    /* =============================================
    
        XiON_getRatingCount($mysql_connection, $recipeID)
        
        values
            $mysql_connection - (mysql_connect) the connectiong to the database
            $recipeID - (integer) the id of the recipe
        description
            returns out the number of votes
            
    */

    function XiON_getRatingsCount($mysql_connection, $recipeID)
    {
        $getRatingsQuery = "SELECT * FROM ratings WHERE recipe_id = '" . $recipeID . "'";
        $getRatingResults = @mysqli_query($mysql_connection, $getRatingsQuery) OR die ("Error: " . mysqli_error($mysql_connection));
        $getRatingsCount = mysqli_num_rows($getRatingResults);
        
        return $getRatingsCount;
    }

    /* =============================================
    
        XiON_getComments($mysql_connection, ($postSection, $parentPost)
        
        values
            $mysql_connection - (mysql_connect) the connectiong to the database
            $postSection - (string) either blog or recipe
            $parentPost - (integer) the blog or recipe id
        description
            prints out all the comments for a blog or recipe post
            
    */

    function XiON_getComments($mysql_connection, $postSection, $parentPost)
    {
        $getcommentsQuery = "SELECT * FROM comments WHERE comments.parent_post = '" . $parentPost . "' AND comments.post_section = '" . $postSection . "' ORDER BY date_posted ASC";
        $getCommentsResult = @mysqli_query($mysql_connection, $getcommentsQuery) OR die ("<br />Error: " . mysqli_error($mysql_connection));
        $getCommentsCount = mysqli_num_rows($getCommentsResult);

        for ($i = 0; $i < $getCommentsCount; $i++)
        {
            $getComments = mysqli_fetch_array($getCommentsResult);
            echo "\n                    <small>by " . XiON_getUserProfileStylized($mysql_connection, XiON_getUsernameFromID($mysql_connection, $getComments['user_id']), 1) . "</small>
                    <br />" . $getComments['content'] . "
                    <br />
                    <br />
                    <small><em>posted on " . $getComments['date_posted'] . "</em></small>
                    <br />
                    <br />";

            if ($i + 1 != $getCommentsCount)
            {
                echo "\n                    <hr />
                    <br />";
            }
        }
    }

    /* =============================================
    
        XiON_getCommentsCount($mysql_connection, ($postSection, $parentPost)
        
        values
            $mysql_connection - (mysql_connect) the connectiong to the database
            $postSection - (string) either blog or recipe
            $parentPost - (integer) the blog or recipe id
        description
            prints out all the comments for a blog or recipe post
            
    */

    function XiON_getCommentsCount($mysql_connection, $postSection, $parentPost)
    {
        $getcommentsQuery = "SELECT * FROM comments WHERE comments.parent_post = '" . $parentPost . "' AND comments.post_section = '" . $postSection . "' ORDER BY date_posted ASC";
        $getCommentsResult = @mysqli_query($mysql_connection, $getcommentsQuery) OR die ("<br />Error: " . mysqli_error($mysql_connection));
        $getCommentsCount = mysqli_num_rows($getCommentsResult);

        return $getCommentsCount;
    }
    
    /* =============================================
    
        XiON_getExtension($file)
        
        values
            $file - (string) the file name
        description
           returns the extension of an uploaded file to check for an image
            
    */
    
     function XiON_getExtension($file)
     {
         $i = strrpos($file,".");
         if (!$i) { return ""; }
         $l = strlen($file) - $i;
         $ext = substr($file, $i+1, $l);
         return $ext;
     }

     /* =============================================
    
        XiON_checkForReport($mysql_connection, $recipe, $user_id, $display)
        
        values
            $mysql_connection - (mysql_connect) the connectiong to the database
            $recipe - (integer) the recipe id to look up
            $user_id - (integer) only used if $display is true
            $display - (boolean) whether to display the flag option for a post
        description
            returns an image if
            
    */
    
     function XiON_checkForReport($mysql_connection, $recipe, $user_id, $display)
     {
         $getRecipes = "SELECT * FROM flags WHERE recipe_id='" . $recipe . "' AND status='Open'";
         $getRecipesResult = @mysqli_query($mysql_connection, $getRecipes);

         $numberOfFlags = mysqli_num_rows($getRecipesResult);

         if ($numberOfFlags > 2)
         {
            $hideRecipe = "UPDATE recipes SET visible = '0' WHERE post_id='" . $recipe . "'";
            $hideRecipeQuery = @mysqli_query($mysql_connection, $hideRecipe);
         }

         if ($display == 1)
         {
            $flagNotFound = 1;

            if ($numberOfFlags > 0)
            {
                for ($i = 0; $i < $numberOfFlags; $i++)
                {
                    $myFlag = mysqli_fetch_array($getRecipesResult);

                    if ($myFlag['user_id'] == XiON_getUserIDFromSession($mysql_connection))
                    {
                        $flagNotFound = 0;
                    }
                }
            }
            if ($flagNotFound == 1)
            {
                return "                        <a href=\"" . $_SERVER['REQUEST_URI'] . "&action=flag\"><img src=\"imgs/sys/flag.png\" width=\"30\" /></a>";
            }
         }
         else
         {
            if ($numberOfFlags > 0)
            {
                return "<img src=\"imgs/sys/warning.png\" width=\"20\"/> ";
            }
         }
     }
?>