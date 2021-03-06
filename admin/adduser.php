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

    //Build the header and the navigation area
    include("themes/admin/header-top.php");
    echo "\n        <title>XiON: Add New User</title>\n";
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

    require_once("includes/mysql_connection.php"); //Connect to the MySQL database
    require_once("includes/auxiliaryFunctions.php");
    
    // Check if the form has been submitted:
    if (isset($_POST['submitted']))
    {
        $errors = array(); // Initialize an error array.
        
        //Santitation and checking if username exists already
        $username = trim($_POST['username']);
        $username = stripslashes($username);
        $username = mysqli_real_escape_string($dbc, $username);
        $checkUserNameQuery = "SELECT username FROM admins WHERE username = '$username'";
        $result = @mysqli_query($dbc, $checkUserNameQuery);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);
        //Check the first name
        if (empty($_POST['username']))
        {
            $errors[] = 'You forgot to enter your desired username.';
        }
        else if ($count == 1)
        {
            $errors[] = 'The specified username is not available.';
        }
        
        //Check the first name
        if (empty($_POST['first_name']))
        {
            $errors[] = 'You forgot to enter your first name.';
        }
        else
        {
            $first_name = trim($_POST['first_name']);
            $first_name = stripslashes($first_name);
            $first_name = mysqli_real_escape_string($dbc, $first_name);
        }
            
        //And check the last name...
        if (empty($_POST['last_name']))
        {
            $errors[] = 'You forgot to enter your last name.';
        }
        else
        {
            $last_name = trim($_POST['last_name']);
            $last_name = stripslashes($last_name);
            $last_name = mysqli_real_escape_string($dbc, $last_name);
        }
            
        //And check the email...
        if (empty($_POST['email']))
        {
            $errors[] = 'You forgot to enter your email.';
        }
        else
        {
            $email = trim($_POST['email']);
            $email = stripslashes($email);
            $email = mysqli_real_escape_string($dbc, $email);
        }
        
        //Check to make sure that the password and confirmation are the same and are valid
        if (!empty($_POST['pass1']) || !empty($_POST['pass2']))
        {
            if ($_POST[‘pass1’] != $_POST[‘pass2’])
            {
                $errors[] = 'Your passwords did not match.';
            }
            else
            {
                $password = trim($_POST['pass1']);
                $password = stripslashes($password);
                $password = mysqli_real_escape_string($dbc, $password);
            }
        }
        else
        {
            $errors[] = 'You forgot to enter your password.';
        }
        
        //Get the permissions for the user
        switch ($_POST['userType'])
        {
	        case 'none':
	        {
		        $errors[] = 'You forgot to specify the user type.';
	        }
	        break;
	        
	        case 'admin':
	        {
		        $userType = 'admin';
	        }
	        break;
	        
	        case 'editor':
	        {
		        $userType = 'editor';
	        }
	        break;
	        
	        case 'systemDev':
	        {
		        $userType = 'systemDev';
	        }
	        break;
        }
        
        $userType = stripslashes($userType);
        $userType = mysqli_real_escape_string($dbc, $userType);
        
        if (empty($errors)) //The user imputted all the fields perfectly without error
        {
			$logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'addUser', '$adminUserName', '$userIP', '$adminUserName created new user account for $username.')";
	        $run_query = @mysqli_query($dbc, $logQuery);
            
            $password = encryptPassword($username, $password);
            //Create the query, execute it, and save the values returned into an array
            $query = "INSERT INTO admin (user_id, username, first_name, last_name, email, pass, registration_date, userType) VALUES (NULL, '$username', '$first_name', '$last_name', '$email', '$password', NOW(), '$userType')";
            $run_query = @mysqli_query($dbc, $query) OR die ("sql error" . mysqli_error($dbc));
            
            if ($run_query) //Hurray no errors!
            {
                echo "<h2>Account Created Successfully</h2>
                      <p>   \nThe account is now available for immediate use.
                        \n<br />
                        \n<br />
                        \n<a href=\"./adduser.php\">&lt; Add Another User</a>
                        \n</p>";
                echo "\n            </div> <!-- End Main Column -->
                        <div id=\"sidebar\">\n";
                include("themes/admin/users-sidebar.php");
                echo "            </div> <!-- End Sidebar -->\n\n";
            }
            else //Crap. Something went wrong
            {
                echo "<h2>Account Creation Failed</h2>
                      <p>The account could not be created due to a system error. Please contact the system administrator.
                      \n<br />
                      \n<br />
                      \n<a href=\"./adduser.php\">&lt; Add Another User</a>
                      \n</p></p>";
            }
            
            mysqli_close($dbc); //This is redundant but it's a good habit
            
            include("themes/admin/footer.php");
            
            exit(); //We're done, prevent malicious code injection
        }
        else //The user forgot to fill in one of the fields
        {
            echo '<h2>Error!</h2>
                  <p class=”error”>The following error(s) occurred:<br />';
                
            foreach ($errors as $msg) //Go through all the errors and output them
            {
                echo " - $msg<br />\n";
            }
            
            echo "</p>\n<br />\n<p>Please try again.</p><p><br /></p>";
        }
    }
?>
                <h2>Add New User</h2>

                <form style="text-align:justify;" action="./adduser.php" method="post">
                    <table width="100%" border="0" cellpadding="3" cellspacing="1">
                        <tr>
                            <td width="200">Username</td>
                            <td width="200"><input type="text" name="username" size="22" maxlength="30" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">First Name</td>
                            <td width="200"><input type="text" name="first_name" size="22" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">Last Name</td>
                            <td width="200"><input type="text" name="last_name" size="22" maxlength="30" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">Email Address</td>
                            <td width="200"><input type="text" name="email" size="22" maxlength="40" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /></td>
                        </tr>
                        <tr>
                            <td width="200">Password</td>
                            <td width="200"><input type="password" name="pass1" size="22" maxlength="30" /></td>
                        </tr>
                        <tr>
                            <td width="200">Confirm Password</td>
                            <td width="200"><input type="password" name="pass2" size="22" maxlength="30" /></td>
                        </tr>
                        <tr>
                            <td width="200">User Type</td>
                            <td width="200">
                                <select name="userType">
                                    <option value="none">----------------</option>
                                    <option value="admin">Administrator</option>
                                    <option value="editor">Editor</option>
                                    <option value="systemDev">System Developer</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="submit" name="submit" value="Create User" />
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