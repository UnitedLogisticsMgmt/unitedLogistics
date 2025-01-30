<?php
require '../db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $newEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $newPassword = $_POST['password'];

    // Validate email format
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Update user information in the database
    if (!empty($newPassword)) {
        // Validate password length (for example, at least 8 characters)
        if (strlen($newPassword) < 8) {
            echo "Password must be at least 8 characters long.";
            exit();
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $newEmail, $hashedPassword, $userId);
    } else {
        $sql = "UPDATE users SET email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newEmail, $userId);
    }

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
