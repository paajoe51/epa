<?php

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
        'sender' => 'EPADAC-IPMC',
        'message' => $message,
        'recipients' => [$number]
    ]),
]);

$response = curl_exec($curl);
curl_close($curl);

$response = json_decode($response, true);
       // Extract values from the decoded data
    $id = $response['data'][0]['id'];
    $recipient = $response['data'][0]['recipient'];
    $status = $response['status'];
    
    include('conn.php');
    $sql = "INSERT INTO sms_log (sms_id, recipient, status) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);

    // Bind the values to the placeholders
    $stmt->bindParam(1, $id, PDO::PARAM_STR);
    $stmt->bindParam(2, $recipient, PDO::PARAM_STR);
    $stmt->bindParam(3, $status, PDO::PARAM_STR);

    // Execute the statement
    $stmt->execute();

    if ($stmt->execute()) {
        $sms_save=true;
    } else {
        $sms_save=false;
    }
    //echo $response;
?>