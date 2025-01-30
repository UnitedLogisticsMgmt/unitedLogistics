<?php
require '../db_connection.php';
require '../php/log_activity.php'; // Include the logging function

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email input

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please enter a valid email address.";
        log_activity("Forgot Password failed: Invalid email format for email: $email.");
        exit();
    }

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Store the token in the database
        $sql = "UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send reset link to the user's email
        $resetLink = "https://unitedlogisticsmgmt.com/php/reset_password.php?token=" . $token; // Update the URL to include the php subdirectory
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: " . $resetLink;
        $headers = "From: no-reply@unitedlogisticsmgmt.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
            log_activity("Password reset link sent to email: $email.");
        } else {
            echo "Failed to send the email.";
            log_activity("Password reset email failed to send for email: $email.");
        }
    } else {
        echo "No account found with that email.";
        log_activity("Password reset failed: No account found for email: $email.");
    }

    $stmt->close();
    $conn->close();
}
?>
