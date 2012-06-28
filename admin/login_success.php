<?php
    session_start();
    
    if(!session_is_registered(xi_username))
    {
        header("location:login.php");
    }
    
    include("themes/SMCHS/admin/header-top.php");
    echo "\n        <title>XiON Administration Control Panel</title>\n";
    include("themes/SMCHS/admin/header-middle.php");
    echo "\n                <h1>XiON Administration</h1>\n";
    include("themes/SMCHS/admin/header-bottom.php");
    include("themes/SMCHS/admin/menubar.php");
    include("themes/SMCHS/admin/header-end.php");
    echo"\n";
    
    echo "\n            <h2>Login Sucessful</h2>
            <p>
                Welcome back to XiON, {$_SESSION['xi_firstName']}. Please use the navigation bar above to select what part of the website you'd like to modify.
            </p>\n\n";
    
    include("themes/SMCHS/admin/footer.php");
?>