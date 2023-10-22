<?php
require __DIR__ . '/twilio-php-main/src/Twilio/autoload.php'; // Include Twilio PHP SDK

use Twilio\Rest\Client;

$accountSid = 'AC97c4672417c53b9a2fbf795ec993d65c';
$authToken = '7ceeb39c21c9d16702a7780b939b6c6e';

$client = new Client($accountSid, $authToken);

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$recipientNumber = 'whatsapp:' . $_POST['phone']; // The recipient's WhatsApp number
$businessNumber = 'whatsapp:+14155238886'; // Your WhatsApp Business Account number

$text = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

try {
    $message = $client->messages->create(
        $recipientNumber,
        array(
            'from' => $businessNumber,
            'body' => $text
        )
    );
    echo "Message sent SID: " . $message->sid;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
