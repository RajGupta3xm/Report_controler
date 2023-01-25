

<?php
$shaString  = '';
$amount = 1000;
$requestParams = array(
'service_command' => 'SDK_TOKEN',
'access_code' => 'u1KTPwtYrFxIz7R4zVJ4',
'merchant_identifier' => '7854d862',
'language'             =>'en',
'device_id'           =>'test10',

);

// sort an array by key
ksort($requestParams);
foreach ($requestParams as $key => $value) {
    $shaString .= "$key=$value";
}
// echo $shaString;
// make sure to fill your sha request pass phrase
$shaString = "54LZYmF815xFCQEsYUH/yl]@" . $shaString . "54LZYmF815xFCQEsYUH/yl]@";
// echo $shaString;
$signature = hash("SHA256", $shaString);
// your request signature
// echo "signature key ========>>>>>>>>>".$signature;

error_reporting(E_ALL);
ini_set('display_errors', '1');

$url = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';

$arrData = array(
'service_command' => 'SDK_TOKEN',
'access_code' => 'u1KTPwtYrFxIz7R4zVJ4',
'merchant_identifier' => '7854d862',
'language' => 'en',
'device_id'=> 'test10',
'signature' => $signature,
);

$ch = curl_init( $url );
# Setup request to send json via POST.
$data = json_encode($arrData);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);
# Print response.
echo "<pre>$result</pre>";

$requestParams['signature'] = $signature;

// $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
// echo "<html xmlns='https://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
// echo "<form action='$redirectUrl' method='post' name='frm'>\n";
// foreach ($requestParams as $a => $b) {
//     echo "\t<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>\n";
// }
// echo "\t<script type='text/javascript'>\n";
// echo "\t\tdocument.frm.submit();\n";
// echo "\t</script>\n";
// echo "</form>\n</body>\n</html>";

 ?>