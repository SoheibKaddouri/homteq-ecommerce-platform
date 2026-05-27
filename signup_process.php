<?php
session_start();
include("db.php"); // Connects to your MySQL DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = trim($_POST['fName']);
    $sName = trim($_POST['sName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($fName) || empty($sName) || empty($email) || empty($password)) {
        header("Location: signup.php?error=All fields are required");
        exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT userEmail FROM users WHERE userEmail = ?";
    $stmt = mysqli_prepare($conn, $checkEmail);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        header("Location: signup.php?error=Email already registered");
        exit();
    }
    mysqli_stmt_close($stmt);

    // Securely hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user as 'Customer' by default
    $insertUser = "INSERT INTO users (userType, userFName, userSName, userEmail, userPassword) VALUES ('Customer', ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertUser);
    mysqli_stmt_bind_param($stmt, "ssss", $fName, $sName, $email, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page on success
        header("Location: login.php?signup=success");
    } else {
        header("Location: signup.php?error=Registration failed. Try again.");
    }
    mysqli_stmt_close($conn);
}
?>