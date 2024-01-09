<?php

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
    CURLOPT_CUSTOMREQUEST => 'GET',
]);

$response = curl_exec($curl);

curl_close($curl);
echo $response;