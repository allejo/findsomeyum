<?php
    session_start();
    
    if(!session_is_registered(xi_username)) //If the user is not logged in, make them login
    {
        header("location:login.php");
    }
    
    include("themes/SMCHS/admin/header-top.php");
    echo "\n        <title>XiON Administration Control Panel</title>\n";
    include("themes/SMCHS/admin/header-middle.php");
    echo "\n                <h1>XiON User Management</h1>\n";
    include("themes/SMCHS/admin/header-bottom.php");
    include("themes/SMCHS/admin/menubar.php");
    include("themes/SMCHS/admin/header-end.php");
    echo"\n";
    echo "\n            <div id=\"main_column\">\n";
    
    //Let's pull the information from the database
    require_once('includes/mysql_connection.php');
    $myusername = $_SESSION['xi_username'];
    $sql = "SELECT * FROM users WHERE username='$myusername'";
    $result = @mysqli_query($dbc, $sql);
    $row = mysqli_fetch_array($result);
    
    if (isset($_POST['submitted']))
    {
        $errors = array(); // Initialize an error array.
        
        if (sha1($_POST['currentpassword']) == $row[5])
        {
            if (!empty($_POST['first_name']) && $_POST['first_name'] != $row[2])
            {
                $updateFirstNameQuery = "UPDATE `smchs`.`users` SET `first_name` = '" . $_POST['first_name'] . "' WHERE `users`.`user_id` = " . $row[0] . " LIMIT 1";
                $result = @mysqli_query($dbc, $updateFirstNameQuery);
            }
            if (!empty($_POST['last_name']) && $_POST['last_name'] != $row[3])
            {
                $updateLastNameQuery = "UPDATE `smchs`.`users` SET  `last_name` = " . $_POST['last_name'] . " WHERE `users`.`user_id` = " . $row[0] . " LIMIT 1";
                $result = @mysqli_query($dbc, $updateLastNameQuery);
            }
            if (!empty($_POST['email']) && $_POST['email'] != $row[4])
            {
                
                $updateEmailQuery = "UPDATE `smchs`.`users` SET  `email` = " . $_POST['email'] . " WHERE `users`.`user_id` = " . $row[0] . " LIMIT 1";
                $result = @mysqli_query($dbc, $updateEmailQuery);
            }
            
            if (!empty($_POST['newpassword']) && !empty($_POST['confirmnewpassword']) && $_POST['newpassword'] == $_POST['confirmnewpassword'])
            {
                $updatePasswordQuery = "UPDATE `smchs`.`users` SET  `pass` = SHA1(" . $_POST['newpassword'] . "') WHERE `users`.`user_id` = " . $row[0] . " LIMIT 1";
                $result = @mysqli_query($dbc, $updatePasswordQuery);
            }
            else if (empty($_POST['newpassword']))
            {
                //Purposely do nothing...
            }
            else
            {
                echo "<p class=\"error\">New passwords do not match.</p>";
            }
            
            header("location:usermanagement.php");
        }
        else
        {
            echo "<p class=\"error\">Invalid current password.</p>";
        }
    }
?>
                <h2>User Profile</h2>
                <p>
                    You must confirm your current password if you wish to change it, alter your e-mail address or name.
                </p>
                <br />
                <form style="text-align:justify;" action="./usermanagement.php" method="post">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="200">Current Password</td>
                            <td width="200"><input type="password" name="currentpassword" size="22" maxlength="30" /></td>
                        </tr>
                    </table>
                    <br />
                    <hr />
                    <br />
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="200">Username</td>
                            <td width="200"><input type="text" readonly="readonly" name="username" size="22" maxlength="30" value="<?php echo "{$_SESSION['xi_username']}"; ?>" /></td>
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