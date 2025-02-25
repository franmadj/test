<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ExternalConfiguration.php';

function SetupCompletionWithFluidDataValueAndPaymentSolution()
{
    $clientReferenceInformationArr = [
            "code" => "cybs_test"
    ];
    $clientReferenceInformation = new CyberSourceApi\Model\Riskv1decisionsClientReferenceInformation($clientReferenceInformationArr);

    $paymentInformationFluidDataArr = [
            "value" => "eyJkYXRhIjoiOFJTK2o1a2ZLRjZkTnkzNVwvOTluR3ZEVis0WUVlaStBb2VmUUNMXC9SNTN0TnVMeHJxTzh4b1g2SnBScm9WWUVUOUNvUkhIWFZMRjJNSVNIZlVtM25UczltdGFPTUdqcW1oeWdjTFpWVWI3OHhxYVVUT2JwWUxLelY0dFR1QmhvRkV4UVJ1d2lvTmo2bXJsRlRjUm5LNzdcL2lCR01yYVlZcXZTVnhGK3ViK1JXK3BGeTRDNUVUOVhmcHBkS2xHYXVpODdzcTBtYVlYVk9qOGFaNTFMWjZvS1NKZkR1clhvWEtLNHRqd1wvaDVRK1dcL0x2dnJxSUhmZmVhK21MZXVRY3RHK0k3UUN6MTRpVmdROUFEMW1oWFUrbVdwZXRUQWZ5WXhoVituZlh1NlpISGRDWFV1cUp6djQydHg4UlwvN0lvdld5OWx6Z0N3YnpuclVsY3pUcThkb3JtV3A4eXhYQklDNnJHRTdlTVJrS3oxZFwvUFFDXC9DS2J1NDhNK0R4XC9VejNoUFwvZ1NnRGoxakJNcUllUUZiRWFzcTRWTUV1ZG9FNUh1UjBcLzRQMXJmdG9EVlpwNnhFdnF1STY5dkt2YnZHcXpmTkpUNjVnPT0iLCJ2ZXJzaW9uIjoiRUNfdjEiLCJoZWFkZXIiOnsiYXBwbGljYXRpb25EYXRhIjoiNzQ2NTczNzQ2MTcwNzA2QzY5NjM2MTc0Njk2RjZFNjQ2MTc0NjEiLCJ0cmFuc2FjdGlvbklkIjoiNzQ2NTczNzQ3NDcyNjE2RTczNjE2Mzc0Njk2RjZFNjk2NCIsImVwaGVtZXJhbFB1YmxpY0tleSI6Ik1JSUJTekNDQVFNR0J5cUdTTTQ5QWdFd2dmY0NBUUV3TEFZSEtvWkl6ajBCQVFJaEFQXC9cL1wvXC84QUFBQUJBQUFBQUFBQUFBQUFBQUFBXC9cL1wvXC9cL1wvXC9cL1wvXC9cL1wvXC9cL1wvXC9NRnNFSVBcL1wvXC9cLzhBQUFBQkFBQUFBQUFBQUFBQUFBQUFcL1wvXC9cL1wvXC9cL1wvXC9cL1wvXC9cL1wvXC84QkNCYXhqWFlxanFUNTdQcnZWVjJtSWE4WlIwR3NNeFRzUFk3emp3K0o5SmdTd01WQU1TZE5naUc1d1NUYW1aNDRST2RKcmVCbjM2UUJFRUVheGZSOHVFc1FrZjR2T2JsWTZSQThuY0RmWUV0NnpPZzlLRTVSZGlZd3BaUDQwTGlcL2hwXC9tNDduNjBwOEQ1NFdLODR6VjJzeFhzN0x0a0JvTjc5UjlRSWhBUFwvXC9cL1wvOEFBQUFBXC9cL1wvXC9cL1wvXC9cL1wvXC8rODV2cXRweGVlaFBPNXlzTDhZeVZSQWdFQkEwSUFCQmJHK2xtTHJIWWtKSVwvSUUwcTU3dEN0bE5jK2pBWHNudVMrSnFlOFVcLzc0cSs5NVRnbzVFRjBZNks3b01LTUt5cTMwY3VQbmtIenkwMjVpU1BGdWczRT0iLCJwdWJsaWNLZXlIYXNoIjoieCtQbUhHMzdUNjdBWUFIenVqbGJyaW1JdzZZaFlYaVpjYjV3WnJCNGpRdz0ifSwic2lnbmF0dXJlIjoiTUlJRFFnWUpLb1pJaHZjTkFRY0NvSUlETXpDQ0F5OENBUUV4Q3pBSkJnVXJEZ01DR2dVQU1Bc0dDU3FHU0liM0RRRUhBYUNDQWlzd2dnSW5NSUlCbEtBREFnRUNBaEJjbCtQZjMrVTRwazEzblZEOW53UVFNQWtHQlNzT0F3SWRCUUF3SnpFbE1DTUdBMVVFQXg0Y0FHTUFhQUJ0QUdFQWFRQkFBSFlBYVFCekFHRUFMZ0JqQUc4QWJUQWVGdzB4TkRBeE1ERXdOakF3TURCYUZ3MHlOREF4TURFd05qQXdNREJhTUNjeEpUQWpCZ05WQkFNZUhBQmpBR2dBYlFCaEFHa0FRQUIyQUdrQWN3QmhBQzRBWXdCdkFHMHdnWjh3RFFZSktvWklodmNOQVFFQkJRQURnWTBBTUlHSkFvR0JBTkM4K2tndGdtdldGMU96amdETnJqVEVCUnVvXC81TUt2bE0xNDZwQWY3R3g0MWJsRTl3NGZJWEpBRDdGZk83UUtqSVhZTnQzOXJMeXk3eER3YlwvNUlrWk02MFRaMmlJMXBqNTVVYzhmZDRmek9wazNmdFphUUdYTkxZcHRHMWQ5VjdJUzgyT3VwOU1NbzFCUFZyWFRQSE5jc005OUVQVW5QcWRiZUdjODdtMHJBZ01CQUFHalhEQmFNRmdHQTFVZEFRUlJNRStBRUhaV1ByV3RKZDdZWjQzMWhDZzdZRlNoS1RBbk1TVXdJd1lEVlFRREhod0FZd0JvQUcwQVlRQnBBRUFBZGdCcEFITUFZUUF1QUdNQWJ3QnRnaEJjbCtQZjMrVTRwazEzblZEOW53UVFNQWtHQlNzT0F3SWRCUUFEZ1lFQWJVS1lDa3VJS1M5UVEybUZjTVlSRUltMmwrWGc4XC9KWHYrR0JWUUprT0tvc2NZNGlOREZBXC9iUWxvZ2Y5TExVODRUSHdOUm5zdlYzUHJ2N1JUWTgxZ3EwZHRDOHpZY0FhQWtDSElJM3lxTW5KNEFPdTZFT1c5a0prMjMyZ1NFN1dsQ3RIYmZMU0tmdVNnUVg4S1hRWXVaTGsyUnI2M044QXBYc1h3QkwzY0oweGdlQXdnZDBDQVFFd096QW5NU1V3SXdZRFZRUURIaHdBWXdCb0FHMEFZUUJwQUVBQWRnQnBBSE1BWVFBdUFHTUFid0J0QWhCY2wrUGYzK1U0cGsxM25WRDlud1FRTUFrR0JTc09Bd0lhQlFBd0RRWUpLb1pJaHZjTkFRRUJCUUFFZ1lBMG9MXC9KSWFTN0tra1RFNG1pOGRmU2tQVVwvdlp2cVwva2NYZ1pUdGJZbENtTFM4YzNuS2VZNVE0c2s4MXJnZkI1ampBMWJRZldhUHBKc05tVWNSS3gzS0FGUEtpNzE0WWVYdGUrcmc2V1k4MnVxcnlwRERiTkhqSWVpNjVqV0dvcGRZUEx6TEk5c1Z3NDh5OHlqSXY3SjFaQVlycnp6YjBwNzUzcUJUQ0ZEN1p3PT0ifQ=="
    ];
    $paymentInformationFluidData = new CyberSourceApi\Model\Riskv1authenticationsetupsPaymentInformationFluidData($paymentInformationFluidDataArr);

    $paymentInformationArr = [
            "fluidData" => $paymentInformationFluidData
    ];
    $paymentInformation = new CyberSourceApi\Model\Riskv1authenticationsetupsPaymentInformation($paymentInformationArr);

    $processingInformationArr = [
            "paymentSolution" => "001"
    ];
    $processingInformation = new CyberSourceApi\Model\Riskv1authenticationsetupsProcessingInformation($processingInformationArr);

    $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "paymentInformation" => $paymentInformation,
            "processingInformation" => $processingInformation
    ];
    $requestObj = new CyberSourceApi\Model\PayerAuthSetupRequest($requestObjArr);


    $commonElement = new CyberSourceApi\ExternalConfiguration();
    $config = $commonElement->ConnectionHost();
    $merchantConfig = $commonElement->merchantConfigObject();

    $api_client = new CyberSourceApi\ApiClient($config, $merchantConfig);
    $api_instance = new CyberSourceApi\Api\PayerAuthenticationApi($api_client);

    try {
        $apiResponse = $api_instance->payerAuthSetup($requestObj);
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
    echo "\nSetupCompletionWithFluidDataValueAndPaymentSolution Sample Code is Running..." . PHP_EOL;
    SetupCompletionWithFluidDataValueAndPaymentSolution();
}
?>
