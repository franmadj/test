<?php
/**
 * ReversalApi
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
 * ReversalApi Class Doc Comment
 *
 * @category Class
 * @package  CyberSourceApi
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ReversalApi
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
     * @return ReversalApi
     */
    public function setApiClient(\CyberSourceApi\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation authReversal
     *
     * Process an Authorization Reversal
     *
     * @param string $id The payment ID returned from a previous payment request. (required)
     * @param \CyberSourceApi\Model\AuthReversalRequest $authReversalRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function authReversal($id, $authReversalRequest)
    {
        self::$logger->info('CALL TO METHOD authReversal STARTED');
        list($response, $statusCode, $httpHeader) = $this->authReversalWithHttpInfo($id, $authReversalRequest);
        self::$logger->info('CALL TO METHOD authReversal ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation authReversalWithHttpInfo
     *
     * Process an Authorization Reversal
     *
     * @param string $id The payment ID returned from a previous payment request. (required)
     * @param \CyberSourceApi\Model\AuthReversalRequest $authReversalRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function authReversalWithHttpInfo($id, $authReversalRequest)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $id when calling authReversal");
            throw new \InvalidArgumentException('Missing the required parameter $id when calling authReversal');
        }
        // verify the required parameter 'authReversalRequest' is set
        if ($authReversalRequest === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $authReversalRequest when calling authReversal");
            throw new \InvalidArgumentException('Missing the required parameter $authReversalRequest when calling authReversal');
        }
        // parse inputs
        $resourcePath = "/pts/v2/payments/{id}/reversals";
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
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // body params
        $_tempBody = null;
        if (isset($authReversalRequest)) {
            $_tempBody = $authReversalRequest;
        }
        
        $sdkTracker = new \CyberSourceApi\Utilities\Tracking\SdkTracker();
        $end=explode('\\', '\CyberSourceApi\Model\AuthReversalRequest');
        $_tempBody = $sdkTracker->insertDeveloperIdTracker($_tempBody, end($end), $this->apiClient->merchantConfig->getRunEnvironment());

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

        self::$logger->debug("Return Type : \CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response',
                '/pts/v2/payments/{id}/reversals'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost400Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 502:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsPost502Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }

    /**
     * Operation mitReversal
     *
     * Timeout Reversal
     *
     * @param \CyberSourceApi\Model\MitReversalRequest $mitReversalRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function mitReversal($mitReversalRequest)
    {
        self::$logger->info('CALL TO METHOD mitReversal STARTED');
        list($response, $statusCode, $httpHeader) = $this->mitReversalWithHttpInfo($mitReversalRequest);
        self::$logger->info('CALL TO METHOD mitReversal ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation mitReversalWithHttpInfo
     *
     * Timeout Reversal
     *
     * @param \CyberSourceApi\Model\MitReversalRequest $mitReversalRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function mitReversalWithHttpInfo($mitReversalRequest)
    {
        // verify the required parameter 'mitReversalRequest' is set
        if ($mitReversalRequest === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $mitReversalRequest when calling mitReversal");
            throw new \InvalidArgumentException('Missing the required parameter $mitReversalRequest when calling mitReversal');
        }
        // parse inputs
        $resourcePath = "/pts/v2/reversals";
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
        if (isset($mitReversalRequest)) {
            $_tempBody = $mitReversalRequest;
        }
        
        $sdkTracker = new \CyberSourceApi\Utilities\Tracking\SdkTracker();
        $_tempBody = $sdkTracker->insertDeveloperIdTracker($_tempBody, end(explode('\\', '\CyberSourceApi\Model\MitReversalRequest')), $this->apiClient->merchantConfig->getRunEnvironment());

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

        self::$logger->debug("Return Type : \CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response',
                '/pts/v2/reversals'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost201Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsReversalsPost400Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 502:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsPost502Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }
}
