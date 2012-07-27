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
			define ("MAX_SIZE","300"); 
			
			//get the original name of the file from the clients machine
			$filename = stripslashes($_FILES['image']['name']);
			//get the extension of the file in a lower case format
			$extension = XiON_getExtension($filename);
			$extension = strtolower($extension);
			
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
			{
				//Unknown extension
				$errors[] = 'Invalid file type uploaded';
			}
			else
			{
				$size = filesize($_FILES['image']['tmp_name']);
		
				if ($size > MAX_SIZE*1024)
				{
					//Over the size limit
					$errors[] = 'Image select is too large to upload';
				}
		
				//we will give an unique name, for example the time in unix time format
				$image_name = time() . '.' . $extension;
				$newname="imgs/recipes/" . $image_name;
				$copied = copy($_FILES['image']['tmp_name'], $newname);

                list($width, $height, $type, $attr) = getimagesize($newname);

                if ($width > 800 || $height > 600)
                {
                    $errors[] = 'Image dimensions cannot exceed 800x600 pixels';
                    unlink($newname);
                }
				if (!$copied)
				{
					//Something went wrong
					$errors[] = 'An unknown error has occured while uploading the image.';
				}
			}
		}

		if (empty($errors))
		{
            //Clean up the old images
            if ($handle = opendir('imgs/recipes/'))
            {
                while (false !== ($entry = readdir($handle)))
                {
                    if ($entry != "." && $entry != "..")
                    {
                        $checkIfImageIsInUse = "SELECT count(*) FROM recipes WHERE images = '" . $entry . "'";
                        $checkIfImageIsInUseQuery = @mysqli_query($dbc, $checkIfImageIsInUse) OR die ("Error: " . mysqli_error($dbc));
                        $isImageInUse = mysqli_fetch_array($checkIfImageIsInUseQuery);

                        if ($isImageInUse[0] == 0 && $entry != "plate.png" && $entry != $image_name)
                        {
                            unlink("imgs/recipes/" . $entry);
                        }
                    }
                }

                closedir($handle);
            }
            //End clean up

	        $getUserIDQuery = "SELECT user_id FROM members WHERE username = '" . $_SESSION['ns_username'] . "'";
	        $getUserIDResult =  @mysqli_query($dbc, $getUserIDQuery);
	        $getUserID = mysqli_fetch_array($getUserIDResult);
	
	        $addRecipeQuery = "INSERT INTO recipes (post_id, user_id, category, title, youtube, images, difficulty, prep_time, cook_time, description, ingredients, directions, notes, date_posted, date_edited, last_activity, ipAddress) VALUES (NULL, '$getUserID[0]', '$category', '$title', '$youtube', '$image_name', '$difficulty', '$prep_time', '$cook_time', '$description', '$ingredients', '$directions', '$notes', NOW(), NOW(), NOW(), '$userIP')";
	        $addRecipeResult = @mysqli_query($dbc, $addRecipeQuery) OR die ("Line 1 Error: " . mysqli_error($dbc));
	        $getLastInsertedRow = "SELECT post_id FROM recipes ORDER BY post_id DESC LIMIT 1";
	        $getLastInsertedRowResult = @mysqli_query($dbc, $getLastInsertedRow) OR die ("Error: " . mysqli_error($dbc));
	        $getLastInsertedRow = mysqli_fetch_array($getLastInsertedRowResult);
	        $getLastInsertedRow = $getLastInsertedRow[0];
	
	        if ($addRecipeResult)
	        {
	            header ("location: viewrecipe.php?recipeid=$getLastInsertedRow");
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

?>

    <form method="post" action="newrecipe.php" enctype="multipart/form-data">
        <input id="formatted" style="width: 585px" name="title" type="text" id="title" placeholder="Title*" width="100%" value="<?php if(isset($_POST['title'])) echo $_POST['title']; ?>"/><br /><br />
        <select name="category">
            <option value="">Select Category</option>
            <option value="Appetizers" <?php if ($_POST['category'] == "Appetizers") echo "selected=\"selected\""; ?>>Appetizers</option>
            <option value="Breakfast" <?php if ($_POST['category'] == "Breakfast") echo "selected=\"selected\""; ?>>Breakfast</option>
            <option value="Dessert" <?php if ($_POST['category'] == "Dessert") echo "selected=\"selected\""; ?>>Dessert</option>
            <option value="Drinks" <?php if ($_POST['category'] == "Drinks") echo "selected=\"selected\""; ?>>Drinks</option>
            <option value="Main Dish" <?php if ($_POST['category'] == "Main Dish") echo "selected=\"selected\""; ?>>Main Dish</option>
            <option value="Salad" <?php if ($_POST['category'] == "Salad") echo "selected=\"selected\""; ?>>Salad</option>
            <option value="Side Dish" <?php if ($_POST['category'] == "Side Dish") echo "selected=\"selected\""; ?>>Side Dish</option>
            <option value="Soup" <?php if ($_POST['category'] == "Soup") echo "selected=\"selected\""; ?>>Soup</option>
        </select><span class="error">*</span>
        <select name="difficulty">
            <option value="">Select Difficulty</option>
            <option value="Easy" <?php if ($_POST['difficulty'] == "Easy") echo "selected=\"selected\""; ?>>Easy</option>
            <option value="Medium" <?php if ($_POST['difficulty'] == "Medium") echo "selected=\"selected\""; ?>>Medium</option>
            <option value="Difficult" <?php if ($_POST['difficulty'] == "Difficult") echo "selected=\"selected\""; ?>>Difficult</option>
        </select><span class="error">*</span>
        <br /><br />
        Image <input type="file" name="image">
        <br /><em><tt>(Max Image Size: 800x600 pixels | Max File Size: 300Kb)</tt></em><br /><br />
        http://www.youtube.com/watch?v=<input id="formatted" style="width: 185px" name="youtube" type="text" id="youtube" placeholder="YouTube ID" maxlength="11" value="<?php if(isset($_POST['youtube'])) echo $_POST['youtube']; ?>"/><br /><br />
        Prep Time<span class="error">*</span> <input id="formatted" name="prep_time" type="text" id="prep_time" placeholder="Prep Time (Minutes)" value="<?php if(isset($_POST['prep_time'])) echo $_POST['prep_time']; ?>"/>
        Cook Time<span class="error">*</span> <input id="formatted" name="cook_time" type="text" id="cook_time" placeholder="Cook Time (Minutes)" value="<?php if(isset($_POST['cook_time'])) echo $_POST['cook_time']; ?>"/><br /><br />
        Description<span class="error">*</span><br /><textarea id="formatted" name="description" rows="10" cols="80" /><?php if(isset($_POST['description'])) echo $_POST['description']; ?></textarea><br /><br />
        Ingredients<span class="error">*</span><br /><textarea id="formatted" name="ingredients" rows="15" cols="80" /><?php if(isset($_POST['ingredients'])) echo $_POST['ingredients']; ?></textarea><br /><br />
        Directions<span class="error">*</span><br /><textarea id="formatted" name="directions" rows="15" cols="80"  /><?php if(isset($_POST['directions'])) echo $_POST['directions']; ?></textarea><br /><br />
        Notes<br /><textarea id="formatted" name="notes" rows="10" cols="80" value="<?php if(isset($_POST['notes'])) echo $_POST['notes']; ?>"/></textarea><br /><br /><br />
        <input id="formatted" type="submit" value="Submit" />
        <input type="hidden" name="submitted" value="TRUE" />
    </form>
</div>
<?php
    include("includes/footer.php");
?>