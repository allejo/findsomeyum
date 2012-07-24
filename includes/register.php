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

    // Check if the form has been submitted:
    
    require_once('../admin/includes/mysql_connection.php');
    require_once('../admin/includes/auxiliaryFunctions.php');
    require_once('../../captcha/recaptchalib.php');
    $privatekey = "6Lc5-NMSAAAAAJ_Ysr2kj8aLfyALS_z9IeqiY5Rf";
    $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid)
    {
        // What happens when the CAPTCHA was entered incorrectly
        header("location:../register.php?register=false&issue=reCaptcha");
    }
    else
    {
       $errors = array(); // Initialize an error array.
    
        //Santitation and checking if username exists already
        $username = trim($_POST['username']);
        $username = stripslashes($username);
        $username = mysqli_real_escape_string($dbc, $username);
        $checkUserNameQuery = "SELECT username FROM members WHERE username = '$username'";
        $result = @mysqli_query($dbc, $checkUserNameQuery);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);
        //Check the first name
        if (empty($_POST['username']))
        {
            $errors[] = "username";
        }
        else if ($count == 1)
        {
            $errors[] = "unUnavailable";
        }
            
        //And check the email...
        if (empty($_POST['email']))
        {
            $errors[] = "email";
        }
        else
        {
            $email = trim($_POST['email']);
            $email = stripslashes($email);
            $email = mysqli_real_escape_string($dbc, $email);
        }
        
        //Check to make sure that the password and confirmation are the same and are valid
        if (!empty($_POST['pass1']) || !empty($_POST['pass2']))
        {
            if ($_POST[‘pass1’] != $_POST[‘pass2’])
            {
                $errors[] = "passM";
            }
            else
            {
                $password = trim($_POST['pass1']);
                $password = stripslashes($password);
                $password = mysqli_real_escape_string($dbc, $password);
            }
        }
        else
        {
            $errors[] = "pass";
        }
        
        if (empty($errors)) //The user imputted all the fields perfectly without error
        {
            $logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'registration', '$username', '$userIP', '$myusername created an account from $userIP')";
            $run_query = @mysqli_query($dbc, $logQuery);
    
            $password = encryptPassword($username, $password);
            //Create the query, execute it, and save the values returned into an array
            $query = "INSERT INTO members (user_id, username, first_name, last_name, email, pass, registration_date, premium) VALUES (NULL, '$username', '$first_name', '$last_name', '$email', '$password', NOW(), '0')";
            $run_query = @mysqli_query($dbc, $query) OR die ("sql error" . mysqli_error($dbc));
            
            if ($run_query) //Hurray no errors!
            {
                session_start();
                $_SESSION["ns_username"] = $username;
                session_register("ns_username");
                header("Location: ../recipes.php");
            }
            else //Crap. Something went wrong
            {
                include("includes/header.php");
                include("includes/menubar.php");
                echo "<h2>Fatal Error</h2>
                <p>An unknown fatal error, which should not have occured, has occured. Please contact the system <a href=\"mailto:allejo@me.com\">administrator</a> immediately.</p>";
                include("includes/footer.php");
            }
        }
        else //The user forgot to fill in one of the fields
        {
            $issues = "";
            foreach ($errors as $msg) //Go through all the errors and output them
            {
                $issues .= "$msg,";
            }
            
            header("location:../register.php?register=false&issue=$issues");
        }
    }
?>