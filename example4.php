<?php

use Ebay\DigitalSignature\Signature;
require 'vendor/autoload.php';

$signature = new Signature("example-config.json");
$endpoint = 'http://localhost:8080/verifysignature';
//$endpoint = 'https://api.sandbox.ebay.com/post-order/v2/cancellation/check_eligibility';

const USER_TOKEN = 'USE_YOUR_TOKEN';
$headers = [
    'Accept' => 'application/json',
    'Authorization' => 'IAF ' . USER_TOKEN,
    'Content-Type' => 'application/json',
    'X-EBAY-C-MARKETPLACE-ID' => NULL,
];
$body = '{"legacyOrderId":98467596}';


$headers = $signature->generateSignatureHeaders($headers, $endpoint, "POST", $body);


//Making a call
$ch = curl_init($endpoint);
if (!empty($body)) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
}
curl_setopt($ch, CURLOPT_HTTPHEADER, curlifyHeaders($headers));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
var_dump($error);
var_dump($info);



curl_close($ch);

echo "response: \n" . $response;

//Header array conversion
function curlifyHeaders($headers): array
{
    $new_headers = [];
    foreach ($headers as $header_name => $header_value) {
        $new_headers[] = $header_name . ': ' . $header_value;
    }

    return $new_headers;
}