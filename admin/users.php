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
    
    $getUserDatabase = "SELECT user_id, username, first_name, last_name, email, userType FROM users";
    $result = @mysqli_query($dbc, $getUserDatabase);
    $numberOfRows = mysqli_num_rows($result);
    
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
    echo "\n                </table>\n";
    echo "            </div> <!-- End Main Column -->
            
            <div id=\"sidebar\">\n";
    include("themes/admin/users-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/admin/footer.php");    
?>