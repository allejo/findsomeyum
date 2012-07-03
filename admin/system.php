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
    
    if (isset($_GET['page']))
    {
        $pageno = $_GET['page'];
    }
    else
    {
        $pageno = 1;
    }
    
    if ($_GET['view'] == "admin")
    {
        $query = "SELECT count(*) FROM logs WHERE actionType = 'editUser' OR actionType = 'deleteUser'";
        $result = mysqli_query($dbc, $query) OR die ("Error: " . mysqli_error($dbc));
        $query_data = mysqli_fetch_row($result);
        $numrows = $query_data[0];
        $rows_per_page = 15;
        $lastpage = ceil($numrows/$rows_per_page);
        
        $getLogDatabase = "SELECT * FROM logs WHERE actionType = 'editUser' OR actionType = 'deleteUser' ORDER BY time DESC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    }
    else if ($_GET['view'] == "editor")
    {
        $query = "SELECT count(*) FROM logs WHERE actionType = 'editor'";
        $result = mysqli_query($dbc, $query) OR die ("Error: " . mysqli_error($dbc));
        $query_data = mysqli_fetch_row($result);
        $numrows = $query_data[0];
        $rows_per_page = 15;
        $lastpage = ceil($numrows/$rows_per_page);
        $getLogDatabase = "SELECT * FROM logs WHERE actionType = 'editor' ORDER BY time DESC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    }
    else if ($_GET['view'] == "login")
    {
        $query = "SELECT count(*) FROM logs WHERE actionType = 'login'";
        $result = mysqli_query($dbc, $query) OR die ("Error: " . mysqli_error($dbc));
        $query_data = mysqli_fetch_row($result);
        $numrows = $query_data[0];
        $rows_per_page = 15;
        $lastpage = ceil($numrows/$rows_per_page);
        
        $getLogDatabase = "SELECT * FROM logs WHERE actionType = 'login' ORDER BY time DESC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    }
    else
    {
        $query = "SELECT count(*) FROM logs";
        $result = mysqli_query($dbc, $query) OR die ("Error: " . mysqli_error($dbc));
        $query_data = mysqli_fetch_row($result);
        $numrows = $query_data[0];
        $rows_per_page = 15;
        $lastpage = ceil($numrows/$rows_per_page);
        
        $getLogDatabase = "SELECT * FROM logs ORDER BY time DESC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    }
    
    
    $pageno = (int)$pageno;
    if ($pageno > $lastpage) { $pageno = $lastpage; }
    if ($pageno < 1) { $pageno = 1; }
    if ($lastpage == 0) { $lastpage += 1; }
    
    
    $result = @mysqli_query($dbc, $getLogDatabase) OR die ("Error: " . mysqli_error($dbc));
    $numberOfRows = mysqli_num_rows($result);
    
    echo "            <div id=\"main_column\">\n";
    echo "                <table  width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
                    <tr>
                        <td><strong>Time</strong></td>
                        <td><strong>User</strong></td>
                        <td><strong>Description</strong></td>
                    </tr>";
    
    if ($_GET['view'] == "admin")
    {
        if ($_SESSION['xi_userType'] != 'admin' && $_SESSION['xi_userType'] != 'systemDev')
        {
            echo "\n                    <tr>
                        <td><p class=\"error\"><strong>No Permission</strong></p></td>
                        <td><p class=\"error\"><strong>No Permission</strong></p></td>
                        <td><p class=\"error\"><strong>No Permission</strong></p></td>
                    </tr>";
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
    }
    else if ($_GET['view'] == "editor")
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
    else if ($_GET['view'] == "login")
    {
        if ($_SESSION['xi_userType'] != 'admin' && $_SESSION['xi_userType'] != 'systemDev')
        {
            echo "\n                    <tr>
                        <td><p class=\"error\"><strong>No Permission</strong></p></td>
                        <td><p class=\"error\"><strong>No Permission</strong></p></td>
                        <td><p class=\"error\"><strong>No Permission</strong></p></td>
                    </tr>";
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
    }
    else
    {
        if ($_SESSION['xi_userType'] == 'editor')
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
    }
    
    echo "\n                </table>\n                <br />\n                <br />";
    echo "\n                <div align=\"center\">\n";
    
    if ($pageno == 1)
    {
       echo "                    &lt;&lt; &lt;";
    }
    else
    {
       echo "                    <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=1'>&lt;&lt;</a> ";
       $prevpage = $pageno-1;
       echo "\n                    <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=$prevpage'>&lt;</a> ";
    }
    
    echo "\n                    ( Page $pageno of $lastpage )";
    
    if ($pageno == $lastpage)
    {
        echo "\n                    &gt; &gt;&gt; ";
    }
    else
    {
       $nextpage = $pageno+1;
       echo "\n                     <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=$nextpage'>&gt;</a>\n";
       echo "                     <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=$lastpage'>&gt;&gt;</a>\n";
    }

    echo "                </div> <!-- End Pagination -->
            </div> <!-- End Main Column -->
            
            ";
    
    echo "<div id=\"sidebar\">\n";
    include("themes/admin/system-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/admin/footer.php");  
?>