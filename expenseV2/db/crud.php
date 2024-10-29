<?php
session_start(); // Start the session to manage user sessions
include("connection.php"); // Include the database connection file

// --------------------------------- SIGNUP --------------------------------------
if (isset($_POST['signup'])) { // Check if the signup form is submitted
    $name = $_POST['name']; // Get the user's name from the POST data
    $user = $_POST['user']; // Get the username from the POST data
    $pass = $_POST['pass']; // Get the password from the POST data

    // SQL query to insert a new user into the users table
    $sql = "INSERT INTO users (name,username,password,user_type) VALUES ('$name','$user','$pass','1')";
    if (mysqli_query($con, $sql)) { // Execute the query
        $_SESSION['status1'] = "Signup Successfully"; // Set success message
        header('location: ../index.php'); // Redirect to signup page
    } else {
        $_SESSION['status'] = "Failed to signup"; // Set error message
        header('location: ../index.php'); // Redirect to signup page
    }
}
// --------------------------------- SIGNUP END -----------------------------------

// --------------------------------- ADD CASH --------------------------------------
if (isset($_POST['add_cash'])) { // Check if the add cash form is submitted
    $cash = $_POST['cash']; // Get the cash amount from the POST data
    $date = $_POST['date']; // Get the date from the POST data
    $id = $_POST['id']; // Get the user ID from the POST data

    // SQL query to check if there is already an entry for the given user ID
    $sql1 = "SELECT * FROM history_cash WHERE users_id = '$id'";
    $result = mysqli_query($con, $sql1);
    $row = mysqli_fetch_assoc($result); // Fetch the result

    $sql2 = "SELECT * FROM petty_cash";
    $result2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($result2); 

    // If there is no entry for the given date, insert a new entry
    if ($row['date'] != $date) {
        $newCash = $row2['cash'] + $cash;
        $sql = "INSERT INTO history_cash(cash,date,users_id) VALUES ('$cash','$date','$id')";
        $sql3 = "UPDATE petty_cash SET cash = '$newCash'";
        mysqli_query($con, $sql3); // Log the history entry
        
        if (mysqli_query($con, $sql)) {
            $_SESSION['status1'] = "Cash Added"; // Set success message
            header('location: ../admin/petty_cash.php'); // Redirect to petty cash page
        } else {
            $_SESSION['status'] = "Failed to add cash"; // Set error message
            header('location: ../admin/petty_cash.php'); // Redirect to petty cash page
        }
    } else {
        // Update the existing entry if the date matches
        $newCash = $row2['cash'] + $cash; // Calculate the new cash amount
        $sql2 = "UPDATE petty_cash SET cash = '$newCash'";
        $sql3 = "INSERT INTO history_cash (cash,date,users_id) VALUES ('$cash','$date','$id')";
        mysqli_query($con, $sql3); // Log the history entry
        
        if (mysqli_query($con, $sql2)) {
            $_SESSION['status1'] = "Cash Updated"; // Set success message
            header('location: ../admin/petty_cash.php'); // Redirect to petty cash page
        } else {
            $_SESSION['status'] = "Cash failed to update"; // Set error message
            header('location: ../admin/petty_cash.php'); // Redirect to petty cash page
        }
    }
}
// --------------------------------- ADD CASH END -----------------------------------

// --------------------------------- ADD ACCOUNT -----------------------------------
if (isset($_POST['account'])) { // Check if the add account form is submitted
    $name = $_POST['name']; // Get the account name from the POST data

    // SQL query to insert a new account into the expense_account table
    $sql = "INSERT INTO expense_account (name) VALUES ('$name')";
    if (mysqli_query($con, $sql)) {
        $_SESSION['status1'] = "Account Successfully Added"; // Set success message
        header('location: ../admin/accounts.php'); // Redirect to accounts page
    } else {
        $_SESSION['status'] = "Account failed to Add"; // Set error message
        header('location: ../admin/accounts.php'); // Redirect to accounts page
    }
}
// --------------------------------- ADD ACCOUNT END -------------------------------

// --------------------------------- PAY EXPENSE -----------------------------------
if (isset($_POST['pay'])) { // Check if the pay expense form is submitted
    $expense = $_POST['expense']; // Get the expense name from the POST data
    $amount = $_POST['cash']; // Get the cash amount from the POST data
    $date = $_POST['date']; // Get the date from the POST data
    $id = $_POST['id']; // Get the user ID from the POST data

    // SQL query to fetch the user's petty cash
    $sql1 = "SELECT * FROM petty_cash";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($result1); // Fetch the result

    // Check if there are sufficient funds to pay the expense
    if ($row1['cash'] >= $amount) {
        $newCash = $row1['cash'] - $amount; // Calculate the new cash amount
        $sql2 = "UPDATE petty_cash SET cash = '$newCash'";
        mysqli_query($con, $sql2); // Update the petty cash

        // SQL query to log the transaction
        $sql = "INSERT INTO transaction (expense,amount,date,users_id) VALUES ('$expense','$amount','$date','$id')";
        if (mysqli_query($con, $sql)) {
            $_SESSION['status1'] = "Transaction Successfully Added"; // Set success message
            header('location: ../users/expense.php'); // Redirect to expense page
        } else {
            $_SESSION['status'] = "Transaction failed to Add"; // Set error message
            header('location: ../users/expense.php'); // Redirect to expense page
        }
    } else {
        $_SESSION['status'] = "Insufficient Funds"; // Set error message for insufficient funds
        header('location: ../users/expense.php'); // Redirect to expense page
    }
}
// --------------------------------- PAY EXPENSE END -------------------------------

