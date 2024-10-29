<?php
session_start();

include("../db/connection.php");
include("../db/function.php");


$sql = "SELECT * FROM users WHERE user_type = '1'";
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

    <link rel="stylesheet" href="../css/index-admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users</title>
</head>

<body>
<?php
include("../sidebar/admin-navbar.php")
?>
            <main>
                <div class="container-fluid mt-4">
                    <div class="container d-flex justify-content-between">
                        <h2 class="pt-3">List of Users</h2>
                    </div>
                    <div class="container table-borrwed mt-5">
                        <table class="table table-striped mb-5 w-75 mx-auto table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td><?= $row['username']; ?></td>
                                    <td><?= $row['password']; ?></td>
                                    <td>
                                        <a href="../edit/edit_user.php?id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                                        <a href="../edit/delete_user.php?id=<?= $row['id']; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
    
    

</body>

</html>
