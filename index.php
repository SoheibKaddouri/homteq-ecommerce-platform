<?php
session_start();
include("db.php");
$pageName = "make your home smart"; 
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>"; 
echo "<title>".$pageName."</title>"; 
echo "<body>";
include("headfile.html"); 
include("detectlogin.php");
echo "<h4>".$pageName."</h4>"; 

$SQL = "select prodId, prodName, prodPicNameSmall, prodDescripShort, prodPrice from Product";
$exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

echo "<table style='border: 0px'>"; // Create HTML table

while ($arrayP = mysqli_fetch_assoc($exeSQL))
{
    echo "<tr>";
    
    // Each individual product row gets its own form container wrapped around it
    echo "<td style='border: 0px' colspan='2'>";
    echo "<form action='basket.php' method='POST' style='margin:0; padding:0;'>";
    echo "<input type='hidden' name='h_prodid' value='".$arrayP['prodId']."'>";
    echo "<table style='border: 0px; width:100%;'>";
    echo "<tr>";
    
    // Left Cell: Clickable thumbnail layout
    echo "<td style='border: 0px; width:220px; vertical-align: top;'>";
    echo "  <a href='prodbuy.php?u_prod_id=".$arrayP['prodId']."'>"; 
    echo "    <img src='images/".$arrayP['prodPicNameSmall']."' height='200' width='200' style='display:block;'>"; 
    echo "  </a>";
    echo "</td>";
    
    // Right Cell: Details, Price, Dropdown selector, and Button
    echo "<td style='border: 0px; vertical-align: top; padding-left: 10px;'>";
    echo "  <a href='prodbuy.php?u_prod_id=".$arrayP['prodId']."' style='text-decoration:none;'>";
    echo "    <h5 style='margin-top:0; margin-bottom:10px;'>".$arrayP['prodName']."</h5>"; 
    echo "  </a>";
    echo "  <p class='updateInfo'>".$arrayP['prodDescripShort']."</p>"; 
    echo "  <p class='updateInfo'><b>&pound;".number_format($arrayP['prodPrice'], 2)."</b></p>";
    
    echo "  <p class='updateInfo'>";
    echo "    <label for='quantity-".$arrayP['prodId']."'>Quantity: </label>";
    echo "    <select name='prod_quantity' id='quantity-".$arrayP['prodId']."'>";
    for ($i = 1; $i <= 10; $i++) {
        echo "  <option value='".$i."'>".$i."</option>";
    }
    echo "    </select>";
    echo "    <input type='submit' value='Add to Basket' id='submitbtn' style='margin-left:15px;'>";
    echo "  </p>";
    
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
    echo "</td>";
    
    echo "</tr>";
    // Spacer row between items
    echo "<tr><td colspan='2' style='border:0px; height:20px;'></td></tr>";
}
echo "</table>"; 

mysqli_close($conn); 
include("footfile.html"); 
echo "</body>";
?>