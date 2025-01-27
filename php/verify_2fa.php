<?php
require 'db_connection.php';
require 'vendor/autoload.php';
$ga = new PHPGangsta_GoogleAuthenticator();

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];

    // Retrieve the user's 2FA secret
    $sql = "SELECT 2fa_secret FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($ga->verifyCode($user['2fa_secret'], $code, 2)) {
        echo "2FA verification successful!";
    } else {
        echo "Invalid 2FA code.";
    }

    $stmt->close();
    $conn->close();
}
?>
