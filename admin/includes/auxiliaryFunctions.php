<?php
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