<?php
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