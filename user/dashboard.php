<?php
require '../db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['user_role'];

// Fetch user-specific data from the database
$sql = "SELECT * FROM user_data WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <?php if ($userRole == 'admin'): ?>
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin!</p>
        <!-- Add more admin-specific content here -->
    <?php else: ?>
        <h2>User Dashboard</h2>
        <p>Welcome, <?php echo ucfirst($userRole); ?>!</p>
        <p>Your personalized data:</p>
        <ul>
            <li>Name: <?php echo isset($userData['name']) ? htmlspecialchars($userData['name']) : 'No data available'; ?></li>
            <li>Email: <?php echo isset($userData['email']) ? htmlspecialchars($userData['email']) : 'No data available'; ?></li>
            <li>Other Info: <?php echo isset($userData['other_info']) ? htmlspecialchars($userData['other_info']) : 'No data available'; ?></li>
        </ul>
        <!-- Add more user-specific content here -->
    <?php endif; ?>
    <p>User ID: <?php echo $_SESSION['user_id']; ?></p>
    <p>User Role: <?php echo $_SESSION['user_role']; ?></p>
</body>
</html>
