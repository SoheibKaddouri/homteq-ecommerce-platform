<?php
// Database configuration - Update these placeholders with your local server environment details
$dbhost = 'localhost'; 
$dbuser = 'YOUR_DATABASE_USERNAME'; 
$dbpass = 'YOUR_DATABASE_PASSWORD'; 
$dbname = 'w2151373_0';

// Establish connection to the server
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Verify database connection integrity
if (!$conn)
{
    die('Could not connect: ' . mysqli_connect_error());
}

// Select the operational database schema
mysqli_select_db($conn, $dbname);
?>