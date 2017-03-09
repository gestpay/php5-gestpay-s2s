<?php
/**
 * Created by Gestpay.
 * Date: 08/03/17
 * Time: 12:32
 *
 * This example shows a way to use callPagamS2S with the minimum required parameters.
 * callPagamS2S is described here: http://docs.gestpay.it/adv/authorization-request.html
 * the API: http://api.gestpay.it/#callpagams2s 
 * 
 * Before opening this file, set M.O.T.O. to "authorize only" and perform an authorization
 * request with callPagamS2S.php. 
 * Then, use the shop transaction ID or the bank transaction ID to identify the transaction.    
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
 * shopLogin: this is a code that identifies your account.
 * amount: the amount of the transaction
 * uicCode: the currency code
 * shopTransactionId: a transaction identifier given by you
 *****************************************************************/

$shopLogin = "GESPAY65987";
$amount = "15.72";
$uicCode = "242"; //EURO
$shopTransactionId = "GESTPAY_S2S_".date("H:i:s");

/****************************************************************
 * CREDIT CARD DATA (or TOKEN)
 *
 * This is a test credit card, valid only in test environment.
 * Check if the card data has changed.
 * Comment this section if you want to use tokens (see below).
 ****************************************************************/
$cardNumber = "4775718800001010";
$expiryMonth = '05';
$expiryYear = '17';

//Optionally, you can use a Token Value to perform a Payment.
// See CallRequestTokenS2S, callDeleteTokenS2S, callUpdateTokenS2S on how to use them.

//$tokenValue = "PUT HERE A TOKEN";


/****************************************************************
 * OPTIONAL DATA
 *
 * you can put any other accepted data below this.
 * Add the data to the $params variable, too.
 ****************************************************************/

// $buyerEmail = '';
// $buyerName = '';
// ...


/****************************************************************
 * CREATING SOAP ARGUMENTS
 * The $param variable will contain the argument for the S2S call.
 * If you add more parameters you must add them here.
 ****************************************************************/


//Set up the parameters array. This array will be the argument for the SOAP call.
$param = array(
    'shopLogin' => $shopLogin,
    'amount' => $amount,
    'uicCode' => $uicCode,
    'shopTransactionId' => $shopTransactionId,
    'cardNumber' => $cardNumber,
    'expiryMonth' => $expiryMonth,
    'expiryYear' => $expiryYear
);


/****************************************************************
 * CALL CallPagamS2S
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
    $objectResult = $client->callPagamS2S($param);
} //catch SOAP exceptions
catch (SoapFault $fault) {
    die($fault);
}
//parse the XML result
$result = simplexml_load_string($objectResult->callPagamS2SResult->any);

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