<?php
    session_start();
    require_once('includes/mysql_connection.php');
    
    //TODO: Add pagination
    
    //Build the header and the navigation area
    include("themes/admin/header-top.php");
    echo "\n        <title>XiON: User List</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON User Management</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    echo "\n            <div id=\"main_column\">\n";
    
    if(!session_is_registered(xi_username)) //The user is not logged in or got logged out due to inactivity
    {
        header("location:login.php"); //Send them to the login page
    }
    
    if ($_SESSION['xi_userType'] != 'admin' && $_SESSION['xi_userType'] != 'systemDev') //The user does not have the permission to add a new user
    {
    	echo '<h2>Permission Denied</h2>
              <p>This page was reached in error or you do not have permission to view this page. If this was a mistake, please contact the system administrator.</p>';
              
        include("themes/admin/footer.php");
        
        exit(); //Kill the script to avoid malicious injections
    }
    
    if (isset($_GET['page']))
    {
        $pageno = $_GET['page'];
    }
    else
    {
        $pageno = 1;
    }
    
    $query = "SELECT count(*) FROM users";
    $result = mysqli_query($dbc, $query) or trigger_error("SQL", E_USER_ERROR);
    $query_data = mysqli_fetch_row($result);
    $numrows = $query_data[0];
    $rows_per_page = 15;
    $lastpage = ceil($numrows/$rows_per_page);
    
    $getUserDatabase = "SELECT user_id, username, first_name, last_name, email, userType FROM users ORDER BY user_id ASC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    $result = @mysqli_query($dbc, $getUserDatabase) OR die ("Error: " . mysqli_error($dbc));
    $numberOfRows = mysqli_num_rows($result);
    
    $pageno = (int)$pageno;
    if ($pageno > $lastpage) { $pageno = $lastpage; }
    if ($pageno < 1) { $pageno = 1; }
    if ($lastpage == 0) { $lastpage += 1; }
    
    echo "                <table  width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
                    <tr>
                        <td><strong>User ID</strong></td>
                        <td><strong>Username</strong></td>
                        <td><strong>User Type</strong></td>
                        <td><strong>First Name</strong></td>
                        <td><strong>Last Name</strong></td>
                        <td><strong>Email</strong></td>
                        <td><strong>Edit</strong></td>
                        <td><strong>Delete</strong></td>
                    </tr>";
    
    for ($i = 0; $i < $numberOfRows; $i++)
    {
        $row = mysqli_fetch_array($result);
        echo "\n                    <tr>
                        <td>$row[0]</td>
                        <td>$row[1]</td>
                        <td>$row[5]</td>
                        <td>$row[2]</td>
                        <td>$row[3]</td>
                        <td>$row[4]</td>
                        <td><a href=\"edituser.php?userid=$row[0]\">Edit</a></td>
                        <td><a href=\"deleteuser.php?userid=$row[0]\">Delete</a></td>
                    </tr>";
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
            
            <div id=\"sidebar\">\n";
    include("themes/admin/users-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/admin/footer.php");    
?>