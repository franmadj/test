<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function SaleUsingSwipedTrackDataWithVisaPlatformConnect()
{
    $clientReferenceInformationArr = [
            "code" => "123456"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationAuthorizationOptionsArr = [
            "partialAuthIndicator" => true,
            "ignoreAvsResult" => false,
            "ignoreCvResult" => false
    ];
    $processingInformationAuthorizationOptions = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformationAuthorizationOptions($processingInformationAuthorizationOptionsArr);

    $processingInformationArr = [
            "capture" => true,
            "commerceIndicator" => "retail",
            "authorizationOptions" => $processingInformationAuthorizationOptions
    ];
    $processingInformation = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "100.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $pointOfSaleInformationArr = [
            "entryMode" => "swiped",
            "terminalCapability" => 2,
            "trackData" => "%B38000000000006^TEST/CYBS         ^2012121019761100      00868000000?;38000000000006=20121210197611868000?"
    ];
    $pointOfSaleInformation = new CyberSourceApi\Model\Ptsv2paymentsPointOfSaleInformation($pointOfSaleInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "orderInformation" => $orderInformation,
            "pointOfSaleInformation" => $pointOfSaleInformation
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
    echo "\nSaleUsingSwipedTrackDataWithVisaPlatformConnect Sample Code is Running..." . PHP_EOL;
    SaleUsingSwipedTrackDataWithVisaPlatformConnect();
}
?>
