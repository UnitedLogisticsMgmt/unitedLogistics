<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email injection prevention
        if (preg_match("/[\r\n]/", $email)) {
            die("Invalid email address.");
        }

        $to = "unitedlogisticsmgmt@gmail.com"; // Your email address
        $subject = "New Newsletter Subscription";
        $message = "A new user has subscribed with the following email address: $email";
        $headers = "From: no-reply@unitedlogisticsmgmt.com"; // Your no-reply email address

        if (mail($to, $subject, $message, $headers)) {
            echo "Thank you for subscribing!";
        } else {
            echo "There was an error sending your subscription request. Please try again.";
        }
    } else {
        echo "Invalid email address. Please enter a valid email.";
    }
} else {
    // Only allow POST requests
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
