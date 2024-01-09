<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $serviceName = $_POST["serviceName"];
    $contact = $_POST["contact"];
    $message = $_POST["message"];

    // SEND SMS
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://sms.arkesel.com/api/v2/sms/send',
        CURLOPT_HTTPHEADER => ['api-key: OnFMYmxraDIzc1BFWG5LWlM='],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query([
            'sender' => "$serviceName",
            'message' => "$message",
            'recipients' => ["$contact"]
        ]),
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    $response = array("status" => "success", "message" => "Message Sent");
    echo json_encode($response);

} else {
    // Handle invalid request method
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}

