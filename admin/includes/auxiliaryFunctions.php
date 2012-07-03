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
        $myPassword = $usernameArray[0] + $password;
        
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
    
    $userIP = getUserIP();
    $adminUserName = $_SESSION[xi_username];
?>