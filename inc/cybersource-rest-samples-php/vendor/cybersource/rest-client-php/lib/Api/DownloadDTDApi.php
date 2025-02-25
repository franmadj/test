<?php
/**
 * DownloadDTDApi
 * PHP version 5
 *
 * @category Class
 * @package  CyberSourceApi
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * CyberSourceApi Merged Spec
 *
 * All CyberSourceApi API specs merged together. These are available at https://developer.cybersource.com/api/reference/api-reference.html
 *
 * OpenAPI spec version: 0.0.1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace CyberSourceApi\Api;

use \CyberSourceApi\ApiClient;
use \CyberSourceApi\ApiException;
use \CyberSourceApi\Configuration;
use \CyberSourceApi\ObjectSerializer;
use \CyberSourceApi\Logging\LogFactory as LogFactory;

/**
 * DownloadDTDApi Class Doc Comment
 *
 * @category Class
 * @package  CyberSourceApi
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class DownloadDTDApi
{
    private static $logger = null;
    
    /**
     * API Client
     *
     * @var \CyberSourceApi\ApiClient instance of the ApiClient
     */
    protected $apiClient;

    /**
     * Constructor
     *
     * @param \CyberSourceApi\ApiClient|null $apiClient The api client to use
     */
    public function __construct(\CyberSourceApi\ApiClient $apiClient = null)
    {
        if ($apiClient === null) {
            $apiClient = new ApiClient();
        }

        $this->apiClient = $apiClient;

        if (self::$logger === null) {
            self::$logger = (new LogFactory())->getLogger(\CyberSourceApi\Utilities\Helpers\ClassHelper::getClassName(get_class()), $apiClient->merchantConfig->getLogConfiguration());
        }
    }

    /**
     * Get API client
     *
     * @return \CyberSourceApi\ApiClient get the API client
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param \CyberSourceApi\ApiClient $apiClient set the API client
     *
     * @return DownloadDTDApi
     */
    public function setApiClient(\CyberSourceApi\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation getDTDV2
     *
     * Download DTD for Report
     *
     * @param string $reportDefinitionNameVersion Name and version of DTD file to download. Some DTDs only have one version. In that case version name is not needed. Some example values are ctdr-1.0, tdr, pbdr-1.1 (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of void, HTTP status code, HTTP response headers (array of strings)
     */
    public function getDTDV2($reportDefinitionNameVersion)
    {
        self::$logger->info('CALL TO METHOD getDTDV2 STARTED');
        list($response, $statusCode, $httpHeader) = $this->getDTDV2WithHttpInfo($reportDefinitionNameVersion);
        self::$logger->info('CALL TO METHOD getDTDV2 ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation getDTDV2WithHttpInfo
     *
     * Download DTD for Report
     *
     * @param string $reportDefinitionNameVersion Name and version of DTD file to download. Some DTDs only have one version. In that case version name is not needed. Some example values are ctdr-1.0, tdr, pbdr-1.1 (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function getDTDV2WithHttpInfo($reportDefinitionNameVersion)
    {
        // verify the required parameter 'reportDefinitionNameVersion' is set
        if ($reportDefinitionNameVersion === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $reportDefinitionNameVersion when calling getDTDV2");
            throw new \InvalidArgumentException('Missing the required parameter $reportDefinitionNameVersion when calling getDTDV2');
        }
        // parse inputs
        $resourcePath = "/reporting/v3/dtds/{reportDefinitionNameVersion}";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/xml-dtd']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

        // path params
        if ($reportDefinitionNameVersion !== null) {
            $resourcePath = str_replace(
                "{" . "reportDefinitionNameVersion" . "}",
                $this->apiClient->getSerializer()->toPathValue($reportDefinitionNameVersion),
                $resourcePath
            );
        }
        if ('GET' == 'POST') {
            $_tempBody = '{}';
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // Logging
        self::$logger->debug("Resource : GET $resourcePath");
        if (isset($httpBody)) {
            if ($this->apiClient->merchantConfig->getLogConfiguration()->isMaskingEnabled()) {
                $printHttpBody = \CyberSourceApi\Utilities\Helpers\DataMasker::maskData($httpBody);
            } else {
                $printHttpBody = $httpBody;
            }
            
            self::$logger->debug("Body Parameter :\n" . $printHttpBody); 
        }

        self::$logger->debug("Return Type : null");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                null,
                '/reporting/v3/dtds/{reportDefinitionNameVersion}'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$response, $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }
}
