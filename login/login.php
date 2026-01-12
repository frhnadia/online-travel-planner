<?php
include '../db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT User_ID, User_Name, User_Password
            FROM user
            WHERE User_Name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['User_Password'])) {

            // Set session variables
            $_SESSION['User_ID'] = $user['User_ID'];
            $_SESSION['User_Name'] = $user['User_Name'];
            $_SESSION['status'] = "Login successful!";
            $_SESSION['alert_type'] = "success";

            // Redirect to traveller home
            header('Location: ../traveller/home_traveller.php');
            exit();

        } else {
            // Wrong password
            $_SESSION['status'] = "Invalid username or password!";
            $_SESSION['alert_type'] = "danger";
        }

    } else {
        // Username not found
        $_SESSION['status'] = "Invalid username or password!";
        $_SESSION['alert_type'] = "danger";
    }

    // Redirect back to login page
    header('Location: ../index.php');
    exit();
}
?>