<?php
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