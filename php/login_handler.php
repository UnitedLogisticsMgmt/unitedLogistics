<?php
require '../db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            echo "Login successful!";
            // Redirect to a logged-in page, e.g., dashboard.php
            header('Location: ../user/dashboard.php');
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "No account found with that email address.";
    }

    $stmt->close();
    $conn->close();
}
?>
