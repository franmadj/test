<?php
/**
 * V2paymentsAggregatorInformationSubMerchant
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSourceApi
 
 */

namespace CybSource\SampleApiClient\Model;

use \ArrayAccess;

/**
 * V2paymentsAggregatorInformationSubMerchant Class Doc Comment
 *
 * @category    Class
 * @package     CyberSourceApi
 */
class V2paymentsAggregatorInformationSubMerchant implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $ModelName = 'v2payments_aggregatorInformation_subMerchant';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Types = [
        'cardAcceptorId' => 'string',
        'name' => 'string',
        'address1' => 'string',
        'locality' => 'string',
        'administrativeArea' => 'string',
        'region' => 'string',
        'postalCode' => 'string',
        'country' => 'string',
        'email' => 'string',
        'phoneNumber' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Formats = [
        'cardAcceptorId' => null,
        'name' => null,
        'address1' => null,
        'locality' => null,
        'administrativeArea' => null,
        'region' => null,
        'postalCode' => null,
        'country' => null,
        'email' => null,
        'phoneNumber' => null
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
        'cardAcceptorId' => 'cardAcceptorID',
        'name' => 'name',
        'address1' => 'address1',
        'locality' => 'locality',
        'administrativeArea' => 'administrativeArea',
        'region' => 'region',
        'postalCode' => 'postalCode',
        'country' => 'country',
        'email' => 'email',
        'phoneNumber' => 'phoneNumber'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'cardAcceptorId' => 'setCardAcceptorId',
        'name' => 'setName',
        'address1' => 'setAddress1',
        'locality' => 'setLocality',
        'administrativeArea' => 'setAdministrativeArea',
        'region' => 'setRegion',
        'postalCode' => 'setPostalCode',
        'country' => 'setCountry',
        'email' => 'setEmail',
        'phoneNumber' => 'setPhoneNumber'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'cardAcceptorId' => 'getCardAcceptorId',
        'name' => 'getName',
        'address1' => 'getAddress1',
        'locality' => 'getLocality',
        'administrativeArea' => 'getAdministrativeArea',
        'region' => 'getRegion',
        'postalCode' => 'getPostalCode',
        'country' => 'getCountry',
        'email' => 'getEmail',
        'phoneNumber' => 'getPhoneNumber'
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
        $this->container['cardAcceptorId'] = isset($data['cardAcceptorId']) ? $data['cardAcceptorId'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['address1'] = isset($data['address1']) ? $data['address1'] : null;
        $this->container['locality'] = isset($data['locality']) ? $data['locality'] : null;
        $this->container['administrativeArea'] = isset($data['administrativeArea']) ? $data['administrativeArea'] : null;
        $this->container['region'] = isset($data['region']) ? $data['region'] : null;
        $this->container['postalCode'] = isset($data['postalCode']) ? $data['postalCode'] : null;
        $this->container['country'] = isset($data['country']) ? $data['country'] : null;
        $this->container['email'] = isset($data['email']) ? $data['email'] : null;
        $this->container['phoneNumber'] = isset($data['phoneNumber']) ? $data['phoneNumber'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];

        if (!is_null($this->container['cardAcceptorId']) && (strlen($this->container['cardAcceptorId']) > 15)) {
            $invalid_properties[] = "invalid value for 'cardAcceptorId', the character length must be smaller than or equal to 15.";
        }

        if (!is_null($this->container['name']) && (strlen($this->container['name']) > 37)) {
            $invalid_properties[] = "invalid value for 'name', the character length must be smaller than or equal to 37.";
        }

        if (!is_null($this->container['address1']) && (strlen($this->container['address1']) > 38)) {
            $invalid_properties[] = "invalid value for 'address1', the character length must be smaller than or equal to 38.";
        }

        if (!is_null($this->container['locality']) && (strlen($this->container['locality']) > 21)) {
            $invalid_properties[] = "invalid value for 'locality', the character length must be smaller than or equal to 21.";
        }

        if (!is_null($this->container['administrativeArea']) && (strlen($this->container['administrativeArea']) > 3)) {
            $invalid_properties[] = "invalid value for 'administrativeArea', the character length must be smaller than or equal to 3.";
        }

        if (!is_null($this->container['region']) && (strlen($this->container['region']) > 3)) {
            $invalid_properties[] = "invalid value for 'region', the character length must be smaller than or equal to 3.";
        }

        if (!is_null($this->container['postalCode']) && (strlen($this->container['postalCode']) > 15)) {
            $invalid_properties[] = "invalid value for 'postalCode', the character length must be smaller than or equal to 15.";
        }

        if (!is_null($this->container['country']) && (strlen($this->container['country']) > 3)) {
            $invalid_properties[] = "invalid value for 'country', the character length must be smaller than or equal to 3.";
        }

        if (!is_null($this->container['email']) && (strlen($this->container['email']) > 40)) {
            $invalid_properties[] = "invalid value for 'email', the character length must be smaller than or equal to 40.";
        }

        if (!is_null($this->container['phoneNumber']) && (strlen($this->container['phoneNumber']) > 20)) {
            $invalid_properties[] = "invalid value for 'phoneNumber', the character length must be smaller than or equal to 20.";
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

        if (strlen($this->container['cardAcceptorId']) > 15) {
            return false;
        }
        if (strlen($this->container['name']) > 37) {
            return false;
        }
        if (strlen($this->container['address1']) > 38) {
            return false;
        }
        if (strlen($this->container['locality']) > 21) {
            return false;
        }
        if (strlen($this->container['administrativeArea']) > 3) {
            return false;
        }
        if (strlen($this->container['region']) > 3) {
            return false;
        }
        if (strlen($this->container['postalCode']) > 15) {
            return false;
        }
        if (strlen($this->container['country']) > 3) {
            return false;
        }
        if (strlen($this->container['email']) > 40) {
            return false;
        }
        if (strlen($this->container['phoneNumber']) > 20) {
            return false;
        }
        return true;
    }


    /**
     * Gets cardAcceptorId
     * @return string
     */
    public function getCardAcceptorId()
    {
        return $this->container['cardAcceptorId'];
    }

    /**
     * Sets cardAcceptorId
     * @param string $cardAcceptorId Unique identifier assigned by the payment card company to the sub-merchant.
     * @return $this
     */
    public function setCardAcceptorId($cardAcceptorId)
    {
        if (!is_null($cardAcceptorId) && (strlen($cardAcceptorId) > 15)) {
            throw new \InvalidArgumentException('invalid length for $cardAcceptorId when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 15.');
        }

        $this->container['cardAcceptorId'] = $cardAcceptorId;

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
     * @param string $name Sub-merchant’s business name.
     * @return $this
     */
    public function setName($name)
    {
        if (!is_null($name) && (strlen($name) > 37)) {
            throw new \InvalidArgumentException('invalid length for $name when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 37.');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets address1
     * @return string
     */
    public function getAddress1()
    {
        return $this->container['address1'];
    }

    /**
     * Sets address1
     * @param string $address1 First line of the sub-merchant’s street address.
     * @return $this
     */
    public function setAddress1($address1)
    {
        if (!is_null($address1) && (strlen($address1) > 38)) {
            throw new \InvalidArgumentException('invalid length for $address1 when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 38.');
        }

        $this->container['address1'] = $address1;

        return $this;
    }

    /**
     * Gets locality
     * @return string
     */
    public function getLocality()
    {
        return $this->container['locality'];
    }

    /**
     * Sets locality
     * @param string $locality Sub-merchant’s city.
     * @return $this
     */
    public function setLocality($locality)
    {
        if (!is_null($locality) && (strlen($locality) > 21)) {
            throw new \InvalidArgumentException('invalid length for $locality when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 21.');
        }

        $this->container['locality'] = $locality;

        return $this;
    }

    /**
     * Gets administrativeArea
     * @return string
     */
    public function getAdministrativeArea()
    {
        return $this->container['administrativeArea'];
    }

    /**
     * Sets administrativeArea
     * @param string $administrativeArea Sub-merchant’s state or province. Use the State, Province, and Territory Codes for the United States and Canada.
     * @return $this
     */
    public function setAdministrativeArea($administrativeArea)
    {
        if (!is_null($administrativeArea) && (strlen($administrativeArea) > 3)) {
            throw new \InvalidArgumentException('invalid length for $administrativeArea when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 3.');
        }

        $this->container['administrativeArea'] = $administrativeArea;

        return $this;
    }

    /**
     * Gets region
     * @return string
     */
    public function getRegion()
    {
        return $this->container['region'];
    }

    /**
     * Sets region
     * @param string $region Sub-merchant’s region. Example `NE` indicates that the sub-merchant is in the northeast region.
     * @return $this
     */
    public function setRegion($region)
    {
        if (!is_null($region) && (strlen($region) > 3)) {
            throw new \InvalidArgumentException('invalid length for $region when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 3.');
        }

        $this->container['region'] = $region;

        return $this;
    }

    /**
     * Gets postalCode
     * @return string
     */
    public function getPostalCode()
    {
        return $this->container['postalCode'];
    }

    /**
     * Sets postalCode
     * @param string $postalCode Partial postal code for the sub-merchant’s address.
     * @return $this
     */
    public function setPostalCode($postalCode)
    {
        if (!is_null($postalCode) && (strlen($postalCode) > 15)) {
            throw new \InvalidArgumentException('invalid length for $postalCode when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 15.');
        }

        $this->container['postalCode'] = $postalCode;

        return $this;
    }

    /**
     * Gets country
     * @return string
     */
    public function getCountry()
    {
        return $this->container['country'];
    }

    /**
     * Sets country
     * @param string $country Sub-merchant’s country. Use the two-character ISO Standard Country Codes.
     * @return $this
     */
    public function setCountry($country)
    {
        if (!is_null($country) && (strlen($country) > 3)) {
            throw new \InvalidArgumentException('invalid length for $country when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 3.');
        }

        $this->container['country'] = $country;

        return $this;
    }

    /**
     * Gets email
     * @return string
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     * @param string $email Sub-merchant’s email address.  **Maximum length for processors**   - American Express Direct: 40  - CyberSourceApi through VisaNet: 40  - FDC Compass: 40  - FDC Nashville Global: 19
     * @return $this
     */
    public function setEmail($email)
    {
        if (!is_null($email) && (strlen($email) > 40)) {
            throw new \InvalidArgumentException('invalid length for $email when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 40.');
        }

        $this->container['email'] = $email;

        return $this;
    }

    /**
     * Gets phoneNumber
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->container['phoneNumber'];
    }

    /**
     * Sets phoneNumber
     * @param string $phoneNumber Sub-merchant’s telephone number.  **Maximum length for procesors**   - American Express Direct: 20  - CyberSourceApi through VisaNet: 20  - FDC Compass: 13  - FDC Nashville Global: 10
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        if (!is_null($phoneNumber) && (strlen($phoneNumber) > 20)) {
            throw new \InvalidArgumentException('invalid length for $phoneNumber when calling V2paymentsAggregatorInformationSubMerchant., must be smaller than or equal to 20.');
        }

        $this->container['phoneNumber'] = $phoneNumber;

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


