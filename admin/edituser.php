<?php
    session_start();
    require_once("includes/mysql_connection.php");
    
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
    
    $getUserDatabase = "SELECT user_id, username, first_name, last_name, email, userType FROM users WHERE user_id = '" . $userToEdit . "'";
    $result = @mysqli_query($dbc, $getUserDatabase);
    $numberOfRows = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    
    if (isset($_POST['submitted']))
    {
        if (!empty($_POST['first_name']) && $_POST['first_name'] != $row[2])
        {
            $updateFirstNameQuery = "UPDATE `smchs`.`users` SET  `first_name` = '" . $_POST['first_name'] . "' WHERE `users`.`user_id` = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateFirstNameQuery);
        }
        
        if (!empty($_POST['last_name']) && $_POST['last_name'] != $row[3])
        {
            $updateLastNameQuery = "UPDATE `smchs`.`users` SET  `last_name` = '" . $_POST['last_name'] . "' WHERE `users`.`user_id` = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateLastNameQuery);
        }
        
        if (!empty($_POST['email']) && $_POST['email'] != $row[4])
        {
            
            $updateEmailQuery = "UPDATE `smchs`.`users` SET  `email` = '" . $_POST['email'] . "' WHERE `users`.`user_id` = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateEmailQuery);
        }
        
        if ($_POST['userType'] && $_POST['userType'] != $row[5])
        {
	        $updateEmailQuery = "UPDATE `smchs`.`users` SET  `userType` = '" . $_POST['userType'] . "' WHERE `users`.`user_id` = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updateEmailQuery);
        }
        
        if (!empty($_POST['newpassword']) && !empty($_POST['confirmnewpassword']) && $_POST['newpassword'] == $_POST['confirmnewpassword'])
        {
            $updatePasswordQuery = "UPDATE `smchs`.`users` SET  `pass` = '" . $_POST['newpassword'] . "' WHERE `users`.`user_id` = '" . $row[0] . "' LIMIT 1";
            $result = @mysqli_query($dbc, $updatePasswordQuery);
        }
        else if (empty($_POST['newpassword']) && empty($_POST['confirmnewpassword']))
        {
            //Do nothing
        }
        else
        {
            echo "<p class=\"error\">New passwords do not match.</p>";
        }
    }
?>
                <h2>User Profile</h2>
                <form style="text-align:justify;" action="./edituser.php?userid=<?php echo $_GET['userid']; ?>" method="post">
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
                        <tr>
                            <td width="200">User Type</td>
                            <td width="200">
                                <select name="userType">
                                    <?php
                                        if ($row[5] == "admin")
                                        {
                                            echo "                                    <option value=\"admin\">Adminstrator</option>";
                                            echo "                                    <option value=\"editor\">Editor</option>";
                                            echo "                                    <option value=\"systemDev\">System Developer</option>";
                                        }
                                        else if ($row[5] == "editor")
                                        {
                                            echo "                                    <option value=\"editor\">Editor</option>";
                                            echo "                                    <option value=\"admin\">Administrator</option>";
                                            echo "                                    <option value=\"systemDev\">System Developer</option>";
                                        }
                                        else if ($row[5] == "systemDev")
                                        {
                                            echo "                                    <option value=\"systemDev\">System Developer</option>";
                                            echo "                                    <option value=\"admin\">Administrator</option>";
                                            echo "                                    <option value=\"editor\">Editor</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
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
    include("themes/SMCHS/admin/users-sidebar.php");
    echo "            </div> <!-- End Sidebar -->\n\n";

    include("themes/SMCHS/admin/footer.php");  
?>