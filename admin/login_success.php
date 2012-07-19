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
    
    session_start();
    
    if(!session_is_registered(xi_username))
    {
        header("location:login.php");
    }
    
    include("themes/admin/header-top.php");
    echo "\n        <title>XiON Administration Control Panel</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON Administration</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    
    echo "\n            <h2>News</h2>
            <p>
                <font color=\"darkgreen\"><b>Database </b></font><font size=\"1\">by allejo (7/7/12)</font><br>We need data entered into the database. Get working...<br><br>
            </p>\n\n";
    
    include("themes/admin/footer.php");
?>