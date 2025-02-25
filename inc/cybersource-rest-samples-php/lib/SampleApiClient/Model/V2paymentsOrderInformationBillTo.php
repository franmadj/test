<?php
/**
 * V2paymentsOrderInformationBillTo
 *
 * PHP version 5
 *
 * @category Class
 * @package  CyberSourceApi
 
 */

namespace CybSource\SampleApiClient\Model;

use \ArrayAccess;

/**
 * V2paymentsOrderInformationBillTo Class Doc Comment
 *
 * @category    Class
 * @package     CyberSourceApi
 */
class V2paymentsOrderInformationBillTo implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $ModelName = 'v2payments_orderInformation_billTo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Types = [
        'firstName' => 'string',
        'lastName' => 'string',
        'company' => 'string',
        'address1' => 'string',
        'address2' => 'string',
        'locality' => 'string',
        'administrativeArea' => 'string',
        'postalCode' => 'string',
        'country' => 'string',
        'district' => 'string',
        'buildingNumber' => 'string',
        'email' => 'string',
        'phoneNumber' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $Formats = [
        'firstName' => null,
        'lastName' => null,
        'company' => null,
        'address1' => null,
        'address2' => null,
        'locality' => null,
        'administrativeArea' => null,
        'postalCode' => null,
        'country' => null,
        'district' => null,
        'buildingNumber' => null,
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
        'firstName' => 'firstName',
        'lastName' => 'lastName',
        'company' => 'company',
        'address1' => 'address1',
        'address2' => 'address2',
        'locality' => 'locality',
        'administrativeArea' => 'administrativeArea',
        'postalCode' => 'postalCode',
        'country' => 'country',
        'district' => 'district',
        'buildingNumber' => 'buildingNumber',
        'email' => 'email',
        'phoneNumber' => 'phoneNumber'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'firstName' => 'setFirstName',
        'lastName' => 'setLastName',
        'company' => 'setCompany',
        'address1' => 'setAddress1',
        'address2' => 'setAddress2',
        'locality' => 'setLocality',
        'administrativeArea' => 'setAdministrativeArea',
        'postalCode' => 'setPostalCode',
        'country' => 'setCountry',
        'district' => 'setDistrict',
        'buildingNumber' => 'setBuildingNumber',
        'email' => 'setEmail',
        'phoneNumber' => 'setPhoneNumber'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'firstName' => 'getFirstName',
        'lastName' => 'getLastName',
        'company' => 'getCompany',
        'address1' => 'getAddress1',
        'address2' => 'getAddress2',
        'locality' => 'getLocality',
        'administrativeArea' => 'getAdministrativeArea',
        'postalCode' => 'getPostalCode',
        'country' => 'getCountry',
        'district' => 'getDistrict',
        'buildingNumber' => 'getBuildingNumber',
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
        $this->container['firstName'] = isset($data['firstName']) ? $data['firstName'] : null;
        $this->container['lastName'] = isset($data['lastName']) ? $data['lastName'] : null;
        $this->container['company'] = isset($data['company']) ? $data['company'] : null;
        $this->container['address1'] = isset($data['address1']) ? $data['address1'] : null;
        $this->container['address2'] = isset($data['address2']) ? $data['address2'] : null;
        $this->container['locality'] = isset($data['locality']) ? $data['locality'] : null;
        $this->container['administrativeArea'] = isset($data['administrativeArea']) ? $data['administrativeArea'] : null;
        $this->container['postalCode'] = isset($data['postalCode']) ? $data['postalCode'] : null;
        $this->container['country'] = isset($data['country']) ? $data['country'] : null;
        $this->container['district'] = isset($data['district']) ? $data['district'] : null;
        $this->container['buildingNumber'] = isset($data['buildingNumber']) ? $data['buildingNumber'] : null;
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

        if (!is_null($this->container['firstName']) && (strlen($this->container['firstName']) > 60)) {
            $invalid_properties[] = "invalid value for 'firstName', the character length must be smaller than or equal to 60.";
        }

        if (!is_null($this->container['lastName']) && (strlen($this->container['lastName']) > 60)) {
            $invalid_properties[] = "invalid value for 'lastName', the character length must be smaller than or equal to 60.";
        }

        if (!is_null($this->container['company']) && (strlen($this->container['company']) > 60)) {
            $invalid_properties[] = "invalid value for 'company', the character length must be smaller than or equal to 60.";
        }

        if (!is_null($this->container['address1']) && (strlen($this->container['address1']) > 60)) {
            $invalid_properties[] = "invalid value for 'address1', the character length must be smaller than or equal to 60.";
        }

        if (!is_null($this->container['address2']) && (strlen($this->container['address2']) > 60)) {
            $invalid_properties[] = "invalid value for 'address2', the character length must be smaller than or equal to 60.";
        }

        if (!is_null($this->container['locality']) && (strlen($this->container['locality']) > 50)) {
            $invalid_properties[] = "invalid value for 'locality', the character length must be smaller than or equal to 50.";
        }

        if (!is_null($this->container['administrativeArea']) && (strlen($this->container['administrativeArea']) > 2)) {
            $invalid_properties[] = "invalid value for 'administrativeArea', the character length must be smaller than or equal to 2.";
        }

        if (!is_null($this->container['postalCode']) && (strlen($this->container['postalCode']) > 10)) {
            $invalid_properties[] = "invalid value for 'postalCode', the character length must be smaller than or equal to 10.";
        }

        if (!is_null($this->container['country']) && (strlen($this->container['country']) > 2)) {
            $invalid_properties[] = "invalid value for 'country', the character length must be smaller than or equal to 2.";
        }

        if (!is_null($this->container['district']) && (strlen($this->container['district']) > 50)) {
            $invalid_properties[] = "invalid value for 'district', the character length must be smaller than or equal to 50.";
        }

        if (!is_null($this->container['buildingNumber']) && (strlen($this->container['buildingNumber']) > 256)) {
            $invalid_properties[] = "invalid value for 'buildingNumber', the character length must be smaller than or equal to 256.";
        }

        if (!is_null($this->container['email']) && (strlen($this->container['email']) > 255)) {
            $invalid_properties[] = "invalid value for 'email', the character length must be smaller than or equal to 255.";
        }

        if (!is_null($this->container['phoneNumber']) && (strlen($this->container['phoneNumber']) > 15)) {
            $invalid_properties[] = "invalid value for 'phoneNumber', the character length must be smaller than or equal to 15.";
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

        if (strlen($this->container['firstName']) > 60) {
            return false;
        }
        if (strlen($this->container['lastName']) > 60) {
            return false;
        }
        if (strlen($this->container['company']) > 60) {
            return false;
        }
        if (strlen($this->container['address1']) > 60) {
            return false;
        }
        if (strlen($this->container['address2']) > 60) {
            return false;
        }
        if (strlen($this->container['locality']) > 50) {
            return false;
        }
        if (strlen($this->container['administrativeArea']) > 2) {
            return false;
        }
        if (strlen($this->container['postalCode']) > 10) {
            return false;
        }
        if (strlen($this->container['country']) > 2) {
            return false;
        }
        if (strlen($this->container['district']) > 50) {
            return false;
        }
        if (strlen($this->container['buildingNumber']) > 256) {
            return false;
        }
        if (strlen($this->container['email']) > 255) {
            return false;
        }
        if (strlen($this->container['phoneNumber']) > 15) {
            return false;
        }
        return true;
    }


    /**
     * Gets firstName
     * @return string
     */
    public function getFirstName()
    {
        return $this->container['firstName'];
    }

    /**
     * Sets firstName
     * @param string $firstName Customer’s first name. This name must be the same as the name on the card.  For processor-specific information, see the customer_firstname field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setFirstName($firstName)
    {
        if (!is_null($firstName) && (strlen($firstName) > 60)) {
            throw new \InvalidArgumentException('invalid length for $firstName when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 60.');
        }

        $this->container['firstName'] = $firstName;

        return $this;
    }

    /**
     * Gets lastName
     * @return string
     */
    public function getLastName()
    {
        return $this->container['lastName'];
    }

    /**
     * Sets lastName
     * @param string $lastName Customer’s last name. This name must be the same as the name on the card.  For processor-specific information, see the customer_lastname field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setLastName($lastName)
    {
        if (!is_null($lastName) && (strlen($lastName) > 60)) {
            throw new \InvalidArgumentException('invalid length for $lastName when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 60.');
        }

        $this->container['lastName'] = $lastName;

        return $this;
    }

    /**
     * Gets company
     * @return string
     */
    public function getCompany()
    {
        return $this->container['company'];
    }

    /**
     * Sets company
     * @param string $company Name of the customer’s company.  For processor-specific information, see the company_name field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setCompany($company)
    {
        if (!is_null($company) && (strlen($company) > 60)) {
            throw new \InvalidArgumentException('invalid length for $company when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 60.');
        }

        $this->container['company'] = $company;

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
     * @param string $address1 First line of the billing street address as it appears on the credit card issuer’s records.  For processor-specific information, see the bill_address1 field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setAddress1($address1)
    {
        if (!is_null($address1) && (strlen($address1) > 60)) {
            throw new \InvalidArgumentException('invalid length for $address1 when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 60.');
        }

        $this->container['address1'] = $address1;

        return $this;
    }

    /**
     * Gets address2
     * @return string
     */
    public function getAddress2()
    {
        return $this->container['address2'];
    }

    /**
     * Sets address2
     * @param string $address2 Additional address information.  For processor-specific information, see the bill_address2 field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setAddress2($address2)
    {
        if (!is_null($address2) && (strlen($address2) > 60)) {
            throw new \InvalidArgumentException('invalid length for $address2 when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 60.');
        }

        $this->container['address2'] = $address2;

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
     * @param string $locality City of the billing address.  For processor-specific information, see the bill_city field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setLocality($locality)
    {
        if (!is_null($locality) && (strlen($locality) > 50)) {
            throw new \InvalidArgumentException('invalid length for $locality when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 50.');
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
     * @param string $administrativeArea State or province of the billing address. Use the State, Province, and Territory Codes for the United States and Canada.  For processor-specific information, see the bill_state field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setAdministrativeArea($administrativeArea)
    {
        if (!is_null($administrativeArea) && (strlen($administrativeArea) > 2)) {
            throw new \InvalidArgumentException('invalid length for $administrativeArea when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 2.');
        }

        $this->container['administrativeArea'] = $administrativeArea;

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
     * @param string $postalCode Postal code for the billing address. The postal code must consist of 5 to 9 digits.  When the billing country is the U.S., the 9-digit postal code must follow this format: [5 digits][dash][4 digits]  Example 12345-6789  When the billing country is Canada, the 6-digit postal code must follow this format: [alpha][numeric][alpha][space][numeric][alpha][numeric]  Example A1B 2C3  For processor-specific information, see the bill_zip field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setPostalCode($postalCode)
    {
        if (!is_null($postalCode) && (strlen($postalCode) > 10)) {
            throw new \InvalidArgumentException('invalid length for $postalCode when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 10.');
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
     * @param string $country Country of the billing address. Use the twocharacter ISO Standard Country Codes.  For processor-specific information, see the bill_country field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setCountry($country)
    {
        if (!is_null($country) && (strlen($country) > 2)) {
            throw new \InvalidArgumentException('invalid length for $country when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 2.');
        }

        $this->container['country'] = $country;

        return $this;
    }

    /**
     * Gets district
     * @return string
     */
    public function getDistrict()
    {
        return $this->container['district'];
    }

    /**
     * Sets district
     * @param string $district Customer’s neighborhood, community, or region (a barrio in Brazil) within the city or municipality. This field is available only on **Cielo**.
     * @return $this
     */
    public function setDistrict($district)
    {
        if (!is_null($district) && (strlen($district) > 50)) {
            throw new \InvalidArgumentException('invalid length for $district when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 50.');
        }

        $this->container['district'] = $district;

        return $this;
    }

    /**
     * Gets buildingNumber
     * @return string
     */
    public function getBuildingNumber()
    {
        return $this->container['buildingNumber'];
    }

    /**
     * Sets buildingNumber
     * @param string $buildingNumber Building number in the street address.  This field is supported only for:  - Cielo transactions.  - Redecard customer validation with CyberSourceApi Latin American Processing.
     * @return $this
     */
    public function setBuildingNumber($buildingNumber)
    {
        if (!is_null($buildingNumber) && (strlen($buildingNumber) > 256)) {
            throw new \InvalidArgumentException('invalid length for $buildingNumber when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 256.');
        }

        $this->container['buildingNumber'] = $buildingNumber;

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
     * @param string $email Customer's email address, including the full domain name.  For processor-specific information, see the customer_email field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setEmail($email)
    {
        if (!is_null($email) && (strlen($email) > 255)) {
            throw new \InvalidArgumentException('invalid length for $email when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 255.');
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
     * @param string $phoneNumber Customer’s phone number.  CyberSourceApi recommends that you include the country code when the order is from outside the U.S.  For processor-specific information, see the customer_phone field in [Credit Card Services Using the SCMP API.](http://apps.cybersource.com/library/documentation/dev_guides/CC_Svcs_SCMP_API/html)
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        if (!is_null($phoneNumber) && (strlen($phoneNumber) > 15)) {
            throw new \InvalidArgumentException('invalid length for $phoneNumber when calling V2paymentsOrderInformationBillTo., must be smaller than or equal to 15.');
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


