<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>
    <?php include '../header.php'; ?>
    <h2>Forgot Password</h2>
    <form action="../php/forgot_password.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
