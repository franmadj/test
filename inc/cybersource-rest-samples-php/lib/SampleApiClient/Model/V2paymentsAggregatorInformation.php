<?php
/**
 * V2paymentsAggregatorInformation
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSourceApi
 
 */

namespace CybSource\SampleApiClient\Model;

use \ArrayAccess;

/**
 * V2paymentsAggregatorInformation Class Doc Comment
 *
 * @category    Class
 * @package     CyberSourceApi

 */
class V2paymentsAggregatorInformation implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $ModelName = 'v2payments_aggregatorInformation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Types = [
        'aggregatorId' => 'string',
        'name' => 'string',
        'subMerchant' => '\CyberSourceApi\Model\V2paymentsAggregatorInformationSubMerchant'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Formats = [
        'aggregatorId' => null,
        'name' => null,
        'subMerchant' => null
    ];

    public static function Types()
    {
        return self::$Types;
    }

    public static function Formats()
    {
        return self::$Formats;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'aggregatorId' => 'aggregatorID',
        'name' => 'name',
        'subMerchant' => 'subMerchant'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'aggregatorId' => 'setAggregatorId',
        'name' => 'setName',
        'subMerchant' => 'setSubMerchant'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'aggregatorId' => 'getAggregatorId',
        'name' => 'getName',
        'subMerchant' => 'getSubMerchant'
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
        $this->container['aggregatorId'] = isset($data['aggregatorId']) ? $data['aggregatorId'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['subMerchant'] = isset($data['subMerchant']) ? $data['subMerchant'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if (!is_null($this->container['aggregatorId']) && (strlen($this->container['aggregatorId']) > 20)) {
            $invalid_properties[] = "invalid value for 'aggregatorId', the character length must be smaller than or equal to 20.";
        }

        if (!is_null($this->container['name']) && (strlen($this->container['name']) > 37)) {
            $invalid_properties[] = "invalid value for 'name', the character length must be smaller than or equal to 37.";
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

        if (strlen($this->container['aggregatorId']) > 20) {
            return false;
        }
        if (strlen($this->container['name']) > 37) {
            return false;
        }
        return true;
    }


    /**
     * Gets aggregatorId
     * @return string
     */
    public function getAggregatorId()
    {
        return $this->container['aggregatorId'];
    }

    /**
     * Sets aggregatorId
     * @param string $aggregatorId Value that identifies you as a payment aggregator. Get this value from the processor.  For processor-specific information, see the aggregatorId field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setAggregatorId($aggregatorId)
    {
        if (!is_null($aggregatorId) && (strlen($aggregatorId) > 20)) {
            throw new \InvalidArgumentException('invalid length for $aggregatorId when calling V2paymentsAggregatorInformation., must be smaller than or equal to 20.');
        }

        $this->container['aggregatorId'] = $aggregatorId;

        return $this;
    }

    /**
     * Gets name
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     * @param string $name Your payment aggregator business name.  For processor-specific information, see the aggregator_name field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setName($name)
    {
        if (!is_null($name) && (strlen($name) > 37)) {
            throw new \InvalidArgumentException('invalid length for $name when calling V2paymentsAggregatorInformation., must be smaller than or equal to 37.');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets subMerchant
     * @return \CyberSourceApi\Model\V2paymentsAggregatorInformationSubMerchant
     */
    public function getSubMerchant()
    {
        return $this->container['subMerchant'];
    }

    /**
     * Sets subMerchant
     * @param \CyberSourceApi\Model\V2paymentsAggregatorInformationSubMerchant $subMerchant
     * @return $this
     */
    public function setSubMerchant($subMerchant)
    {
        $this->container['subMerchant'] = $subMerchant;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
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
            return json_encode(\CybSource\SampleApiClient\controller\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\CybSource\SampleApiClient\controller\ObjectSerializer::sanitizeForSerialization($this));
    }
}


