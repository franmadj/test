<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
//require_once __DIR__ . DIRECTORY_SEPARATOR . '../Payments/SimpleAuthorizationInternet.php';

function ProcessAuthorizationReversal($data)
{
    //$id = SimpleAuthorizationInternet("false")[0]['id'];
    $id = $data['id'][0];

//    $clientReferenceInformationArr = [
//            "code" => "TC50171_3"
//    ];
//    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);
    $clientReferenceInformation = $data['client_inf'];

//    $reversalInformationAmountDetailsArr = [
//            "totalAmount" => "102.21"
//    ];
//    $reversalInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($reversalInformationAmountDetailsArr);
    $reversalInformationAmountDetails = $data['amount_details'];

    $reversalInformationArr = [
            "amountDetails" => $reversalInformationAmountDetails,
            "auth_reversal_reason" => "34"
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
//        print_r(PHP_EOL);
//        print_r($apiResponse);

        //WriteLogAudit($apiResponse[1]);
        return $apiResponse;
    } catch (CyberSourceApi\ApiException $e) {
//        print_r($e->getResponseBody());
//        print_r($e->getMessage());
        $errorCode = $e->getCode();
        WriteLogAudit($errorCode);
        error_log('$requestObjArr: ' . print_r($requestObjArr, true));
        error_log('ProcessAuthorizationReversal ApiException: ' . print_r([$e->getResponseBody(), $e->getMessage()], true));
        return false;
    }
}

if (!function_exists('WriteLogAudit')){
    function WriteLogAudit($status){
        $sampleCode = basename(__FILE__, '.php');
        print_r("\n[Sample Code Testing] [$sampleCode] $status");
    }
}

//if(!defined('DO_NOT_RUN_SAMPLES')){
//    echo "\nProcessAuthorizationReversal Sample Code is Running..." . PHP_EOL;
//    ProcessAuthorizationReversal();
//}
?>
