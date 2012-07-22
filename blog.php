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
    
    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');
    
    if (isset($_GET['view']))
    {
        $blogPost = stripslashes($_GET['view']);
        $blogPost = mysqli_real_escape_string($dbc, $blogPost);
        
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

                    $addNewCommentQuery = "INSERT INTO comments (post_section, parent_post, user_id, content, date_posted, date_edited) VALUES ('blog', '$blogPost', '$user_id', '$comment', NOW(), NOW())";
                    $addNewComment = @mysqli_query($dbc, $addNewCommentQuery) OR die ("Error: " . mysqli_error($dbc));

                    header("location: blog.php?view=" . $blogPost);
                }
            }
        }

        $getBlogPostQuery = "SELECT * FROM blog WHERE blog_id='" . $blogPost . "'";
        $blogPostResult = @mysqli_query($dbc, $getBlogPostQuery);
        $blogPostData = mysqli_fetch_array($blogPostResult);
        $numberOfPosts = mysqli_num_rows($blogPostResult);
        
        if ($numberOfPosts == 1)
        {
            include("includes/header.php");
            include("includes/menubar.php");
            
            $usernameQuery = "SELECT * FROM members WHERE members.user_id = '" . $blogPostData[1] . "' LIMIT 1";
            $userNameResult = @mysqli_query($dbc, $usernameQuery);
            $myUsername = mysqli_fetch_array($userNameResult);
            
            $userColorQuery = "SELECT * FROM groups WHERE groups.userType = '" . $myUsername[1] . "' LIMIT 1";
            $userColorResult = @mysqli_query($dbc, $userColorQuery) OR die ("Error: " . mysqli_error($dbc));
            $userColor = mysqli_fetch_array($userColorResult);
            
            echo "<div id=\"content\">
                <div class=\"blog\">
            <h2>$blogPostData[2]</h2>
                            by <strong><a href=\"./profile.php?user=$myUsername[0]\" style=\"color: $userColor[1]\">$myUsername[2]</a></strong><br /><br />
                            $blogPostData[3]<br />
                            <span class=\"category\">Category: $blogPostData[4]</span></div>";
            if(session_is_registered(ns_username))
            {
                echo "<br /><h3>Comments</h3>
                <form method=\"POST\" action=\"" . $_SERVER['REQUEST_URI'] . "&action=comment\"><br />
                <textarea id=\"command\" name=\"comment\" rows=\"10\" cols=\"80\" /></textarea><br /><br />
                <input type=\"hidden\" name=\"submitted\" value=\"TRUE\" />
                <input type=\"submit\" value=\"Comment\" />
                </form><br /><br />";
            }
            else
            {
                echo "<br /><div class=\"login\">Please <a href=\"#login-box\" class=\"download_button orange links login-window\">login</a> or <a href=\"#register-box\" class=\"download_button orange links login-window\">register</a> to comment.</div><br /><br />";
            }
            
            echo "\n<!-- Start printing out comments -->\n";

            if (XiON_getCommentsCount($dbc, "blog", $blogPost) != 0)
            {
                echo XiON_getComments($dbc, "blog", $blogPost);
            }
            else
            {
                echo "<em>No Comments</em>";
            }
            
            echo "</div>";

            include("includes/footer.php");
            exit();
        }
        else
        {
            //TODO change to proper 404 page
            header("location: missing.html");
        }
    }
    
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

    $recipesCount = "SELECT count(*) FROM blog";
    $recipesCountResult = mysqli_query($dbc, $recipesCount) OR die ("Error: " . mysqli_error($dbc));
    $recipesQueryData = mysqli_fetch_row($recipesCountResult);
    $numrows = $recipesQueryData[0];
    $rows_per_page = 5;
    $lastpage = ceil($numrows/$rows_per_page);

    $myRecipesQuery = "SELECT * FROM blog ORDER BY date_posted DESC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
    $myRecipesResult = @mysqli_query($dbc, $myRecipesQuery) OR die ("Error: " . mysqli_error($dbc));
    $numberOfRows = mysqli_num_rows($myRecipesResult);

    $pageno = (int)$pageno;
    if ($pageno > $lastpage) { $pageno = $lastpage; }
    if ($pageno < 1) { $pageno = 1; }
    if ($lastpage == 0) { $lastpage += 1; }
    
    echo "\n            <div id=\"content\">\n";
    echo "                <table  width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"1\">";
    
    for ($i = 0; $i < $numberOfRows; $i++)
    {
        $row = mysqli_fetch_array($myRecipesResult);

        $usernameQuery = "SELECT * FROM members WHERE members.user_id = '" . $row[1] . "' LIMIT 1";
        $userNameResult = @mysqli_query($dbc, $usernameQuery) OR die ("Error: " . mysqli_error($dbc));
        $myUsername = mysqli_fetch_array($userNameResult);
        
        $userColorQuery = "SELECT * FROM groups WHERE groups.userType = '" . $myUsername[1] . "' LIMIT 1";
        $userColorResult = @mysqli_query($dbc, $userColorQuery) OR die ("Error: " . mysqli_error($dbc));
        $userColor = mysqli_fetch_array($userColorResult);

        echo "\n                    <tr>
                        <td class=\"blog\">
                            <h2><a href=\"blog.php?view=$row[0]\">$row[2]</a></h2>
                            by <strong><a href=\"./profile.php?user=$myUsername[0]\" style=\"color: $userColor[1]\">$myUsername[2]</a></strong><br /><br />" .
                            substr($row[3], 0, 300). "...<br />
                            <span class=\"category\">Category: $row[4]</span>
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
    
    echo "\n                </div>
            </div>";
    include("includes/footer.php");
?>