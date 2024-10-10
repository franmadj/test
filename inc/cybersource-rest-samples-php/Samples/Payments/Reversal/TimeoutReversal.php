<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function TimeoutReversal()
{
    include __DIR__ . DIRECTORY_SEPARATOR . '../Payments/AuthorizationForTimeoutReversalFlow.php';
    
    $clientReferenceInformationArr = [
            "code" => "TC50171_3",
            "transactionId" => $timeoutReversalTransactionId
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $reversalInformationAmountDetailsArr = [
            "totalAmount" => "102.21"
    ];
    $reversalInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($reversalInformationAmountDetailsArr);

    $reversalInformationArr = [
            "amountDetails" => $reversalInformationAmountDetails,
            "reason" => "testing"
    ];
    $reversalInformation = new CyberSourceApi\Model\Ptsv2paymentsidreversalsReversalInformation($reversalInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "reversalInformation" => $reversalInformation
    ];
    $requestObj = new CyberSourceApi\Model\MitReversalRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\ReversalApi($api_client);

    try {
        $apiResponse = $api_instance->mitReversal($requestObj);
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
    echo "\nTimeoutReversal Sample Code is Running..." . PHP_EOL;
    TimeoutReversal();
}
?>
