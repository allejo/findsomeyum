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
    
    if (!session_is_registered(ns_username))
    {
        header ("location: login.php");
    }

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
    
    $userIDQuery = "SELECT * FROM members WHERE members.username = '" . $_SESSION['ns_username'] . "'";
    $myUserResult = @mysqli_query($dbc, $userIDQuery) OR die ("Error: " . mysqli_error($dbc));
    $myUserID = mysqli_fetch_array($myUserResult);

    $recipesCount = "SELECT count(*) FROM recipes WHERE recipes.user_id = '" . $myUserID[0] . "'";
    $recipesCountResult = mysqli_query($dbc, $recipesCount) OR die ("Error: " . mysqli_error($dbc));
    $recipesQueryData = mysqli_fetch_row($recipesCountResult);
    $numrows = $recipesQueryData[0];
    $rows_per_page = 15;
    $lastpage = ceil($numrows/$rows_per_page);

    $myRecipesQuery = "SELECT * FROM recipes WHERE recipes.user_id = '" . $myUserID[0] . "' ORDER BY title ASC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    $myRecipesResult = @mysqli_query($dbc, $myRecipesQuery) OR die ("Error: " . mysqli_error($dbc));
    $numberOfRows = mysqli_num_rows($myRecipesResult);

    $pageno = (int)$pageno;
    if ($pageno > $lastpage) { $pageno = $lastpage; }
    if ($pageno < 1) { $pageno = 1; }
    if ($lastpage == 0) { $lastpage += 1; }
    
    echo "<div id=\"content\">
    <div class=\"viewrecipe\">
                    <table  width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"10\">
                    <tr>
                        <td><strong>Recipes</strong></td>
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                    </tr>";
    
    for ($i = 0; $i < $numberOfRows; $i++)
    {
        $row = mysqli_fetch_array($myRecipesResult);
        echo "\n                    <tr>
                        <td><div class=\"rating\"><span>$row[3]</span> " . XiON_getStarRating($dbc, XiON_getRating($dbc, $row['post_id'])) . "</td></div>
                        <td><a href=\"myrecipes.php?action=edit&recipeid=$row[0]\">Edit</a></td>
                        <td><a href=\"myrecipes.php?action=delete&recipeid=$row[0]\">Delete</a></td>
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

    echo "</div></div></div>";

    include("includes/footer.php");
?>