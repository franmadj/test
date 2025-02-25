<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function SetupCompletionWithTMSToken()
{
    $clientReferenceInformationArr = [
            "code" => "cybs_test"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationCustomerArr = [
            "customerId" => "AB695DA801DD1BB6E05341588E0A3BDC"
    ];
    $paymentInformationCustomer = new CyberSourceApi\Model\Riskv1authenticationsetupsPaymentInformationCustomer($paymentInformationCustomerArr);

    $paymentInformationArr = [
            "customer" => $paymentInformationCustomer
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
    echo "\nSetupCompletionWithTMSToken Sample Code is Running..." . PHP_EOL;
    SetupCompletionWithTMSToken();
}
?>
