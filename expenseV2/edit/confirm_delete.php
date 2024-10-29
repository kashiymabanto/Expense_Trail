<?php
session_start(); // Starts the session to track user data across pages

include("../db/connection.php"); // Includes the database connection file to connect to the database

// Check if the user is logged in by verifying the session 'id'
// If the session 'id' is not set, redirect to the signout page
if (!isset($_SESSION['id'])) {
    header("Location: ../signout.php");
    exit(); // Stop further script execution
}

// Retrieve the 'id' from the query string, if available
$id = $_GET['id'] ?? null;
if (!$id) {
    // If no 'id' is provided, redirect to the expense list page
    header("Location: expense-list.php");
    exit(); // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../css/bootstrap/bootstrap.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete</title>
    <style>
        body {
            background-color: #f8f9fa;
            /* Light background */
            display: flex;
            align-items: center;
            /* Center vertically */
            justify-content: center;
            /* Center horizontally */
            height: 100vh;
            /* Full height */
            margin: 0;
            /* Remove default margin */
        }

        .container {
            background-color: white;
            /* White background for container */
            padding: 30px;
            /* Padding around content */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            /* Shadow effect */
            text-align: center;
            /* Center text inside container */
            width: 300px;
            /* Fixed width for the dialog */
        }

        h1 {
            font-size: 1.5rem;
            /* Font size for heading */
            margin-bottom: 20px;
            /* Space below heading */
        }

        p {
            font-size: 1rem;
            /* Font size for paragraph */
            margin-bottom: 30px;
            /* Space below paragraph */
        }

        .btn {
            width: 100%;
            /* Full width buttons */
            padding: 10px;
            /* Padding inside buttons */
            margin-bottom: 10px;
            /* Space below buttons */
        }

        .btn-danger {
            background-color: #dc3545;
            /* Red button */
            border: none;
            /* No border */
        }

        .btn-secondary {
            background-color: #6c757d;
            /* Grey button */
            border: none;
            /* No border */
        }

        .btn:hover {
            opacity: 0.9;
            /* Slightly transparent on hover */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Confirm Deletion</h1>
        <p>Are you sure you want to delete this expense?</p>
        <form action="../db/crud.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" value="<?= $_SESSION['id'] ?>" name="eid">
            <button type="submit" name="delete_expense" class="btn btn-danger">Yes, Delete</button>
            <a href="../users/expense-list.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>