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
    
    if (session_is_registered(ns_username))
    {
	    header ("location: recipes.php");
    }
    
    include("includes/header.php");
    include("includes/menubar.php");
?>
				<div id="content">
					<h2>Register</h2>
                    <h6>All fields are required</h6>
                    <br />
                    <?php
                        $myErrors = explode(",", $_GET["issue"]);
                        
                        foreach ($myErrors as $msg) //Some errors occured, list them out
                        {
                            if ($_GET['register'] == "false" && $msg == "username")
                            {
                                echo "<span align=\"center\" class=\"error\">You forgot to enter your desired username.</span><br />\n";
                            }
                            if ($_GET['register'] == "false" && $msg == "unUnavailable")
                            {
                                echo "                    <span align=\"center\" class=\"error\">The specified username is not available.</span><br />\n";
                            }
                            if ($_GET['register'] == "false" && $msg == "email")
                            {
                                echo "                    <span align=\"center\" class=\"error\">You forgot to enter your email.</span><br />\n";
                            }
                            if ($_GET['register'] == "false" && $msg == "passM")
                            {
                                echo "                    <span align=\"center\" class=\"error\">Your passwords did not match.</span><br />\n";
                            }
                            if ($_GET['register'] == "false" && $msg == "pass")
                            {
                                echo "                    <span align=\"center\" class=\"error\">You forgot to enter your password.</span><br />\n";
                            }
                        }
                    ?>
                    <form style="text-align:justify;" action="./includes/register.php" method="post">
                        <table width="100%" border="0" cellpadding="3" cellspacing="1">
                            <tr>
                                <td width="200">Username</td>
                                <td width="200"><input type="text" name="username" size="22" maxlength="30" value="<?php if (isset($_GET['username'])) echo $_GET['username']; ?>" /></td>
                            </tr>
                            <tr>
                                <td width="200">Email Address</td>
                                <td width="200"><input type="text" name="email" size="22" maxlength="40" value="<?php if (isset($_GET['email'])) echo $_GET['email']; ?>" /></td>
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
                                <td colspan="2" align="center">
                                    <?php
                                        foreach ($myErrors as $msg)
                                        {
                                            if ($_GET['register'] == "false" && $msg == "reCaptcha")
                                            {
                                                echo "            <span align=\"center\" class=\"error\">The reCaptcha was not entered correctly.</span>\n\n";
                                            }
                                        }
                                        
                                        require_once('../captcha/recaptchalib.php');
                                        $publickey = "6Lc5-NMSAAAAAFeAgEf4CpV3J5ijBHix1NrKky5E";
                                        echo recaptcha_get_html($publickey);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <input type="submit" name="submit" value="Register" />
                                    <input type="hidden" name="submitted" value="TRUE" />
                                </td>
                            </tr>
                        </table>
                    </form>
				</div>
<?php
    include("includes/footer.php");
?>