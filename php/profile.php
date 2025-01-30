<?php
require '../db_connection.php'; // Ensure correct path to db_connection.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.html");
    exit();
}

$userId = $_SESSION['user_id'];

// Retrieve user information from the database
$sql = "SELECT email, role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
</head>
<body>
    <h2>User Profile</h2>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
    
    <form action="update_profile.php" method="POST">
        <label for="email">Update Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <br>
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" value="Update Profile">
    </form>
</body>
</html>
