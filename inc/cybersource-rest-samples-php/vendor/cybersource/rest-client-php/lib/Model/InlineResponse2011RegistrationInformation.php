<?php
/**
 * InlineResponse2011RegistrationInformation
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
 * InlineResponse2011RegistrationInformation Class Doc Comment
 *
 * @category    Class
 * @package     CyberSourceApi
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class InlineResponse2011RegistrationInformation implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'inline_response_201_1_registrationInformation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'boardingPackageId' => 'string',
        'mode' => 'string',
        'salesRepId' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'boardingPackageId' => null,
        'mode' => null,
        'salesRepId' => null
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
        'boardingPackageId' => 'boardingPackageId',
        'mode' => 'mode',
        'salesRepId' => 'salesRepId'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'boardingPackageId' => 'setBoardingPackageId',
        'mode' => 'setMode',
        'salesRepId' => 'setSalesRepId'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'boardingPackageId' => 'getBoardingPackageId',
        'mode' => 'getMode',
        'salesRepId' => 'getSalesRepId'
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

    const MODE_COMPLETE = 'COMPLETE';
    const MODE_PARTIAL = 'PARTIAL';
    

    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getModeAllowableValues()
    {
        return [
            self::MODE_COMPLETE,
            self::MODE_PARTIAL,
        ];
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
        $this->container['boardingPackageId'] = isset($data['boardingPackageId']) ? $data['boardingPackageId'] : null;
        $this->container['mode'] = isset($data['mode']) ? $data['mode'] : null;
        $this->container['salesRepId'] = isset($data['salesRepId']) ? $data['salesRepId'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        $allowed_values = $this->getModeAllowableValues();
        if (!in_array($this->container['mode'], $allowed_values)) {
            $invalid_properties[] = sprintf(
                "invalid value for 'mode', must be one of '%s'",
                implode("', '", $allowed_values)
            );
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

        $allowed_values = $this->getModeAllowableValues();
        if (!in_array($this->container['mode'], $allowed_values)) {
            return false;
        }
        return true;
    }


    /**
     * Gets boardingPackageId
     * @return string
     */
    public function getBoardingPackageId()
    {
        return $this->container['boardingPackageId'];
    }

    /**
     * Sets boardingPackageId
     * @param string $boardingPackageId
     * @return $this
     */
    public function setBoardingPackageId($boardingPackageId)
    {
        $this->container['boardingPackageId'] = $boardingPackageId;

        return $this;
    }

    /**
     * Gets mode
     * @return string
     */
    public function getMode()
    {
        return $this->container['mode'];
    }

    /**
     * Sets mode
     * @param string $mode In case mode is not provided the API will use COMPLETE as default Possible Values:   - 'COMPLETE'   - 'PARTIAL'
     * @return $this
     */
    public function setMode($mode)
    {
        $allowed_values = $this->getModeAllowableValues();
        if (!is_null($mode) && !in_array($mode, $allowed_values)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'mode', must be one of '%s'",
                    implode("', '", $allowed_values)
                )
            );
        }
        $this->container['mode'] = $mode;

        return $this;
    }

    /**
     * Gets salesRepId
     * @return string
     */
    public function getSalesRepId()
    {
        return $this->container['salesRepId'];
    }

    /**
     * Sets salesRepId
     * @param string $salesRepId
     * @return $this
     */
    public function setSalesRepId($salesRepId)
    {
        $this->container['salesRepId'] = $salesRepId;

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


