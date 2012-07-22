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
    
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');

    $recipeID = $_GET['recipeid'];
    $recipeID = stripslashes($recipeID);
    $recipeID = mysqli_real_escape_string($dbc, $recipeID);

    if(isset($_POST['submitted']))
    {
        if (isset($_GET['action']))
        {
            if ($_GET['action'] == "comment")
            {
                $comment = $_POST['comment'];
                $comment = stripslashes($comment);
                $comment = mysqli_real_escape_string($dbc, $comment);
                $user_id = XiON_getUserIDFromUsername($dbc, XiON_getUsernameFromSession());

                $addNewCommentQuery = "INSERT INTO comments (post_section, parent_post, user_id, content, date_posted, date_edited) VALUES ('recipe', '$recipeID', '$user_id', '$comment', NOW(), NOW())";
                $addNewComment = @mysqli_query($dbc, $addNewCommentQuery) OR die ("Error: " . mysqli_error($dbc));

                header("location: viewrecipe.php?recipeid=" . $recipeID);
            }
        }
    }
    
    if ($_GET['action'] == "rating")
    {
        $rating = $_GET['value'];
        $rating = stripslashes($rating);
        $rating = mysqli_real_escape_string($dbc, $rating);
        $user_id = XiON_getUserIDFromUsername($dbc, XiON_getUsernameFromSession());

        $addNewRatingQuery = "INSERT INTO ratings (user_id, recipe_id, value, date) VALUES ('$user_id', '$recipeID', '$rating', NOW())";
        $addNewRating = @mysqli_query($dbc, $addNewRatingQuery) OR die ("Error:" . mysqli_error($dbc));
        
        header("location: viewrecipe.php?recipeid=" . $recipeID);
    }
    
    if (!isset($_GET['recipeid']))
    {
        header ("location: recipes.php");
    }
    
    $checkRecipeID = "SELECT * FROM recipes WHERE post_id ='" . $recipeID . "' LIMIT 1";
    $recipeQuery = @mysqli_query($dbc, $checkRecipeID);
    $recipeData = mysqli_fetch_array($recipeQuery);
    
    if (count($recipeData) == 0)
    {
        header ("location: recipes.php");
    }
    
    include("includes/header.php");
    include("includes/menubar.php");
    
    echo "<div id=\"content\">
        <div class=\"viewrecipe\">";
    
    echo "<span class=\"title\">" . $recipeData['title'] . "</span> <span class=\"category\">[" . $recipeData['category'] . "]</span> <br />\n";
    echo "<div class=\"author\">by " . XiON_getUserProfileStylized($dbc, XiON_getUsernameFromID($dbc, $recipeData['user_id']), 1) . "</div> <!-- End .author -->\n";
    echo "<div class=\"rating\">" . XiON_getStarRating($dbc, XiON_getRating($dbc, $recipeID)) . " <small>(" . XiON_getRating($dbc, $recipeID) . " / 5)</small></div> <!-- End .rating --><br /><br />\n";
    
    if ($recipeData['images'] != "")
    {
        echo "<div class=\"image\"><img src=\"imgs/uploads/recipes/" . $recipeData['images'] . "\" /></div><br /> <!-- End .image -->";
    }
    else
    {
        echo "<!-- No Image Available Embedded --><br />";
    }

    if ($recipeData['youtube'] != "")
    {
        echo "<iframe width=\"560\" height=\"315\" src=\"http://www.youtube.com/embed/" . $recipeData['youtube'] . "?wmode=opaque\" frameborder=\"0\" allowfullscreen></iframe><br /><br /><br />";
    }
    else
    {
        echo "<!-- No YouTube Video Embedded --><br />";
    }
    echo "<strong>Difficulty</strong>: " . $recipeData['difficulty']. " | <strong>Prep Time</strong>: " . $recipeData['prep_time'] . " minutes | <strong>Cook Time</strong>: " . $recipeData['cook_time'] . " minutes<br /><br />";
    echo "<strong>Ingredients</strong>: <br />" . $recipeData['ingredients'] . "<br />";
    echo "<strong>Directions</strong>: <br />" . $recipeData['directions'] . "<br />";
    if ($recipeData['notes'] != "")
    {
        echo "<strong>Notes</strong>: <br />" . $recipeData['notes'] . "<br />";
    }

    if(session_is_registered(ns_username))
    {
?>
        <br /><h3>Your Rating</h3>
        <div id="giveRating">
    	<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=rating&value=1"><img id="star1" src="imgs/transparent.gif" width="40" height="40" /></a>
    	<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=rating&value=2"><img id="star2" src="imgs/transparent.gif" width="40" height="40" /></a>
    	<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=rating&value=3"><img id="star3" src="imgs/transparent.gif" width="40" height="40" /></a>
    	<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=rating&value=4"><img id="star4" src="imgs/transparent.gif" width="40" height="40" /></a>
    	<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&action=rating&value=5"><img id="star5" src="imgs/transparent.gif" width="40" height="40" /></a>
    	</div><br />
        <br /><h3>Comments</h3>
        <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?> &action=comment"><br />
        <textarea id="command" name="comment" rows="10" cols="80" /></textarea><br /><br />
        <input type="hidden" name="submitted" value="TRUE" />
        <input type="submit" value="Comment" />
        </form><br /><br />
<?php
    }
    else
    {
        echo "<br /><div class=\"login\">Please <a href=\"#login-box\" class=\"download_button orange links login-window\">login</a> or <a href=\"#register-box\" class=\"download_button orange links login-window\">register</a> to comment.</div><br /><br />";
    }
?>
    
<?php
    echo "\n<!-- Start printing out comments -->\n";

    if (XiON_getCommentsCount($dbc, "recipe", $recipeID) != 0)
    {
        echo XiON_getComments($dbc, "recipe", $recipeID);
    }
    else
    {
        echo "<em>No Comments</em>";
    }
    
    echo "</div> <!-- End .viewrecipe -->
    </div> <!-- #content -->";
    
    include("includes/footer.php");
?>