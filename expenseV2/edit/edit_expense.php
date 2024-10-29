<?php
session_start();
include("../db/connection.php"); // Includes the database connection file to connect to the database
include("../db/function.php");   // Includes additional functions from the function.php file

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
    header("Location: ../users/expense-list.php");
    exit(); // Stop further script execution
}

// Fetch the expense details for the current user from the database
$sql = "SELECT * FROM transaction WHERE id = '$id' AND users_id = '" . $_SESSION['id'] . "'";
$result = mysqli_query($con, $sql); // Execute the query
$expense = mysqli_fetch_assoc($result); // Fetch the result as an associative array

// Check if the expense exists in the database
if (!$expense) {
    // If the expense is not found, redirect to the expense list page
    header("Location: ../users/expense-list.php");
    exit(); // Stop further script execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-label {
            position: absolute;
            left: 12px;
            pointer-events: none;
            font-size: 1rem;

        }

        .form-control {
            font-size: 1rem;
            padding: 12px 10px;
            height: 45px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 96%;

        }

        .form-control:focus {
            outline: none;
            border-color: #007bff;
        }

        .form-control:focus+.form-label,
        .form-control:not(:placeholder-shown)+.form-label {
            top: -10px;
            left: 12px;
            font-size: 0.85rem;
            color: #007bff;
        }

        button {
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: 500;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .alert {
            animation: fadeOut 5s forwards;

        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Expense</h1>
        <form action="../db/crud.php" method="POST">
            <input type="hidden" name="id" value="<?= $expense['id'] ?>">
            <input type="hidden" value="<?= $_SESSION['id'] ?>" name="eid">
            <div class="mb-3">
                <input type="date" class="form-control" id="date" name="date" value="<?= $expense['date'] ?>">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="expense" name="expense" value="<?= $expense['expense'] ?>">
            </div>
            <div class="mb-3">
                <input type="number" class="form-control" id="amount" name="cash" value="<?= $expense['amount'] ?>" required>
            </div>
            <button type="submit" name="edit_expense" class="btn btn-primary">Update Expense</button>
        </form>
    </div>
</body>

</html>