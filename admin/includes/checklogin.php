<?php
    ob_start();
    
    require_once('mysql_connection.php');
    
    // Define $myusername and $mypassword 
    $myusername=$_POST['username']; 
    $mypassword=$_POST['password']; 
    
    // To protect MySQL injection (more detail about MySQL injection)
    $myusername = stripslashes($myusername);
    $mypassword = stripslashes($mypassword);
    $myusername = mysqli_real_escape_string($dbc, $myusername);
    $mypassword = mysqli_real_escape_string($dbc, $mypassword);
    
    $sql = "SELECT * FROM users WHERE username='$myusername' AND pass=SHA1('$mypassword')";
    $result = @mysqli_query($dbc, $sql);
    
    // Mysql_num_row is counting table row
    $count = mysqli_num_rows($result);
    
    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count == 1)
    {
    	$row = mysqli_fetch_array($result);
        session_start();
        $_SESSION["xi_username"] = $myusername;
        $_SESSION["xi_firstName"] = $row[2];
        $_SESSION["xi_userType"] = $row[8];
        session_register("xi_username");
        header("location:../login_success.php");
    }
    else
    {
        echo "Wrong Username or Password";
    }
    
    ob_end_flush();
?>