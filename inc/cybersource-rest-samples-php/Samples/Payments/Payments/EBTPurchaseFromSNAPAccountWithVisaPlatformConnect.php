<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';

function EBTPurchaseFromSNAPAccountWithVisaPlatformConnect()
{
    $clientReferenceInformationArr = [
            "code" => "EBT - Purchase From SNAP Account"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationPurchaseOptionsArr = [
            "isElectronicBenefitsTransfer" => true
    ];
    $processingInformationPurchaseOptions = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformationPurchaseOptions($processingInformationPurchaseOptionsArr);

    $processingInformationElectronicBenefitsTransferArr = [
            "category" => "FOOD"
    ];
    $processingInformationElectronicBenefitsTransfer = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformationElectronicBenefitsTransfer($processingInformationElectronicBenefitsTransferArr);

    $processingInformationArr = [
            "capture" => false,
            "commerceIndicator" => "retail",
            "purchaseOptions" => $processingInformationPurchaseOptions,
            "electronicBenefitsTransfer" => $processingInformationElectronicBenefitsTransfer
    ];
    $processingInformation = new CyberSourceApi\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);

    $paymentInformationPaymentTypeArr = [
            "name" => "CARD",
            "subTypeName" => "DEBIT"
    ];
    $paymentInformationPaymentType = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationPaymentType($paymentInformationPaymentTypeArr);

    $paymentInformationArr = [
            "paymentType" => $paymentInformationPaymentType
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "101.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

    $pointOfSaleInformationArr = [
            "entryMode" => "swiped",
            "terminalCapability" => 4,
            "trackData" => "%B4111111111111111^JONES/JONES ^3112101976110000868000000?;4111111111111111=16121019761186800000?",
            "pinBlockEncodingFormat" => 1,
            "encryptedPin" => "52F20658C04DB351",
            "encryptedKeySerialNumber" => "FFFF1B1D140000000005"
    ];
    $pointOfSaleInformation = new CyberSourceApi\Model\Ptsv2paymentsPointOfSaleInformation($pointOfSaleInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "processingInformation" => $processingInformation,
            "paymentInformation" => $paymentInformation,
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

if(!defined('DO_NOT_RUN_SAMPLES')) {
    echo "\nEBTPurchaseFromSNAPAccountWithVisaPlatformConnect Sample Code is Running..." . PHP_EOL;
    EBTPurchaseFromSNAPAccountWithVisaPlatformConnect();
}
?>