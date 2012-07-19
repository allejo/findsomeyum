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
    
    //include("./admin/includes/detectMobile.php");
    
    session_start();
    require_once("./admin/includes/mysql_connection.php");
    require_once("./admin/includes/auxiliaryFunctions.php");
    
    $currentFile = $_SERVER["PHP_SELF"];
    $phpMySelf = explode('/', $currentFile);
    
    $query = "SELECT * FROM content WHERE page_name = '" . $phpMySelf[count($phpMySelf) - 1] . "'";
    $result = @mysqli_query($dbc, $query) OR die ("Error: " . mysqli_error($dbc));
    $row = mysqli_fetch_array($result);
?>
<html>
    <!--
        XiON, Copyright Sujevo Software, 2012. All Rights Reserved.
        http://sujevo.com
        
        This page was generated with XiON, a closed source software.
        All content on this website is copyright of it's appropriate
        owner.
    -->
    
    <head> 
        <title>FindSomeYum: <?php echo $row[1]; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.js"></script>
        <link rel="stylesheet" type="text/css" href="./includes/buttons.css" />
        <link rel="stylesheet" type="text/css" href="./includes/jquery.css" />
        <link rel="stylesheet" type="text/css" href="./includes/styles.css" />
        <link rel="apple-touch-icon" href="./imgs/iFSY.jpg" />
    </head>
    
    <script>
        $(document).ready(function() {
        	$('a.login-window').click(function() {
        		
                        //Getting the variable's value from a link 
        		var loginBox = $(this).attr('href');
        
        		//Fade in the Popup
        		$(loginBox).fadeIn(300);
        		
        		//Set the center alignment padding + border see css style
        		var popMargTop = ($(loginBox).height() + 24) / 2; 
        		var popMargLeft = ($(loginBox).width() + 24) / 2; 
        		
        		$(loginBox).css({ 
        			'margin-top' : -popMargTop,
        			'margin-left' : -popMargLeft
        		});
        		
        		// Add the mask to body
        		$('body').append('<div id="mask"></div>');
        		$('#mask').fadeIn(300);
        		
        		return false;
        	});
        	
        	// When clicking on the button close or the mask layer the popup closed
        	$('a.close, #mask').live('click', function() { 
        	  $('#mask , .login-popup').fadeOut(300 , function() {
        		$('#mask').remove();  
        	}); 
        	return false;
        	});
        });
    </script>
    
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-33396562-1']);
        _gaq.push(['_setDomainName', 'findsomeyum.com']);
        _gaq.push(['_trackPageview']);
        
        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    
    <body>
    <?php
        if (!session_is_registered(ns_username))
        {
    ?>
        <div id="login-box" class="login-popup">
            <form method="post" class="signin" action="includes/checklogin.php">
                <fieldset class="textbox">
                	<label class="username">
                        <span>Username</span>
                        <input name="username" type="text" id="myusername" autocomplete="on" placeholder="Username">
                    </label>
                    <label class="password">
                        <span>Password</span>
                        <input name="password" type="password" id="mypassword" placeholder="Password">
                    </label>
                    <input type="submit" name="Submit" value="Login">
                </fieldset>
            </form>
        </div>
    <?php
        }
    ?>
        <div id="wrapper">
            <div id="topMenuBar">
                <a href="index.php" class="logo"><img src="./imgs/findsomeyum_logo.png" height="80"></a>