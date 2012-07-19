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

    if (isset($_POST['submitted']))
    {
        $category = $_POST['category'];
        $category = stripslashes($category);
        $category = mysqli_real_escape_string($dbc, $category);
        $title = $_POST['title'];
        $title = stripslashes($title);
        $title = mysqli_real_escape_string($dbc, $title);
        $difficulty = $_POST['difficulty'];
        $difficulty = stripslashes($difficulty);
        $difficulty = mysqli_real_escape_string($dbc, $difficulty);
        $image = $_POST['image'];
        $image = stripslashes($image);
        $image = mysqli_real_escape_string($dbc, $image);
        $youtube = $_POST['youtube'];
        $youtube = stripslashes($youtube);
        $youtube = mysqli_real_escape_string($dbc, $youtube);
        $prep_time = $_POST['prep_time'];
        $prep_time = stripslashes($prep_time);
        $prep_time = mysqli_real_escape_string($dbc, $prep_time);
        $cook_time = $_POST['cook_time'];
        $cook_time = stripslashes($cook_time);
        $cook_time = mysqli_real_escape_string($dbc, $cook_time);
        $description = $_POST['description'];
        $description = stripslashes($description);
        $description = mysqli_real_escape_string($dbc, $description);
        $ingredients = $_POST['ingredients'];
        $ingredients = stripslashes($ingredients);
        $ingredients = mysqli_real_escape_string($dbc, $ingredients);
        $directions = $_POST['directions'];
        $directions = stripslashes($directions);
        $directions = mysqli_real_escape_string($dbc, $directions);
        $notes = $_POST['notes'];
        $notes = stripslashes($notes);
        $notes = mysqli_real_escape_string($dbc, $notes);

        $getUserIDQuery = "SELECT user_id FROM members WHERE username = '" . $_SESSION['ns_username'] . "'";
        $getUserIDResult =  @mysqli_query($dbc, $getUserIDQuery);
        $getUserID = mysqli_fetch_array($getUserIDResult);

        $addRecipeQuery = "INSERT INTO recipes (post_id, user_id, category, title, youtube, images, difficulty, prep_time, cook_time, description, ingredients, directions, notes, rating, date_posted, date_edited, ipAddress) VALUES (NULL, '$getUserID[0]', '$category', '$title', '$youtube', '$image', '$difficulty', '$prep_time', '$cook_time', '$description', '$ingredients', '$directions', '$notes', 0.0, NOW(), NOW(), '$userIP')";
        $addRecipeResult = @mysqli_query($dbc, $addRecipeQuery) OR die ("Line 1 Error: " . mysqli_error($dbc));
        $getLastInsertedRow = "SELECT post_id FROM recipes ORDER BY post_id DESC LIMIT 1";
        $getLastInsertedRowResult = @mysqli_query($dbc, $getLastInsertedRow) OR die ("Error: " . mysqli_error($dbc));
        $getLastInsertedRow = mysqli_fetch_array($getLastInsertedRowResult);
        $getLastInsertedRow = $getLastInsertedRow[0];

        if ($addRecipeResult)
        {
            header ("location: viewrecipe.php?recipeid=$getLastInsertedRow");
        }
        else
        {
            //TODO Actually do something here!
            echo "SOMETHING FUCKING WENT WRONG!";
        }
    }

    include("includes/header.php");
    include("includes/menubar.php");
?>

<div id="content">
    <form method="post" action="newrecipe.php">
        <select name="category">
            <option value="">Select Category</option>
            <option value="appetizers">Appetizers</option>
            <option value="breakfast">Breakfast</option>
            <option value="dessert">Dessert</option>
            <option value="drinks">Drinks</option>
            <option value="main_dish">Main Dish</option>
            <option value="salad">Salad</option>
            <option value="side_dish">Side Dish</option>
            <option value="soup">Soup</option>
        </select>
        <select name="difficulty">
            <option value="">Select Difficulty</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="difficult">Difficult</option>
        </select>
        <br />
        <br />
        Title <input class="input" name="title" type="text" id="title" placeholder="Title" width="100%" /><br />
        Image <input class="input" name="image" type="text" id="image" placeholder="Image URL" /><br />
        YouTube <input class="input" name="youtube" type="text" id="youtube" placeholder="YouTube URL" /><br />
        Prep Time <input name="prep_time" type="text" id="prep_time" placeholder="Prep Time (Minutes)" />
        Cook Time <input name="cook_time" type="text" id="cook_time" placeholder="Cook Time (Minutes)" /><br /><br />
        Description<br /><textarea name="description" rows="10" cols="80" /></textarea><br /><br />
        Ingredients<br /><textarea name="ingredients" rows="15" cols="80" /></textarea><br /><br />
        Directions<br /><textarea name="directions" rows="15" cols="80" /></textarea><br /><br />
        Notes<br /><textarea name="notes" rows="10" cols="80" /></textarea><br /><br /><br />
        <input type="submit" value="Submit" />
        <input type="hidden" name="submitted" value="TRUE" />
    </form>
</div>
<?php
    include("includes/footer.php");
?>