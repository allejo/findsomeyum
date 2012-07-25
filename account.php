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
?>
    <div id="content">
    	<div class="account">
	    	<table border="0" width="100%" cellspacing="5">
	    		<tr>
	    			<td><a href="myrecipes.php"><img src="./imgs/sys/basket.png" /></a></td>
	    			<td><a href="#"><img src="./imgs/sys/chat.png" /></a></td>
	    			<td><a href="#"><img src="./imgs/sys/messages.png" /></a></td>
	    		</tr>
	    		<tr>
	    			<td>My Recipes</td>
	    			<td>Chat (Coming Soon)</td>
	    			<td>Messages (Coming Soon)</td>
	    		</tr>
	    		<tr>
	    			<td><a href="#"><img src="./imgs/sys/search.png" /></a></td>
	    			<td><a href="profile.php?user=<?php echo XiON_getUserIDFromSession($dbc); ?>"><img src="./imgs/sys/user.png" /></a></td>
	    			<td><a href="ucp.php"><img src="./imgs/sys/gear.png" /></a></td>
	    		</tr>
	    		<tr>
	    			<td>Search (Coming Soon)</td>
	    			<td>Profile</td>
	    			<td>Settings</td>
	    		</tr>
	    	</table>
    	</div>
    </div>
<?php
    include("includes/footer.php");
?>