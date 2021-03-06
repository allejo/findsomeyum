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
    echo "\n        <title>XiON: Edit User</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON User Management</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    echo "\n            <div id=\"main_column\">\n";
    
    $userType = $_GET['type'];
    $userToEdit = trim($_GET['userid']);
    $userToEdit = stripslashes($userToEdit);
    
    if ($userType == "admin")
        $getUserDatabase = "SELECT user_id, username, first_name, last_name, email, userType FROM admins WHERE user_id = '" . $userToEdit . "'";
    else
        $getUserDatabase = "SELECT user_id, username, first_name, last_name, email, premium FROM members WHERE user_id = '" . $userToEdit . "'";
    $result = @mysqli_query($dbc, $getUserDatabase);
    $numberOfRows = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    
    if (isset($_POST['submitted']))
    {
        if (!empty($_POST['first_name']) && $_POST['first_name'] != $row[2])
        {
			$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'editUser', '$adminUserName', '$userIP', '$adminUserName edited $row[1]\'s first name.')";
	        $run_query = @mysqli_query($dbc, $logQuery);
	
            $newFirstName = trim($_POST['first_name']);
            $newFirstName = stripslashes($newFirstName);
            
            if ($userType == "admin")
                $updateFirstNameQuery = "UPDATE admins SET  first_name = '" . $newFirstName . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            else
                $updateFirstNameQuery = "UPDATE members SET  first_name = '" . $newFirstName . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateFirstNameQuery);
        }
        
        if (!empty($_POST['last_name']) && $_POST['last_name'] != $row[3])
        {
			$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'editUser', '$adminUserName', '$userIP', '$adminUserName edited $row[1]\'s last name.')";
	        $run_query = @mysqli_query($dbc, $logQuery);
	
            $newLastName = trim($_POST['last_name']);
            $newLastName = stripslashes($newLastName);
            
            if ($userType == "admin")
                $updateLastNameQuery = "UPDATE admins SET  last_name = '" . $newLastName . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            else
                $updateLastNameQuery = "UPDATE members SET  last_name = '" . $newLastName . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateLastNameQuery);
        }
        
        if (!empty($_POST['email']) && $_POST['email'] != $row[4])
        {
			$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'editUser', '$adminUserName', '$userIP', '$adminUserName edited $row[1]\'s email.')";
	        $run_query = @mysqli_query($dbc, $logQuery);
	
            $newEmail = trim($_POST['email']);
            $newEmail = stripslashes($newEmail);
            
            if ($userType == "admin")
                $updateEmailQuery = "UPDATE admins SET  email = '" . $newEmail . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            else
                $updateEmailQuery = "UPDATE members SET  email = '" . $newEmail . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateEmailQuery);
        }
        
        if (isset($_POST['userType']) && $_POST['userType'] != $row[5] && $userType == "admin")
        {
			$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'editUser', '$adminUserName', '$userIP', '$adminUserName edited $row[1]\'s user type.')";
	        $run_query = @mysqli_query($dbc, $logQuery);
	
            $newUserType = trim($_POST['userType']);
            $newUserType = stripslashes($newUserType);
	        $updateEmailQuery = "UPDATE admins SET  userType = '" . $newUserType . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateEmailQuery);
        }
        
        if (!empty($_POST['newpassword']) && !empty($_POST['confirmnewpassword']) && $_POST['newpassword'] == $_POST['confirmnewpassword'])
        {
			$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'editUser', '$adminUserName', '$userIP', '$adminUserName edited $row[1]\'s password.')";
	        $run_query = @mysqli_query($dbc, $logQuery);
	
            $newPassword = trim($_POST['newpassword']);
            $newPassword = stripslashes($newPassword);
            $newPassword = encryptPassword($row[1], $newPassword);
            
            if ($userType == "admin")
                $updatePasswordQuery = "UPDATE admins SET pass = '" . $newPassword . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            else
                $updatePasswordQuery = "UPDATE members SET pass = '" . $newPassword . "' WHERE user_id = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updatePasswordQuery);
        }
        else if (empty($_POST['newpassword']) && empty($_POST['confirmnewpassword']))
        {
            //Purposely do nothing because we don't want to do anything if a new password wasn't requested
        }
        else
        {
            echo "<p class=\"error\">New passwords do not match.</p>";
        }
        
        echo "\n                User information successfully updated.
            \n<br />
            \n<br />
            <a href=\"./edituser.php?type=$userType&userid=$userToEdit\">&lt; Go Back</a>
            \n        </div> <!-- End Main Column -->
                
                <div id=\"sidebar\">\n";
        include("themes/admin/users-sidebar.php");
        echo "            </div> <!-- End Sidebar -->\n\n";

        include("themes/admin/footer.php");
        exit();
    }
    
    if ($row[5] == "systemDev" && $_SESSION['xi_userType'] != 'systemDev')
    {
        echo "\n                Permission Denied.
            \n<br />
            \n<br />
            <a href=\"./admins.php\">&lt; Go Back</a>
            \n        </div> <!-- End Main Column -->
                
                <div id=\"sidebar\">\n";
                
        include("themes/admin/users-sidebar.php");
        echo "            </div> <!-- End Sidebar -->\n\n";

        include("themes/admin/footer.php");
        exit();
    }
