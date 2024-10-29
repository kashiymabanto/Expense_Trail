<?php
session_start(); // Start the session to manage user login state
include("function.php"); // Include the functions file for utility functions

// Check if the login form has been submitted
if (isset($_POST['login'])) {
    include("connection.php"); // Include the database connection file
    
    // Get username and password from POST data
    $username = $_POST['user'];
    $password = $_POST['pass'];
    
    // Prepare SQL query to select user by username and password
    $sql = "SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password'";
    $query = $con->query($sql); // Execute the query
    $row = $query->fetch_array(); // Fetch the result as an associative array

    // Check if any user matched the query
    if ($query->num_rows != 0) {
        $_SESSION['id'] = $row['id']; // Store user ID in session

        // Redirect based on user type
        if ($row['user_type'] == 1) { // Regular user
            @header("Location: ../users/petty_cash.php"); // Redirect to user dashboard
            exit(); // Stop further execution
        } else if ($row['user_type'] == 2) { // Admin user
            @header("Location: ../admin/index.php"); // Redirect to admin dashboard
            exit(); // Stop further execution
        }
    } else {
        // User not found or password is incorrect
        $_SESSION['status'] = "Wrong username or password!"; // Set session status for error message
        header('location: ../index.php'); // Redirect back to login page
        exit(); // Stop further execution
    }
}
?>
