<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function InterchangeClearingLevelDataForAccountOrMerchant()
{
    // QUERY PARAMETERS
    $organizationId = "testrest";
    $startTime = "2021-08-01T00:00:00Z";
    $endTime = "2021-09-01T23:59:59Z";

    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $apiClient = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $apiInstance = new CyberSourceApi\Api\InterchangeClearingLevelDetailsApi($apiClient);

    try {
        $apiResponse = $apiInstance->getInterchangeClearingLevelDetails($startTime, $endTime, $organizationId);
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

if (!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nInterchangeClearingLevelDataForAccountOrMerchant Sample Code is Running..." . PHP_EOL;
    InterchangeClearingLevelDataForAccountOrMerchant();
}