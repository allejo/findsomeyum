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
    
    // Set the database access information as constants:
    DEFINE ('DB_USER', 'findsomeyum');
    DEFINE ('DB_PASSWORD', 'xjWh0gpY5pVvgt');
    DEFINE ('DB_HOST', '50.63.104.73');
    DEFINE ('DB_NAME', 'findsomeyum');

    // Make the connection:
    global $dbc;
    $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
?>
