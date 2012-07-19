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
    require_once('includes/mysql_connection.php');
    require_once('includes/auxiliaryFunctions.php');
    
    if(!session_is_registered(xi_username)) //The user is not logged in or got logged out due to inactivity
    {
        header("location:login.php"); //Send them to the login page
    }
    
    include("themes/admin/header-top.php");
    echo "\n        <title>XiON: Content Manager</title>\n";
    include("themes/admin/header-middle.php");
    echo "\n                <h1>XiON Content</h1>\n";
    include("themes/admin/header-bottom.php");
    include("themes/admin/menubar.php");
    include("themes/admin/header-end.php");
    echo"\n";
    echo "            <div id=\"main_column\">\n";
    
    $pageToEdit = $_GET['edit'];
    $pageToEdit = stripslashes($pageToEdit);
    $getIndividualPage = "SELECT * FROM content WHERE page_name = '" . $pageToEdit . ".php" . "'";
    $pageResult = @mysqli_query($dbc, $getIndividualPage) OR die ("ERROR: " . mysqli_error($dbc));
    $myPageData = mysqli_fetch_array($pageResult);
    
    if (isset($_POST['submitted']))
    {
        $logQuery = "INSERT INTO logs (time, actionType, username, ipaddress, description) VALUES (NOW(), 'editor', '$adminUserName', '$userIP', '$adminUserName edited $pageToEdit.php.')";
	    $run_query = @mysqli_query($dbc, $logQuery);
	    
	    $newPageContent = $_POST['page_content'];
	    $newPageContent = stripslashes($newPageContent);
        $newPageContent = mysqli_real_escape_string($dbc, $newPageContent);
        $updatePageQuery = "UPDATE content SET content = '" . $newPageContent . "', last_edit_by = '" . $adminUserName . "', last_edited = NOW() WHERE page_name = '" . $pageToEdit . ".php" . "' LIMIT 1";
        $result = @mysqli_query($dbc, $updatePageQuery) OR die ("Error: " . mysqli_error($dbc));
        
        echo "\n                Page successfully updated.
            \n<br />
            \n<br />
            <a href=\"./content.php?edit=$pageToEdit\">&lt; Go Back</a>
            \n        </div> <!-- End Main Column -->
                
                <div id=\"sidebar\">\n";
        
        $pagesQuery = "SELECT * FROM content";
        $result = @mysqli_query($dbc, $pagesQuery);
        $numberOfRows = mysqli_num_rows($result);
        
        for ($i = 0; $i < $numberOfRows; $i++)
        {
            $rows = mysqli_fetch_array($result);
            $pageName = explode(".", $rows[0]);
            echo "                <a href=\"content.php?edit=$pageName[0]\">$rows[0]</a>\n";
        }
                
        echo "            </div> <!-- End Sidebar -->\n\n";
     
        include("themes/admin/footer.php");
        exit();
    }
?>
            <form style="text-align:justify;" action="./content.php?edit=<?php echo $pageToEdit ?>" method="post">
                <p>Page Title</p>
                <input type="text" name="page_title" value="<?php echo $myPageData[1]; ?>" />
                <br />
                <br />
                <p>Page Content</p>
                <textarea name="page_content" rows="20" cols="80" /><?php echo $myPageData[2]; ?></textarea>
                <br />
                <?php if (isset($_GET['edit'])) echo "<em>Last edited by " . $myPageData[3] . " on " . $myPageData[5] . "</em>"; ?>
                <br />
                <br />
                <input type="submit" name="submit" value="Update Page" />
                <input type="hidden" name="submitted" value="TRUE" />
            </form>
<?php
    echo "\n            </div> <!-- End Main Column -->
            
            <div id=\"sidebar\">
            <strong>Page List</strong>
            <br />
            <hr />
            <br />";
    
    $pagesQuery = "SELECT * FROM content";
    $result = @mysqli_query($dbc, $pagesQuery);
    $numberOfRows = mysqli_num_rows($result);
    
    for ($i = 0; $i < $numberOfRows; $i++)
    {
        $rows = mysqli_fetch_array($result);
        $pageName = explode(".", $rows[0]);
        echo "                <a href=\"content.php?edit=$pageName[0]\">$rows[0]</a>\n";
    }
            
    echo "            </div> <!-- End Sidebar -->\n\n";
 
    include("themes/admin/footer.php");  
?>