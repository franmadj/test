<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AuthorizationWithInstrumentIdentifierTokenId()
{
    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationArr = [
            "capture" => false,
            "commerceIndicator" => "internet"
    ];
    $processingInformation = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "expirationMonth" => "03",
            "expirationYear" => "2031",
            "type" => "001"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationInstrumentIdentifierArr = [
            "id" => "7010000000016241111"
    ];
    $paymentInformationInstrumentIdentifier = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationInstrumentIdentifier($paymentInformationInstrumentIdentifierArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard,
            "instrumentIdentifier" => $paymentInformationInstrumentIdentifier
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "200",
            "currency" => "usd"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Deo",
            "address1" => "900 Metro Center Blvd",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "postalCode" => "48104-2201",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "9321499232"
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
    echo "\nAuthorizationWithInstrumentIdentifierTokenId Sample Code is Running..." . PHP_EOL;
    AuthorizationWithInstrumentIdentifierTokenId();
}
?>
