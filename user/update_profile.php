<?php
session_start();
include("../config.php");

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['address'])) {
        $updatedUsername = mysqli_real_escape_string($con, $_POST['username']);
        $updatedEmail = mysqli_real_escape_string($con, $_POST['email']);
        $updatedAddress = mysqli_real_escape_string($con, $_POST['address']);

        // Update user information in the database
        $updateUserQuery = "UPDATE users SET name = '$updatedUsername', email = '$updatedEmail', address = '$updatedAddress' WHERE id = '$user_id'";
        $runUpdateQuery = mysqli_query($con, $updateUserQuery);

        if ($runUpdateQuery) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}
?>