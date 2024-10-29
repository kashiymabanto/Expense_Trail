<?php
session_start();
include("../db/connection.php");
include("../db/function.php");

$sql = "SELECT * FROM transaction INNER JOIN users ON transaction.users_id = users.id WHERE user_type = '1'";
$result = mysqli_query($con, $sql);


$user_data = check_login($con);
if ($user_data['user_type'] !== '2') {
    // Redirect to a different page or display an error message
    header("Location: ../signout.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../css//index-admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - home</title>
</head>

<body>
    <?php
    $page = 'history';
    include("../sidebar/admin-navbar.php");
    ?>
    <main>
        <div class="container-fluid mt-4">
            <div class="container d-flex justify-content-between">
                <h2 class="pt-3">Users Transaction</h2>
            </div>
            <div class="container table-borrwed mt-5">
                <table class="table table-striped mb-5 w-75 mx-auto table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Expense</th>
                            <th>Amount</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $row) {
                        ?>
                            <tr>
                                <td><?= $row['id']; ?>
                                <td><?= $row['name']; ?>
                                <td><?= $row['expense']; ?></td>
                                <td><?= $row['amount']; ?></td>
                                <td><?= $row['date']; ?></td>
                            </tr>

                        <?php } ?>
                </table>
            </div>
        </div>
    </main>





</body>

</html>