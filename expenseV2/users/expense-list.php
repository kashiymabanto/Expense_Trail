<?php
session_start();
include("../db/connection.php"); // Includes the database connection file to establish a connection to the database
include("../db/function.php");   // Includes additional functions from the function.php file

// SQL query to fetch all transactions for the current user based on the session 'id'
$sql = "SELECT * FROM transaction WHERE users_id = '" . $_SESSION['id'] . "'";
$result = mysqli_query($con, $sql); // Execute the query to retrieve the transaction records

$sql1 = "SELECT SUM(amount) AS total FROM transaction WHERE users_id = '" . $_SESSION['id'] . "'";
$row3 = mysqli_query($con, $sql1); // Execute the query to get the total amount
while ($row2 = mysqli_fetch_assoc($row3)) {
    $output = $row2['total']; // Store the total amount in the output variable
} 

// Check if the user is logged in and retrieve user data
$user_data = check_login($con); // Calls a function to verify the user's login status and get their data

// Verify the user's type to ensure they have the appropriate permissions
if ($user_data['user_type'] !== '1') {
    // If the user is not of the required type (user_type '1'), redirect to the signout page
    // or you could choose to display an error message instead
    header("Location: ../signout.php");
    exit(); // Stop further script execution
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <link href="../css/bootstrap/bootstrap.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../css/expense-list.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>
</head>

<body>
<?php 
include("../sidebar/navbar.php")
?>
    <div class="container petty_cash mt-5">
        <?php
        if (isset($_SESSION['status'])) {
        ?>
            <div class="text-center">
                <div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert" style="width: 300px; border-radius: 20px;">
                    <strong> Hey! </strong> <?php echo $_SESSION['status']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php

            unset($_SESSION['status']);
        }

        if (isset($_SESSION['status1'])) {
        ?>
            <div class="text-center">
                <div class="alert alert-success alert-dismissible fade show mx-auto" role="alert" style="width: 300px; border-radius: 20px;">
                    <strong> Hey! </strong> <?php echo $_SESSION['status1']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php

            unset($_SESSION['status1']);
        }
        ?>

        <div class="container border border-dark rounded w-75">
            <h1 class="d-flex justify-content-center">Expense List</h1>
            <h3>Total: ₱<?php echo $output ?></h3>
            <div class="container-fluid d-flex justify-content-center">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Expense Account</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $row) {
                        ?>
                            <tr>
                                <th><?= $row['date'] ?></th>
                                <td><?= $row['expense'] ?></td>
                                <td><?= $row['amount'] ?></td>
                                <td>
                                <a href="../edit/edit_expense.php?id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
                                <a href="../edit/confirm_delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>

                                </td>
                            </tr>




                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




</body>

</html>