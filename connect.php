<?php

// Headers to deal with CORS errors when hosting the PHP remotely
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$checkWA = $_POST['wa-message'];
$checkEmail = $_POST['recv-email'];

// to test
// $name = "asd";
// $email = "yr94310@gmail.com";
// $phone = "123";
// $message = "asd";

// $checkWA = true;
// $checkEmail = true;

//Database connection
$dbHost = $_ENV["DB_HOST"];
$dbName = $_ENV["DB_NAME"];
$dbUser = $_ENV["DB_USERNAME"];
$dbPass = $_ENV["DB_PASSWORD"];

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO userqueries (Name, Email, Phone, Query) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $email, $phone, $message);
    $stmt->execute();
    echo nl2br("Record added to database Successfully...\n");
    $stmt->close();
    $conn->close();
}

//Whatsapp message to customer
use Twilio\Rest\Client;

if ($checkWA) {

    $accountSid = $_ENV['TWILIO_SID'];
    $authToken = $_ENV['TWILIO_AUTH_TOKEN'];

    if (!$accountSid || !$authToken) {
        die("Environment variables not loaded. SID: " . var_export($accountSid, true) . ", Token: " . var_export($authToken, true));
    }
    $client = new Client($accountSid, $authToken);

    $recipientNumber = 'whatsapp:' . '+91' . $phone; // The recipient's WhatsApp number
    $businessNumber = 'whatsapp:+14155238886';

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
                    'body' => 'Hello, this is a test message from EcoSphere!', // Modify this message as per need
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

} else {
    echo "Not checked for recieving whatsapp message\n";
}



//Email to customer

if ($checkEmail) {


    // Configure API key authorization: api-key
    $config = Brevo\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $_ENV['BREVO_API_KEY']);

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

} else {
    echo nl2br("\nNot checked for recieving email");
}

?>