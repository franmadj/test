<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/ServiceFeesWithCreditCardTransaction.php';

function ServiceFeesAuthorizationReversal()
{
    $id = ServiceFeesWithCreditCardTransaction("false")[0]['id'];
    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);

    $reversalInformationAmountDetailsArr = [
            "totalAmount" => "2325.00"
    ];
    $reversalInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($reversalInformationAmountDetailsArr);

    $reversalInformationArr = [
            "amountDetails" => $reversalInformationAmountDetails,
            "reason" => "34"
    ];
    $reversalInformation = new CyberSourceApi\Model\Ptsv2paymentsidreversalsReversalInformation($reversalInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "reversalInformation" => $reversalInformation
    ];
    $requestObj = new CyberSourceApi\Model\AuthReversalRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\ReversalApi($api_client);

    try {
        $apiResponse = $api_instance->authReversal($id, $requestObj);
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
    echo "\nServiceFeesAuthorizationReversal Sample Code is Running..." . PHP_EOL;
    ServiceFeesAuthorizationReversal();
}
?>
