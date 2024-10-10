<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function ShippingDetailsNotUSOrCanada()
{
    $clientReferenceInformationArr = [
            "code" => "addressEg",
            "comments" => "dav-All fields"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $orderInformationBillToArr = [
            "address1" => "12301 research st",
            "address2" => "1",
            "address3" => "2",
            "address4" => "3",
            "administrativeArea" => "TX",
            "country" => "US",
            "locality" => "Austin",
            "postalCode" => "78759"
    ];
    $orderInformationBillTo = new CyberSourceApi\Model\Riskv1addressverificationsOrderInformationBillTo($orderInformationBillToArr);

    $orderInformationShipToArr = [
            "address1" => "4R.ILHA TERCEIRA,232-R/C-ESQ",
            "address2" => " ",
            "address3" => "",
            "address4" => "",
            "administrativeArea" => "WI",
            "country" => "PT",
            "locality" => "Carcavelos",
            "postalCode" => "29681"
    ];
    $orderInformationShipTo = new CyberSourceApi\Model\Riskv1addressverificationsOrderInformationShipTo($orderInformationShipToArr);

    $orderInformationLineItems = array();
    $orderInformationLineItems_0 = [
            "unitPrice" => "120.50",
            "quantity" => 3,
            "productSKU" => "9966223",
            "productName" => "headset",
            "productCode" => "electronic"
    ];
    $orderInformationLineItems[0] = new CyberSourceApi\Model\Riskv1addressverificationsOrderInformationLineItems($orderInformationLineItems_0);

    $orderInformationArr = [
            "billTo" => $orderInformationBillTo,
            "shipTo" => $orderInformationShipTo,
            "lineItems" => $orderInformationLineItems
    ];
    $orderInformation = new CyberSourceApi\Model\Riskv1addressverificationsOrderInformation($orderInformationArr);

    $buyerInformationArr = [
            "merchantCustomerId" => "ABCD"
    ];
    $buyerInformation = new CyberSourceApi\Model\Riskv1addressverificationsBuyerInformation($buyerInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "buyerInformation" => $buyerInformation
    ];
    $requestObj = new CyberSourceApi\Model\VerifyCustomerAddressRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\VerificationApi($api_client);

    try {
        $apiResponse = $api_instance->verifyCustomerAddress($requestObj);
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
    echo "\nShippingDetailsNotUSOrCanada Sample Code is Running..." . PHP_EOL;
    ShippingDetailsNotUSOrCanada();
}
?>
