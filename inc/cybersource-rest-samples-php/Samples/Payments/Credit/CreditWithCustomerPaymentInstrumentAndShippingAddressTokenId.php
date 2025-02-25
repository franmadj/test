<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreditWithCustomerPaymentInstrumentAndShippingAddressTokenId()
{
    $clientReferenceInformationArr = [
            "code" => "12345678"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationCustomerArr = [
            "id" => "AB695DA801DD1BB6E05341588E0A3BDC"
    ];
    $paymentInformationCustomer = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationCustomer($paymentInformationCustomerArr);

    $paymentInformationPaymentInstrumentArr = [
            "id" => "AB6A54B982A6FCB6E05341588E0A3935"
    ];
    $paymentInformationPaymentInstrument = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationPaymentInstrument($paymentInformationPaymentInstrumentArr);

    $paymentInformationShippingAddressArr = [
            "id" => "AB6A54B97C00FCB6E05341588E0A3935"
    ];
    $paymentInformationShippingAddress = new CyberSourceApi\Model\Ptsv2paymentsPaymentInformationShippingAddress($paymentInformationShippingAddressArr);

    $paymentInformationArr = [
            "customer" => $paymentInformationCustomer,
            "paymentInstrument" => $paymentInformationPaymentInstrument,
            "shippingAddress" => $paymentInformationShippingAddress
    ];
    $paymentInformation = new CyberSourceApi\Model\Ptsv2paymentsidrefundsPaymentInformation($paymentInformationArr);

    $orderInformationAmountDetailsArr = [
            "totalAmount" => "200",
            "currency" => "usd"
    ];
    $orderInformationAmountDetails = new CyberSourceApi\Model\Ptsv2paymentsidcapturesOrderInformationAmountDetails($orderInformationAmountDetailsArr);

    $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
    ];
    $orderInformation = new CyberSourceApi\Model\Ptsv2paymentsidrefundsOrderInformation($orderInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
            "orderInformation" => $orderInformation
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

if(!defined('DO_NOT_RUN_SAMPLES')){
    echo "\nCreditWithCustomerPaymentInstrumentAndShippingAddressTokenId Sample Code is Running..." . PHP_EOL;
    CreditWithCustomerPaymentInstrumentAndShippingAddressTokenId();
}
?>
