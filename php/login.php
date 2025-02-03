<?php
require '../db_connection.php';
require '../php/log_activity.php'; // Include the logging function
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email input
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please enter a valid email address.";
        log_activity("Login failed: Invalid email format for email: $email.");
        exit();
    }

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            log_activity("User with ID: {$_SESSION['user_id']} logged in.");

            if (!empty($user['2fa_secret'])) {
                // Redirect to 2FA verification page
                header("Location: ../user/verify_2fa.php");
                exit();
            } else {
                // Redirect to dashboard or any authenticated page
                header("Location: ../user/dashboard.php");
                exit();
            }
        } else {
            echo "Incorrect email or password. Please try again.";
            log_activity("Login failed: Incorrect password for email: $email.");
        }
    } else {
        echo "No account found with that email. Please <a href='../user/signup.php'>sign up</a>.";
        log_activity("Login failed: No account found for email: $email.");
    }

    $stmt->close();
    $conn->close();
}
