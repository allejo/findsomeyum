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
    
    if ($_SESSION['xi_userType'] == 'admin' || $_SESSION['xi_userType'] == 'systemDev')
    {
        echo "                <a href=\"./system.php?view=all\">All Logs</a><br />\n";
        echo "                <a href=\"./system.php?view=admin\">Admin Logs</a><br />\n";
    }
    
    echo "                <a href=\"./system.php?view=editor\">Editor Logs</a><br />\n";
    
    if ($_SESSION['xi_userType'] == 'admin' || $_SESSION['xi_userType'] == 'systemDev')
    {
        echo "                <a href=\"./system.php?view=login\">Login Logs</a><br />\n";
    }
?>