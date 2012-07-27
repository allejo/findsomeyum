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
?>
            <center><input id="search" type="text" name="search" /></center>

            <div id="featured">
                <img src="http://www.italian-food.us/vealsaltimboccalarge.jpg">
                
                <div class="description">
                    <a href="#"><h1>Some Amazing Salad</h1></a>
                    by <a href="#">allejo</a>
                    <br />
                    <br />
                    <p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ut posuere tellus. In non quam a orci pellentesque varius. Integer vitae ligula id urna imperdiet lacinia sit amet sed diam. Sed eu turpis pretium libero dignissim hendrerit quis in urna. Aenean nec nulla neque. Phasellus sit amet mauris nibh, vel dapibus velit. Integer vulputate bibendum felis consectetur pretium. Nulla et enim mi. Phasellus elementum enim et tellus tincidunt suscipit ultricies leo feugiat. Maecenas enim tortor.
                    </p>
                    
                    <div class="recipeBtn">
                        <a href="#" class="download_button orange">See the recipe</a>
                    </div>
                </div>
            </div>
            
            <div id="content" class="clearfix">
                <div class="main_column_left">
                    <?php echo $row[2]; ?>
                </div>
                <div class="side_bar_right">
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
?>
                </div>
            </div>
<?php
    include("includes/footer.php");
?>