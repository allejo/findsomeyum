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
    
    $currentPage = $_SERVER["PHP_SELF"];
    
    $menuBarLinksGlobal = array(
        0 => array (0 => "FSY Program", 1 => "fsyprogram.php"),
        1 => array (0 => "Tutorials", 1 => "tutorials.php"),
        2 => array (0 => "Recipes", 1 => "recipes.php"),
        3 => array (0 => "Blog", 1 => "blog.php"),
        4 => array (0 => "About", 1 => "about.php"),
        5 => array (0 => "Index", 1 => "index.php"));
    
    if (!session_is_registered(ns_username))
    {
        echo "<a href=\"#login-box\" class=\"links login-window\">Log In</a>";
    }
    else
    {
        echo "<a href=\"logout.php\" class=\"links\">Logout</a>";
        
        if (strpos($currentPage, "account.php"))
        {
            echo "<a href=\"account.php\" class=\"links active\">account</a>";
        }
        else
        {
            echo "<a href=\"account.php\" class=\"links\">Account</a>";
        }
    }
    
    for ($page = 0; $page < count($menuBarLinksGlobal); $page++)
    {
        if (strpos($currentPage, $menuBarLinksGlobal[$page][1]))
            echo "\n                <a href=\"./{$menuBarLinksGlobal[$page][1]}\" class=\"links active\">{$menuBarLinksGlobal[$page][0]}</a>";
        else
            echo "\n                <a href=\"./{$menuBarLinksGlobal[$page][1]}\" class=\"links\">{$menuBarLinksGlobal[$page][0]}</a>";
    }
    
    echo "\n            </div>\n";

    if ($_SESSION["ns_userType"] == "admin" || $_SESSION["ns_userType"] == "editor" || $_SESSION["ns_userType"] == "systemDev")
    {
?>
                <div id="content">
                    <h6><a href="admin/login.php">[Adminstrator Control Panel]</a></h6>
                </div>
<?php
    }
?>