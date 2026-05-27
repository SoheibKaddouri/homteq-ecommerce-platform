<?php
session_start();
include("db.php");

$pageName = "smart basket";
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>"; 
echo "<title>".$pageName."</title>"; 
echo "<body>";

include("headfile.html"); 
include("detectlogin.php");
echo "<h4>".$pageName."</h4>"; 

// 1. Handle product removal
if (isset($_POST['remove_prodid'])) {
    $removeId = $_POST['remove_prodid'];
    unset($_SESSION['basket'][$removeId]);
    echo "<p class='updateInfo'>1 item removed from the basket</p>";
}

// 2. Handle product addition
if (isset($_POST['h_prodid'])) {
    $newProdId = $_POST['h_prodid'];
    $requQuantity = $_POST['prod_quantity'];  
    echo "<p class='updateInfo'>Selected product ID: ".$newProdId."</p>"; 
    echo "<p class='updateInfo'>Selected quantity: ".$requQuantity."</p>";
    $_SESSION['basket'][$newProdId] = $requQuantity;
    echo "<p class='updateInfo'>1 item added</p>";
} else {
    echo "<p class='updateInfo'><b>Basket unchanged</b></p>";
}

$total = 0;

// Render clean HTML table structure
echo "<table border='1' id='baskettable' style='width:100%; border-collapse: collapse; text-align: left;'>";
echo "<tr>";
echo "    <th>Product Name</th>";
echo "    <th>Price</th>";
echo "    <th>Quantity</th>";
echo "    <th>Subtotal</th>";
echo "    <th>Action</th>";
echo "</tr>";

if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
    foreach ($_SESSION['basket'] as $key => $value) {
        
        $SQL = "SELECT prodName, prodPrice FROM Product WHERE prodId=" . (int)$key;
        $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
        $arrayProd = mysqli_fetch_array($exeSQL);

        if (!$arrayProd) {
            continue;
        }
        
        $subtotal = $arrayProd['prodPrice'] * $value;
        $total = $total + $subtotal;
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($arrayProd['prodName']) . "</td>";
        echo "<td>£" . number_format($arrayProd['prodPrice'], 2) . "</td>";
        echo "<td>" . $value . "</td>";
        echo "<td>£" . number_format($subtotal, 2) . "</td>";
        echo "<td>";
        echo "    <form action='basket.php' method='post' style='margin:0;'>"; 
        echo "        <input type='hidden' name='remove_prodid' value='" . $key . "'>";
        echo "        <input type='submit' value='Remove' id='submitbtn'>"; 
        echo "    </form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align:center; padding:10px;'>Your basket is empty</td></tr>";
}

echo "</table><br>";

echo "<p class='updateInfo'><b>Total: £" . number_format($total, 2) . "</b></p>";

mysqli_close($conn);

// 3. Navigation Controls & Security Logic Gates
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
    echo "<p class='updateInfo'><a href='clearbasket.php'>CLEAR BASKET</a></p>";

    if (isset($_SESSION['userid'])) {
        echo "<p class='updateInfo'><a href='checkout.php' style='font-weight:bold; color:green;'>PROCEED TO CHECKOUT</a></p>";
    } else {
        echo "<p class='updateInfo'><a href='signup.php'>Sign Up</a> or <a href='login.php'>Log In</a> to complete your checkout.</p>";
    }
} else {
    echo "<p class='updateInfo'>Your basket is empty.</p>";
    echo "<p class='updateInfo'><a href='index.php'>Continue Shopping</a></p>";
}

include("footfile.html"); 
echo "</body>";
?>