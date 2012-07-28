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
    
    ob_start();
    
    require_once('../admin/includes/mysql_connection.php');
	require_once('../admin/includes/auxiliaryFunctions.php');
    
    // Define $myusername and $mypassword 
    $myusername = $_POST['username']; 
    $mypassword = $_POST['password']; 
    
    // To protect MySQL injections... Those damn pricks
    $mypassword = stripslashes($mypassword);
    $myusername = mysqli_real_escape_string($dbc, $myusername);
    $mypassword = mysqli_real_escape_string($dbc, $mypassword);
    $mypassword = encryptPassword($myusername, $mypassword);
    
    $sql = "SELECT * FROM members WHERE username='$myusername' AND pass='$mypassword'";
    $result = @mysqli_query($dbc, $sql);
    $count = mysqli_num_rows($result); // Mysql_num_row is counting table row
    $userIP = getUserIP();

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count == 1)
    {
		$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'login', '$myusername', '$userIP', 'Member login successful.')";
        $run_query = @mysqli_query($dbc, $logQuery);
	
    	$row = mysqli_fetch_array($result);
        session_start();
        $_SESSION["ns_username"] = $myusername;
        $_SESSION["ns_userType"] = $row[1];
        session_register("ns_username");
        header("location:../account.php");
    }
    else
    {
		$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'login', '$myusername', '$userIP', '<p class=\"error\">Failed member login attempt.</p>')";
        $run_query = @mysqli_query($dbc, $logQuery);

        header("location:../login.php?login=false");
    }
    
    ob_end_flush();
?>