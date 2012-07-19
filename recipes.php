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
    $rows_per_page = 15;
    $lastpage = ceil($numrows/$rows_per_page);

    $myRecipesQuery = "SELECT * FROM recipes ORDER BY title ASC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    $myRecipesResult = @mysqli_query($dbc, $myRecipesQuery) OR die ("Error: " . mysqli_error($dbc));
    $numberOfRows = mysqli_num_rows($myRecipesResult);

    $pageno = (int)$pageno;
    if ($pageno > $lastpage) { $pageno = $lastpage; }
    if ($pageno < 1) { $pageno = 1; }
    if ($lastpage == 0) { $lastpage += 1; }
    
    echo "<div id=\"content\">";

    if (session_is_registered(ns_username))
    {
        echo "<a href=\"./newrecipe.php\" style=\"padding: 10px\" class=\"download_button orange\">Post New Recipe</a><br /><br />";
    }

    echo "                <table  width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"1\">";
    
    for ($i = 0; $i < $numberOfRows; $i++)
    {
        $row = mysqli_fetch_array($myRecipesResult);

        $usernameQuery = "SELECT username FROM members WHERE members.user_id = '" . $row[1] . "' LIMIT 1";
        $userNameResult = @mysqli_query($dbc, $usernameQuery);
        $myUsername = mysqli_fetch_array($userNameResult);
        //3.4
        $fullStars = round($row[13]); //3
        $halfStars = $row[13] - $fullStars;
        if ($halfStars > 0)
        {
            $emptyStars = 4 - $fullStars;
        }
        else
        {
            $emptyStars = 5 - $fullStars;
        }
        
        echo "\n                    <tr>
                        <td>
                            <h2><a href=\"viewrecipe.php?recipeid=$row[0]\">$row[3]</a>";
        for ($s = 0; $s < $fullStars; $s++)
        {
            echo "<img src=\"./imgs/star.png\" width=\"20px\" />";
        }
        if ($halfStars > 0)
        {
            echo "<img src=\"./imgs/star_half.png\" width=\"20px\" />";
        }
        for ($s = 0; $s < $emptyStars; $s++)
        {
            echo "<img src=\"./imgs/star_empty.png\" width=\"20px\" />";
        }
        echo "</h2>
                            by $myUsername[0]<br /><br />
                            $row[9]<br /><br />
                            Difficulty: $row[6] | Prep Time: $row[7] | Cook Time: $row[8]
                        </td>
                    </tr>";
    }
    echo "\n                </table>\n                <br />\n                <br />";
    
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