<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function UpdateCustomer()
{
    $customerTokenId = 'AB695DA801DD1BB6E05341588E0A3BDC';
    $buyerInformationArr = [
            "merchantCustomerID" => "Your customer identifier",
            "email" => "test@cybs.com"
    ];
    $buyerInformation = new CyberSourceApi\Model\Tmsv2customersBuyerInformation($buyerInformationArr);

    $clientReferenceInformationArr = [
            "code" => "TC50171_3"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Tmsv2customersClientReferenceInformation($clientReferenceInformationArr);

    $merchantDefinedInformation = array();
    $merchantDefinedInformation_0 = [
            "name" => "data1",
            "value" => "Your customer data"
    ];
    $merchantDefinedInformation[0] = new CyberSourceApi\Model\Tmsv2customersMerchantDefinedInformation($merchantDefinedInformation_0);

    $requestObjArr = [
            "buyerInformation" => $buyerInformation,
            "clientReferenceInformation" => $clientReferenceInformation,
            "merchantDefinedInformation" => $merchantDefinedInformation
    ];
    $requestObj = new CyberSourceApi\Model\PatchCustomerRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\CustomerApi($api_client);

    try {
        $apiResponse = $api_instance->patchCustomer($customerTokenId, $requestObj, null, null);
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
    UpdateCustomer();
}
?>
