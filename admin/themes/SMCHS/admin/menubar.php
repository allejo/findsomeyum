<?
    if(!session_is_registered(xi_username))
    {
        echo "\n                    <li><a href=\"./login.php\" target=\"_top\">Login</a></li>\n";
    }
    else
    {
        echo "\n                    <li><a href=\"./usermanagement.php\" target=\"_top\">User Management</a></li>";
        echo "\n                    <li><a href=\"./information.php\" target=\"_top\">Information</a></li>";
        
        if ($_SESSION['xi_userType'] == 'admin' || $_SESSION['xi_userType'] == 'systemDev')
        {
            echo "\n                    <li><a href=\"./system.php\" target=\"_top\">System</a></li>\n";
        }
        
        echo "\n                    <li><a href=\"./logout.php\" target=\"_top\">Log Out</a></li>\n";
    }
?> 