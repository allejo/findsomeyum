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
    
    session_destroy();
    
    include("themes/admin/header-top.php");
    echo "\n        <title>Logged Out</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON Administration</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    
    echo "\n            <h2>Logout Successful</h2>
            <p>
                Log out successful, you may now close your browser.
            </p>\n\n";
          
    include("themes/admin/footer.php");
?>