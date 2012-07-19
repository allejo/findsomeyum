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
    include("includes/header.php");
    include("includes/menubar.php");
?>
                <div class="left_half">
                    <h2>User Login</h2>
                    <br />
                    <?php
                        if ($_GET['login'] == "false")
                        {
                            echo "<span align=\"center\" class=\"error\">Wrong username or password.</span><br />\n";
                        }
                    ?>
                    <form method="post" action="includes/checklogin.php">
                        <td>
                            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                <tr>
                                    <td width="78">Username</td>
                                    <td width="6">:</td>
                                    <td width="294"><input name="username" type="text" id="myusername"></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>:</td>
                                    <td><input name="password" type="password" id="mypassword"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" name="Submit" value="Login"></td>
                                </tr>
                            </table>
                        </td>
                    </form>
                </div> <!-- End .left_half -->
                
                <div class="right_half">
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
                </div> <!-- End .right_half -->
<?php
    include("includes/footer.php");
?>