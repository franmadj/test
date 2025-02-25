<?php
/**
 * PaymentsProductsPayerAuthenticationConfigurationInformationConfigurationsCardTypesVerifiedByVisaCurrencies
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSource
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * CyberSource Merged Spec
 *
 * All CyberSource API specs merged together. These are available at https://developer.cybersource.com/api/reference/api-reference.html
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

namespace CyberSourceApi\Model;

use \ArrayAccess;

/**
 * PaymentsProductsPayerAuthenticationConfigurationInformationConfigurationsCardTypesVerifiedByVisaCurrencies Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PaymentsProductsPayerAuthenticationConfigurationInformationConfigurationsCardTypesVerifiedByVisaCurrencies implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'paymentsProducts_payerAuthentication_configurationInformation_configurations_cardTypes_verifiedByVisa_currencies';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'currencyCodes' => 'string[]',
        'acquirerId' => 'string',
        'processorMerchantId' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'currencyCodes' => null,
        'acquirerId' => null,
        'processorMerchantId' => null
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'currencyCodes' => 'currencyCodes',
        'acquirerId' => 'acquirerId',
        'processorMerchantId' => 'processorMerchantId'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'currencyCodes' => 'setCurrencyCodes',
        'acquirerId' => 'setAcquirerId',
        'processorMerchantId' => 'setProcessorMerchantId'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'currencyCodes' => 'getCurrencyCodes',
        'acquirerId' => 'getAcquirerId',
        'processorMerchantId' => 'getProcessorMerchantId'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['currencyCodes'] = isset($data['currencyCodes']) ? $data['currencyCodes'] : null;
        $this->container['acquirerId'] = isset($data['acquirerId']) ? $data['acquirerId'] : null;
        $this->container['processorMerchantId'] = isset($data['processorMerchantId']) ? $data['processorMerchantId'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if (!is_null($this->container['acquirerId']) && !preg_match("/^[a-zA-Z0-9]{6,20}$/", $this->container['acquirerId'])) {
            $invalid_properties[] = "invalid value for 'acquirerId', must be conform to the pattern /^[a-zA-Z0-9]{6,20}$/.";
        }

        if (!is_null($this->container['processorMerchantId']) && !preg_match("/^[a-zA-Z0-9]{6,35}$/", $this->container['processorMerchantId'])) {
            $invalid_properties[] = "invalid value for 'processorMerchantId', must be conform to the pattern /^[a-zA-Z0-9]{6,35}$/.";
        }

        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        if (!preg_match("/^[a-zA-Z0-9]{6,20}$/", $this->container['acquirerId'])) {
            return false;
        }
        if (!preg_match("/^[a-zA-Z0-9]{6,35}$/", $this->container['processorMerchantId'])) {
            return false;
        }
        return true;
    }


    /**
     * Gets currencyCodes
     * @return string[]
     */
    public function getCurrencyCodes()
    {
        return $this->container['currencyCodes'];
    }

    /**
     * Sets currencyCodes
     * @param string[] $currencyCodes
     * @return $this
     */
    public function setCurrencyCodes($currencyCodes)
    {
        $this->container['currencyCodes'] = $currencyCodes;

        return $this;
    }

    /**
     * Gets acquirerId
     * @return string
     */
    public function getAcquirerId()
    {
        return $this->container['acquirerId'];
    }

    /**
     * Sets acquirerId
     * @param string $acquirerId The Acquirer ID value, often referred to as the Acquirer BIN, is specific to an Acquirer. The value is created by Cardinal in their system and the Acquirer may not know that the Acquirer ID is different from their Acquiring BIN. It is most often the Acquiring BIN + \"-1000\" but the trailing character can be different. **Note** We will need to double check with Cardinal before setting up the Portfolio Template in production.
     * @return $this
     */
    public function setAcquirerId($acquirerId)
    {
        if (!is_null($acquirerId) && (!preg_match("/^[a-zA-Z0-9]{6,20}$/", $acquirerId))) {
            throw new \InvalidArgumentException("invalid value for $acquirerId when calling PaymentsProductsPayerAuthenticationConfigurationInformationConfigurationsCardTypesVerifiedByVisaCurrencies., must conform to the pattern /^[a-zA-Z0-9]{6,20}$/.");
        }
        $this->container['acquirerId'] = $acquirerId;

        return $this;
    }

    /**
     * Gets processorMerchantId
     * @return string
     */
    public function getProcessorMerchantId()
    {
        return $this->container['processorMerchantId'];
    }

    /**
     * Sets processorMerchantId
     * @param string $processorMerchantId Processor Merchant ID is the Merchant ID assigned by your acquiring bank. This Merchant ID should also be used by your bank to register your account to the card scheme Directory Server for processing Payer Authentication services.
     * @return $this
     */
    public function setProcessorMerchantId($processorMerchantId)
    {
        if (!is_null($processorMerchantId) && (!preg_match("/^[a-zA-Z0-9]{6,35}$/", $processorMerchantId))) {
            throw new \InvalidArgumentException("invalid value for $processorMerchantId when calling PaymentsProductsPayerAuthenticationConfigurationInformationConfigurationsCardTypesVerifiedByVisaCurrencies., must conform to the pattern /^[a-zA-Z0-9]{6,35}$/.");
        }
        $this->container['processorMerchantId'] = $processorMerchantId;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\CyberSourceApi\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\CyberSourceApi\ObjectSerializer::sanitizeForSerialization($this));
    }
}


