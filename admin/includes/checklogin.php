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
    
    require_once('mysql_connection.php');
	require_once('auxiliaryFunctions.php');
    
    // Define $myusername and $mypassword 
    $myusername = $_POST['username']; 
    $mypassword = $_POST['password']; 
    
    // To protect MySQL injections... Those damn pricks
    $mypassword = stripslashes($mypassword);
    $myusername = mysqli_real_escape_string($dbc, $myusername);
    $mypassword = mysqli_real_escape_string($dbc, $mypassword);
    $mypassword = encryptPassword($myusername, $mypassword);
    
    $sql = "SELECT * FROM members WHERE members.username='$myusername' AND members.pass='$mypassword' AND (members.group='systemDev' OR members.group='admin' OR members.group='editor')";
    $result = @mysqli_query($dbc, $sql) OR die ("Error: " . mysqli_error($dbc));
    $count = mysqli_num_rows($result); // Mysql_num_row is counting table row
    $userIP = getUserIP();

    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count == 1)
    {
		$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'login', '$myusername', '$userIP', 'Administrative login successful.')";
        $run_query = @mysqli_query($dbc, $logQuery);
	
    	$row = mysqli_fetch_array($result);
        session_start();
        $_SESSION["xi_username"] = $myusername;
        $_SESSION["xi_firstName"] = $row['first_name'];
        $_SESSION["xi_userType"] = $row['group'];
        session_register("xi_username");
        header("location:../login_success.php");
    }
    else
    {
		$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'login', '$myusername', '$userIP', '<p class=\"error\">Failed login attempt.</p>')";
        $run_query = @mysqli_query($dbc, $logQuery);

        header("location:../login.php?login=false");
    }
    
    ob_end_flush();
?>