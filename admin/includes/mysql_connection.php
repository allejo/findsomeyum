<?php
    // Set the database access information as constants:
    DEFINE ('DB_USER', 'smchs');
    DEFINE ('DB_PASSWORD', 'L34344682AY24u');
    DEFINE ('DB_HOST', '184.168.45.98');
    DEFINE ('DB_NAME', 'smchs');

    // Make the connection:
    $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
?>
