<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Capture/CapturePayment.php';

function VoidCapture()
{
    $id = CapturePayment()[0]['id'];

    $clientReferenceInformationArr = [
            "code" => "test_void"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation
    ];
    $requestObj = new CyberSourceApi\Model\VoidCaptureRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\VoidApi($api_client);

    try {
        $apiResponse = $api_instance->voidCapture($requestObj, $id);
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
    echo "\nVoidCapture Sample Code is Running..." . PHP_EOL;
    VoidCapture();
}
?>
