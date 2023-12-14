<?php
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

//Database connection 
// $conn = new mysqli('sql12.freesqldatabase.com', 'sql12662934', 'CY2DyHwdab', 'sql12662934');
// if ($conn->connect_error) {
//     die('Connection Failed : ' . $conn->connect_error);
// } else {
//     $stmt = $conn->prepare("insert into EcoSphere (name, email, phone, query) 
//         values (?, ?, ?, ?)");
//     $stmt->bind_param("ssis", $name, $email, $phone, $message);
//     $stmt->execute();
//     echo nl2br("Record added to database Successfully...\n");
//     $stmt->close();
//     $conn->close();
// }

//Whatsapp message to customer
require __DIR__ . '/twilio-php-main/src/Twilio/autoload.php'; // Include Twilio PHP SDK

use Twilio\Rest\Client;

$accountSid = 'AC97c4672417c53b9a2fbf795ec993d65c';
$authToken = '14712da20482a837bcf0cf76b2fe2544';

$client = new Client($accountSid, $authToken);

$recipientNumber = 'whatsapp:' . '+91' . $phone; // The recipient's WhatsApp number
$businessNumber = 'whatsapp:+14155238886'; // Your WhatsApp Business Account number

$text = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

try {
    // Create a Twilio client
    $twilio = new Client($accountSid, $authToken);

    // Your Twilio API code here (e.g., sending an SMS)
    $message = $twilio->messages
        ->create(
            $recipientNumber, // To phone number
            [
                'from' => $businessNumber,
                'body' => 'Hello, this is a test message from EcoSphere!',
            ]
        );

    // Check if the message was sent successfully
    if ($message->status === 'sent') {
        echo 'Message sent successfully. SID: ' . $message->sid . PHP_EOL;
    } else {
        echo 'Failed to send message. Channel Sandbox can only send messages to phone numbers that have joined the Sandbox';
    }
} catch (Exception $e) {
    // Handle exceptions
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}




//Email to customer

require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: api-key
$config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');

// Create an instance of the TransactionalEmailsApi
$apiInstance = new Brevo\Client\Api\TransactionalEmailsApi(
    new GuzzleHttp\Client(),
    $config
);

// Create an instance of SendSmtpEmail
$sendSmtpEmail = new \Brevo\Client\Model\SendSmtpEmail([
    'to' => [
        ['email' => $email, 'name' => $name]
    ],
    'templateId' => 1,
    'params' => [
        'name' => $name,
        'email' => $email
    ]
]);

try {
    // Send the transactional email
    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
    
    // Present the result in a more readable format
    echo nl2br("\nEmail sent successfully!\n");
    echo "Message ID: " . $result->getMessageId() . "\n";
    // echo "Message IDs: " . implode(', ', $result->getMessageIds()) . "\n";
} catch (Exception $e) {
    // Handle exceptions
    echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
}


?>