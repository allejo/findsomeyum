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
    
    if(!session_is_registered(xi_username))
    {
        echo "\n                    <li><a href=\"./login.php\" target=\"_top\">Login</a></li>\n";
    }
    else
    {
        echo "\n                    <li><a href=\"./usermanagement.php\" target=\"_top\">User Management</a></li>";
        echo "\n                    <li><a href=\"./content.php\" target=\"_top\">Content</a></li>";
        echo "\n                    <li><a href=\"./system.php\" target=\"_top\">System</a></li>";
        echo "\n                    <li><a href=\"./logout.php\" target=\"_top\">Log Out</a></li>\n";
    }
?>