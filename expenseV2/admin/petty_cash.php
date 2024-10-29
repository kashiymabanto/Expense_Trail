<?php
session_start();
include("../db/connection.php"); // Includes the database connection file to establish a connection to the database
include("../db/function.php");   // Includes additional functions from the function.php file



// Check if the user is logged in and retrieve user data
$user_data = check_login($con); // Calls a function to verify the user's login status and get their data

// Verify the user's type to ensure they have the appropriate permissions
if ($user_data['user_type'] !== '2') {
    // If the user is not of the required type (user_type '1'), redirect to the signout page
    // This ensures that only users with the appropriate permissions can access the page
    header("Location: ../signout.php");
    exit(); // Stop further script execution
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="../css/admin-petty.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash</title>
</head>

<body>
   <?php 
   include("../sidebar/admin-navbar.php");
   ?>
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
    <div class="container mt-5 pt-2">
        <div class="container mt-5 pt-5">

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="container-fluid d-flex justify-content-center petty_cash mt-2">

                        <div class="box border border-dark rounded-2 w-75 ">
                            <h1 class="text-center mt-3">Petty Cash</h1>
                            <div class="container">
                                <div class="row">

                                    <form action="../db/crud.php" method="POST">
                                        <div class="col-md-12">
                                            <input type="hidden" value="<?= $user_data['id']; ?>" name="id">
                                            <label for="inputUsername" class="form-label"><b>Date</b></label>
                                            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label for="inputUsername" class="form-label"><b>Petty Cash</b></label>
                                            <input type="text" name="cash" class="form-control" placeholder="Amount">
                                        </div>
                                        <div class="col-md-12 mt-3 d-flex justify-content-evenly">
                                            <button type="submit" name="add_cash" class="btn btn-warning petty_btn">Add</button>
                                        </div>
                                    </form>
                                    </br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>






</body>

</html>