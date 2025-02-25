<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Plans/CreatePlan.php';

function UpdatePlan()
{
    $id = CreatePlan()[0]['id'];

    $planInformationBillingPeriodArr = [
            "length" => "2",
            "unit" => "W"
    ];
    $planInformationBillingPeriod = new CyberSourceApi\Model\GetAllPlansResponsePlanInformationBillingPeriod($planInformationBillingPeriodArr);

    $planInformationBillingCyclesArr = [
            "total" => "11"
    ];
    $planInformationBillingCycles = new CyberSourceApi\Model\Rbsv1plansPlanInformationBillingCycles($planInformationBillingCyclesArr);

    $planInformationArr = [
            "name" => "Gold Plan NA",
            "description" => "Updated Gold Plan",
            "billingPeriod" => $planInformationBillingPeriod,
            "billingCycles" => $planInformationBillingCycles
    ];
    $planInformation = new CyberSourceApi\Model\Rbsv1plansidPlanInformation($planInformationArr);

    $processingInformationSubscriptionBillingOptionsArr = [
            "applyTo" => "ALL"
    ];
    $processingInformationSubscriptionBillingOptions = new CyberSourceApi\Model\Rbsv1plansidProcessingInformationSubscriptionBillingOptions($processingInformationSubscriptionBillingOptionsArr);

    $processingInformationArr = [
            "subscriptionBillingOptions" => $processingInformationSubscriptionBillingOptions
    ];
    $processingInformation = new CyberSourceApi\Model\Rbsv1plansidProcessingInformation($processingInformationArr);

    $orderInformationAmountDetailsArr = [
            "currency" => "USD",
            "billingAmount" => "11",
            "setupFee" => "2"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\GetAllPlansResponseOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\GetAllPlansResponseOrderInformation($orderInformationArr);

    $requestObjArr = [
            "planInformation" => $planInformation,
            "processingInformation" => $processingInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSourceApi\Model\UpdatePlanRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\PlansApi($api_client);

    try {
        $apiResponse = $api_instance->updatePlan($id, $requestObj);
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
    echo "\nUpdatePlan Sample Code is Running..." . PHP_EOL;
    UpdatePlan();
}
?>