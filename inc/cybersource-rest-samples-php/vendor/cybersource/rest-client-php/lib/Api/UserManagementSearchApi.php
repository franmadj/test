<?php
/**
 * UserManagementSearchApi
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
 * UserManagementSearchApi Class Doc Comment
 *
 * @category Class
 * @package  CyberSourceApi
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class UserManagementSearchApi
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
     * @return UserManagementSearchApi
     */
    public function setApiClient(\CyberSourceApi\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation searchUsers
     *
     * Search User Information
     *
     * @param \CyberSourceApi\Model\SearchRequest $searchRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\UmsV1UsersGet200Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function searchUsers($searchRequest)
    {
        self::$logger->info('CALL TO METHOD searchUsers STARTED');
        list($response, $statusCode, $httpHeader) = $this->searchUsersWithHttpInfo($searchRequest);
        self::$logger->info('CALL TO METHOD searchUsers ENDED');
        self::$logger->close();
        return [$response, $statusCode, $httpHeader];
    }

    /**
     * Operation searchUsersWithHttpInfo
     *
     * Search User Information
     *
     * @param \CyberSourceApi\Model\SearchRequest $searchRequest  (required)
     * @throws \CyberSourceApi\ApiException on non-2xx response
     * @return array of \CyberSourceApi\Model\UmsV1UsersGet200Response, HTTP status code, HTTP response headers (array of strings)
     */
    public function searchUsersWithHttpInfo($searchRequest)
    {
        // verify the required parameter 'searchRequest' is set
        if ($searchRequest === null) {
            self::$logger->error("InvalidArgumentException : Missing the required parameter $searchRequest when calling searchUsers");
            throw new \InvalidArgumentException('Missing the required parameter $searchRequest when calling searchUsers');
        }
        // parse inputs
        $resourcePath = "/ums/v1/users/search";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/hal+json;charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json']);

        // body params
        $_tempBody = null;
        if (isset($searchRequest)) {
            $_tempBody = $searchRequest;
        }
        
        $sdkTracker = new \CyberSourceApi\Utilities\Tracking\SdkTracker();
        $_tempBody = $sdkTracker->insertDeveloperIdTracker($_tempBody, end(explode('\\', '\CyberSourceApi\Model\SearchRequest')), $this->apiClient->merchantConfig->getRunEnvironment());

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

        self::$logger->debug("Return Type : \CyberSourceApi\Model\UmsV1UsersGet200Response");
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\CyberSourceApi\Model\UmsV1UsersGet200Response',
                '/ums/v1/users/search'
            );
            
            self::$logger->debug("Response Headers :\n" . \CyberSourceApi\Utilities\Helpers\ListHelper::toString($httpHeader));

            return [$this->apiClient->getSerializer()->deserialize($response, '\CyberSourceApi\Model\UmsV1UsersGet200Response', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\UmsV1UsersGet200Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\CyberSourceApi\Model\PtsV2PaymentsRefundPost400Response', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            self::$logger->error("ApiException : $e");
            throw $e;
        }
    }
}
