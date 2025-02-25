<?php
/**
 * Ptsv2paymentsWatchlistScreeningInformation
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
 * Ptsv2paymentsWatchlistScreeningInformation Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Ptsv2paymentsWatchlistScreeningInformation implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'ptsv2payments_watchlistScreeningInformation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'addressOperator' => 'string',
        'weights' => '\CyberSourceApi\Model\Ptsv2paymentsWatchlistScreeningInformationWeights',
        'sanctionLists' => 'string[]',
        'proceedOnMatch' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'addressOperator' => null,
        'weights' => null,
        'sanctionLists' => null,
        'proceedOnMatch' => null
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
        'addressOperator' => 'addressOperator',
        'weights' => 'weights',
        'sanctionLists' => 'sanctionLists',
        'proceedOnMatch' => 'proceedOnMatch'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'addressOperator' => 'setAddressOperator',
        'weights' => 'setWeights',
        'sanctionLists' => 'setSanctionLists',
        'proceedOnMatch' => 'setProceedOnMatch'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'addressOperator' => 'getAddressOperator',
        'weights' => 'getWeights',
        'sanctionLists' => 'getSanctionLists',
        'proceedOnMatch' => 'getProceedOnMatch'
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
        $this->container['addressOperator'] = isset($data['addressOperator']) ? $data['addressOperator'] : null;
        $this->container['weights'] = isset($data['weights']) ? $data['weights'] : null;
        $this->container['sanctionLists'] = isset($data['sanctionLists']) ? $data['sanctionLists'] : null;
        $this->container['proceedOnMatch'] = isset($data['proceedOnMatch']) ? $data['proceedOnMatch'] : null;
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
     * Gets addressOperator
     * @return string
     */
    public function getAddressOperator()
    {
        return $this->container['addressOperator'];
    }

    /**
     * Sets addressOperator
     * @param string $addressOperator Parts of the customer's information that must match with an entry in the DPL (denied parties list) before a match occurs. This field can contain one of the following values: - AND: (default) The customer's name or company and the customer's address must appear in the database. - OR: The customer's name must appear in the database. - IGNORE: You want the service to detect a match only of the customer's name or company but not of the address.
     * @return $this
     */
    public function setAddressOperator($addressOperator)
    {
        $this->container['addressOperator'] = $addressOperator;

        return $this;
    }

    /**
     * Gets weights
     * @return \CyberSourceApi\Model\Ptsv2paymentsWatchlistScreeningInformationWeights
     */
    public function getWeights()
    {
        return $this->container['weights'];
    }

    /**
     * Sets weights
     * @param \CyberSourceApi\Model\Ptsv2paymentsWatchlistScreeningInformationWeights $weights
     * @return $this
     */
    public function setWeights($weights)
    {
        $this->container['weights'] = $weights;

        return $this;
    }

    /**
     * Gets sanctionLists
     * @return string[]
     */
    public function getSanctionLists()
    {
        return $this->container['sanctionLists'];
    }

    /**
     * Sets sanctionLists
     * @param string[] $sanctionLists Use this field to specify which list(s) you want checked with the request. The reply will include the list name as well as the response data. To check against multiple lists, enter multiple list codes separated by a caret (^). For more information, see \"Restricted and Denied Parties List,\" page 68.
     * @return $this
     */
    public function setSanctionLists($sanctionLists)
    {
        $this->container['sanctionLists'] = $sanctionLists;

        return $this;
    }

    /**
     * Gets proceedOnMatch
     * @return bool
     */
    public function getProceedOnMatch()
    {
        return $this->container['proceedOnMatch'];
    }

    /**
     * Sets proceedOnMatch
     * @param bool $proceedOnMatch Indicates whether the transaction should proceed if there is a match. Possible values: - `true`: Transaction proceeds even when match is found in the Denied Parties List. The match is noted in the response. - `false`: Normal watchlist screening behavior occurs. (Transaction stops if a match to DPL occurs. Transaction proceeds if no match.)
     * @return $this
     */
    public function setProceedOnMatch($proceedOnMatch)
    {
        $this->container['proceedOnMatch'] = $proceedOnMatch;

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


