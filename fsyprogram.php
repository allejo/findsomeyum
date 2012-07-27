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
    
    include("includes/header.php");
    include("includes/menubar.php");

    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');
    
    $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
    $paypal_id='wRUFGB78GM37T6';  // sriniv_1293527277_biz@inbox.com
?>
            <div id="content" class="clearfix">
<?php
echo $row[2] . "
                <br />
                <br />
                <br />";

    if (session_is_registered(ns_username))
    {
        $checkEmail = "SELECT email FROM members WHERE user_id = '" . XiON_getUserIDFromSession($dbc) . "'";
        $checkEmailData = @mysqli_query($dbc, $checkEmail) OR die ("Error:" . mysqli_error($dbc));
        $myEmail = mysqli_fetch_array($checkEmailData);

        $getPayPalStatus = "SELECT * FROM sales WHERE email = '" . $myEmail[0] . "' LIMIT 1";
        $getPayPalData = @mysqli_query($dbc, $getPayPalStatus);
        $isPayPalVerified = mysqli_num_rows($getPayPalData);
?>
                <!-- Annual Classes -->
                <span>Annual Classes $1600</span>
                <div class="right_side" align="center">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="XSLNDSNVVKYXG">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
                <br />
                <br />
                <br />
                <br />
                <!-- Monthly Classes -->
                <span>Monthly Class $150</span>
                <div class="right_side" align="center">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="SD7X5EKXVTPK4">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
                <br />
                <br />
                <br />
                <br />

<?php
        if ($isPayPalVerified == 1)
        {
?>

                <span>Website Membership</span>
                <div class="right_side" align="center">
                    <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=RUFGB78GM37T6">
                        <IMG SRC="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
                    </A>
                </div>
            </div> <!-- End #content -->
<?php
        }
        else
        {
?>
                <!-- Membership For Website -->
                <span>Website Membership</span>
                <div class="right_side" align="center">
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="5TD7SD7HX46ZY">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </div>
            </div> <!-- End #content -->
<?php
        }
    }
    else
    {
        echo "                <div class=\"login\">
                    Please <a href=\"#login-box\" class=\"download_button orange links login-window\">login</a> or <a href=\"#register-box\" class=\"download_button orange links login-window\">register</a> to continue with a transaction.
                </div> <!-- End .login -->
            </div> <!-- End #content -->\n";
    }
    include("includes/footer.php");
?>