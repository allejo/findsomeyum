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
    require_once("includes/mysql_connection.php");
	require_once("includes/auxiliaryFunctions.php");
    
    if(!session_is_registered(xi_username)) //If the user is not logged in, make them login
    {
        header("location:login.php");
    }
    
    //Build the header and the navigation area
    include("themes/admin/header-top.php");
    echo "\n        <title>XiON: Delete User</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON User Management</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    echo "\n            <div id=\"main_column\">\n";
    
    $userType = $_GET['type'];
    $userToEdit = $_GET['userid'];
    $userToEdit = stripslashes($userToEdit);
    $userToEdit = mysqli_real_escape_string($dbc, $userToEdit);
    if ($userType == "admin")
        $nameQuery = "SELECT username, userType FROM admins WHERE user_id = '$userToEdit' LIMIT 1";
	else
        $nameQuery = "SELECT username FROM members WHERE user_id = '$userToEdit' LIMIT 1";
	$runNameQuery = @mysqli_query($dbc, $nameQuery);
	$row = mysqli_fetch_array($runNameQuery);
	
	if (isset($_POST['submitted']) && $row[1] == "systemDev")
    {
        echo "\n                Action failed. You cannot delete a System Developer.
            \n<br />
            \n<br />
            <a href=\"./admins.php\">&lt; Go Back</a>";
            
        echo "            </div> <!-- End Main Column -->
                
                <div id=\"sidebar\">\n";
        include("themes/admin/users-sidebar.php");
        echo "            </div> <!-- End Sidebar -->\n\n";

        include("themes/admin/footer.php");
        exit();
    }
    else if (isset($_POST['submitted']))
    {
		$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'deleteUser', '$adminUserName', '$userIP', '$adminUserName deleted user account $row[0].')";
        $run_query = @mysqli_query($dbc, $logQuery);
        
        if ($userType == "admin")
            $deleteUserQuery = "DELETE FROM `admins` WHERE `admins`.`user_id` = '$userToEdit' LIMIT 1";
        else
            $deleteUserQuery = "DELETE FROM `members` WHERE `members`.`user_id` = '$userToEdit' LIMIT 1";
        $run_query = @mysqli_query($dbc, $deleteUserQuery);
        
        if ($userType == "admin")
            echo "\n                User successfully deleted.
            \n<br />
            \n<br />
            <a href=\"./admins.php\">&lt; Go Back</a>";
        else
            echo "\n                User successfully deleted.
            \n<br />
            \n<br />
            <a href=\"./users.php\">&lt; Go Back</a>";
            
        echo "            </div> <!-- End Main Column -->
                
                <div id=\"sidebar\">\n";
        include("themes/admin/users-sidebar.php");
        echo "            </div> <!-- End Sidebar -->\n\n";

        include("themes/admin/footer.php");
        exit();
    }
?>
                <p>Are you sure you want to delete <strong><?php echo $row[0]?></strong>? This action cannot be undone.</p>
                <br />
                <div align="center">
                    <form style="text-align:justify;" action="./deleteuser.php?type=<?php echo $userType?>&userid=<?php echo $userToEdit; ?>" method="post">
                        <input type="button" value="Cancel" onClick="location.href='users.php'">
                        <input type="submit" name="submit" value="Delete User" />
                        <input type="hidden" name="submitted" value="TRUE" />
                    </form>
                </div>
<?php
    echo "            </div> <!-- End Main Column -->
            
            <div id=\"sidebar\">\n";
    include("themes/admin/users-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/admin/footer.php");  
?>