<!DOCTYPE HTML>
<html>
<head>
    <style>
        html, body {
            margin: 0;
            padding: 0;
        }

        .error {
            width: 100%;
            margin: 0;
            border-bottom: 1px solid black;
            background-color: #FFEC8B;
            text-align: center;
            font-size: 1em;
            font-weight: bold;
            color: red;
            padding: 0;
        }
    </style>
</head>
<body>
<?php
/**
 * Created by Gestpay.
 * Date: 13/03/17
 * Time: 12:32
 *
 * This example shows a way to use callUpdateTokenS2S with the minimum required parameters.
 * callUpdateTokenS2S is described here: http://docs.gestpay.it/adv/update-tokens.html
 * the API: http://api.gestpay.it/#callupdatetokens2s
 *
 */

//display errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*****************************************************************
 * TEST ENVIRONMENT: if set to false, this example will launch
 * against the production server.
 *****************************************************************/

$testEnv = true;

/*****************************************************************
 * INPUT DATA
 *****************************************************************/

$shopLogin = 'GESPAY65987';
$token = '54L76F8OSOAK1018';
$expiryMonth = '05';
$expiryYear = '17';
$withAut = 'Y';

/****************************************************************
 * CREATING SOAP ARGUMENTS
 * The $param variable will contain the argument for the S2S call.
 * If you add more parameters you must add them here.
 ****************************************************************/


//Set up the parameters array. This array will be the argument for the SOAP call.
$param = array(
    'shopLogin' => $shopLogin,
    'token' => $token,
    'expiryMonth' => $expiryMonth,
    'expiryYear' => $expiryYear,
    'withAut' => $withAut
);


/****************************************************************
 * CALL callUpdateTokenS2S
 ****************************************************************/
//setting up the WSDL url
$wsdl = "https://ecomms2s.sella.it/gestpay/gestpayws/WSs2s.asmx?WSDL";
if ($testEnv) {
    //Test
    $wsdl = "https://testecomm.sella.it/gestpay/gestpayws/WSs2s.asmx?WSDL";
}

//Soap client
$client = new SoapClient($wsdl);

//do the call to Encrypt method
try {
    $objectResult = $client->callUpdateTokenS2S($param);
} //catch SOAP exceptions
catch (SoapFault $fault) {
    die($fault);
}

//parse the XML result
$result = simplexml_load_string($objectResult->CallUpdateTokenS2SResult->any);

//Error Check
$errCode = (string)$result->ErrorCode;
$errDesc = (string)$result->ErrorDescription;

if ($errCode != "0") {
    //An error has occurred;  check ErrorCode and ErrorDescription
    echo '<div class="error">Error: ';
    echo $errCode;
    echo '<br>ErrorDesc: ';
    echo $errDesc;
    echo '</div>';
}
//this is the output
echo '<pre>';
print_r($result);
echo '</pre>';

?>
</body>
</html>

