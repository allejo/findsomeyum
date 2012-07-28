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
        header("location:membership.php");
    }
        
    //Let's pull the information from the database
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');
    $myusername = $_SESSION['ns_username'];
    $sql = "SELECT * FROM members WHERE username='$myusername'";
    $result = @mysqli_query($dbc, $sql) OR die ("Error: " . mysqli_error($dbc));
    $myUserData = mysqli_fetch_array($result);
    
    if (isset($_POST['submitted'])) //If the user submitted the form
    {
        $errors = array();

        $newFirstName = $_POST['first_name'];
        $newLastName = $_POST['last_name'];
        $newEmail = $_POST['email'];
        $newGender = $_POST['gender'];
        $newBDay = $_POST['bday'];
        $newJob = $_POST['job'];
        $newHobbies = $_POST['hobbies'];
        $newBio = $_POST['bio'];
        $newRank = $_POST['rank'];
                
        if (encryptPassword($_SESSION['ns_username'], $_POST['currentpassword']) == $myUserData['pass']) //If the current password is correct
        {
            if (!empty($_POST['first_name']) && $_POST['first_name'] != $myUserData['first_name'])
            {
                $newFirstName = stripslashes($newFirstName);
                $newFirstName = mysqli_real_escape_string($dbc, $newFirstName);
            
                $updateFirstNameQuery = "UPDATE members SET first_name = '" . $newFirstName . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateFirstNameQuery);
            }
            if (!empty($_POST['last_name']) && $_POST['last_name'] != $myUserData['last_name'])
            {
                $newLastName = stripslashes($newLastName);
                $newLastName = mysqli_real_escape_string($dbc, $newLastName);
                
                $updateLastNameQuery = "UPDATE members SET last_name = '" . $newLastName . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateLastNameQuery);
            }
            if (!empty($_POST['email']) && $_POST['email'] != $myUserData['email'])
            {
                $newEmail = stripslashes($newEmail);
                $newEmail = mysqli_real_escape_string($dbc, $newEmail);
            
                $updateEmailQuery = "UPDATE members SET email = '" . $newEmail . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateEmailQuery);
            }
            if (!empty($_POST['gender']) && $_POST['gender'] != $myUserData['gender'])
            {
                $newGender = stripslashes($newGender);
                $newGender = mysqli_real_escape_string($dbc, $newGender);
            
                $updateGenderQuery = "UPDATE members SET gender = '" . $newGender . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateGenderQuery);
            }
            if (!empty($_POST['bday']) && $_POST['bday'] != $myUserData['birthday'])
            {
                $newBDay = stripslashes($newBDay);
                $newBDay = mysqli_real_escape_string($dbc, $newBDay);
            
                $updateBDayQuery = "UPDATE members SET birthday = '" . $newBDay . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateBDayQuery);
            }
            if (!empty($_POST['job']) && $_POST['job'] != $myUserData['job'])
            {
                $newJob = stripslashes($newJob);
                $newJob = mysqli_real_escape_string($dbc, $newJob);
            
                $updateJobQuery = "UPDATE members SET job = '" . $newJob . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateJobQuery);
            }
            if (!empty($_POST['hobbies']) && $_POST['hobbies'] != $myUserData['hobbies'])
            {
                $newHobbies = stripslashes($newHobbies);
                $newHobbies = mysqli_real_escape_string($dbc, $newHobbies);
            
                $updateHobbiesQuery = "UPDATE members SET hobbies = '" . $newHobbies . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateHobbiesQuery);
            }
            if (!empty($_POST['bio']) && $_POST['bio'] != $myUserData['bio'])
            {
                $newBio = stripslashes($newBio);
                $newBio = mysqli_real_escape_string($dbc, $newBio);
            
                $updateBioQuery = "UPDATE members SET bio = '" . $newBio . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateBioQuery);
            }
            if (!empty($_POST['rank']) && $_POST['rank'] != $myUserData['rank'])
            {
                $newRank = stripslashes($newRank);
                $newRank = mysqli_real_escape_string($dbc, $newRank);
            
                $updateRankQuery = "UPDATE members SET rank = '" . $newRank . "' WHERE members.user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updateRankQuery);
            }
            
            if (!empty($_POST['newpassword']) && !empty($_POST['confirmnewpassword']) && $_POST['newpassword'] == $_POST['confirmnewpassword'])
            {
                $newPassword = $_POST['newpassword'];
                $newPassword = stripslashes($newPassword);
                $newPassword = mysqli_real_escape_string($dbc, $newPassword);
                $newPassword = encryptPassword($_SESSION['ns_username'], $newPassword);
                
                $updatePasswordQuery = "UPDATE members SET pass = '" . $newPassword . "' WHERE user_id = '" . $myUserData['user_id'] . "' LIMIT 1";
                $result = @mysqli_query($dbc, $updatePasswordQuery);
            }
            else if (empty($_POST['newpassword']))
            {
                //Purposely do nothing...
            }
            else
            {
                $errors[] = 'Your new passwords did not match';
            }
        }
        else
        {
            $errors[] = 'Invalid current password';
        }
        
        if (empty($errors))
        {
            header("location: ucp.php");
        }
    }
    
    include("includes/header.php");
    include("includes/menubar.php");
