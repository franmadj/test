<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreatePaymentInstrumentPinlessDebit()
{
    $profileid = '93B32398-AD51-4CC2-A682-EA3E93614EB1';

    $cardArr = [
        "expirationMonth" => "12",
        "expirationYear" => "2031",
        "type" => "visa",
        "issueNumber" => "01",
        "startMonth" => "01",
        "startYear" => "2020",
        "useAs" => "pinless debit"
    ];
    $card = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentCard($cardArr);

    $billToArr = [
        "firstName" => "John",
        "lastName" => "Doe",
        "company" => "Cybersource",
        "address1" => "1 Market St",
        "locality" => "San Francisco",
        "administrativeArea" => "CA",
        "postalCode" => "94105",
        "country" => "US",
        "email" => "test@cybs.com",
        "phoneNumber" => "4158880000"
    ];
    $billTo = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBillTo($billToArr);

    $instrumentIdentifierArr = [
            "id" => "7010000000016241111"
    ];
    $instrumentIdentifier = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentInstrumentIdentifier($instrumentIdentifierArr);

    $requestObjArr = [
            "card" => $card,
            "billTo" => $billTo,
            "instrumentIdentifier" => $instrumentIdentifier
    ];
    $requestObj = new CyberSourceApi\Model\PostPaymentInstrumentRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\PaymentInstrumentApi($api_client);
    
    try {
        $apiResponse = $api_instance->postPaymentInstrument($requestObj, $profileid);
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
    echo "\nCreatePaymentInstrumentPinlessDebit Sample Code is Running..." . PHP_EOL;
    CreatePaymentInstrumentPinlessDebit();
}
?>
