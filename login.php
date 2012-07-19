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
            <div id="content">
                <div class="center">
                    <h2>User Login</h2>
                    <br />
                    <?php
                        if ($_GET['login'] == "false")
                        {
                            echo "<span class=\"error\">Wrong username or password.</span><br />\n";
                        }
                    ?>
<form method="post" action="includes/checklogin.php">
                        <td>
                            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                                <tr>
                                    <td width="78">Username</td>
                                    <td width="294"><input name="username" type="text" id="myusername"></td>
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
                </div>
            </div>
<?php
    include("includes/footer.php");
?>