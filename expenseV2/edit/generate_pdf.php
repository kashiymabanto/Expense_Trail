<?php
session_start(); // Starts the session to track user data across pages

include("../db/connection.php"); // Includes the database connection file to connect to the database

// Check if the user is logged in by verifying the session 'id'
// If the session 'id' is not set, redirect to the signout page
if (!isset($_SESSION['id'])) {
    header("Location: ../signout.php");
    exit(); // Stop further script execution
}

$user_id = $_SESSION['id']; // Retrieve the current user's ID from the session

// Get the date range from the GET request
$date_start = $_GET['date_start'] ?? null; // Start date for the expense filter
$date_end = $_GET['date_end'] ?? null;     // End date for the expense filter

// Check if both start and end dates are provided
if ($date_start && $date_end) {
    // Fetch the expenses for the given date range for the current user
    $sql = "SELECT * FROM transaction INNER JOIN users ON transaction.users_id = users.id WHERE date BETWEEN '$date_start' AND '$date_end'";
    $result = mysqli_query($con, $sql); // Execute the query

    // Include FPDF library to generate a PDF document
    require('fpdf/fpdf.php'); // Make sure the path to fpdf.php is correct
    $pdf = new FPDF(); // Create a new PDF instance
    $pdf->AddPage(); // Add a new page to the PDF
    $pdf->SetFont('Arial', 'B', 16); // Set the font to Arial, bold, size 16

    // Title of the PDF
    $pdf->Cell(0, 10, 'Expense Trail', 0, 1, 'C'); // Center-aligned title
    $pdf->Ln(10); // Line break

    // Table header
    $pdf->SetFont('Arial', 'B', 12); // Set font for the table header
    $pdf->Cell(50, 10, 'Name', 1); // Column for 'Expense'
    $pdf->Cell(50, 10, 'Expense', 1); // Column for 'Expense'
    $pdf->Cell(45, 10, 'Date', 1);    // Column for 'Date'
    $pdf->Cell(45, 10, 'Amount', 1);  // Column for 'Amount'
    $pdf->Ln(); // Line break

    // Initialize total amount
    $total_amount = 0;

    // Loop through the fetched expense data
    while ($row = mysqli_fetch_assoc($result)) {
        // Output expense data in each row of the table
        $pdf->Cell(50, 10, $row['name'], 1);
        $pdf->Cell(50, 10, $row['expense'], 1);
        $pdf->Cell(45, 10, $row['date'], 1);
        $pdf->Cell(45, 10, 'PHP' . $row['amount'], 1);
        $pdf->Ln(); // Line break
        $total_amount += $row['amount']; // Add to the total amount
    }

    // Output the total amount at the end of the table
    $pdf->Cell(130, 10, 'Total:', 1); // Total label
    $pdf->Cell(60, 10, 'PHP' . $total_amount, 1); // Total amount value

    // Output the PDF to the browser
    $pdf->Output();
    exit(); // Stop further script execution
} else {
    // Redirect back to the history page if no date range is provided
    header("Location: ../users/history.php");
    exit(); // Stop further script execution
}
?>
