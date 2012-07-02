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


$userIP = getUserIP();
$adminUserName = $_SESSION[xi_username];
?>