?>
                <h2>User Profile</h2>
                <form style="text-align:justify;" action="./edituser.php?type=<?php echo $_GET['type']; ?>&userid=<?php echo $_GET['userid']; ?>" method="post">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="200">Username</td>
                            <td width="200"><input type="text" readonly="readonly" name="username" size="22" maxlength="30" value="<?php echo $row[1]; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">First Name</td>
                            <td width="200"><input type="text" name="first_name" size="22" maxlength="20" value="<?php echo $row[2]; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">Last Name</td>
                            <td width="200"><input type="text" name="last_name" size="22" maxlength="30" value="<?php echo $row[3]; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">Email Address</td>
                            <td width="200"><input type="text" name="email" size="22" maxlength="40" value="<?php echo $row[4]; ?>" /></td>
                        </tr>
                        <?php
                            if ($_SESSION['xi_userType'] == 'systemDev' && $userType == "admin")
                            {
                                echo "<tr>
                                        <td width=\"200\">User Type</td>
                                        <td width=\"200\">
                                            <select name=\"userType\">";
                                                if ($row[5] == "admin")
                                                {
                                                    echo "<option value=\"admin\">Adminstrator</option>\n";
                                                    echo "                                    <option value=\"editor\">Editor</option>\n";
                                                    echo "                                    <option value=\"systemDev\">System Developer</option>\n";
                                                }
                                                else if ($row[5] == "editor")
                                                {
                                                    echo "<option value=\"editor\">Editor</option>\n";
                                                    echo "                                    <option value=\"admin\">Administrator</option>\n";
                                                    echo "                                    <option value=\"systemDev\">System Developer</option>\n";
                                                }
                                                else if ($row[5] == "systemDev")
                                                {
                                                    echo "<option value=\"systemDev\">System Developer</option>\n";
                                                    echo "                                    <option value=\"admin\">Administrator</option>\n";
                                                    echo "                                    <option value=\"editor\">Editor</option>\n";
                                                }
                                echo "            </select>
                                        </td>
                                    </tr>";
                            }
                        ?>
                    </table>
                    <br />
                    <hr />
                    <br />
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="200">New Password</td>
                            <td width="200"><input type="password" name="newpassword" size="22" maxlength="30" /></td>
                        </tr>
                        <tr>
                            <td width="200">Confirm New Password</td>
                            <td width="200"><input type="password" name="confirmnewpassword" size="22" maxlength="30" /></td>
                        </tr>
                    </table>
                    <br />
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td>
                                <input type="submit" name="submit" value="Update Profile" />
                                <input type="hidden" name="submitted" value="TRUE" />
                            </td>
                        </tr>
                    </table>
                </form>
<?php
    echo "            </div> <!-- End Main Column -->
            
            <div id=\"sidebar\">\n";
    include("themes/admin/users-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/admin/footer.php");  
?>