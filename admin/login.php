<?php
    include("themes/SMCHS/admin/header-top.php");
    echo "\n        <title>Administrator Login</title>\n";
    include("themes/SMCHS/admin/header-middle.php");
    echo "\n                <h1>XiON Administration</h1>\n";
    include("themes/SMCHS/admin/header-bottom.php");
    include("themes/SMCHS/admin/menubar.php");
    include("themes/SMCHS/admin/header-end.php");
    echo"\n";
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
                    </tr>
                </table>
            </div>
<?php
    include("themes/SMCHS/admin/footer.php");
?>