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
    include("includes/header.php");
    include("includes/menubar.php");

    if (isset($_GET['page']))
    {
        $pageno = $_GET['page'];
    }
    else
    {
        $pageno = 1;
    }

    $recipesCount = "SELECT count(*) FROM recipes";
    $recipesCountResult = mysqli_query($dbc, $recipesCount) OR die ("Error: " . mysqli_error($dbc));
    $recipesQueryData = mysqli_fetch_row($recipesCountResult);
    $numrows = $recipesQueryData[0];
    $rows_per_page = 10;
    $lastpage = ceil($numrows/$rows_per_page)
;
    $myRecipesQuery = "SELECT * FROM recipes ORDER BY last_activity DESC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    $myRecipesResult = @mysqli_query($dbc, $myRecipesQuery) OR die ("Error: " . mysqli_error($dbc));
    $numberOfRows = mysqli_num_rows($myRecipesResult);

    $pageno = (int)$pageno;
    if ($pageno > $lastpage) { $pageno = $lastpage; }
    if ($pageno < 1) { $pageno = 1; }
    if ($lastpage == 0) { $lastpage += 1; }
    
    echo "<div id=\"content\" class=\"clearfix\">";

    if (session_is_registered(ns_username))
    {
        echo "<a href=\"./newrecipe.php\" style=\"padding: 10px\" class=\"download_button orange\">Post New Recipe</a>";
    }
    echo "<form style=\"margin-top: 5px; margin-bottom: 20px; float: right;\" method=\"POST\" action=\"search.php\">
    <input style=\"float:right\" name=\"search\" placeholder=\"Search\" />
    </form><br /><br />";
    
    for ($i = 0; $i < $numberOfRows; $i++)
    {
        $row = mysqli_fetch_array($myRecipesResult);

        if ($row['visible'] == 1 || ($_SESSION["ns_userType"] == "admin" || $_SESSION["ns_userType"] == "editor" || $_SESSION["ns_userType"] == "systemDev" || $_SESSION["ns_userType"] == "moderator"))
        {

            echo "\n                    <table cellspacing=\"10\">
                            <tr>";

            if ($row['images'] != "")
            {
                echo "\n                    <td><img src=\"imgs/recipes/" . $row['images'] . "\" width=\"200px\"/></td>";
            }
            else
            {
                echo "<td><img src=\"imgs/recipes/plate.png\" width=\"200px\"/></td>";
            }

            echo "                                <td><h2><a href=\"viewrecipe.php?recipeid=$row[0]\">$row[3]</a>";
            echo XiON_getStarRating($dbc, XiON_getRating($dbc, $row['post_id']));
            
            echo "</h2>
                                by " . XiON_getUserProfileStylized($dbc, XiON_getUsernameFromID($dbc, $row[1]), 1) . "<br /><br />
                                <p class=\"description\">$row[9]</p><br /><br />
                                <strong>Difficulty:</strong> $row[6] | <strong>Prep Time:</strong> $row[7] minutes | <strong>Cook Time:</strong> $row[8] minutes
                                </td>
                            </tr>
                        </table>";

            if ($i + 1 != $numberOfRows)
            {
                echo "<br /><br /><hr /><br />";
            }
        }
    }
    echo "\n                <br />\n                <br />";
    
    echo "\n                <div align=\"center\">\n";
    
    if ($pageno == 1)
    {
       echo "                    &lt;&lt; &lt;";
    }
    else
    {
       echo "                    <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=1'>&lt;&lt;</a> ";
       $prevpage = $pageno-1;
       echo "\n                    <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=$prevpage'>&lt;</a> ";
    }
    
    echo "\n                    ( Page $pageno of $lastpage )";
    
    if ($pageno == $lastpage)
    {
        echo "\n                    &gt; &gt;&gt; ";
    }
    else
    {
       $nextpage = $pageno+1;
       echo "\n                     <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=$nextpage'>&gt;</a>\n";
       echo "                     <a href='{$_SERVER['PHP_SELF']}?view={$_GET['view']}&page=$lastpage'>&gt;&gt;</a>\n";
    }

    echo "</div>
    </div> <!-- End of Content -->";

    include("includes/footer.php");
?>