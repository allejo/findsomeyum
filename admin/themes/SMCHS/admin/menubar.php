<?
    if(!session_is_registered(xi_username))
    {
        echo "\n                    <li><a href=\"./login.php\" target=\"_top\">Login</a></li>\n";
    }
    else
    {
        
        echo "\n                    <li><a href=\"./usermanagement.php\" target=\"_top\">User Management</a></li>\n";
        echo "\n                    <li><a href=\"./logout.php\" target=\"_top\">Log Out</a></li>\n";
    }
?>