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
    
    /*
    	post_id [0]
    	user_id [1]
    	category [2]
    	title [3]
    	youtube [4]
    	images [5]
    	difficulty [6]
    	prep_time [7]
    	cook_time [8]
    	description [9]
    	ingredients [10]
    	directions [11]
    	notes [12]
    	rating [13]
    	date_posted [14]
    	date_edited [15]
    	ipAddress [16]
    */
    
    session_start();
    
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');
    
    if (!isset($_GET['recipeid']))
    {
	    header ("location: recipes.php");
    }
    
    $recipeID = $_GET['recipeid'];
    $recipeID = stripslashes($recipeID);
    $recipeID = mysqli_real_escape_string($dbc, $recipeID);
    
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
    
    echo "<span class=\"category\">[$recipeData[2]]</span> <span class=\"title\">$recipeData[3]</span>";
    
    echo "</div>
    </div>";
    
    include("includes/footer.php");
?>