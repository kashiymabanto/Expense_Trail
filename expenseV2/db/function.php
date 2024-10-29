<?php

function check_login($con)
{
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1"; // Get user data based on session ID

        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result); // Fetch user data
            return $user_data; // Return user data if found
        }
    }

    header("Location: ../index.php"); // Redirect to login page if not found
    die; // Terminate the script
}
?>
