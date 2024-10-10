<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../../Resources/ExternalConfiguration.php';

function CreateCustomerPaymentInstrumentBankAccount()
{
    $customerTokenId = 'AB695DA801DD1BB6E05341588E0A3BDC';
    $bankAccountArr = [
            "type" => "savings"
    ];
    $bankAccount = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBankAccount($bankAccountArr);

    $buyerInformationPersonalIdentification = array();
    $buyerInformationPersonalIdentificationIssuedBy_0Arr = [
            "administrativeArea" => "CA" ];
    $buyerInformationPersonalIdentificationIssuedBy_0 = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBuyerInformationIssuedBy($buyerInformationPersonalIdentificationIssuedBy_0Arr);

    $buyerInformationPersonalIdentification_0 = [
            "id" => "57684432111321",
            "type" => "driver license", "issuedBy" => $buyerInformationPersonalIdentificationIssuedBy_0
    ];
    $buyerInformationPersonalIdentification[0] = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBuyerInformationPersonalIdentification($buyerInformationPersonalIdentification_0);

    $buyerInformationArr = [
            "companyTaxID" => "12345",
            "currency" => "USD",
            "dateOfBirth" => "2000-12-13",
            "personalIdentification" => $buyerInformationPersonalIdentification
    ];
    $buyerInformation = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBuyerInformation($buyerInformationArr);

    $billToArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "company" => "CyberSourceApi",
            "address1" => "1 Market St",
            "locality" => "San Francisco",
            "administrativeArea" => "CA",
            "postalCode" => "94105",
            "country" => "US",
            "email" => "test@cybs.com",
            "phoneNumber" => "4158880000"
    ];
    $billTo = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentBillTo($billToArr);

    $processingInformationBankTransferOptionsArr = [
            "seCCode" => "WEB"
    ];
    $processingInformationBankTransferOptions = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentProcessingInformationBankTransferOptions($processingInformationBankTransferOptionsArr);

    $processingInformationArr = [
            "bankTransferOptions" => $processingInformationBankTransferOptions
    ];
    $processingInformation = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentProcessingInformation($processingInformationArr);

    $instrumentIdentifierArr = [
            "id" => "A7A91A2CA872B272E05340588D0A0699"
    ];
    $instrumentIdentifier = new CyberSourceApi\Model\Tmsv2customersEmbeddedDefaultPaymentInstrumentInstrumentIdentifier($instrumentIdentifierArr);

    $requestObjArr = [
            "bankAccount" => $bankAccount,
            "buyerInformation" => $buyerInformation,
            "billTo" => $billTo,
            "processingInformation" => $processingInformation,
            "instrumentIdentifier" => $instrumentIdentifier
    ];
    $requestObj = new CyberSourceApi\Model\PostCustomerPaymentInstrumentRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\CustomerPaymentInstrumentApi($api_client);

    try {
        $apiResponse = $api_instance->postCustomerPaymentInstrument($customerTokenId, $requestObj, null);
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
    CreateCustomerPaymentInstrumentBankAccount();
}
?>
