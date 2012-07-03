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
    
    echo "                <a href=\"./usermanagement.php\">User Profile</a><br />\n";
    
    if ($_SESSION['xi_userType'] == 'admin' || $_SESSION['xi_userType'] == 'systemDev')
    {
        echo "                <a href=\"./adduser.php\">Add User</a><br />\n";
    }
    
    if ($_SESSION['xi_userType'] == 'admin' || $_SESSION['xi_userType'] == 'systemDev')
    {
        echo "                <a href=\"./users.php\">User List</a><br />\n";
    }
?>