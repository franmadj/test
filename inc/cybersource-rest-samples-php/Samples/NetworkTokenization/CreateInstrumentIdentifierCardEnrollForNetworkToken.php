<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '/../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '/../../Resources/ExternalConfiguration.php';

function CreateInstrumentIdentifierCardEnrollForNetworkToken()
{
    $profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';

    $cardArr = [
        "number" => "5204245750003216",
        "expirationMonth" => "12",
        "expirationYear" => "2025"
    ];
    $card = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentEmbeddedInstrumentIdentifierCard($cardArr);

    $requestObjArr = [
        "type" => "enrollable card",
        "card" => $card
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
        print_r("\n[Sample Code Testing] [$sampleCode] $status".PHP_EOL);
    }
}

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nCreateInstrumentIdentifierCardEnrollForNetworkToken Sample Code is Running..." . PHP_EOL;
    CreateInstrumentIdentifierCardEnrollForNetworkToken();
}
?>
