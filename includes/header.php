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
        $(document).ready(function()
        {
            $('a.login-window').click(function()
            {
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
            $('a.close, #mask').live('click', function()
            { 
                $('#mask , .login-popup').fadeOut(300 , function()
                {
                    $('#mask').remove();  
                }); 
            
                return false;
            });
            
            // star 1
            $('#star1').mouseover(function()
            {
                $('#star1').css('background', 'url("imgs/star_m.png")');
            });
            $('#star1').mouseout(function()
            {
                $('#star1').css('background', 'url("imgs/star_m_empty.png")');
            });
            
            // star 2
            $('#star2').mouseover(function()
            {
                $('#star1').css('background', 'url("imgs/star_m.png")');
                $('#star2').css('background', 'url("imgs/star_m.png")');
            });
            $('#star2').mouseout(function()
            {
                $('#star1').css('background', 'url("imgs/star_m_empty.png")');
                $('#star2').css('background', 'url("imgs/star_m_empty.png")');
            });
            
            // star 3
            $('#star3').mouseover(function()
            {
                $('#star1').css('background', 'url("imgs/star_m.png")');
                $('#star2').css('background', 'url("imgs/star_m.png")');
                $('#star3').css('background', 'url("imgs/star_m.png")');
            });
            $('#star3').mouseout(function()
            {
                $('#star1').css('background', 'url("imgs/star_m_empty.png")');
                $('#star2').css('background', 'url("imgs/star_m_empty.png")');
                $('#star3').css('background', 'url("imgs/star_m_empty.png")');
            });
            
            // star 4
            $('#star4').mouseover(function()
            {
                $('#star1').css('background', 'url("imgs/star_m.png")');
                $('#star2').css('background', 'url("imgs/star_m.png")');
                $('#star3').css('background', 'url("imgs/star_m.png")');
                $('#star4').css('background', 'url("imgs/star_m.png")');
            });
            $('#star4').mouseout(function()
            {
                $('#star1').css('background', 'url("imgs/star_m_empty.png")');
                $('#star2').css('background', 'url("imgs/star_m_empty.png")');
                $('#star3').css('background', 'url("imgs/star_m_empty.png")');
                $('#star4').css('background', 'url("imgs/star_m_empty.png")');
            });
            
            // star 5
            $('#star5').mouseover(function()
            {
                $('#star1').css('background', 'url("imgs/star_m.png")');
                $('#star2').css('background', 'url("imgs/star_m.png")');
                $('#star3').css('background', 'url("imgs/star_m.png")');
                $('#star4').css('background', 'url("imgs/star_m.png")');
                $('#star5').css('background', 'url("imgs/star_m.png")');
            });
            $('#star5').mouseout(function()
            {
                $('#star1').css('background', 'url("imgs/star_m_empty.png")');
                $('#star2').css('background', 'url("imgs/star_m_empty.png")');
                $('#star3').css('background', 'url("imgs/star_m_empty.png")');
                $('#star4').css('background', 'url("imgs/star_m_empty.png")');
                $('#star5').css('background', 'url("imgs/star_m_empty.png")');
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
            <a href="#" class="close"><img src="imgs/close_pop.png" style="margin-left: 320px" class="btn_close" title="Close Window" alt="Close" /></a>
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
                    <br />
                    <input type="submit" name="Submit" value="Login">
                </fieldset>
            </form>
        </div>
<?php
	if (!strstr($_SERVER['PHP_SELF'], "register.php"))
	{
?>
        <div id="register-box" class="login-popup">
            <a href="#" class="close"><img src="imgs/close_pop.png" style="margin-left: 320px" class="btn_close" title="Close Window" alt="Close" /></a>
            <form method="post" class="signin" action="includes/register.php">
                <fieldset class="textbox">
                    <label class="username">
                        <span>Username</span>
                        <input name="username" type="text" id="username" autocomplete="on" placeholder="Username">
                    </label>
                    <label class="email">
                        <span>Email</span>
                        <input name="email" type="text" id="email" autocomplete="on" placeholder="Email">
                    </label>
                    <label class="password">
                        <span>Password</span>
                        <input name="pass1" type="password" id="pass1" placeholder="Password">
                    </label>
                    <label class="password">
                        <span>Confirm Password</span>
                        <input name="pass2" type="password" id="pass2" placeholder="Confirm Password">
                    </label>
                    <?php
                        require_once('../captcha/recaptchalib.php');
                        $publickey = "6Lc5-NMSAAAAAFeAgEf4CpV3J5ijBHix1NrKky5E";
                        echo recaptcha_get_html($publickey);
                    ?>
                    <br />
                    <input type="submit" name="Submit" value="Register">
                </fieldset>
            </form>
        </div>
    <?php
    	}
        }
    ?>
        <div id="wrapper">
            <div id="topMenuBar">
                <a href="index.php" class="logo"><img src="./imgs/findsomeyum_logo.png" height="80"></a>