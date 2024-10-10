<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function AuthorizationWithDecisionManagerBuyerInformation()
{
    $clientReferenceInformationArr = [
            "code" => "54323007"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationCardArr = [
            "number" => "4444444444444448",
            "expirationMonth" => "12",
            "expirationYear" => "2020"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "144.14",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "firstName" => "James",
            "lastName" => "Smith",
            "address1" => "96, powers street",
            "locality" => "Clearwater milford",
            "administrativeArea" => "NH",
            "postalCode" => "03055",
            "country" => "US",
            "email" => "test@visa.com",
            "phoneNumber" => "7606160717"
    ];
    $orderInformationBillTo = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $buyerInformationPersonalIdentification = array();
    $buyerInformationPersonalIdentification_0 = [
            "type" => "CPF",
            "id" => "1a23apwe98"
    ];
    $buyerInformationPersonalIdentification[0] = new CyberSourceApi\Model\Ptsv2paymentsBuyerInformationPersonalIdentification($buyerInformationPersonalIdentification_0);

    $buyerInformationArr = [
            "dateOfBirth" => "19980505",
            "personalIdentification" => $buyerInformationPersonalIdentification,
            "hashedPassword" => ""
    ];
    $buyerInformation = new CyberSourceApi\Model\Ptsv2paymentsBuyerInformation($buyerInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation,
            "buyerInformation" => $buyerInformation
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
    echo "\nAuthorizationWithDecisionManagerBuyerInformation Sample Code is Running..." . PHP_EOL;
    AuthorizationWithDecisionManagerBuyerInformation();
}
?>
