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

    if (isset($_POST['submitted']))
    {
        //reads the name of the file the user submitted for uploading
        $image = $_FILES['image']['name'];
        $errors = array();
    
        if (empty($_POST['category']))
        {
            $errors[] = 'A category was not specifed';
        }
        else
        {
            $category = $_POST['category'];
            $category = stripslashes($category);
            $category = mysqli_real_escape_string($dbc, $category);
        }
        
        if (empty($_POST['title']))
        {
            $errors[] = 'No title was specified';
        }
        else
        {
            $title = $_POST['title'];
            $title = stripslashes($title);
            $title = mysqli_real_escape_string($dbc, $title);
        }
        
        if (empty($_POST['difficulty']))
        {
            $errors[] = 'No difficulty was specified';
        }
        else
        {
            $difficulty = $_POST['difficulty'];
            $difficulty = stripslashes($difficulty);
            $difficulty = mysqli_real_escape_string($dbc, $difficulty);
        }
        
        $youtube = $_POST['youtube'];
        $youtube = stripslashes($youtube);
        $youtube = mysqli_real_escape_string($dbc, $youtube);
        
        if (empty($_POST['prep_time']))
        {
            $errors[] = 'No preparation time was specified';
        }
        else
        {
            $prep_time = $_POST['prep_time'];
            $prep_time = stripslashes($prep_time);
            $prep_time = mysqli_real_escape_string($dbc, $prep_time);
        }
        
        if (empty($_POST['cook_time']))
        {
            $errors[] = 'No cook time was specified';
        }
        else
        {
            $cook_time = $_POST['cook_time'];
            $cook_time = stripslashes($cook_time);
            $cook_time = mysqli_real_escape_string($dbc, $cook_time);
        }
        
        if (empty($_POST['description']))
        {
            $errors[] = 'No descriptoin was specified';
        }
        else
        {
            $description = $_POST['description'];
            $description = stripslashes($description);
            $description = mysqli_real_escape_string($dbc, $description);
        }
        
        if (empty($_POST['ingredients']))
        {
            $errors[] = 'No ingredients were specified';
        }
        else
        {
            $ingredients = $_POST['ingredients'];
            $ingredients = stripslashes($ingredients);
            $ingredients = mysqli_real_escape_string($dbc, $ingredients);
        }
        
        if (empty($_POST['directions']))
        {
            $errors[] = 'No directions were specified';
        }
        else
        {
            $directions = $_POST['directions'];
            $directions = stripslashes($directions);
            $directions = mysqli_real_escape_string($dbc, $directions);
        }
        
        $notes = $_POST['notes'];
        $notes = stripslashes($notes);
        $notes = mysqli_real_escape_string($dbc, $notes);
        
        if ($image)
        {
            define ("MAX_SIZE","100"); 
            
            //get the original name of the file from the clients machine
            $filename = stripslashes($_FILES['image']['name']);
            //get the extension of the file in a lower case format
            $extension = XiON_getExtension($filename);
            $extension = strtolower($extension);
            
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
            {
                //Unknown extension
                $error[] = 'Invalid file type uploaded';
            }
            else
            {
                $size = filesize($_FILES['image']['tmp_name']);
        
                if ($size > MAX_SIZE*1024)
                {
                    //Over the size limit
                    $error[] = 'Image select is too large to upload';
                }
        
                //we will give an unique name, for example the time in unix time format
                $image_name = time() . '.' . $extension;
                $newname="imgs/recipes/" . $image_name;
                $copied = copy($_FILES['image']['tmp_name'], $newname);
                
                if (!$copied) 
                {
                    //Something went wrong
                    $error[] = 'An unknown error has occured while uploading the image.';
                }
            }
        }

        if (empty($errors))
        {
            if ($image_name != "")
            {
                $updateNewImage = "UPDATE recipes SET images = '$image_name' WHERE post_id='" . $recipeID . "' LIMIT 1";
                $updateNewImageQuery = @mysqli_query($dbc, $updateNewImage);
            }

            $updateRecipeQuery = "UPDATE recipes SET category = '$category', title = '$title', youtube = '$youtube', difficulty = '$difficulty', prep_time = '$prep_time', cook_time = '$cook_time', description = '$description', ingredients = '$ingredients', directions = '$directions', notes = '$notes', date_edited=NOW() WHERE post_id='" . $recipeID . "'";
            $updateRecipeQueryResult = @mysqli_query($dbc, $updateRecipeQuery) OR die ("Error: " . mysqli_error($dbc));
            
            if ($updateRecipeQueryResult)
            {
                header ("location: viewrecipe.php?recipeid=$recipeID");
            }
        }
        else
        {
            include("includes/header.php");
            include("includes/menubar.php");

            echo '<div id="content">
                  <p class="error"><strong>The following error(s) occurred:</strong><br />';
                
            foreach ($errors as $msg) //Go through all the errors and output them
            {
                echo " - $msg<br />\n";
            }
            
            echo "</p><br />";
        }
    }
    else
    {       
        include("includes/header.php");
        include("includes/menubar.php");
        echo "<div id=\"content\">";
    }

    $getAllRecipeData = "SELECT * FROM recipes WHERE post_id='" . $recipeID . "'";
    $getAllRecipeDataResult = @mysqli_query($dbc, $getAllRecipeData);
    $recipeData = mysqli_fetch_array($getAllRecipeDataResult);
