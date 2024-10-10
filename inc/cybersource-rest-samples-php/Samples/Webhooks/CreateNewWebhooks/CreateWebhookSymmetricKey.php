<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateWebhookSymmetricKey($vCcorrelationId, $vCsenderOrganizationId, $vCpermissions)
{
    $keyInformationArr = [
            "provider" => "nrtd",
            "tenant" => "<INSERT ORGANIZATION ID HERE>",
            "keyType" => "sharedSecret",
            "organizationId" => "<INSERT ORGANIZATION ID HERE>"
    ];
    $keyInformation = new CyberSourceApi\Model\Kmsegressv2keyssymKeyInformation($keyInformationArr);

    $requestObjArr = [
            "clientRequestAction" => "CREATE",
            "keyInformation" => $keyInformation
    ];
    $requestObj = new CyberSourceApi\Model\SaveSymEgressKey($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\CreateNewWebhooksApi($api_client);

    try {
        $apiResponse = $api_instance->saveSymEgressKey($vCsenderOrganizationId, $vCpermissions, $vCcorrelationId, $requestObj);
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
    echo "\nCreateWebhookSymmetricKey Sample Code is Running..." . PHP_EOL;
    CreateWebhookSymmetricKey($vCcorrelationId, $vCsenderOrganizationId, $vCpermissions);
}
?>