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
	if(session_is_registered(xi_username))
	{
	    header("location:login_success.php");
	}

    include("themes/admin/header-top.php");
    echo "\n        <title>Administrator Login</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON Administration</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    
    if ($_GET['login'] == "false")
    {
        echo "            <p align=\"center\" class=\"error\">Username or password is incorrect.</p><br />\n\n";
    }
?>
            <div align="center">
                <table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                    <tr>
                        <form name="form1" method="post" action="includes/checklogin.php">
                            <td>
                                <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                                    <tr>
                                        <td colspan="3"><strong>Adminstrator Login </strong></td>
                                    </tr>
                                    <tr>
                                        <td width="78">Username</td>
                                        <td width="294"><input name="username" type="text" id="myusername" value="<?php echo $_SESSION['ns_username']; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td><input name="password" type="password" id="mypassword"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><input type="submit" name="Submit" value="Login"></td>
                                    </tr>
                                </table>
                            </td>
                        </form>
                    </tr>
                </table>
            </div>
            
<?php
    include("themes/admin/footer.php");
?>