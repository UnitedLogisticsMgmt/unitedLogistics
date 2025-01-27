<?php
require 'db_connection.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // Ensure to handle this safely, possibly with a dropdown

    // Generate a unique email verification token
    $verification_token = bin2hex(random_bytes(50));

    // Insert the new user into the database
    $sql = "INSERT INTO users (email, password, role, verification_token) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $password, $role, $verification_token);

    if ($stmt->execute()) {
        // Send verification email
        $verificationLink = "https://unitedlogisticsmgmt.com/verify_email.php?token=" . $verification_token;
        $subject = "Email Verification";
        $message = "Click the following link to verify your email: " . $verificationLink;
        $headers = "From: no-reply@unitedlogisticsmgmt.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Registration successful! Please verify your email.";
        } else {
            echo "Failed to send verification email.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
