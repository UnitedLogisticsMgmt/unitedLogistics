<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST["fq_name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["fq_email"], FILTER_SANITIZE_EMAIL);

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email injection prevention
        if (preg_match("/[\r\n]/", $email)) {
            die("Invalid email address.");
        }

        $to = "unitedlogisticsmgmt@gmail.com"; // Your email address
        $subject = "New Quote Request";
        $message = "A new user has requested a quote with the following details:\n\nName: $name\nEmail: $email";
        $headers = "From: no-reply@unitedlogisticsmgmt.com\r\n" .
                   "Reply-To: no-reply@unitedlogisticsmgmt.com\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo "Thank you for requesting a quote! We will get back to you soon.";
        } else {
            echo "There was an error sending your request. Please try again.";
        }
    } else {
        echo "Please enter a valid name and email address.";
    }
} else {
    // Only allow POST requests
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
