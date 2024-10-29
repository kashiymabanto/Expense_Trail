<?php
session_start();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/signup.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPENSE</title>
</head>

<<h1>Expense</h1>
    <div class="signup-form">
        <h2>Expense Sign Up</h2>
        <form action="db/crud.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Name">

            <label for="username">Username:</label>
            <input type="text" id="username" name="user"
                placeholder="Username">

            <label for="password">Password:</label>
            <input type="password" id="password"
                name="pass" placeholder="Password">

            <button type="submit" name="signup">SIGN UP</button>
        </form>
        <p>Already have an account? 
            <a href="index.php">Login here</a>
        </p>
    </div>

    </body>

</html>