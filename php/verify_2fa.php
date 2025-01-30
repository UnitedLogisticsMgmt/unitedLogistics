<?php
require '../db_connection.php';
require '../vendor/autoload.php'; // Path to Composer's autoload file
session_start();

use PHPGangsta_GoogleAuthenticator;

$ga = new PHPGangsta_GoogleAuthenticator();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $userId = $_SESSION['user_id'];

    // Retrieve the user's 2FA secret
    $sql = "SELECT 2fa_secret FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($ga->verifyCode($user['2fa_secret'], $code, 2)) {
        // 2FA verification successful
        header("Location: dashboard.php"); // Redirect to the dashboard
        exit();
    } else {
        echo "Invalid 2FA code.";
    }

    $stmt->close();
    $conn->close();
}
?>
