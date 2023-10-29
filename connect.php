<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    //Database connection 
    $conn = new mysqli('localhost', 'root','', 'ecosphere_getInTouch'); 
    if($conn->connect_error){ 
        die('Connection Failed : '.$conn->connect_error); 
    }else{ 
        $stmt = $conn->prepare("insert into customer_data (name, email, phone, message) 
        values (?, ?, ?, ?)"); 
        $stmt->bind_param("ssis",$name, $email, $phone, $message); 
        $stmt->execute(); 
        echo "Record added to database Successfully...";
        $stmt->close(); 
        $conn->close();
    }

    //Whatsapp message to customer
    require __DIR__ . '/twilio-php-main/src/Twilio/autoload.php'; // Include Twilio PHP SDK

    use Twilio\Rest\Client;

    $accountSid = 'AC97c4672417c53b9a2fbf795ec993d65c';
    $authToken = '14712da20482a837bcf0cf76b2fe2544';

    $client = new Client($accountSid, $authToken);

    $recipientNumber = 'whatsapp:' . '+91'.$phone; // The recipient's WhatsApp number
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
        //PHP provides nl2br() function to insert the HTML line breaks
        echo nl2br("\nMessage sent SID: " . $message->sid);
    } catch (Exception $e) {
        echo nl2br("\nError: " . $e->getMessage());
    }
?>