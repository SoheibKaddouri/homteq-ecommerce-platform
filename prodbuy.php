<?php
session_start();
include ("db.php");
$pageName="a smart buy for a smart home"; //Create and populate a variable called $pageName
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pageName."</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file
include ("detectlogin.php");
echo "<h4>".$pageName."</h4>"; //display name of the page on the web page
//display random text
$prodId=$_GET['u_prod_id']; //see https://www.w3schools.com/php/php_superglobals_get.asp
echo "<p>Selected product Id: ".$prodId."</p>"; //display the value of the product id, for debugging purposes.
$SQL="select prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice, prodQuantity
from Product
where prodId=".$prodId; //this query only retrieves one product as prodId is a PK
$exeSQL=mysqli_query($conn, $SQL) or die (mysqli_error($conn)); //no while loop required since only one product is retrieved.
$arrayPr=mysqli_fetch_assoc($exeSQL);
echo "<table style='border: 0px'>";
echo "<tr>";
echo "<td style='border: 0px'>";
echo "<img src=images/".$arrayPr['prodPicNameLarge']." height=350 width=350>";
echo "</td>";
echo "<td style='border: 0px'>";
echo "<p><h5>".$arrayPr['prodName']."</h5></p>";
echo "<p class='updateInfo'>".$arrayPr['prodDescripLong']."</p>";
echo "<p class='updateInfo'><b>&pound".$arrayPr['prodPrice']."</b></p>";
echo "<p class='updateInfo'>Number left in stock: ".$arrayPr['prodQuantity'] ."</p>";
echo "<p class='updateInfo'>Number to be purchased: </p>";
echo "<form action='basket.php' method='post'>"; //action is page to be called, method is POST
echo " <p class='updateInfo'><select name='prod_quantity'>"; //create a drop-down called prod_quantity
for ($i=1; $i<=$arrayPr['prodQuantity']; $i++) //iterate from 1 to quantity in stock
{
echo "<option value=".$i.">".$i."</option>";//display current value in drop-down, pass current value
}
echo "</select>"; //close drop-down
echo "<input type='submit' name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
echo "<input type='hidden' name='h_prodid' value=".$prodId.">"; //pass product id to next page basket.php as hidden value
echo "</p>";
echo "</form>";
echo "</td>";
echo "</tr>";
echo "</table>";
mysqli_close($conn);
?>