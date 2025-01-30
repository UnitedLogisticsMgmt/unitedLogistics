<?php
require '../db_connection.php'; // Correct path to db_connection.php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email input
    $password = $_POST['password'];

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

            if (!empty($user['2fa_secret'])) {
                // Redirect to 2FA verification page
                header("Location: ../user/verify_2fa.html"); // Updated path if verify_2fa.html is in the user subdirectory
                exit();
            } else {
                // Redirect to dashboard or any authenticated page
                header("Location: dashboard.php"); // Updated path if dashboard.php is in the php subdirectory
                exit();
            }
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo "No account found with that email. Please try again.";
    }

    $stmt->close();
    $conn->close();
}
?>
