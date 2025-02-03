<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Two-Factor Authentication</title>
</head>
<body>
    <?php include '../header.php'; ?>
    <h2>Verify Two-Factor Authentication</h2>
    <form action="../php/verify_2fa.php" method="POST">
        <label for="code">2FA Code:</label>
        <input type="text" name="code" id="code" required>
        <br>
        <input type="submit" value="Verify">
    </form>
</body>
</html>
