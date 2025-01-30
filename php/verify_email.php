<?php
require '../db_connection.php';
session_start();

if (isset($_GET['token'])) {
    $token = filter_var($_GET['token'], FILTER_SANITIZE_STRING); // Sanitize token

    // Verify the token
    $sql = "SELECT * FROM users WHERE email_verification_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Update the user's email_verified status and clear the token
        $sql = "UPDATE users SET email_verified = 1, email_verification_token = NULL WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();

        echo "Email verification successful! You can now log in.";
    } else {
        echo "Invalid or expired token.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No token provided.";
}
?>
