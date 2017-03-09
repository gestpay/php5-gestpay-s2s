<?php
/**
 * Created by Gestpay.
 * Date: 08/03/17
 * Time: 12:32
 *
 * This example shows a way to use callVerifycardS2S with the minimum required parameters.
 * callVerifycardS2S is described here: http://docs.gestpay.it/adv/card-verification.html
 * the API: http://api.gestpay.it/#callverifycards2s
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
 * MANDATORY DATA
 *****************************************************************/

$shopLogin = "GESPAY65987";
$shopTransactionId = "GESTPAY_S2S_".date("Y-m-d-H-i-s");
$cardNumber = "4775718800001010";
$expMonth = "05";
$expYear = "17";
$CVV2 = "999";

/****************************************************************
 * CREATING SOAP ARGUMENTS
 * The $param variable will contain the argument for the S2S call.
 * If you add more parameters you must add them here.
 ****************************************************************/


//Set up the parameters array. This array will be the argument for the SOAP call.
$param = array(
    'shopLogin' => $shopLogin,
    'shopTransactionId' => $shopTransactionId,
    'cardNumber' => $cardNumber,
    'expMonth' => $expMonth,
    'expYear' => $expYear,
    'CVV2' => $CVV2
);


/****************************************************************
 * CALL callVerifycardS2S
 ****************************************************************/
$wsdl = null;
//setting up the WSDL url
if ($testEnv) {
    //Test
    $wsdl = "https://testecomm.sella.it/gestpay/gestpayws/WSs2s.asmx?WSDL";
} else {
    //Production
    $wsdl = "https://ecomms2s.sella.it/gestpay/gestpayws/WSs2s.asmx?WSDL";
}

//Soap client
$client = new SoapClient($wsdl);

//do the call to Encrypt method
try {
    $objectResult = $client->callVerifycardS2S($param);
} //catch SOAP exceptions
catch (SoapFault $fault) {
    die($fault);
}
//parse the XML result
$result = simplexml_load_string($objectResult->callVerifycardS2SResult->any);

//Error Check
$errCode = (string) $result->ErrorCode;
$errDesc = (string) $result->ErrorDescription;

if ($errCode !== "0") {
    //An error has occurred;  check ErrorCode and ErrorDescription
    echo '<!DOCTYPE HTML><html><head><style>html,body{margin: 0;padding: 0;} .error{width:100%;margin:0;border-bottom:1px solid black;background-color:#FFEC8B;text-align:center;font-size:1em;font-weight:bold;color:red;padding: 0;}</style></head><html><body>';
    echo '<div class="error">Error:';
    echo $errCode;
    echo '<br>ErrorDesc:';
    echo $errDesc;
    echo '</div></body></html>';
    exit();
} else {

    //Call went OK, see the parameters
    echo '<!DOCTYPE HTML><html><body>';
    echo '<pre>';
    print_r($result);
    echo '</pre>';
    echo '</body></html>';
}