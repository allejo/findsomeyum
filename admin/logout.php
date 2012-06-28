<?php
    session_start();
    
    if(!session_is_registered(xi_username))
    {
        header("location:login.php");
    }
    
    session_destroy();
    
    include("themes/SMCHS/admin/header-top.php");
    echo "\n        <title>Logged Out</title>\n";
    include("themes/SMCHS/admin/header-middle.php");
    echo "\n                <h1>XiON Administration</h1>\n";
    include("themes/SMCHS/admin/header-bottom.php");
    include("themes/SMCHS/admin/menubar.php");
    include("themes/SMCHS/admin/header-end.php");
    echo"\n";
    
    echo "\n            <h2>Logout Successful</h2>
            <p>
                Log out successful, you may now close your browser.
            </p>\n\n";
          
    include("themes/SMCHS/admin/footer.php");
?>