<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function DMWithBuyerInformation()
{
    $clientReferenceInformationArr = [
            "code" => "54323007"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationCardArr = [
            "number" => "4444444444444448",
            "expirationMonth" => "12",
            "expirationYear" => "2020"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Riskv1decisionsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSourceApi\Model\Riskv1decisionsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "currency" => "USD",
            "totalAmount" => "144.14"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Riskv1decisionsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "address1" => "96, powers street",
            "administrativeArea" => "NH",
            "country" => "US",
            "locality" => "Clearwater milford",
            "firstName" => "James",
            "lastName" => "Smith",
            "phoneNumber" => "7606160717",
            "email" => "test@visa.com",
            "postalCode" => "03055"
    ];
    $orderInformationBillTo = new CyberSourceApi\Model\Riskv1decisionsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSourceApi\Model\Riskv1decisionsOrderInformation($orderInformationArr);

    $buyerInformationPersonalIdentification = array();
    $buyerInformationPersonalIdentification_0 = [
            "type" => "CPF",
            "id" => "1a23apwe98"
    ];
    $buyerInformationPersonalIdentification[0] = new CyberSourceApi\Model\Ptsv2paymentsBuyerInformationPersonalIdentification($buyerInformationPersonalIdentification_0);

    $buyerInformationArr = [
            "hashedPassword" => "",
            "dateOfBirth" => "19980505",
            "personalIdentification" => $buyerInformationPersonalIdentification
    ];
    $buyerInformation = new CyberSourceApi\Model\Riskv1decisionsBuyerInformation($buyerInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation,
            "buyerInformation" => $buyerInformation
    ];
    $requestObj = new CyberSourceApi\Model\CreateBundledDecisionManagerCaseRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\DecisionManagerApi($api_client);

    try {
        $apiResponse = $api_instance->createBundledDecisionManagerCase($requestObj);
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
    echo "\nDMWithBuyerInformation Sample Code is Running..." . PHP_EOL;
    DMWithBuyerInformation();
}
?>
