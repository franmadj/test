<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/AlternativeConfiguration.php';

function EBTMerchandiseReturnCreditVoucherFromSNAP()
{
    $clientReferenceInformationArr = [
            "code" => "Merchandise Return / Credit Voucher from SNAP"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $processingInformationPurchaseOptionsArr = [
            "isElectronicBenefitsTransfer" => true
    ];
    $processingInformationPurchaseOptions = new CyberSourceApi\Model\Ptsv2creditsProcessingInformationPurchaseOptions($processingInformationPurchaseOptionsArr);

    $processingInformationElectronicBenefitsTransferArr = [
            "category" => "FOOD"
    ];
    $processingInformationElectronicBenefitsTransfer = new CyberSourceApi\Model\Ptsv2creditsProcessingInformationElectronicBenefitsTransfer($processingInformationElectronicBenefitsTransferArr);

    $processingInformationArr = [
            "commerceIndicator" => "retail",
            "purchaseOptions" => $processingInformationPurchaseOptions,
            "electronicBenefitsTransfer" => $processingInformationElectronicBenefitsTransfer
    ];
    $processingInformation = new CyberSourceApi\Model\Ptsv2creditsProcessingInformation($processingInformationArr);

    $paymentInformationCardArr = [
            "type" => "001"
    ];
    $paymentInformationCard = new CyberSourceApi\Model\Ptsv2paymentsidrefundsPaymentInformationCard($paymentInformationCardArr);

    $paymentInformationPaymentTypeArr = [
            "name" => "CARD",
            "subTypeName" => "DEBIT"
    ];
    $paymentInformationPaymentType = new CyberSourceApi\Model\Ptsv2paymentsidrefundsPaymentInformationPaymentType($paymentInformationPaymentTypeArr);

    $paymentInformationArr = [
            "card" => $paymentInformationCard,
            "paymentType" => $paymentInformationPaymentType
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsidrefundsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "204.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsidrefundsOrderInformation($orderInformationArr);

    $merchantInformationArr = [
            "categoryCode" => 5411
    ];
    $merchantInformation = new CyberSourceApi\Model\Ptsv2paymentsidrefundsMerchantInformation($merchantInformationArr);

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
            "merchantInformation" => $merchantInformation,
            "pointOfSaleInformation" => $pointOfSaleInformation
    ];
    $requestObj = new CyberSourceApi\Model\CreateCreditRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\CreditApi($api_client);

    try {
        $apiResponse = $api_instance->createCredit($requestObj);
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
    echo "\nEBTMerchandiseReturnCreditVoucherFromSNAP Sample Code is Running..." . PHP_EOL;
    EBTMerchandiseReturnCreditVoucherFromSNAP();
}
?>