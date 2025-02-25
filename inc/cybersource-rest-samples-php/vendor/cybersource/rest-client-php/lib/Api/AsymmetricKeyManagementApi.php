<?php
/**
 * AsymmetricKeyManagementApi
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
 * AsymmetricKeyManagementApi Class Doc Comment
 *
 * @category Class
 * @package  CyberSourceApi
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class AsymmetricKeyManagementApi
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
     * @return AsymmetricKeyManagementApi
     */
    public function setApiClient(\CyberSourceApi\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation createP12Keys
     *
     * Create one or more PKCS12 keys
     *
     * @param \CyberSourceApi\Model\CreateP12KeysRequest $createP12KeysRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\KmsV2KeysAsymPost201Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function createP12Keys($createP12KeysRequest)
    {
        self::$logger->info('CALL TO METHOD createP12Keys STARTED');
        list($response, $statusCode, $httpHeader) = $this->createP12KeysWithHttpInfo($createP12KeysRequest);
        self::$logger->info('CALL TO METHOD createP12Keys ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation createP12KeysWithHttpInfo
     *
     * Create one or more PKCS12 keys
     *
     * @param \CyberSourceApi\Model\CreateP12KeysRequest $createP12KeysRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\KmsV2KeysAsymPost201Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function createP12KeysWithHttpInfo($createP12KeysRequest)
    {
        // verify the required parameter 'createP12KeysRequest' is set
        if ($createP12KeysRequest === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $createP12KeysRequest when calling createP12Keys");
            throw new \InvalidArgumentException('Missing the required parameter $createP12KeysRequest when calling createP12Keys');
        }
        // parse inputs
        $resourcePath = "/kms/v2/keys-asym";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/hal+json;charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

        // body params
        $_tempBody = null;
        if (isset($createP12KeysRequest)) {
            $_tempBody = $createP12KeysRequest;
        }
        
        $sdkTracker = new \CyberSourceApi\Utilities\Tracking\SdkTracker();
        $_tempBody = $sdkTracker->insertDeveloperIdTracker($_tempBody, end(explode('\\', '\CyberSourceApi\Model\CreateP12KeysRequest')), $this->apiClient->merchantConfig->getRunEnvironment());

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // Logging
        self::$logger->debug("Resource : POST $resourcePath");
        if (isset($httpBody)) {
            if ($this->apiClient->merchantConfig->getLogConfiguration()->isMaskingEnabled()) {
                $printHttpBody = \CyberSourceApi\Utilities\Helpers\DataMasker::maskData($httpBody);
            } else {
                $printHttpBody = $httpBody;
            }
            
            self::$logger->debug("Body Parameter :\n" . $printHttpBody); 
        }

        self::$logger->debug("Return Type : \CyberSourceApi\Model\KmsV2KeysAsymPost201Response");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\CyberSourceApi\Model\KmsV2KeysAsymPost201Response',
                '/kms/v2/keys-asym'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, '\CyberSourceApi\Model\KmsV2KeysAsymPost201Response', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\KmsV2KeysAsymPost201Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse4005', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 502:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse5021', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }

    /**
     * Operation deleteBulkP12Keys
     *
     * Delete one or more PKCS12 keys
     *
     * @param \CyberSourceApi\Model\DeleteBulkP12KeysRequest $deleteBulkP12KeysRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\KmsV2KeysAsymDeletesPost200Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function deleteBulkP12Keys($deleteBulkP12KeysRequest)
    {
        self::$logger->info('CALL TO METHOD deleteBulkP12Keys STARTED');
        list($response, $statusCode, $httpHeader) = $this->deleteBulkP12KeysWithHttpInfo($deleteBulkP12KeysRequest);
        self::$logger->info('CALL TO METHOD deleteBulkP12Keys ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation deleteBulkP12KeysWithHttpInfo
     *
     * Delete one or more PKCS12 keys
     *
     * @param \CyberSourceApi\Model\DeleteBulkP12KeysRequest $deleteBulkP12KeysRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\KmsV2KeysAsymDeletesPost200Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function deleteBulkP12KeysWithHttpInfo($deleteBulkP12KeysRequest)
    {
        // verify the required parameter 'deleteBulkP12KeysRequest' is set
        if ($deleteBulkP12KeysRequest === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $deleteBulkP12KeysRequest when calling deleteBulkP12Keys");
            throw new \InvalidArgumentException('Missing the required parameter $deleteBulkP12KeysRequest when calling deleteBulkP12Keys');
        }
        // parse inputs
        $resourcePath = "/kms/v2/keys-asym/deletes";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/hal+json;charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

        // body params
        $_tempBody = null;
        if (isset($deleteBulkP12KeysRequest)) {
            $_tempBody = $deleteBulkP12KeysRequest;
        }
        
        $sdkTracker = new \CyberSourceApi\Utilities\Tracking\SdkTracker();
        $_tempBody = $sdkTracker->insertDeveloperIdTracker($_tempBody, end(explode('\\', '\CyberSourceApi\Model\DeleteBulkP12KeysRequest')), $this->apiClient->merchantConfig->getRunEnvironment());

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // Logging
        self::$logger->debug("Resource : POST $resourcePath");
        if (isset($httpBody)) {
            if ($this->apiClient->merchantConfig->getLogConfiguration()->isMaskingEnabled()) {
                $printHttpBody = \CyberSourceApi\Utilities\Helpers\DataMasker::maskData($httpBody);
            } else {
                $printHttpBody = $httpBody;
            }
            
            self::$logger->debug("Body Parameter :\n" . $printHttpBody); 
        }

        self::$logger->debug("Return Type : \CyberSourceApi\Model\KmsV2KeysAsymDeletesPost200Response");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\CyberSourceApi\Model\KmsV2KeysAsymDeletesPost200Response',
                '/kms/v2/keys-asym/deletes'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, '\CyberSourceApi\Model\KmsV2KeysAsymDeletesPost200Response', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\KmsV2KeysAsymDeletesPost200Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse4005', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 502:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse5021', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }

    /**
     * Operation getP12KeyDetails
     *
     * Retrieves PKCS12 key details
     *
     * @param string $keyId Key ID. (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\KmsV2KeysAsymGet200Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function getP12KeyDetails($keyId)
    {
        self::$logger->info('CALL TO METHOD getP12KeyDetails STARTED');
        list($response, $statusCode, $httpHeader) = $this->getP12KeyDetailsWithHttpInfo($keyId);
        self::$logger->info('CALL TO METHOD getP12KeyDetails ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation getP12KeyDetailsWithHttpInfo
     *
     * Retrieves PKCS12 key details
     *
     * @param string $keyId Key ID. (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\KmsV2KeysAsymGet200Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function getP12KeyDetailsWithHttpInfo($keyId)
    {
        // verify the required parameter 'keyId' is set
        if ($keyId === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $keyId when calling getP12KeyDetails");
            throw new \InvalidArgumentException('Missing the required parameter $keyId when calling getP12KeyDetails');
        }
        // parse inputs
        $resourcePath = "/kms/v2/keys-asym/{keyId}";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/hal+json;charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

        // path params
        if ($keyId !== null) {
            $resourcePath = str_replace(
                "{" . "keyId" . "}",
                $this->apiClient->getSerializer()->toPathValue($keyId),
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

        self::$logger->debug("Return Type : \CyberSourceApi\Model\KmsV2KeysAsymGet200Response");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\CyberSourceApi\Model\KmsV2KeysAsymGet200Response',
                '/kms/v2/keys-asym/{keyId}'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, '\CyberSourceApi\Model\KmsV2KeysAsymGet200Response', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\KmsV2KeysAsymGet200Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse4005', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 502:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse5021', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }

    /**
     * Operation updateAsymKey
     *
     * Activate or De-activate Asymmetric Key
     *
     * @param string $keyId Key ID. (required)
     * @param \CyberSourceApi\Model\UpdateAsymKeysRequest $updateAsymKeysRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of object, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateAsymKey($keyId, $updateAsymKeysRequest)
    {
        self::$logger->info('CALL TO METHOD updateAsymKey STARTED');
        list($response, $statusCode, $httpHeader) = $this->updateAsymKeyWithHttpInfo($keyId, $updateAsymKeysRequest);
        self::$logger->info('CALL TO METHOD updateAsymKey ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation updateAsymKeyWithHttpInfo
     *
     * Activate or De-activate Asymmetric Key
     *
     * @param string $keyId Key ID. (required)
     * @param \CyberSourceApi\Model\UpdateAsymKeysRequest $updateAsymKeysRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of object, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateAsymKeyWithHttpInfo($keyId, $updateAsymKeysRequest)
    {
        // verify the required parameter 'keyId' is set
        if ($keyId === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $keyId when calling updateAsymKey");
            throw new \InvalidArgumentException('Missing the required parameter $keyId when calling updateAsymKey');
        }
        // verify the required parameter 'updateAsymKeysRequest' is set
        if ($updateAsymKeysRequest === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $updateAsymKeysRequest when calling updateAsymKey");
            throw new \InvalidArgumentException('Missing the required parameter $updateAsymKeysRequest when calling updateAsymKey');
        }
        // parse inputs
        $resourcePath = "/kms/v2/keys-asym/{keyId}";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/hal+json;charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

        // path params
        if ($keyId !== null) {
            $resourcePath = str_replace(
                "{" . "keyId" . "}",
                $this->apiClient->getSerializer()->toPathValue($keyId),
                $resourcePath
            );
        }
        // body params
        $_tempBody = null;
        if (isset($updateAsymKeysRequest)) {
            $_tempBody = $updateAsymKeysRequest;
        }
        
        $sdkTracker = new \CyberSourceApi\Utilities\Tracking\SdkTracker();
        $_tempBody = $sdkTracker->insertDeveloperIdTracker($_tempBody, end(explode('\\', '\CyberSourceApi\Model\UpdateAsymKeysRequest')), $this->apiClient->merchantConfig->getRunEnvironment());

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // Logging
        self::$logger->debug("Resource : PATCH $resourcePath");
        if (isset($httpBody)) {
            if ($this->apiClient->merchantConfig->getLogConfiguration()->isMaskingEnabled()) {
                $printHttpBody = \CyberSourceApi\Utilities\Helpers\DataMasker::maskData($httpBody);
            } else {
                $printHttpBody = $httpBody;
            }
            
            self::$logger->debug("Body Parameter :\n" . $printHttpBody); 
        }

        self::$logger->debug("Return Type : object");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PATCH',
                $queryParams,
                $httpBody,
                $headerParams,
                'object',
                '/kms/v2/keys-asym/{keyId}'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, 'object', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), 'object', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse4006', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\InlineResponse5002', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }
}
