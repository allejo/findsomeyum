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
	    	return "<a href=\"profile.php?user=" . $XiON_userIDFromUsername . "\" style=\"color: " . $userTypeColor[1] . "\">" . $username . "</a>";
	    }
	    else
	    {
	    	return "<span style=\"color: " . $userTypeColor . "\">" . $username . "</span>";
	    }
    }
?>