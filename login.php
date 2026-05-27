<?php
session_start();
$pageName="log in"; //Create and populate a variable called $pageName
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pageName."</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file
echo "<h4>".$pageName."</h4>"; //display name of the page on the web page
//display random text
// Login form
echo "<form action='login_process.php' method='post'>";
echo "<table id='baskettable' style='border: 0px'>";

echo "<tr>";
echo "<td style='border: 0px'><b>Email:</b></td>";
echo "<td style='border: 0px'><input type='text' name='login_email' size='40'></td>";
echo "</tr>";

echo "<tr>";
echo "<td style='border: 0px'><b>Password:</b></td>";
echo "<td style='border: 0px'><input type='password' name='login_pwd' size='40'></td>";
echo "</tr>";

echo "<tr>";
echo "<td style='border: 0px'><input type='submit' value='Login' id='submitbtn'></td>";
echo "<td style='border: 0px'><input type='reset' value='Clear Form' id='submitbtn'></td>";
echo "</tr>";

echo "</table>";
echo "</form>";

include("footfile.html"); //include head layout
echo "</body>";
?>