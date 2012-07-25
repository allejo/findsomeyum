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
    
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');

    $recipeID = $_GET['recipeid'];
    $recipeID = stripslashes($recipeID);
    $recipeID = mysqli_real_escape_string($dbc, $recipeID);

    if ($recipeData['user_id'] !=  XiON_getUserIDFromSession($dbc) && ($_SESSION["ns_userType"] != "admin" && $_SESSION["ns_userType"] != "editor" && $_SESSION["ns_userType"] != "systemDev" && $_SESSION["ns_userType"] != "moderator"))
    {
        header("location:viewrecipe.php?recipeid=$recipeID");
    }

    if (isset($_POST['submitted']))
    {
        $myAdminUsername = XiON_getUsernameFromSession();
        $adminIP = XiON_getUserIP();

        $logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'deleteRecipe', '$myAdminUsername', '$adminIP', '$myAdminUsername deleted recipe $row[0].')";
        $run_query = @mysqli_query($dbc, $logQuery);
        
        $deleteRecipeQuery = "DELETE FROM recipes WHERE post_id = '$recipeID' LIMIT 1";
        $deleteQuery = mysqli_query($dbc, $deleteRecipeQuery) OR die ("Error: " . mysqli_error($dbc));

        header("location: recipes.php");
    }
    else
    {       
        include("includes/header.php");
        include("includes/menubar.php");
        echo "            <div id=\"content\">\n";
    }

    $getAllRecipeData = "SELECT * FROM recipes WHERE post_id='" . $recipeID . "'";
    $getAllRecipeDataResult = @mysqli_query($dbc, $getAllRecipeData);
    $recipeData = mysqli_fetch_array($getAllRecipeDataResult);
?>
                <p>Are you sure you want to delete <strong><?php echo $row[0]?></strong>? This action cannot be undone.</p>
                <br />
                <div align="center">
                    <form style="text-align:justify;" action="./deleterecipe.php?recipeid=<?php echo $recipeID; ?>" method="post">
                        <input id="formatted" type="button" value="Cancel" onClick="location.href='viewrecipe.php?recipeid=<?php echo $recipeID; ?>'">
                        <input id="formatted" type="submit" name="submit" value="Delete Recipe" />
                        <input type="hidden" name="submitted" value="TRUE" />
                    </form>
                </div>
            </div>
<?php
    include("includes/footer.php");
?>