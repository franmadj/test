<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AuthorizationSkipDecisionManagerForSingleTransaction()
{
    $clientReferenceInformationArr = [
            "code" => "TC50171_16"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationActionList = array();
    $processingInformationActionList[0] = "DECISION_SKIP";
    $processingInformationArr = [
            "actionList" => $processingInformationActionList,
            "capture" => false
    ];
    $processingInformation = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "number" => "4111111111111111",
            "expirationMonth" => "11",
            "expirationYear" => "2025"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "10",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "address1" => "1 Market St",
            "locality" => "san francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "4158880000"
    ];
    $orderInformationBillTo = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSourceApi\Model\CreatePaymentRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\PaymentsApi($api_client);

    try {
        $apiResponse = $api_instance->createPayment($requestObj);
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
    echo "\nAuthorizationSkipDecisionManagerForSingleTransaction Sample Code is Running..." . PHP_EOL;
    AuthorizationSkipDecisionManagerForSingleTransaction();
}
?>
