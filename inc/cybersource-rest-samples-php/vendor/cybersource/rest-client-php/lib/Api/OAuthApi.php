<?php
/**
 * OAuthApi
 * PHP version 5
 *
 * @category Class
 * @package  CyberSourceApi
 */

/**
 * CyberSourceApi Merged Spec
 *
 * All CyberSourceApi API specs merged together. These are available at https://developer.cybersource.com/api/reference/api-reference.html
 *
 * OpenAPI spec version: 0.0.1
 * 
 */


namespace CyberSourceApi\Api;

use \CyberSourceApi\ApiClient;
use \CyberSourceApi\ApiException;
use \CyberSourceApi\Configuration;
use \CyberSourceApi\ObjectSerializer;
use \CyberSourceApi\Logging\LogFactory as LogFactory;

/**
 * OAuthApi Class Doc Comment
 *
 * @category Class
 * @package  CyberSourceApi
 */
class OAuthApi
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
     * @return OAuthApi
     */
    public function setApiClient(\CyberSourceApi\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation postAccessTokenRequest
     *
     * Post Access Token
     *
     * @param \CyberSourceApi\Model\CreateAccessTokenRequest $createAccessTokenRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\AccessTokenResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function postAccessTokenRequest($createAccessTokenRequest)
    {
        self::$logger->info('CALL TO METHOD postAccessTokenRequest STARTED');
        list($response, $statusCode, $httpHeader) = $this->postAccessTokenRequestWithHttpInfo($createAccessTokenRequest);
        self::$logger->info('CALL TO METHOD postAccessTokenRequest ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation postAccessTokenRequestWithHttpInfo
     *
     * Post Access Token
     *
     * @param \CyberSourceApi\Model\CreateAccessTokenRequest $createAccessTokenRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\AccessTokenResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function postAccessTokenRequestWithHttpInfo($createAccessTokenRequest)
    {
        // verify the required parameter 'createAccessTokenRequest' is set
        if ($createAccessTokenRequest === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $createAccessTokenRequest when calling postAccessTokenRequest");
            throw new \InvalidArgumentException('Missing the required parameter $createAccessTokenRequest when calling postAccessTokenRequest');
        }
        // parse inputs
        $resourcePath = "/oauth2/v3/token";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/hal+json;charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/x-www-form-urlencoded']);

        // body params
        $_tempBody = null;
        if (isset($createAccessTokenRequest)) {
            $_tempBody = $createAccessTokenRequest;
        }

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

        self::$logger->debug("Return Type : \CyberSourceApi\Model\AccessTokenResponse");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\CyberSourceApi\Model\AccessTokenResponse',
                '/oauth2/v3/token'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, '\CyberSourceApi\Model\AccessTokenResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\AccessTokenResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsCapturesPost400Response', $e->getResponseHeaders());
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
