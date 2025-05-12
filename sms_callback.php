<?php
require_once 'sms.php';
// ussdandsms/sms_callback.php

// Log the incoming SMS (optional for debugging)
file_put_contents("sms_log.txt", json_encode($_POST) . PHP_EOL, FILE_APPEND);

// Extract SMS data
$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';
$text = $_POST['text'] ?? '';
$date = $_POST['date'] ?? '';
$messageId = $_POST['id'] ?? '';

if (!$from || !$text) {
    http_response_code(400);
    echo "Missing required fields.";
    exit;
}

// You can process the message here (e.g., save to DB, trigger action, send reply)
$response = "Received message from $from: $text";
echo $response;

// Optional: Send automated SMS reply if you want to


?>
