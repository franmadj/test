<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateInstrumentIdentifierCardEnrollForNetworkToken()
{
    $profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';

    $cardArr = [
        "number" => "4111111111111111",
        "expirationMonth" => "12",
        "expirationYear" => "2031",
        "securityCode" => "123"
    ];
    $card = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentEmbeddedInstrumentIdentifierCard($cardArr);

    $billToArr = [
            "address1" => "1 Market St",
            "locality" => "San Francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
        "country" => "US"
    ];
    $billTo = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentEmbeddedInstrumentIdentifierBillTo($billToArr);

    $requestObjArr = [
        "type" => "enrollable card",
        "card" => $card,
        "billTo" => $billTo
    ];
    $requestObj = new CyberSourceApi\Model\PostInstrumentIdentifierRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\InstrumentIdentifierApi($api_client);

    try {
        $apiResponse = $api_instance->postInstrumentIdentifier($requestObj, $profileid);
        print_r(PHP_EOL);
        print_r($apiResponse);

        WriteLogAudit($apiResponse[1]);
        return $apiResponse;
    } catch (Cybersource\ApiException $e) {
        print_r($e->getResponseBody());
        print_r($e->getMessage());
        $errorCode = $e->getCode();
        WriteLogAudit($errorCode);
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nCreateInstrumentIdentifierCardEnrollForNetworkToken Sample Code is Running..." . PHP_EOL;
    CreateInstrumentIdentifierCardEnrollForNetworkToken();
}
?>
