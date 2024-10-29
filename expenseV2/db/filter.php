<?php
session_start(); // Start the session to manage user sessions
include("connection.php"); // Include the database connection file

$result = null; // Initialize result variable to null

// Check if the search form was submitted
if (isset($_POST['search'])) {
    $date_start = $_POST['date_start']; // Get the start date from the POST data
    $date_end = $_POST['date_end']; // Get the end date from the POST data
    $id = $_POST['id']; // Get the user ID from the POST data

    // SQL query to select transactions based on date range
    $sql = "SELECT * FROM transaction INNER JOIN users ON transaction.users_id = users.id WHERE date BETWEEN '$date_start' AND '$date_end'";

    $result = mysqli_query($con, $sql); // Execute the query

    // SQL query to calculate the total amount of transactions for the user
    $sql1 = "SELECT SUM(amount) AS total FROM transaction";
    $row3 = mysqli_query($con, $sql1); // Execute the query to get the total amount
    while ($row2 = mysqli_fetch_assoc($row3)) {
        $output = $row2['total']; // Store the total amount in the output variable
    } 

    // Error handling for SQL execution
    if (!$result) {
        die("Error executing query: " . mysqli_error($con)); // Display error if the query fails
    }
}
?>
