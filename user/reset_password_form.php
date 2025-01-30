<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="../php/reset_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>" required>
        <label for="password">New Password:</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