?>
    <form method="post" action="editrecipe.php?recipeid=<?php echo $recipeID;?>" enctype="multipart/form-data">
        <input id="formatted" style="width: 585px" name="title" type="text" id="title" placeholder="Title" width="100%" value="<?php if (isset($_POST['title'])) echo $_POST['title']; else echo $recipeData['title']; ?>"/><br /><br />
        <select name="category">
            <option value="">Select Category</option>
            <option value="Appetizers" <?php if ($recipeData['category'] == "Appetizers") echo "selected=\"selected\""; ?>>Appetizers</option>
            <option value="Breakfast" <?php if ($recipeData['category'] == "Breakfast") echo "selected=\"selected\""; ?>>Breakfast</option>
            <option value="Dessert" <?php if ($recipeData['category'] == "Dessert") echo "selected=\"selected\""; ?>>Dessert</option>
            <option value="Drinks" <?php if ($recipeData['category'] == "Drinks") echo "selected=\"selected\""; ?>>Drinks</option>
            <option value="Main Dish" <?php if ($recipeData['category'] == "Main Dish") echo "selected=\"selected\""; ?>>Main Dish</option>
            <option value="Salad" <?php if ($recipeData['category'] == "Salad") echo "selected=\"selected\""; ?>>Salad</option>
            <option value="Side Dish" <?php if ($recipeData['category'] == "Side Dish") echo "selected=\"selected\""; ?>>Side Dish</option>
            <option value="Soup" <?php if ($recipeData['category'] == "Soup") echo "selected=\"selected\""; ?>>Soup</option>
        </select>
        <select name="difficulty">
            <option value="">Select Difficulty</option>
            <option value="Easy" <?php if ($recipeData['difficulty'] == "Easy") echo "selected=\"selected\""; ?>>Easy</option>
            <option value="Medium" <?php if ($recipeData['difficulty'] == "Medium") echo "selected=\"selected\""; ?>>Medium</option>
            <option value="Difficult" <?php if ($recipeData['difficulty'] == "Difficult") echo "selected=\"selected\""; ?>>Difficult</option>
        </select>
        Image <input type="file" name="image"><br /><br />
        http://www.youtube.com/watch?v=<input id="formatted" style="width: 185px" name="youtube" type="text" id="youtube" placeholder="YouTube ID" maxlength="11" value="<?php if (isset($_POST['youtube'])) echo $_POST['youtube']; else echo $recipeData['youtube']; ?>"/><br /><br />
        Prep Time <input id="formatted" name="prep_time" type="text" id="prep_time" placeholder="Prep Time (Minutes)" value="<?php echo $recipeData['prep_time']; ?>"/>
        Cook Time <input id="formatted" name="cook_time" type="text" id="cook_time" placeholder="Cook Time (Minutes)" value="<?php echo $recipeData['cook_time']; ?>"/><br /><br />
        Description<br /><textarea id="formatted" name="description" rows="10" cols="80" /><?php if (isset($_POST['description'])) echo $_POST['description']; else echo $recipeData['description']; ?></textarea><br /><br />
        Ingredients<br /><textarea id="formatted" name="ingredients" rows="15" cols="80" /><?php if (isset($_POST['ingredients'])) echo $_POST['ingredients']; else echo $recipeData['ingredients']; ?></textarea><br /><br />
        Directions<br /><textarea id="formatted" name="directions" rows="15" cols="80" /><?php if (isset($_POST['directions'])) echo $_POST['directions']; else echo $recipeData['directions']; ?></textarea><br /><br />
        Notes<br /><textarea id="formatted" name="notes" rows="10" cols="80" /><?php if (isset($_POST['notes'])) echo $_POST['notes']; else echo $recipeData['notes']; ?></textarea><br /><br /><br />
        <input id="formatted" type="submit" value="Submit" />
        <input type="hidden" name="submitted" value="TRUE" />
    </form>
</div>
<?php
    include("includes/footer.php");
?>