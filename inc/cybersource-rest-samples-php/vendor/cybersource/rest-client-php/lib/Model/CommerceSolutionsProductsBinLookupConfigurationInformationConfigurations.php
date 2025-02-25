<?php
/**
 * CommerceSolutionsProductsBinLookupConfigurationInformationConfigurations
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSourceApi
 * @author   Swaagger Codegen team
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

namespace CyberSourceApi\Model;

use \ArrayAccess;

/**
 * CommerceSolutionsProductsBinLookupConfigurationInformationConfigurations Class Doc Comment
 *
 * @category    Class
 * @package     CyberSourceApi
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class CommerceSolutionsProductsBinLookupConfigurationInformationConfigurations implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'commerceSolutionsProducts_binLookup_configurationInformation_configurations';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'isPayoutOptionsEnabled' => 'bool',
        'isAccountPrefixEnabled' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'isPayoutOptionsEnabled' => null,
        'isAccountPrefixEnabled' => null
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
        'isPayoutOptionsEnabled' => 'isPayoutOptionsEnabled',
        'isAccountPrefixEnabled' => 'isAccountPrefixEnabled'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'isPayoutOptionsEnabled' => 'setIsPayoutOptionsEnabled',
        'isAccountPrefixEnabled' => 'setIsAccountPrefixEnabled'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'isPayoutOptionsEnabled' => 'getIsPayoutOptionsEnabled',
        'isAccountPrefixEnabled' => 'getIsAccountPrefixEnabled'
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
        $this->container['isPayoutOptionsEnabled'] = isset($data['isPayoutOptionsEnabled']) ? $data['isPayoutOptionsEnabled'] : null;
        $this->container['isAccountPrefixEnabled'] = isset($data['isAccountPrefixEnabled']) ? $data['isAccountPrefixEnabled'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

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

        return true;
    }


    /**
     * Gets isPayoutOptionsEnabled
     * @return bool
     */
    public function getIsPayoutOptionsEnabled()
    {
        return $this->container['isPayoutOptionsEnabled'];
    }

    /**
     * Sets isPayoutOptionsEnabled
     * @param bool $isPayoutOptionsEnabled This flag indicates if the merchant is configured to make payout calls
     * @return $this
     */
    public function setIsPayoutOptionsEnabled($isPayoutOptionsEnabled)
    {
        $this->container['isPayoutOptionsEnabled'] = $isPayoutOptionsEnabled;

        return $this;
    }

    /**
     * Gets isAccountPrefixEnabled
     * @return bool
     */
    public function getIsAccountPrefixEnabled()
    {
        return $this->container['isAccountPrefixEnabled'];
    }

    /**
     * Sets isAccountPrefixEnabled
     * @param bool $isAccountPrefixEnabled This flag indicates if the merchant is configured to receive account prefix
     * @return $this
     */
    public function setIsAccountPrefixEnabled($isAccountPrefixEnabled)
    {
        $this->container['isAccountPrefixEnabled'] = $isAccountPrefixEnabled;

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


