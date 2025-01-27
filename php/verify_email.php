<?php
require 'db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $sql = "UPDATE users SET email_verified = 1, verification_token = NULL WHERE verification_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);

    if ($stmt->execute()) {
        echo "Email verified successfully!";
    } else {
        echo "Invalid or expired token.";
    }

    $stmt->close();
    $conn->close();
}
?>
