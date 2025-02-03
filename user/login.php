<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <?php include '../header.php'; ?>
    <h2>Login</h2>
    <form action="../php/login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <br>
    <a href="../user/signup.php"><button>Sign Up</button></a>
    <a href="../user/forgot_password.php"><button>Forgot Password</button></a>
</body>
</html>
