<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function SetupCompletionWithCardNumber()
{
    $clientReferenceInformationPartnerArr = [
            "developerId" => "7891234",
            "solutionId" => "89012345"
    ];
    $clientReferenceInformationPartner = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformationPartner($clientReferenceInformationPartnerArr);

    $clientReferenceInformationArr = [
            "code" => "cybs_test",
            "partner" => $clientReferenceInformationPartner
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationCardArr = [
            "type" => "001",
            "expirationMonth" => "12",
            "expirationYear" => "2025",
            "number" => "4000000000000101"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Riskv1authenticationsetupsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard
    ];
    $paymentInformation = new CyberSourceApi\Model\Riskv1authenticationsetupsPaymentInformation($paymentInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation
    ];
    $requestObj = new CyberSourceApi\Model\PayerAuthSetupRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\PayerAuthenticationApi($api_client);

    try {
        $apiResponse = $api_instance->payerAuthSetup($requestObj);
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
    echo "\nSetupCompletionWithCardNumber Sample Code is Running..." . PHP_EOL;
    SetupCompletionWithCardNumber();
}
?>
