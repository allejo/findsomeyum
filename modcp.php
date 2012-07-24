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
        header("location:login.php");
    }

    require_once('admin/includes/mysql_connection.php');
    require_once('admin/includes/auxiliaryFunctions.php');

    if ($_GET['action'] == "close")
    {
        if (isset($_GET['flagid']))
        {
            $flagID = $_GET['flagid'];
            $flagID = stripslashes($flagID);
            $flagID = mysqli_real_escape_string($dbc, $flagID);

            $closeFlag = "UPDATE flags SET status='Closed' WHERE flag_id='" . $flagID . "'";
            $closeFlagQuery = @mysqli_query($dbc, $closeFlag);

            header("location: modcp.php");
        }
    }

    include("includes/header.php");
    include("includes/menubar.php");
?>
            <div id="content">
                <h2>Flags</h2>
                <hr />
                <table width="100%" cellspacing="10px">
<?php
                $getFlags = "SELECT * FROM flags";
                $getFlagsResults = @mysqli_query($dbc, $getFlags);
                $numberOfFlags = mysqli_num_rows($getFlagsResults);

                echo "<tr>
                <td><strong>Recipe</strong></td>
                <td><strong>Comment</strong></td>
                <td><strong>Status</strong></td>
                <td></td>
                </tr>";

                for ($i = 0; $i < $numberOfFlags; $i++)
                {
                    $myFlagData = mysqli_fetch_array($getFlagsResults);
                    $getRecipeName = "SELECT title FROM recipes WHERE post_id='" . $myFlagData[1] . "'";
                    $getRecipeData = mysqli_query($dbc, $getRecipeName);
                    $recipeName = mysqli_fetch_array($getRecipeData);

                    if ($myFlagData[6] == "Open")
                    {
                        echo "<tr>";
                        echo "<td><a href=\"viewrecipe.php?recipeid=" . $myFlagData[1] . "\">" . $recipeName[0] . "</a></td>";
                        echo "<td>" . $myFlagData[3] . " by " . XiON_getUserProfileStylized($dbc, XiON_getUsernameFromID($dbc, $myFlagData[2]), 1) . " (" .$myFlagData[4] . ")<br /><small><em>Flagged on: " . $myFlagData[5] ."</em></small></td>";
                        echo "<td><a href=\"modcp.php?action=close&flagid=" . $myFlagData[0] . "\">" . $myFlagData[6] . "</a></td>";
                        echo "</tr>";
                    }
                }
?>
                </table>
            </div>
<?php
    include("includes/footer.php");
?>