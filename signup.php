<?php
session_start();
$pagename = "Sign Up";
echo "<title>".$pagename."</title>";
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>";

include("headfile.html");
echo "<h2>".$pagename."</h2>";

// Display any errors if redirected back from process script
if (isset($_GET['error'])) {
    echo "<p style='color:red;'>".htmlspecialchars($_GET['error'])."</p>";
}

echo "<form action='signup_process.php' method='POST' class='signup-form'>";
echo "<label>First Name: </label><input type='text' name='fName' required><br><br>";
echo "<label>Surname: </label><input type='text' name='sName' required><br><br>";
echo "<label>Email Address: </label><input type='email' name='email' required><br><br>";
echo "<label>Password: </label><input type='password' name='password' required><br><br>";
echo "<input type='submit' value='Register'>";
echo "</form>";

include("footfile.html");
?>