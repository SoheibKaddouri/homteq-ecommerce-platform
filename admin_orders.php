<?php
session_start();
include("db.php");

$pageName = "Order Fulfillment Management";
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>";
echo "<title>".$pageName."</title>";
echo "<body>";

include("headfile.html");
echo "<h4>".$pageName."</h4>";

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'Admin') {
    echo "<p class='updateInfo' style='color:red;'>Access Denied.</p>";
    include("footfile.html");
    exit();
}

// Update Order Status action if triggered
if (isset($_GET['action']) && $_GET['action'] == 'ship') {
    $orderNo = intval($_GET['orderNo']);
    $updateSQL = "UPDATE orders SET orderStatus = 'Shipped' WHERE orderNo = ?";
    $stmt = mysqli_prepare($conn, $updateSQL);
    mysqli_stmt_bind_param($stmt, "i", $orderNo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<p class='updateInfo' style='color:green;'>Order #".$orderNo." updated to Shipped!</p>";
}

// Fetch all orders along with the user details who placed them
$ordersSQL = "SELECT o.*, u.userFName, u.userSName FROM orders o JOIN users u ON o.userId = u.userId ORDER BY o.orderDateTime DESC";
$res = mysqli_query($conn, $ordersSQL);

echo "<div class='updateInfo'>";
echo "<table style='width:100%; border-collapse: collapse; text-align: left;' border='1'>";
echo "<tr style='background-color:#eee;'><th>Order No</th><th>Customer</th><th>Date/Time</th><th>Total</th><th>Status</th><th>Action</th></tr>";

while ($order = mysqli_fetch_assoc($res)) {
    echo "<tr>";
    echo "<td>#" . $order['orderNo'] . "</td>";
    echo "<td>" . htmlspecialchars($order['userFName'] . " " . $order['userSName']) . "</td>";
    echo "<td>" . $order['orderDateTime'] . "</td>";
    echo "<td>£" . number_format($order['orderTotal'], 2) . "</td>";
    echo "<td>" . $order['orderStatus'] . "</td>";
    echo "<td>";
    if ($order['orderStatus'] == 'Pending') {
        echo "<a href='admin_orders.php?action='ship'&orderNo=" . $order['orderNo'] . "'>Mark Shipped</a>";
    } else {
        echo "Completed";
    }
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<p><a href='admin_dashboard.php'>Back to Admin Dashboard</a></p>";
echo "</div>";

include("footfile.html");
echo "</body>";
?>