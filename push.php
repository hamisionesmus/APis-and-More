<?php
// Replace with your server key from Firebase Console
$server_key = "YOUR_SERVER_KEY";

// Replace with the device token you want to send the notification to
$device_token = "DEVICE_TOKEN";

// Notification data
$data = [
    "title" => "New Notification",
    "body" => "This is a test notification",
];

// Send notification to device
sendNotification($server_key, $device_token, $data);

// Function to send the notification
function sendNotification($server_key, $device_token, $data) {
    $headers = [
        'Authorization: key=' . $server_key,
        'Content-Type: application/json',
    ];
    $payload = [
        'to' => $device_token,
        'notification' => $data,
    ];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}


// Sending push notifications from a PHP application can be done using a third-party push notification service such as Firebase Cloud Messaging (FCM) or OneSignal. Here's an example of how you can send push notifications using Firebase Cloud Messaging in PHP:
  // In the above code, the server key and device token are set as $server_key and $device_token respectively. The notification data is set as $data. The sendNotification function is used to send the notification, which makes a POST request to the FCM API endpoint with the server key, device token, and notification data. The result of the request is stored in the $result variable and returned by the function.