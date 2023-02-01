<?php

use Ebay\DigitalSignature\Signature;
require 'vendor/autoload.php';

$signature = new Signature("example-config.json");
$endpoint = 'http://localhost:8080/verifysignature';

$headers = [
    'Content-Type' => 'application/json',
    'KLO' => 'KLOKLOKLO',
];

$body = '{"hello": "worldAAAFDFD"}';

$headers = $signature->generateSignatureHeaders($headers, $endpoint, "POST", $body);


var_export($headers);
// working headers
/*$headers = [
    'Content-Type' => 'application/json',
    'Signature-Input' => 'sig1=("content-digest" "x-ebay-signature-key" "@method" "@path" "@authority");created=1658440308',
    'Content-Digest' => 'sha-256=:X48E9qOokqqrvdts8nOJRJN3OWDUoyWxBf7kbu9DBPE=:',
    'x-ebay-enforce-signature' => 'true',
    'x-ebay-signature-key' => 'eyJ6aXAiOiJERUYiLCJlbmMiOiJBMjU2R0NNIiwidGFnIjoiSXh2dVRMb0FLS0hlS0Zoa3BxQ05CUSIsImFsZyI6IkEyNTZHQ01LVyIsIml2IjoiaFd3YjNoczk2QzEyOTNucCJ9.2o02pR9SoTF4g_5qRXZm6tF4H52TarilIAKxoVUqjd8.3qaF0KJN-rFHHm_P.AMUAe9PPduew09mANIZ-O_68CCuv6EIx096rm9WyLZnYz5N1WFDQ3jP0RBkbaOtQZHImMSPXIHVaB96RWshLuJsUgCKmTAwkPVCZv3zhLxZVxMXtPUuJ-ppVmPIv0NzznWCOU5Kvb9Xux7ZtnlvLXgwOFEix-BaWNomUAazbsrUCbrp514GIea3butbyxXLNi6R9TJUNh8V2uan-optT1MMyS7eMQnVGL5rYBULk.9K5ucUqAu0DqkkhgubsHHw',
    'Signature' => 'sig1=:ZMUpAejnqrt6POSx02ltx3cT9YODV2r+Cem/BKOagDSfztKOtCsjP/MxZqmY+FVJ3/8E4BL76T9Fjty8oJnsAw==:',
];


array (
  'Content-Type' => 'application/json',
  'Content-Digest' => 'sha-256=:B7rKiGCTXLTBlhc/78UYUgSP9ogQbz4l6PyelzCqbIM=:',
  'x-ebay-signature-key' => 'eyJ6aXAiOiJERUYiLCJlbmMiOiJBMjU2R0NNIiwidGFnIjoiSXh2dVRMb0FLS0hlS0Zoa3BxQ05CUSIsImFsZyI6IkEyNTZHQ01LVyIsIml2IjoiaFd3YjNoczk2QzEyOTNucCJ9.2o02pR9SoTF4g_5qRXZm6tF4H52TarilIAKxoVUqjd8.3qaF0KJN-rFHHm_P.AMUAe9PPduew09mANIZ-O_68CCuv6EIx096rm9WyLZnYz5N1WFDQ3jP0RBkbaOtQZHImMSPXIHVaB96RWshLuJsUgCKmTAwkPVCZv3zhLxZVxMXtPUuJ-ppVmPIv0NzznWCOU5Kvb9Xux7ZtnlvLXgwOFEix-BaWNomUAazbsrUCbrp514GIea3butbyxXLNi6R9TJUNh8V2uan-optT1MMyS7eMQnVGL5rYBULk.9K5ucUqAu0DqkkhgubsHHw',
  'Signature-Input' => 'sig1=("content-digest" "x-ebay-signature-key" "@method" "@path" "@authority");created=1658440308',
  'Signature' => 'sig1=:2AvPYMbUGXAo6hY8LfEX4RNT0Ak9Z5UNCxWeasAMxHSatN6qof6CX2J88+44TCpM4UuPryPNcXly7ORKsBcFDg==:',
  'x-ebay-enforce-signature' => 'true',
)
*/

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