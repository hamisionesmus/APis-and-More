<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recipient email address
    $to = 'recipient@example.com';

    // Subject of the email
    $subject = 'New Request';

    // Message body
    $message = 'A new request has been made:';
    $message .= "\n\n";
    $message .= 'Name: ' . $_POST['name'];
    $message .= "\n";
    $message .= 'Email: ' . $_POST['email'];
    $message .= "\n";
    $message .= 'Message: ' . $_POST['message'];

    // Additional headers
    $headers = 'From: noreply@example.com' . "\r\n" .
        'Reply-To: ' . $_POST['email'] . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo 'Email sent successfully';
    } else {
        echo 'Email sending failed';
    }
}
?>

<form method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>
    <br>
    <input type="submit" value="Submit">
</form>