// --------------------------------- EXPENSE LIST -----------------------------------
if (isset($_POST['edit_expense'])) { // Check if the edit expense form is submitted
    $expense = $_POST['expense']; // Get the expense name from the POST data
    $amount = $_POST['cash']; // Get the cash amount from the POST data
    $id = $_POST['id']; // Get the transaction ID from the POST data
    $eid = $_POST['eid']; // Get the user ID from the POST data

    // SQL query to fetch the current transaction details
    $sql1 = "SELECT * FROM transaction WHERE id = '$id'";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($result1); // Fetch the result

    // SQL query to fetch the user's petty cash details
    $sql2 = "SELECT * FROM petty_cash";
    $result2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($result2); // Fetch the result

    // Check if there are sufficient funds for the new amount
    if ($row2['cash'] >= $amount) {
        if ($row1['amount'] >= $amount) { // If the new amount is less than or equal to the current amount
            $newCash = $row1['amount'] - $amount; // Calculate the cash difference
            $newCash1 = $newCash + $row2['cash']; // Update petty cash
            $sql2 = "UPDATE petty_cash SET cash = '$newCash1'";
            mysqli_query($con, $sql2); // Update the petty cash

            // Update the transaction with the new amount
            $sql3 = "UPDATE transaction SET amount = '$amount' WHERE id = '$id'";
            if (mysqli_query($con, $sql3)) {
                $_SESSION['status1'] = "Amount Successfully Edited"; // Set success message
                header('location: ../users/expense-list.php'); // Redirect to expense list
            } else {
                $_SESSION['status'] = "Amount failed to Edit"; // Set error message
                header('location: ../users/expense-list.php'); // Redirect to expense list
            }
        } else {
            // If the new amount is greater than the current amount
            $newCash2 = $amount - $row1['amount']; // Calculate the difference
            $newCash3 = $row2['cash'] - $newCash2; // Deduct from petty cash
            $sql2 = "UPDATE pety_cash SET cash = '$newCash3'";
            mysqli_query($con, $sql2); // Update the petty cash

            // Update the transaction with the new amount
            $sql3 = "UPDATE transaction SET amount = $amount WHERE id = '$id'";
            if (mysqli_query($con, $sql3)) {
                $_SESSION['status1'] = "Amount Successfully Edited"; // Set success message
                header('location: ../users/expense-list.php'); // Redirect to expense list
            } else {
                $_SESSION['status'] = "Amount failed to Edit"; // Set error message
                header('location: ../users/expense-list.php'); // Redirect to expense list
            }
        }
    }
}

// --------------------------------- DELETE EXPENSE ------------------------------
if (isset($_POST['delete_expense'])) { // Check if the delete expense form is submitted
    $id = $_POST['id']; // Get the transaction ID from the POST data
    $eid = $_POST['eid']; // Get the user ID from the POST data

    // SQL query to fetch the transaction details
    $sql1 = "SELECT * FROM transaction WHERE id = '$id'";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_assoc($result1); // Fetch the result

    // SQL query to fetch the user's petty cash details
    $sql2 = "SELECT * FROM petty_cash";
    $result2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_assoc($result2); // Fetch the result

    $newamount = $row2['cash'] + $row1['amount']; // Calculate the new cash amount to restore funds

    $sql = "DELETE FROM transaction WHERE id = $id"; // SQL query to delete the transaction
    if (mysqli_query($con, $sql)) {
        // Update the petty cash to restore funds
        $sql3 = "UPDATE petty_cash SET cash = '$newamount'";
        mysqli_query($con, $sql3);

        $_SESSION['status1'] = "Deleted Successfully"; // Set success message
        header('location: ../users/expense-list.php'); // Redirect to expense list
    } else {
        $_SESSION['status'] = "Failed to delete"; // Set error message
        header('location: ../users/expense-list.php'); // Redirect to expense list
    }
}
// --------------------------------- DELETE EXPENSE END ----------------------------

// --------------------------------- USER EDIT -------------------------------------
if (isset($_POST['edit_user'])) { // Check if the edit user form is submitted
    $id = $_POST['id']; // Get the user ID from the POST data
    $name = $_POST['name']; // Get the user's name from the POST data
    $user = $_POST['user']; // Get the username from the POST data
    $pass = $_POST['pass']; // Get the password from the POST data

    // SQL query to update the user details
    $sql = "UPDATE users SET name = '$name', username = '$user', password = '$pass' WHERE id = '$id'";
    if (mysqli_query($con, $sql)) {
        $_SESSION['status1'] = "User Successfully Edited"; // Set success message
        header('location: ../admin/index.php'); // Redirect to admin index
    } else {
        $_SESSION['status'] = "Failed to edit user"; // Set error message
        header('location: ../admin/index.php'); // Redirect to admin index
    }
}

// --------------------------------- DELETE USER -------------------------------------
if (isset($_POST['delete_user'])) { // Check if the delete user form is submitted
    $id = $_POST['id']; // Get the user ID from the POST data

    // SQL query to delete the user
    $sql = "DELETE FROM users WHERE id = '$id'";
    if (mysqli_query($con, $sql)) {
        $_SESSION['status1'] = "User Successfully Deleted"; // Set success message
        header('location: ../admin/index.php'); // Redirect to admin index
    } else {
        $_SESSION['status'] = "Failed to delete user"; // Set error message
        header('location: ../admin/index.php'); // Redirect to admin index
    }
}
// --------------------------------- USER EDIT END ---------------------------------
?>
