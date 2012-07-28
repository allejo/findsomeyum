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
        header("location:login.php");
    }
        
    //Let's pull the information from the database
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');
    
    include("includes/header.php");
    include("includes/menubar.php");

    $checkEmail = "SELECT email FROM members WHERE user_id = '" . XiON_getUserIDFromSession($dbc) . "'";
    $checkEmailData = @mysqli_query($dbc, $checkEmail) OR die ("Error:" . mysqli_error($dbc));
    $myEmail = mysqli_fetch_array($checkEmailData);

    $getPayPalStatus = "SELECT * FROM sales WHERE email = '" . $myEmail[0] . "' LIMIT 1";
    $getPayPalData = @mysqli_query($dbc, $getPayPalStatus);
    $isPayPalVerified = mysqli_num_rows($getPayPalData);
?>
    <div id="content">
    	<div class="account">
	    	<table border="0" width="100%" cellspacing="5">
	    		<tr>
	    			<td><a href="myrecipes.php"><img src="./imgs/sys/basket.png" /></a></td>
	    			<td><img src="./imgs/sys/chat.png" style="opacity: 0.3" /></td>
	    			<td><img src="./imgs/sys/messages.png" style="opacity: 0.3" /></td>
	    		</tr>
	    		<tr>
	    			<td>My Posts</td>
	    			<td><s>Chat</s></td>
	    			<td><s>Messages</s><td>
	    		</tr>
	    		<tr>
	    			<td><img src="./imgs/sys/search.png" style="opacity: 0.3" /></td>
	    			<td><a href="profile.php?user=<?php echo XiON_getUserIDFromSession($dbc); ?>"><img src="./imgs/sys/user.png" /></a></td>
	    			<td><a href="ucp.php"><img src="./imgs/sys/gear.png" /></a></td>
	    		</tr>
	    		<tr>
	    			<td><s>Search</s></td>
	    			<td>Profile</td>
	    			<td>Settings</td>
	    		</tr>
                <tr>
                    <td></td>
                    <td>
                        <br />
                        <br />
<?php
        if ($isPayPalVerified == 1)
        {
?>
                        <A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=RUFGB78GM37T6">
                            <IMG SRC="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
                        </A>
<?php
        }
        else
        {
?>
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="5TD7SD7HX46ZY">
                            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form>
<?php
        }
?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Premium Membership</td>
                    <td></td>
                </tr>
	    	</table>
    	</div>
    </div>
<?php
    include("includes/footer.php");
?>