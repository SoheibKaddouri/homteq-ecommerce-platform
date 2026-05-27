<?php
session_start();
include("db.php");

$pagename = "Checkout Receipt";
echo "<title>".$pagename."</title>";
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>";

include("headfile.html");
echo "<h2>".$pagename."</h2>";

// 1. Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<p style='color:red;'>You must be logged in to checkout. <a href='login.php'>Login here</a></p>";
    include("footfile.html");
    exit();
}

// 2. Check if basket exists and is not empty
if (!isset($_SESSION['basket']) || empty($_SESSION['basket'])) {
    echo "<p style='color:red;'>Your basket is empty! <a href='index.php'>Browse products</a></p>";
    include("footfile.html");
    exit();
}

$userId = $_SESSION['userid'];
$currentDateTime = date('Y-m-d H:i:s');
$orderTotal = 0;

// Turn off autocommit to handle checkout as a single atomic transaction
mysqli_begin_transaction($conn);

try {
    // A. Calculate the total cost dynamically from the DB to prevent client-side tampering
    foreach ($_SESSION['basket'] as $prodId => $qty) {
        $prodQuery = "SELECT prodPrice, prodQuantity, prodName FROM Product WHERE prodId = ?";
        $stmt = mysqli_prepare($conn, $prodQuery);
        mysqli_stmt_bind_param($stmt, "i", $prodId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        if (!$product) {
            throw new Exception("Product ID $prodId no longer exists.");
        }

        if ($product['prodQuantity'] < $qty) {
            throw new Exception("Sorry, there is insufficient stock for '" . $product['prodName'] . "'. Only " . $product['prodQuantity'] . " remaining.");
        }

        $orderTotal += ($product['prodPrice'] * $qty);
    }

    // B. Insert high-level summary record into 'orders' table
    $orderQuery = "INSERT INTO orders (userId, orderDateTime, orderTotal, orderStatus) VALUES (?, ?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $orderQuery);
    mysqli_stmt_bind_param($stmt, "isd", $userId, $currentDateTime, $orderTotal);
    mysqli_stmt_execute($stmt);
    $orderNo = mysqli_insert_id($conn); // Grab the auto-generated order number
    mysqli_stmt_close($stmt);

    // C. Loop back through basket to populate 'order_line' and update 'Product' inventory stock
    echo "<p><strong>Order successfully placed!</strong> Here is your receipt:</p>";
    echo "<table style='width:100%; border-collapse: collapse; text-align: left;'>";
    echo "<tr style='background-color:#f2f2f2;'><th>Product Name</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>";

    foreach ($_SESSION['basket'] as $prodId => $qty) {
        // Fetch product info again for line processing
        $prodQuery = "SELECT prodPrice, prodName FROM Product WHERE prodId = ?";
        $stmt = mysqli_prepare($conn, $prodQuery);
        mysqli_stmt_bind_param($stmt, "i", $prodId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);

        $subTotal = $product['prodPrice'] * $qty;

        // Insert into order_line
        $lineQuery = "INSERT INTO order_line (orderNo, prodId, quantityOrdered, subTotal) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $lineQuery);
        mysqli_stmt_bind_param($stmt, "iiid", $orderNo, $prodId, $qty, $subTotal);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Deduct inventory stock from Product table
        $updateStockQuery = "UPDATE Product SET prodQuantity = prodQuantity - ? WHERE prodId = ?";
        $stmt = mysqli_prepare($conn, $updateStockQuery);
        mysqli_stmt_bind_param($stmt, "ii", $qty, $prodId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Display row in customer receipt UI
        echo "<tr>";
        echo "<td>" . htmlspecialchars($product['prodName']) . "</td>";
        echo "<td>&pound;" . number_format($product['prodPrice'], 2) . "</td>";
        echo "<td>" . $qty . "</td>";
        echo "<td>£" . number_format($subTotal, 2) . "</td>";
        echo "</tr>";
    }

    echo "<tr style='font-weight:bold; border-top:2px solid #000;'>";
    echo "<td colspan='3' style='text-align:right;'>Total Paid:</td>";
    echo "<td>&pound;" . number_format($orderTotal, 2) . "</td>";
    echo "</tr>";
    echo "</table>";
    echo "<p>Your Order reference number is: <strong>#HOMTEQ-" . $orderNo . "</strong></p>";

    // Everything went great! Commit transaction permanently to the database
    mysqli_commit($conn);

    // Clear the customer's session basket
    unset($_SESSION['basket']);

} catch (Exception $e) {
    // If anything fails above, cancel the transaction completely so database remains clean
    mysqli_rollback($conn);
    echo "<p style='color:red;'>Checkout Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='basket.php'>Return to basket to adjust quantities</a></p>";
}

include("footfile.html");
?>