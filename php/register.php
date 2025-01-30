<?php
require '../db_connection.php';
require '../php/log_activity.php'; // Include the logging function
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Define the allowed roles
    $allowed_roles = ['admin', 'affiliate', 'customer', 'employee', 'developer', 'partner'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please enter a valid email address.";
        log_activity("Registration failed: Invalid email format for email: $email.");
        exit();
    }

    // Validate password length (for example, at least 8 characters)
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        log_activity("Registration failed: Password too short for email: $email.");
        exit();
    }

    // Validate role
    if (!in_array($role, $allowed_roles)) {
        echo "Invalid role selected. Please select a valid role.";
        log_activity("Registration failed: Invalid role selected for email: $email.");
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "Registration successful! You can now <a href='../user/login.html'>log in</a>.";
        log_activity("User registered: Email: $email, Role: $role.");
    } else {
        echo "Error: Registration failed. Please try again later.";
        log_activity("Registration failed: Database error for email: $email.");
    }

    $stmt->close();
    $conn->close();
}
?>
