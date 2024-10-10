<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function DigitalPaymentsApplePay($flag)
{
    if (isset($flag) && $flag == "true") {
        $capture = true;
    } else {
        $capture = false;
    }

    $clientReferenceInformationArr = [
            "code" => "TC_1231223"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationArr = [
            "capture" => $capture,
            "paymentSolution" => "001"
    ];
    $processingInformation = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationTokenizedCardArr = [
            "number" => "4111111111111111",
            "expirationMonth" => "12",
            "expirationYear" => "2031",
            "cryptogram" => "AceY+igABPs3jdwNaDg3MAACAAA=",
            "transactionType" => "1"
    ];
    $paymentInformationTokenizedCard = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationTokenizedCard($paymentInformationTokenizedCardArr);

    $paymentInformationArr = [
            "tokenizedCard" => $paymentInformationTokenizedCard
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "10",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Deo",
            "address1" => "901 Metro Center Blvd",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "postalCode" => "94404",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "6504327113"
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
    echo "\nDigitalPaymentsApplePay Sample Code is Running..." . PHP_EOL;
    DigitalPaymentsApplePay('false');
}
?>
