<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function EnrollWithTransientToken()
{
    $clientReferenceInformationArr = [
            "code" => "UNKNOWN"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationAmountDetailsArr = [
            "currency" => "USD",
            "totalAmount" => "10.99"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Riskv1authenticationsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationBillToArr = [
            "address1" => "1 Market St",
            "address2" => "Address 2",
            "administrativeArea" => "CA",
            "country" => "US",
            "locality" => "san francisco",
            "firstName" => "John",
            "lastName" => "Doe",
            "phoneNumber" => "4158880000",
            "email" => "test@cybs.com",
            "postalCode" => "94105"
    ];
    $orderInformationBillTo = new CyberSourceApi\Model\Riskv1authenticationsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
    ];
    $orderInformation = new CyberSourceApi\Model\Riskv1authenticationsOrderInformation($orderInformationArr);

    $tokenInformationArr = [
            "transientToken" => "1D5ZX4HMOV20FKEBE3IO240JWYJ0NJ90B4V9XQ6SCK4BDN0W96E65E2A39052056"
    ];
    $tokenInformation = new CyberSourceApi\Model\Riskv1authenticationsetupsTokenInformation($tokenInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "tokenInformation" => $tokenInformation
    ];
    $requestObj = new CyberSourceApi\Model\CheckPayerAuthEnrollmentRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\PayerAuthenticationApi($api_client);

    try {
        $apiResponse = $api_instance->checkPayerAuthEnrollment($requestObj);
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
    echo "\nEnrollWithTransientToken Sample Code is Running..." . PHP_EOL;
    EnrollWithTransientToken();
}
?>
