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
        header("location:membership.php");
    }
    
    require_once('admin/includes/mysql_connection.php');
    
    if (isset($_POST['search']))
    {
        $searchItem = $_POST['search'];
        $searchItem = stripslashes($searchItem);
        $searchItem = mysqli_real_escape_string($dbc, $searchItem);
        $searchItemArray = preg_split('/\s+/', $searchItem);
        $searchList = "";
        
        for ($i = 0; $i < count($searchItemArray); $i++)
        {
            $searchList .= $searchItemArray[$i];
            if ($i+1 < count($searchItemArray))
            {
                $searchList .= ",";
            }
        }
        
        header("location: ./search.php?search={$searchList}");
    }
    else if (isset($_GET['search']))
    {
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
        
        $searchItem = $_GET['search'];
        $searchItem = stripslashes($searchItem);
        $searchItem = mysqli_real_escape_string($dbc, $searchItem);
        
        $searchList = explode(",", $searchItem);
        for ($i = 0; $i < count($searchList); $i++)
        {
            $sqlList .= " name LIKE '%$searchList[$i]%' OR description LIKE '%$searchList[$i]%' OR brand LIKE '%$searchList[$i]%' OR information LIKE '%$searchList[$i]%'";
            if ($i+1 < count($searchList))
            {
                $sqlList .= " OR ";
            }
        }
        
        $query = "SELECT count(*) FROM products WHERE $sqlList";
        $result = mysqli_query($dbc, $query) OR die ("Error: " . mysqli_error($dbc));
        $query_data = mysqli_fetch_row($result);
        $numrows = $query_data[0];
        $rows_per_page = 15;
        $lastpage = ceil($numrows/$rows_per_page);
    
        $searchQuery = "SELECT * FROM products WHERE $sqlList ORDER BY price ASC LIMIT " . ($pageno - 1) * $rows_per_page . ", " . $rows_per_page;
        $run_query = @mysqli_query($dbc, $searchQuery) OR die ("sql error: " . mysqli_error($dbc));
        $numberOfRows = mysqli_num_rows($run_query);
    
        $pageno = (int)$pageno;
        if ($pageno > $lastpage) { $pageno = $lastpage; }
        if ($pageno < 1) { $pageno = 1; }
        if ($lastpage == 0) { $lastpage += 1; }
        
        echo "                <table  width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
                        <tr>
                            <td><h3>Item</h3></td>
                            <td><h3>Location</h3></td>
                            <td><h3>Price</h3></td>
                            <td></td>
                        </tr>";
        
        for ($i = 0; $i < $numberOfRows; $i++)
        {
            $row = mysqli_fetch_array($run_query);
            echo "\n                    <tr>
                            <td>
                                <h4>$row[6] $row[1]<h4><br />
                                <p>$row[2]</p>
                            </td>
                            <td>$row[5]</td>
                            <td>$row[3]</td>
                            <td><a href=\"grocerylist.php?action=add&item=$row[0]\">Add to List</a></td>
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
           echo "                    <a href='{$_SERVER['PHP_SELF']}?search={$_GET['search']}&page=1'>&lt;&lt;</a> ";
           $prevpage = $pageno-1;
           echo "\n                    <a href='{$_SERVER['PHP_SELF']}?search={$_GET['search']}&page=$prevpage'>&lt;</a> ";
        }
        
        echo "\n                    ( Page $pageno of $lastpage )";
        
        if ($pageno == $lastpage)
        {
            echo "\n                    &gt; &gt;&gt; ";
        }
        else
        {
           $nextpage = $pageno+1;
           echo "\n                     <a href='{$_SERVER['PHP_SELF']}?search={$_GET['search']}&page=$nextpage'>&gt;</a>\n";
           echo "                     <a href='{$_SERVER['PHP_SELF']}?search={$_GET['search']}&page=$lastpage'>&gt;&gt;</a>\n";
        }
        
        echo "                </div> <!-- End Pagination -->";
    }
    
    include("includes/footer.php");
?>