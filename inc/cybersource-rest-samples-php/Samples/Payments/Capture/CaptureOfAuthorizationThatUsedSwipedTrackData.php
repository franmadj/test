<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CaptureOfAuthorizationThatUsedSwipedTrackData()
{    
    require_once __DIR__. DIRECTORY_SEPARATOR .'../Payments/AuthorizationUsingSwipedTrackData.php';
    $id = AuthorizationUsingSwipedTrackData()[0]['id'];
    
    $clientReferenceInformationPartnerArr = [
            "thirdPartyCertificationNumber" => "123456789012"
    ];
    $clientReferenceInformationPartner = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
            "code" => "1234567890",
            "partner" => $clientReferenceInformationPartner
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "100",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsidcapturesOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSourceApi\Model\CapturePaymentRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\CaptureApi($api_client);

    try {
        $apiResponse = $api_instance->capturePayment($requestObj, $id);
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
    echo "\nCaptureOfAuthorizationThatUsedSwipedTrackData Sample Code is Running..." . PHP_EOL;
    CaptureOfAuthorizationThatUsedSwipedTrackData();
}
?>
