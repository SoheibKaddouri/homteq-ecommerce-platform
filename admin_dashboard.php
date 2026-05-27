<?php
session_start();
$pageName = "Admin Administration Dashboard";
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>";
echo "<title>".$pageName."</title>";
echo "<body>";

include("headfile.html");
echo "<h4>".$pageName."</h4>";

// Guard: Strict Role-Based Access Control
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'Admin') {
    echo "<p class='updateInfo' style='color:red;'><b>Access Denied.</b> You do not have permissions to view this portal.</p>";
    include("footfile.html");
    echo "</body>";
    exit();
}

echo "<div class='updateInfo'>";
echo "<p>Welcome back, Administrator <b>".$_SESSION['fname']."</b>!</p>";
echo "<ul>";
echo "<li><a href='admin_addproduct.php'>Add New Catalog Items</a></li>";
echo "<li><a href='admin_orders.php'>View and Process Customer Orders</a></li>";
echo "<li><a href='index.php'>Return to Main Shop</a></li>";
echo "</ul>";
echo "</div>";

include("footfile.html");
echo "</body>";
?>