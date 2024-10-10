<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../Credit/EBTMerchandiseReturnCreditVoucherFromSNAP.php';

function EBTReversalOfPurchaseFromSNAPAccount()
{
    $id = EBTMerchandiseReturnCreditVoucherFromSNAP()[0]['id'];

    $clientReferenceInformationArr = [
            "code" => "Reversal of Purchase from SNAP Account"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsidreversalsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationPaymentTypeArr = [
            "name" => "CARD",
            "subTypeName" => "DEBIT"
    ];
    $paymentInformationPaymentType = new CyberSourceApi\Model\Ptsv2paymentsidrefundsPaymentInformationPaymentType($paymentInformationPaymentTypeArr);

    $paymentInformationArr = [
            "paymentType" => $paymentInformationPaymentType
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsidvoidsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "204.00",
            "currency" => "USD"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsidreversalsReversalInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsidvoidsOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation
    ];
    $requestObj = new CyberSourceApi\Model\VoidPaymentRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\VoidApi($api_client);

    try {
        $apiResponse = $api_instance->voidPayment($requestObj, $id);
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
    echo "\nEBTReversalOfPurchaseFromSNAPAccount Sample Code is Running..." . PHP_EOL;
    EBTReversalOfPurchaseFromSNAPAccount();
}
?>