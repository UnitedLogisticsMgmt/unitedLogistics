<?php
require 'db_connection.php';
require 'vendor/autoload.php';
$ga = new PHPGangsta_GoogleAuthenticator();

session_start();

if (isset($_SESSION['user_id'])) {
    $secret = $ga->createSecret();
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('UnitedLogisticsMgmt', $secret); // Change 'YourAppName' to 'UnitedLogisticsMgmt'

    echo '<img src="' . $qrCodeUrl . '" />';
    echo '<p>Secret: ' . $secret . '</p>';

    // Store the secret in the database
    $sql = "UPDATE users SET 2fa_secret = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $secret, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}
?>
