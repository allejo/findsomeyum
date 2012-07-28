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
    
    include("includes/header.php");
    include("includes/menubar.php");
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');
    
    $getRecipes = "SELECT post_id FROM recipes ORDER BY last_activity ASC";
    $getRecipesQuery = @mysqli_query($dbc, $getRecipes) OR die ("Error: " . mysqli_query($dbc));
    $recipeCount = mysqli_num_rows($getRecipesQuery);
    
    $mostPopularRecipe = 0;
    $mostPopularNumberOfRatings = 0;
    $mostPopularAverage = 0;
    
    for ($j = 0; $j < $recipeCount; $j++)
    {
    	$recipes = mysqli_fetch_array($getRecipesQuery);
	    $getRatingCount = "SELECT value FROM ratings WHERE recipe_id = '" . $recipes[0] . "'";
	    $getRatingCountQuery = @mysqli_query($dbc, $getRatingCount);
	    $numberOfRatings = mysqli_num_rows($getRatingCountQuery);
	    
	    $totalRating = 0;
	    
	    for ($i = 0; $i < $numberOfRatings; $i++)
	    {
		    $getRatingTotal = mysqli_fetch_array($getRatingCountQuery);
		    $totalRating += $getRatingTotal[0];
	    }
	    
	    if ($numberOfRatings > 0)
		    $averageRating = $totalRating / $numberOfRatings;
		else
			$averageRating = 0;
			
	    if ($numberOfRatings > $mostPopularNumberOfRatings && $averageRating >= $mostPopularAverage)
	    {
	    	$mostPopularAverage = $averageRating;
		    $mostPopularNumberOfRatings = $numberOfRatings;
		    $mostPopularRecipe = $recipes[0];
	    }
    }
    
    $featuredRecipeQuery = "SELECT * FROM recipes WHERE post_id='" . $mostPopularRecipe . "'";
    $featuredRecipeResult = @mysqli_query($dbc, $featuredRecipeQuery);
    $featuredRecipe = mysqli_fetch_array($featuredRecipeResult);
?>
            <center><input id="search" type="text" name="search" /></center>

            <div id="featured">
                <img src="imgs/recipes/<?php echo $featuredRecipe['images']; ?>">
                
                <div class="description">
                    <a href="viewrecipe.php?recipeid=<?php echo $featuredRecipe['post_id']; ?>"><h1><?php echo $featuredRecipe['title']; ?></h1></a>
                    by <?php echo XiON_getUserProfileStylized($dbc, XiON_getUsernameFromID($dbc, $featuredRecipe['user_id']), 1); ?>
                    <br />
                    <br />
                    <p class="desc">
<?php echo $featuredRecipe['description']; ?>
                    </p>
                    
                    <div class="recipeBtn">
                        <a href="viewrecipe.php?recipeid=<?php echo $featuredRecipe['post_id']; ?>" class="download_button orange">See the recipe</a>
                    </div>
                </div>
            </div>
            
            <div id="content" class="clearfix">
                <div class="main_column_left">
                    <?php echo $row[2]; ?>
                </div>
                <div class="sidebar_right">
                    <h3>Latest Recipes</h3>
                    <hr />
<?php
    $myRecipesQuery = "SELECT * FROM recipes ORDER BY last_activity DESC LIMIT 5";
    $myRecipesResult = @mysqli_query($dbc, $myRecipesQuery) OR die ("Error: " . mysqli_error($dbc));
    $numberOfRows = mysqli_num_rows($myRecipesResult);

    for ($i = 0; $i < $numberOfRows; $i++)
    {
        $row = mysqli_fetch_array($myRecipesResult);

        if ($row['visible'] == 1)
        {
            echo "\n                    <strong><small><a href=\"viewrecipe.php?recipeid=$row[0]\">$row[3]</a></small></strong>";
            
            echo "                                <small>by " . XiON_getUserProfileStylized($dbc, XiON_getUsernameFromID($dbc, $row[1]), 1) . "</small><br />
                                <small class=\"description\">$row[9]</small><br />";

            if ($i + 1 != $numberOfRows)
            {
                echo "<br /><hr /><br />";
            }
        }
    }

    echo "<br /><h3>Team Updates</h3>
    <hr />";

    $blogQuery = "SELECT * FROM blog ORDER BY date_posted DESC LIMIT 3";
    $blogResult = @mysqli_query($dbc, $blogQuery) OR die ("Error: " . mysqli_error($dbc));
    $numberOfPosts = mysqli_num_rows($blogResult);

    for ($i = 0; $i < $numberOfPosts; $i++)
    {
        $row = mysqli_fetch_array($blogResult);

        echo "\n                    <strong><small><a href=\"blog.php?view=$row[0]\">$row[2]</a></small></strong>";
        
        echo "                                <small>by " . XiON_getUserProfileStylized($dbc, XiON_getUsernameFromID($dbc, $row[1]), 1) . "</small><br />
                            <small class=\"description\">" . substr($row[3], 0, 100) . "...</small><br />";

        if ($i + 1 != $numberOfRows)
        {
            echo "<br /><hr /><br />";
        }
    }
?>
                </div> <!-- End .sidebar_right -->
            </div> <!-- End #content -->
<?php
    include("includes/footer.php");
?>