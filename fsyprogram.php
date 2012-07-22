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
    
    $paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; 
    $paypal_id='wRUFGB78GM37T6';  // sriniv_1293527277_biz@inbox.com
?>
            <div id="content">
                <?php echo $row[2]; ?>
<?php
            require_once("admin/includes/mysql_connection.php");
            $result = @mysqli_query($dbc, "SELECT * from products");
            while($row = mysqli_fetch_array($result))
            {
?>
            <!-- Subscribe Button -->
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="DMBNZHNRJE7CC">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>

            <!--
            <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=RUFGB78GM37T6">
            <IMG SRC="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
            </A>
            -->

            <!-- Monthly Classes Payment -->
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="UKUNE4DD6J7VS">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>

            <!-- Annual Classes Payment -->
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="GREERAW2KJEJA">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>

            <div class="product">
                <div class="name">
                        <?php echo $row['product'];?>
                </div>
                <div class="price">
                    Price: $<?php echo $row['price'];?>
                </div>
                <div class="btn">
                    <form action='<?php echo $paypal_url; ?>' method='post' name='frmPayPal1'>
                        <input type='hidden' name='business' value='<?php echo $paypal_id;?>'>
                        <input type='hidden' name='cmd' value='_xclick'>

                        <input type='hidden' name='item_name' value='<?php echo $row['product'];?>'>
                        <input type='hidden' name='item_number' value='<?php echo $row['pid'];?>'>
                        <input type='hidden' name='amount' value='<?php echo $row['price'];?>'>

                        <input type='hidden' name='no_shipping' value='1'>
                        <input type='hidden' name='currency_code' value='USD'>
                        <input type='hidden' name='handling' value='0'>
                        <input type='hidden' name='cancel_return' value='http://localhost/paypal/cancel.php'>
                        <input type='hidden' name='return' value='http://localhost/paypal/success.php'>

                        <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form> 
                </div>
            </div>
                <?php
            }
            ?>
        </div>
<?php
    include("includes/footer.php");
?>