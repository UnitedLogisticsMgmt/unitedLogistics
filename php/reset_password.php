<?php
require '../db_connection.php';
require '../php/log_activity.php'; // Include the logging function

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = filter_var($_POST['token'], FILTER_SANITIZE_STRING); // Sanitize token
    $newPassword = $_POST['password'];

    // Validate password length (for example, at least 8 characters)
    if (strlen($newPassword) < 8) {
        echo "Password must be at least 8 characters long.";
        log_activity("Password reset failed: Password too short for token: $token.");
        exit();
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Verify the token and check if it's still valid
    $sql = "SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Update the user's password and clear the token
        $sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $user['id']);
        $stmt->execute();

        echo "Password has been reset successfully.";
        log_activity("Password reset successful for user ID: {$user['id']}.");
    } else {
        echo "Invalid or expired token.";
        log_activity("Password reset failed: Invalid or expired token: $token.");
    }

    $stmt->close();
    $conn->close();
}
?>
