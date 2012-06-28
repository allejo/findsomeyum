<?php
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