?>
                <div id="content">
                <h2>User Profile</h2>
<?php
    if (!empty($errors))
    {
        foreach ($errors as $msg)
        {
            echo "<p class=\"error\">" . $msg . "</p>";
        }
    }
?>
                <br />
                <p>
                    <em>You must confirm your current password if you wish to change it, alter your e-mail address or name.</em>
                </p>
                <br />
                <form style="text-align:justify;" action="./ucp.php" method="post">
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Current Password</span>
                        <input style="float: left" type="password" name="currentpassword" size="22" maxlength="30" />
                    </div>
                    <br />
                    <hr />
                    <br />
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Username</span>
                        <input style="float: left" type="text" readonly="readonly" name="username" size="22" maxlength="30" value="<?php echo "{$_SESSION['ns_username']}"; ?>" />
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">First Name</span>
                        <input style="float: left" type="text" name="first_name" size="22" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; else echo $myUserData['first_name']; ?>" />
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Last Name</span>
                        <input style="float: left" type="text" name="last_name" size="22" maxlength="30" value="<?php if (isset($_POST['last_name'])) {echo $_POST['last_name'];} else {echo $myUserData['last_name'];} ?>" /></td>
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Email</span>
                        <input style="float: left" type="text" name="email" size="22" maxlength="40" value="<?php if (isset($_POST['email'])) {echo $_POST['email'];} else {echo $myUserData['email'];} ?>" />
                    </div>
                    <br />
                    <hr />
                    <br />
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Gender</span>
                        <input type="radio" name="gender" value="F" <?php if ((isset($_POST['gender']) && $_POST['gender'] == "F") || $myUserData['gender'] == "F") {echo " checked";} ?>><small>Female</small>
                        <input type="radio" name="gender" value="M" <?php if ((isset($_POST['gender']) && $_POST['gender'] == "M") || $myUserData['gender'] == "M") {echo " checked";} ?>><small>Male</small>
                        <input type="radio" name="gender" value="" <?php if ((isset($_POST['gender']) && $_POST['gender'] == "") || $myUserData['gender'] == "") {echo " checked";} ?>> <small>Prefer not to Answer</small>
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Birthday</span>
                        <input style="float:left" id="bday" name="bday" size="22" maxlength="30" value="<?php if (isset($_POST['bday'])) {echo $_POST['bday'];} else {echo $myUserData['birthday'];} ?>"> <tt><em>(YYYY-MM-DD)</em></tt>
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Job</span>
                        <input style="float: left" type="text" name="job" size="22" maxlength="50" value="<?php if (isset($_POST['job'])) {echo $_POST['job'];} else {echo $myUserData['job'];} ?>" />
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Hobbies</span>
                        <input style="float:left" type="text" name="hobbies" size="22" maxlength="50" value="<?php if (isset($_POST['hobbies'])) {echo $_POST['hobbies'];} else {echo $myUserData['hobbies'];} ?>" />
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Biography</span>
                        <textarea style="float: left" name="bio" rows="10" cols="40"><?php if (isset($_POST['bio'])) {echo $_POST['bio'];} else {echo $myUserData['bio'];} ?></textarea>
                    </div>
<?php
    if ($_SESSION["ns_userType"] == "admin" || $_SESSION["ns_userType"] == "editor" || $_SESSION["ns_userType"] == "systemDev" || $_SESSION["ns_userType"] == "moderator")
    {
?>
                    <br />
                    <hr />
                    <br />
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Rank</span>
                        <input style="float: left" type="text" name="rank" size="22" maxlength="30" value="<?php if (isset($_POST['rank'])) {echo $_POST['rank'];} else {echo $myUserData['rank'];} ?>" />
                    </div>
<?php
    }
?>
                    <br />
                    <hr />
                    <br />
                    <div class="clearfix">
                        <span style="width: 50%; float: left">New Password</span>
                        <input style="float:left" type="password" name="newpassword" size="22" maxlength="30" />
                    </div>
                    <div class="clearfix">
                        <span style="width: 50%; float: left">Confirm New Password</span>
                        <input style="float: left" type="password" name="confirmnewpassword" size="22" maxlength="30" />
                    </div>
                    <br />
                    <hr />
                    <br />
                    <br />
                    <input id="formatted" type="submit" name="submit" value="Update Profile" />
                    <input type="hidden" name="submitted" value="TRUE" />
                </form>
            </div>
<?php
    include("includes/footer.php");
?>