<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function ValidateAuthenticationResults()
{
    $clientReferenceInformationPartnerArr = [
        "developerId" => "7891234",
        "solutionId" => "89012345"
    ];
    $clientReferenceInformationPartner = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
        "code" => "pavalidatecheck",
        "partner" => $clientReferenceInformationPartner
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationAmountDetailsArr = [
        "currency" => "USD",
        "totalAmount" => "200.00"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Riskv1authenticationresultsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
        "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\Riskv1authenticationresultsOrderInformation($orderInformationArr);

    $paymentInformationCardArr = [
        "type" => "002",
        "expirationMonth" => "12",
        "expirationYear" => "2025",
        "number" => "5200000000000007"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Riskv1authenticationresultsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
        "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSourceApi\Model\Riskv1authenticationresultsPaymentInformation($paymentInformationArr);

    $consumerAuthenticationInformationArr = [
        "authenticationTransactionId" => "PYffv9G3sa1e0CQr5fV0"
    ];
    $consumerAuthenticationInformation = new CyberSourceApi\Model\Riskv1authenticationresultsConsumerAuthenticationInformation($consumerAuthenticationInformationArr);

    $requestObjArr = [
        "clientReferenceInformation" => $clientReferenceInformation,
        "orderInformation" => $orderInformation,
        "paymentInformation" => $paymentInformation,
        "consumerAuthenticationInformation" => $consumerAuthenticationInformation
    ];
    $requestObj = new CyberSourceApi\Model\ValidateRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\PayerAuthenticationApi($api_client);

    try {
        $apiResponse = $api_instance->validateAuthenticationResults($requestObj);
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

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nValidateAuthenticationResults Sample Code is Running..." . PHP_EOL;
    ValidateAuthenticationResults();
}
?>
