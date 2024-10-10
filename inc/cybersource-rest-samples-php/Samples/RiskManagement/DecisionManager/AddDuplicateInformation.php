<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AddDuplicateInformation()
{
    $type = 'positive';
    $orderInformationAddressArr = [
            "address1" => "1234 Sample St.",
            "address2" => "Mountain View",
            "locality" => "California",
            "country" => "US",
            "administrativeArea" => "CA",
            "postalCode" => "94043"
    ];
    $orderInformationAddress = new CyberSourceApi\Model\Riskv1liststypeentriesOrderInformationAddress($orderInformationAddressArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "email" => "nobody@example.com"
    ];
    $orderInformationBillTo = new CyberSourceApi\Model\Riskv1liststypeentriesOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "address" => $orderInformationAddress,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSourceApi\Model\Riskv1liststypeentriesOrderInformation($orderInformationArr);

    $paymentInformationArr = [
    ];
    $paymentInformation = new CyberSourceApi\Model\Riskv1liststypeentriesPaymentInformation($paymentInformationArr);

    $clientReferenceInformationArr = [
            "code" => "54323007"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $riskInformationMarkingDetailsArr = [
            "action" => "add"
    ];
    $riskInformationMarkingDetails = new CyberSourceApi\Model\Riskv1liststypeentriesRiskInformationMarkingDetails($riskInformationMarkingDetailsArr);

    $riskInformationArr = [
            "markingDetails" => $riskInformationMarkingDetails
    ];
    $riskInformation = new CyberSourceApi\Model\Riskv1liststypeentriesRiskInformation($riskInformationArr);

    $requestObjArr = [
            "orderInformation" => $orderInformation,
            "paymentInformation" => $paymentInformation,
            "clientReferenceInformation" => $clientReferenceInformation,
            "riskInformation" => $riskInformation
    ];
    $requestObj = new CyberSourceApi\Model\AddNegativeListRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\DecisionManagerApi($api_client);

    try {
        $apiResponse = $api_instance->addNegative($type, $requestObj);
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
    echo "\nAddDuplicateInformation Sample Code is Running..." . PHP_EOL;
    AddDuplicateInformation();
}
?>
