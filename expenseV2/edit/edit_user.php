<?php
session_start();
include("../db/connection.php"); // Includes the database connection file to establish a connection to the database
include("../db/function.php");   // Includes additional functions from the function.php file

// Check if the 'id' is provided in the query string
if (isset($_GET['id'])) {
    $user_id = $_GET['id']; // Retrieve the user ID from the query string

    // Fetch the user data from the database using the provided ID
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($con, $sql); // Execute the query
    $user = mysqli_fetch_assoc($result); // Fetch the result as an associative array

    // Check if the user exists in the database
    if (!$user) {
        // If the user is not found, redirect to the admin home page with an error message
        header("Location: admin_home.php?error=User not found");
        exit(); // Stop further script execution
    }
} else {
    // If no 'id' is provided in the query string, redirect to the admin home page
    header("Location: admin_home.php");
    exit(); // Stop further script execution
}

// Update user data when the form is submitted

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Container Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #80bdff;
            outline: none;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form action="../db/crud.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="hidden" value="<?= $user['id'] ?>" name="id">
                <input type="text" name="name" class="form-control" value="<?= $user['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="user" class="form-control" value="<?= $user['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="pass" class="form-control" value="<?= $user['password']; ?>" required>
            </div>
            <button type="submit" name="edit_user" class="btn btn-success">Update User</button>
            <a href="../admin/index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>