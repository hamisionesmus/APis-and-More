<?php

// Include the required library for accessing the Daraja API
require_once 'path/to/daraja-api-library.php';

// Define the Daraja API credentials
$consumer_key = 'your_consumer_key';
$consumer_secret = 'your_consumer_secret';

// Initialize the Daraja API client
$daraja = new Daraja($consumer_key, $consumer_secret);

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the phone number and amount from the form
    $phone_number = $_POST['phone_number'];
    $amount = $_POST['amount'];

    // Use the Daraja API to initiate the transaction
    $response = $daraja->mpesa->stkPush($phone_number, $amount);

    // Check if the transaction was successful
    if ($response->ResultCode == 0) {
        // The transaction was successful, save the details in the database
        // ... (code to save the details in the database)

        // Show a success message to the user
        echo 'Transaction successful, the amount of KES ' . $amount . ' has been deducted from your MPESA account.';
    } else {
        // The transaction was not successful, show an error message
        echo 'Transaction failed, please try again later.';
    }
}

?>

<!-- The form for entering the phone number and amount -->
<form method="post">
    <label for="phone_number">Phone number:</label>
    <input type="text" name="phone_number" id="phone_number" required>
    <br>
    <label for="amount">Amount:</label>
    <input type="text" name="amount" id="amount" required>
    <br>
    <input type="submit" name="submit" value="Submit">
</form>
