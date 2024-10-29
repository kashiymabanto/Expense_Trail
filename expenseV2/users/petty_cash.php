<?php
session_start();
include("../db/connection.php"); // Includes the database connection file to establish a connection to the database
include("../db/function.php");   // Includes additional functions from the function.php file

// SQL query to fetch all cash history records for the current user
$sql1 = "SELECT * FROM history_cash";
$result1 = mysqli_query($con, $sql1); // Execute the query to retrieve cash history records

// SQL query to calculate the total cash from the petty_cash table for the current user
$sql = "SELECT sum(cash) as total FROM petty_cash";
$row3 = mysqli_query($con, $sql); // Execute the query to get the total cash amount

// Loop through the results to fetch the total cash amount
while ($row2 = mysqli_fetch_assoc($row3)) {
    $output = $row2['total']; // Store the total cash in the $output variable
}
//     $output = $row2['total']; // Store the total cash in the $output variable
// }

// Check if the user is logged in and retrieve user data
$user_data = check_login($con); // Calls a function to verify the user's login status and get their data

// Verify the user's type to ensure they have the appropriate permissions
if ($user_data['user_type'] !== '1') {
    // If the user is not of the required type (user_type '1'), redirect to the signout page
    // This ensures that only users with the appropriate permissions can access the page
    header("Location: ../signout.php");
    exit(); // Stop further script execution
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="../css/petty_cash.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash</title>
</head>

<body>
   <?php 
   include("../sidebar/navbar.php");
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
                
                </div>
                <div class="container petty_cash mt-4 col-md-6 mb-4">
                    <div class="box2 border border-dark rounded-2 w-75 ">
                        <h1 class="text-center mt-3">Petty Cash</h1>
                        <div class="container">
                            <h6>Total:
                                 ₱<?php echo $output; ?>
                        </h6>
                            <hr>
                            <div class="container d-flex justify-content-between w-75">
                                <span>Date</span>
                                <span>Cash</span>
                            </div>
                            <hr>
                            <!-- <?php if ($result1 && mysqli_num_rows($result1) > 0) {   ?>
                                <?php foreach ($result1 as $row) { ?> -->
                                    <div class="container d-flex justify-content-between w-75">
                                        <span><?= $row['date'] ?></span>
                                        <span><?= $row['cash'] ?></span>
                                    </div>
                                <!-- <?php } ?>

                            <?php } else { ?> -->
                                <span>No records found.</span>
                            <!-- <?php } ?> -->

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