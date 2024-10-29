<?php
session_start(); // Starts the session to track user data across pages

include("../db/connection.php"); // Includes the database connection file to establish a connection with the database

// Check if 'id' is provided in the query string
if (isset($_GET['id'])) {
    $user_id = $_GET['id']; // Retrieve the user ID from the query string

    // Fetch user data from the database for confirmation
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($con, $sql); // Execute the query
    $user = mysqli_fetch_assoc($result); // Fetch the result as an associative array
} else {
    // If no 'id' is provided in the query string, redirect to the admin home page
    header("Location: admin_home.php");
    exit(); // Stop further script execution
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
    <title>Confirm Delete</title>
    <style>
                body {
            background-color: #f8f9fa; 
            display: flex;
            align-items: center; 
            justify-content: center;
            height: 100vh; 
            margin: 0; 
        }
        .container {
            background-color: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); 
            text-align: center; 
            width: 300px; 
        }
        h1 {
            font-size: 1.5rem;
            margin-bottom: 20px; 
        }
        p {
            font-size: 1rem; 
        }
        .btn {
            width: 100%; 
            padding: 10px; 
            margin-bottom: 10px; 
        }
        .btn-danger {
            background-color: #dc3545;
            border: none; 
        }
        .btn-secondary {
            background-color: #6c757d; 
            border: none; 
        }
        .btn:hover {
            opacity: 0.9; 
        }
        </style>
</head>
<body>
    <div class="container mt-5">
        <h3>Are you sure you want to delete the user: <?= $user['name']; ?>?</h3>
        <form method="POST">
            <input type="hidden" value="<?=$user['id']?>" name="id">
            <button type="submit" name="delete_user" class="btn btn-danger">Yes, Delete</button>
            <a href="../admin/index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
