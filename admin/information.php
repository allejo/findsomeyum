<?php
    /*
        Copyright Sujevo Software, 2012. All Rights Reserved.
        http://sujevo.com
        
        Usage of this system is allowed with expressed written
        permission of the owner. This source may not be modified
        or built upon without expressed written permission from
        the copyright holder.
        This software is provided "AS IS" and at no time is the
        developer or distributed of this software is liable for
        any damage caused with the use or misuse of the this
        software.
    */
    
    session_start();
    
    if(!session_is_registered(xi_username)) //The user is not logged in or got logged out due to inactivity
    {
        header("location:login.php"); //Send them to the login page
    }
    
    include("themes/SMCHS/admin/header-top.php");
    echo "\n        <title>Administrator Login</title>\n";
    include("themes/SMCHS/admin/header-middle.php");
    echo "\n                <h1>XiON Administration</h1>\n";
    include("themes/SMCHS/admin/header-bottom.php");
    include("themes/SMCHS/admin/menubar.php");
    include("themes/SMCHS/admin/header-end.php");
    echo"\n";
    
    echo "<div id=\"main_column\">Jeeze Jamila... I'm still working on this... Calm yo'self, girl!!! D:&lt;</div>";
    
    echo "            </div> <!-- End Main Column -->
            
            ";

    include("themes/SMCHS/admin/footer.php");  
?>