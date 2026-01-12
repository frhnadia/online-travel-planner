<?php
include '../db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $password = $_POST['password'];

    //Password validation
    if (strlen($password) < 8 || strlen($password) > 16) {
        $_SESSION['status'] = "Password must be between 8 and 16 characters!";
        $_SESSION['alert_type'] = "danger";
        header('Location: ../index.php');
        exit();
    }

    $checkSql = "SELECT User_ID FROM user WHERE User_Name = ? OR User_Email = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['status'] = "Username or email already exists!";
        $_SESSION['alert_type'] = "danger";
        header('Location: ../index.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertUserSql = "INSERT INTO user(User_Name, User_Email, User_Password)
                        VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertUserSql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if (!$stmt->execute()) {
        $_SESSION['status'] = "User registration failed!";
        $_SESSION['alert_type'] = "danger";
        header('Location: ../index.php');
        exit();
    }

    $userId = $conn->insert_id;

    $insertTravellerSql = "INSERT INTO traveller (Traveller_Name, Traveller_DOB, User_ID)
                            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($insertTravellerSql);
    $stmt->bind_param("ssi", $name, $dob, $userId);

    if (!$stmt->execute()) {
        $_SESSION['status'] = "Traveller registration failed!";
        $_SESSION['alert_type'] = "danger";
        header('Location: ../index.php');
        exit();
    }

    $_SESSION['status'] = "Registration succesful!";
    $_SESSION['alert_type'] = "success";
    header('Location: ../index.php');
    exit();
}
$conn->close();
?>