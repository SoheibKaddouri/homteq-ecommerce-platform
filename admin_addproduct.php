<?php
session_start();
include("db.php");

$pageName = "Add Product to Inventory";
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>";
echo "<title>".$pageName."</title>";
echo "<body>";

include("headfile.html");
echo "<h4>".$pageName."</h4>";

// Admin Check
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'Admin') {
    echo "<p class='updateInfo' style='color:red;'>Access Denied.</p>";
    include("footfile.html");
    exit();
}

// Process the submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['prodName']);
    $small = trim($_POST['prodPicSmall']);
    $large = trim($_POST['prodPicLarge']);
    $short = trim($_POST['prodDescShort']);
    $long  = trim($_POST['prodDescLong']);
    $price = $_POST['prodPrice'];
    $qty   = $_POST['prodQty'];

    $insertSQL = "INSERT INTO Product (prodName, prodPicNameSmall, prodPicNameLarge, prodDescripShort, prodDescripLong, prodPrice, prodQuantity) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertSQL);
    mysqli_stmt_bind_param($stmt, "sssssdi", $name, $small, $large, $short, $long, $price, $qty);

    if (mysqli_stmt_execute($stmt)) {
        echo "<p class='updateInfo' style='color:green;'><b>Success!</b> Product added to database.</p>";
    } else {
        echo "<p class='updateInfo' style='color:red;'>Error adding product.</p>";
    }
    mysqli_stmt_close($stmt);
}

// Render Input Form
echo "<div class='updateInfo'>";
echo "<form action='admin_addproduct.php' method='POST'>";
echo "Product Name: <input type='text' name='prodName' required><br><br>";
echo "Small Image Filename (e.g., hivesmall.jpg): <input type='text' name='prodPicSmall' required><br><br>";
echo "Large Image Filename (e.g., hivebig.jpg): <input type='text' name='prodPicLarge' required><br><br>";
echo "Short Description: <br><textarea name='prodDescShort' rows='3' cols='50'></textarea><br><br>";
echo "Long Description: <br><textarea name='prodDescLong' rows='6' cols='50'></textarea><br><br>";
echo "Price (£): <input type='number' step='0.01' name='prodPrice' required><br><br>";
echo "Stock Quantity: <input type='number' name='prodQty' value='100' required><br><br>";
echo "<input type='submit' value='Add Product to Store'>";
echo "</form>";
echo "<p><a href='admin_dashboard.php'>Back to Admin Dashboard</a></p>";
echo "</div>";

include("footfile.html");
echo "</body>";
?>