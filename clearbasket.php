<?php
session_start();
$pageName="Clear Smart Basket"; //Create and populate a variable called $pageName
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pageName."</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file
include ("detectlogin.php");
echo "<h4>".$pageName."</h4>"; //display name of the page on the web page
unset($_SESSION['basket']);
echo "Your basket has been cleared" ;
//display random text

include("footfile.html"); //include head layout
echo "</body>";
?>