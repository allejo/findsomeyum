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
    require_once("includes/mysql_connection.php");
	require_once("includes/auxiliaryFunctions.php");
    
    if(!session_is_registered(xi_username)) //If the user is not logged in, make them login
    {
        header("location:login.php");
    }
    
    //Build the header and the navigation area
    include("themes/SMCHS/admin/header-top.php");
    echo "\n        <title>XiON: User List</title>\n";
    include("themes/SMCHS/admin/header-middle.php");
    echo "\n                <h1>XiON User Management</h1>\n";
    include("themes/SMCHS/admin/header-bottom.php");
    include("themes/SMCHS/admin/menubar.php");
    include("themes/SMCHS/admin/header-end.php");
    echo"\n";
    echo "\n            <div id=\"main_column\">\n";
    
    $userToEdit = $_GET['userid'];
    $userToEdit = stripslashes($userToEdit);
    $userToEdit = mysqli_real_escape_string($dbc, $userToEdit);
    $nameQuery = "SELECT username FROM users WHERE user_id = '$userToEdit' LIMIT 1";
	$runNameQuery = @mysqli_query($dbc, $nameQuery);
	$row = mysqli_fetch_array($runNameQuery);

    if (isset($_POST['submitted']))
    {
		$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'deleteUser', '$adminUserName', '$userIP', '$adminUserName deleted user account $row[0].')";
        $run_query = @mysqli_query($dbc, $logQuery);
	
        $deleteUserQuery = "DELETE FROM `users` WHERE `users`.`user_id` = '$userToEdit' LIMIT 1";
        $run_query = @mysqli_query($dbc, $deleteUserQuery);
        
        echo "\n                User successfully deleted.
            \n<br />
            \n<br />
            <a href=\"./users.php\">&lt; Go Back</a>";
            
        echo "            </div> <!-- End Main Column -->
                
                <div id=\"sidebar\">\n";
        include("themes/SMCHS/admin/users-sidebar.php");
        echo "            </div> <!-- End Sidebar -->\n\n";

        include("themes/SMCHS/admin/footer.php");
        exit();
    }
?>
                <p>Are you sure you want to delete <strong><?php echo $row[0]?></strong>? This action cannot be undone.</p>
                <br />
                <div align="center">
                    <form style="text-align:justify;" action="./deleteuser.php?userid=<?php echo $userToEdit; ?>" method="post">
                        <input type="button" value="Cancel" onClick="location.href='users.php'">
                        <input type="submit" name="submit" value="Delete User" />
                        <input type="hidden" name="submitted" value="TRUE" />
                    </form>
                </div>
<?php
    echo "            </div> <!-- End Main Column -->
            
            <div id=\"sidebar\">\n";
    include("themes/SMCHS/admin/users-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/SMCHS/admin/footer.php");  
?>