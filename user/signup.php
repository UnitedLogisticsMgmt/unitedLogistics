<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
</head>
<body>
    <?php include '../header.php'; ?>
    <h2>Signup</h2>
    <form action="../php/register.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="admin">Admin</option>
            <option value="affiliate">Affiliate</option>
            <option value="customer">Customer</option>
            <option value="employee">Employee</option>
            <option value="developer">Developer</option>
            <option value="partner">Partner</option>
        </select>
        <br>
        <input type="submit" value="Signup">
    </form>
</body>
</html>
