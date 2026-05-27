<?php
session_start();
include("db.php");

$pageName = "login outcome";
echo "<link rel='stylesheet' type='text/css' href='mystylesheet.css'>";
echo "<title>".$pageName."</title>";
echo "<body>";

include("headfile.html");
echo "<h4>".$pageName."</h4>";

$email = $_POST['login_email'];
$password = $_POST['login_pwd'];

if (empty($email) || empty($password)) {
    echo "<p class='updateInfo'><b>Login failed!</b></p>";
    echo "<p class='updateInfo'>Login form incomplete</p>";
    echo "<p class='updateInfo'>Make sure you provide all the required details</p>";
    echo "<p class='updateInfo'>Go back to <a href='login.php'>login</a></p>";
} 
else {
    // 1. Use parameterized queries to eliminate SQL injection risks
    $SQL = "SELECT * FROM users WHERE userEmail = ?";
    $stmt = mysqli_prepare($conn, $SQL);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $nbRecords = mysqli_num_rows($result);

    if ($nbRecords == 0) {
        echo "<p class='updateInfo'><b>Login failed!</b></p>";
        echo "<p class='updateInfo'>Email not recognised</p>";
        echo "<p class='updateInfo'>Go back to <a href='login.php'>login</a></p>";
    }
    else {
        $arrayU = mysqli_fetch_array($result, MYSQLI_ASSOC);

        // 2. Safely verify the user's password using standard password hashing verification
        if (!password_verify($password, $arrayU['userPassword'])) {
            echo "<p class='updateInfo'><b>Login failed!</b></p>";
            echo "<p class='updateInfo'>Incorrect password</p>";
            echo "<p class='updateInfo'>Go back to <a href='login.php'>login</a></p>";
        }
        else {
            // 3. Populate matching session variables used by your application
            $_SESSION['userid'] = $arrayU['userId'];
            $_SESSION['fname'] = $arrayU['userFName'];
            $_SESSION['sname'] = $arrayU['userSName'];
            $_SESSION['usertype'] = $arrayU['userType']; // Essential for upcoming Admin logic!

            echo "<p class='updateInfo'><b>Login successful!</b></p>";
            echo "<p class='updateInfo'>Welcome, ".$arrayU['userFName']." ".$arrayU['userSName']."</p>";
            echo "<p class='updateInfo'>You are logged in as: ".$arrayU['userType']."</p>";

            if ($arrayU['userType'] == "Customer") {
                echo "<p class='updateInfo'>Continue shopping <a href='index.php'>here</a></p>";
            }

            if ($arrayU['userType'] == "Admin") {
                // Link changed directly to your upcoming admin management file
                echo "<p class='updateInfo'>Access the <a href='admin_dashboard.php'>Admin Dashboard</a></p>";
            }
        }
    }
    mysqli_stmt_close($stmt);
}

include("footfile.html");
echo "</body>";
?>