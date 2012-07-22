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
    
    if(!session_is_registered(ns_username)) //If the user is not logged in, make them login
    {
        header("location:membership.php");
    }
        
    //Let's pull the information from the database
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');
    $myusername = $_SESSION['ns_username'];
    $sql = "SELECT * FROM members WHERE username='$myusername'";
    $result = @mysqli_query($dbc, $sql) OR die ("Error: " . mysqli_error($dbc));
    $myUserData = mysqli_fetch_array($result);
    
    if (isset($_POST['submitted'])) //If the user submitted the form
    {
        $newFirstName = $_POST['first_name'];
        $newLastName = $_POST['last_name'];
        $newEmail = $_POST['email'];
                
        if (encryptPassword($_SESSION['ns_username'], $_POST['currentpassword']) == $myUserData[5]) //If the current password is correct
        {
            if (!empty($_POST['first_name']) && $_POST['first_name'] != $myUserData[2])
            {
                $newFirstName = stripslashes($newFirstName);
                $newFirstName = mysqli_real_escape_string($dbc, $newFirstName);
            
                $updateFirstNameQuery = "UPDATE members SET first_name = '" . $newFirstName . "' WHERE members.user_id = '" . $myUserData[0] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateFirstNameQuery);
            }
            if (!empty($_POST['last_name']) && $_POST['last_name'] != $myUserData[3])
            {
                $newLastName = stripslashes($newLastName);
                $newLastName = mysqli_real_escape_string($dbc, $newLastName);
                
                $updateLastNameQuery = "UPDATE members SET last_name = '" . $newLastName . "' WHERE members.user_id = '" . $myUserData[0] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateLastNameQuery);
            }
            if (!empty($_POST['email']) && $_POST['email'] != $myUserData[4])
            {
                $newEmail = stripslashes($newEmail);
                $newEmail = mysqli_real_escape_string($dbc, $newEmail);
            
                $updateEmailQuery = "UPDATE members SET email = '" . $newEmail . "' WHERE members.user_id = '" . $myUserData[0] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateEmailQuery);
            }
            
            if (!empty($_POST['newpassword']) && !empty($_POST['confirmnewpassword']) && $_POST['newpassword'] == $_POST['confirmnewpassword'])
            {
                $newPassword = $_POST['newpassword'];
                $newPassword = stripslashes($newPassword);
                $newPassword = mysqli_real_escape_string($dbc, $newPassword);
                $newPassword = encryptPassword($_SESSION['ns_username'], $newPassword);
                
                $updatePasswordQuery = "UPDATE members SET pass = '" . $newPassword . "' WHERE user_id = '" . $myUserData[0] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updatePasswordQuery);
            }
            else if (empty($_POST['newpassword']))
            {
                //Purposely do nothing...
            }
            else
            {
                header("location: account.php?error=npass");
                exit();
            }
        }
        else
        {
            header("location: account.php?error=pass");
            exit();
        }
        
        header("location: account.php");
        exit();
    }
    
    include("includes/header.php");
    include("includes/menubar.php");
    
    if (isset($_GET['error']))
    {
        if ($_GET['error'] == "npass")
        {
            echo "<p class=\"error\">Your new passwords did not match</p>";
        }
        else if ($_GET['error'] == "pass")
        {
            echo "<p class=\"error\">Invalid current password.</p>";
        }
    }
?>
                <div id="content">
                <h2>User Profile</h2>
                <br />
                <p>
                    <em>You must confirm your current password if you wish to change it, alter your e-mail address or name.</em>
                </p>
                <br />
                <form style="text-align:justify;" action="./account.php" method="post">
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
                            <td width="200"><input type="text" readonly="readonly" name="username" size="22" maxlength="30" value="<?php echo "{$_SESSION['ns_username']}"; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">First Name</td>
                            <td width="200"><input type="text" name="first_name" size="22" maxlength="20" value="<?php echo $myUserData[3]; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">Last Name</td>
                            <td width="200"><input type="text" name="last_name" size="22" maxlength="30" value="<?php echo $myUserData[4]; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">Email Address</td>
                            <td width="200"><input type="text" name="email" size="22" maxlength="40" value="<?php echo $myUserData[5]; ?>" /></td>
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
                    <hr />
                    <br />
                    <br />
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
            </div>
<?php
    include("includes/footer.php");
?>