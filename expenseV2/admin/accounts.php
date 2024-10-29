<?php
session_start();
include("../db/connection.php"); // Includes the database connection file to establish a connection to the database
include("../db/function.php");   // Includes additional functions from the function.php file

// Check if the user is logged in and retrieve user data
$user_data = check_login($con); // Calls a function to verify the user's login status and get their data

// Verify the user's type to ensure they have the appropriate permissions
if ($user_data['user_type'] !== '2') {
    // If the user is not of the required type (user_type '1'), redirect to the signout page
    // This is used to prevent unauthorized access to certain parts of the application
    header("Location: ../signout.php");
    exit(); // Stop further script execution
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../css/bootstrap/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/accounts.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash</title>
</head>

<body>
<?php 
include("../sidebar/admin-navbar.php")
?>
    <div class="container mt-5 pt-2">
        <div class="container mt-5 pt-5">
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
        </div>
        <div class="container-fluid d-flex justify-content-center petty_cash">
            <div class="box border border-dark rounded-2 w-25">
                <h1 class="text-center mt-3">Accounts</h1>
                <div class="container">
                    <div class="row">

                        <form action="../db/crud.php" method="POST">
                            <div class="col-md-12 mt-3">
                                <label for="inputUsername" class="form-label"><b>Expense Account</b></label>
                                <input type="text" name="name" class="form-control" placeholder="Account">
                            </div>
                            <div class="col-md-12 mt-4 d-flex justify-content-center">
                                <center>
                                <button type="submit" name="account" class="btn btn-warning w-50">Add</button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>

</html>