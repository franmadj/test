<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AuthorizationWithPAEnrollAuthenticationNeeded()
{
    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationActionList = array();
    $processingInformationActionList[0] = "CONSUMER_AUTHENTICATION";
    $processingInformationArr = [
            "actionList" => $processingInformationActionList,
            "capture" => false
    ];
    $processingInformation = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "number" => "4000000000001091",
            "expirationMonth" => "12",
            "expirationYear" => "2023"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "100.00",
            "currency" => "usd"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "John",
            "lastName" => "Smith",
            "address1" => "201 S. Division St._1",
            "address2" => "Suite 500",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "postalCode" => "94404",
            "country" => "US",
            "email" => "accept@cybersource.com",
            "phoneNumber" => "6504327113"
    ];
    $orderInformationBillTo = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $consumerAuthenticationInformationArr = [
            "requestorId" => "123123197675",
            "referenceId" => "CybsCruiseTester-8ac0b02f"
    ];
    $consumerAuthenticationInformation = new CyberSourceApi\Model\Ptsv2paymentsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation,
            "consumerAuthenticationInformation" => $consumerAuthenticationInformation
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
    echo "\nAuthorizationWithPAEnrollAuthenticationNeeded Sample Code is Running..." . PHP_EOL;
    AuthorizationWithPAEnrollAuthenticationNeeded();
}
?>
