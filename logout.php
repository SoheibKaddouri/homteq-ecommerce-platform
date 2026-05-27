<?php
session_start();
$pageName="log out"; 
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>".$pageName."</title>";
echo "<body>";

include("headfile.html");
include("detectlogin.php");

echo "<h4>".$pageName."</h4>";

// Display thank you message using session values
echo "<p class='updateInfo'>Thank you, ".$_SESSION['fname']." ".$_SESSION['sname'].", for shopping with us.</p>";
echo "<p class='updateInfo'>Goodbye!</p>";

// Unset all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Display logout confirmation
echo "<p class='updateInfo'><b>You have been logged out.</b></p>";
echo "<p class='updateInfo'>Return to <a href='index.php'>Home</a></p>";

include("footfile.html");
echo "</body>";
?>