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
    require_once('includes/mysql_connection.php');
    
    if(!session_is_registered(xi_username)) //The user is not logged in or got logged out due to inactivity
    {
        header("location:login.php"); //Send them to the login page
    }
    
    include("themes/admin/header-top.php");
    echo "\n        <title>XiON: System Information</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON System</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    
    echo "            <div id=\"main_column\">\n";
    $getLogDatabase = "SELECT * FROM logs";
    $result = @mysqli_query($dbc, $getLogDatabase);
    $numberOfRows = mysqli_num_rows($result);
    
    echo "                <table  width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
                    <tr>
                        <td><strong>Time</strong></td>
                        <td><strong>User</strong></td>
                        <td><strong>Description</strong></td>
                    </tr>";
    
    if ($_GET['view'] == "admin")
    {
        for ($i = 0; $i < $numberOfRows; $i++)
        {
            $row = mysqli_fetch_array($result);
            if ($row[1] == "editUser" || $row[1] == "deleteUser" || $row[1] == "addUser")
            {
                echo "\n                    <tr>
                        <td>$row[0]</td>
                        <td>$row[2] ($row[3])</td>
                        <td>$row[4]</td>
                    </tr>";
            }
        }
    }
    else if ($_GET['view'] == "editor")
    {
        for ($i = 0; $i < $numberOfRows; $i++)
        {
            $row = mysqli_fetch_array($result);
            if ($row[1] == "editContent")
            {
                echo "\n                    <tr>
                        <td>$row[0]</td>
                        <td>$row[2] ($row[3])</td>
                        <td>$row[4]</td>
                    </tr>";
            }
        }
    }
    else if ($_GET['view'] == "login")
    {
        for ($i = 0; $i < $numberOfRows; $i++)
        {
            $row = mysqli_fetch_array($result);
            if ($row[1] == "login")
            {
                echo "\n                    <tr>
                        <td>$row[0]</td>
                        <td>$row[2] ($row[3])</td>
                        <td>$row[4]</td>
                    </tr>";
            }
        }
    }
    else
    {
        for ($i = 0; $i < $numberOfRows; $i++)
        {
            $row = mysqli_fetch_array($result);
            echo "\n                    <tr>
                        <td>$row[0]</td>
                        <td>$row[2] ($row[3])</td>
                        <td>$row[4]</td>
                    </tr>";
        }
    }
    
    echo "\n                </table>";
    echo "\n            </div> <!-- End Main Column -->
            
            ";
    echo "<div id=\"sidebar\">\n";
    include("themes/admin/system-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/admin/footer.php");  
?>