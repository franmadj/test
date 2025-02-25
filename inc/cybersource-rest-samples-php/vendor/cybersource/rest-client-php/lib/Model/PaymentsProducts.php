<?php
/**
 * PaymentsProducts
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
 * PaymentsProducts Class Doc Comment
 *
 * @category    Class
 * @package     CyberSource
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PaymentsProducts implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'paymentsProducts';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'cardProcessing' => '\CyberSourceApi\Model\PaymentsProductsCardProcessing',
        'cardPresentConnect' => '\CyberSourceApi\Model\PaymentsProductsCardPresentConnect',
        'cybsReadyTerminal' => '\CyberSourceApi\Model\PaymentsProductsCybsReadyTerminal',
        'eCheck' => '\CyberSourceApi\Model\PaymentsProductsECheck',
        'payerAuthentication' => '\CyberSourceApi\Model\PaymentsProductsPayerAuthentication',
        'digitalPayments' => '\CyberSourceApi\Model\PaymentsProductsDigitalPayments',
        'secureAcceptance' => '\CyberSourceApi\Model\PaymentsProductsSecureAcceptance',
        'virtualTerminal' => '\CyberSourceApi\Model\PaymentsProductsVirtualTerminal',
        'currencyConversion' => '\CyberSourceApi\Model\PaymentsProductsCurrencyConversion',
        'tax' => '\CyberSourceApi\Model\PaymentsProductsTax',
        'customerInvoicing' => '\CyberSourceApi\Model\PaymentsProductsTax',
        'recurringBilling' => '\CyberSourceApi\Model\PaymentsProductsTax',
        'paymentOrchestration' => '\CyberSourceApi\Model\PaymentsProductsTax',
        'payouts' => '\CyberSourceApi\Model\PaymentsProductsPayouts',
        'differentialFee' => '\CyberSourceApi\Model\PaymentsProductsDifferentialFee',
        'payByLink' => '\CyberSourceApi\Model\PaymentsProductsTax',
        'unifiedCheckout' => '\CyberSourceApi\Model\PaymentsProductsTax'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerFormats = [
        'cardProcessing' => null,
        'cardPresentConnect' => null,
        'cybsReadyTerminal' => null,
        'eCheck' => null,
        'payerAuthentication' => null,
        'digitalPayments' => null,
        'secureAcceptance' => null,
        'virtualTerminal' => null,
        'currencyConversion' => null,
        'tax' => null,
        'customerInvoicing' => null,
        'recurringBilling' => null,
        'paymentOrchestration' => null,
        'payouts' => null,
        'differentialFee' => null,
        'payByLink' => null,
        'unifiedCheckout' => null
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
        'cardProcessing' => 'cardProcessing',
        'cardPresentConnect' => 'cardPresentConnect',
        'cybsReadyTerminal' => 'cybsReadyTerminal',
        'eCheck' => 'eCheck',
        'payerAuthentication' => 'payerAuthentication',
        'digitalPayments' => 'digitalPayments',
        'secureAcceptance' => 'secureAcceptance',
        'virtualTerminal' => 'virtualTerminal',
        'currencyConversion' => 'currencyConversion',
        'tax' => 'tax',
        'customerInvoicing' => 'customerInvoicing',
        'recurringBilling' => 'recurringBilling',
        'paymentOrchestration' => 'paymentOrchestration',
        'payouts' => 'payouts',
        'differentialFee' => 'differentialFee',
        'payByLink' => 'payByLink',
        'unifiedCheckout' => 'unifiedCheckout'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'cardProcessing' => 'setCardProcessing',
        'cardPresentConnect' => 'setCardPresentConnect',
        'cybsReadyTerminal' => 'setCybsReadyTerminal',
        'eCheck' => 'setECheck',
        'payerAuthentication' => 'setPayerAuthentication',
        'digitalPayments' => 'setDigitalPayments',
        'secureAcceptance' => 'setSecureAcceptance',
        'virtualTerminal' => 'setVirtualTerminal',
        'currencyConversion' => 'setCurrencyConversion',
        'tax' => 'setTax',
        'customerInvoicing' => 'setCustomerInvoicing',
        'recurringBilling' => 'setRecurringBilling',
        'paymentOrchestration' => 'setPaymentOrchestration',
        'payouts' => 'setPayouts',
        'differentialFee' => 'setDifferentialFee',
        'payByLink' => 'setPayByLink',
        'unifiedCheckout' => 'setUnifiedCheckout'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'cardProcessing' => 'getCardProcessing',
        'cardPresentConnect' => 'getCardPresentConnect',
        'cybsReadyTerminal' => 'getCybsReadyTerminal',
        'eCheck' => 'getECheck',
        'payerAuthentication' => 'getPayerAuthentication',
        'digitalPayments' => 'getDigitalPayments',
        'secureAcceptance' => 'getSecureAcceptance',
        'virtualTerminal' => 'getVirtualTerminal',
        'currencyConversion' => 'getCurrencyConversion',
        'tax' => 'getTax',
        'customerInvoicing' => 'getCustomerInvoicing',
        'recurringBilling' => 'getRecurringBilling',
        'paymentOrchestration' => 'getPaymentOrchestration',
        'payouts' => 'getPayouts',
        'differentialFee' => 'getDifferentialFee',
        'payByLink' => 'getPayByLink',
        'unifiedCheckout' => 'getUnifiedCheckout'
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
        $this->container['cardProcessing'] = isset($data['cardProcessing']) ? $data['cardProcessing'] : null;
        $this->container['cardPresentConnect'] = isset($data['cardPresentConnect']) ? $data['cardPresentConnect'] : null;
        $this->container['cybsReadyTerminal'] = isset($data['cybsReadyTerminal']) ? $data['cybsReadyTerminal'] : null;
        $this->container['eCheck'] = isset($data['eCheck']) ? $data['eCheck'] : null;
        $this->container['payerAuthentication'] = isset($data['payerAuthentication']) ? $data['payerAuthentication'] : null;
        $this->container['digitalPayments'] = isset($data['digitalPayments']) ? $data['digitalPayments'] : null;
        $this->container['secureAcceptance'] = isset($data['secureAcceptance']) ? $data['secureAcceptance'] : null;
        $this->container['virtualTerminal'] = isset($data['virtualTerminal']) ? $data['virtualTerminal'] : null;
        $this->container['currencyConversion'] = isset($data['currencyConversion']) ? $data['currencyConversion'] : null;
        $this->container['tax'] = isset($data['tax']) ? $data['tax'] : null;
        $this->container['customerInvoicing'] = isset($data['customerInvoicing']) ? $data['customerInvoicing'] : null;
        $this->container['recurringBilling'] = isset($data['recurringBilling']) ? $data['recurringBilling'] : null;
        $this->container['paymentOrchestration'] = isset($data['paymentOrchestration']) ? $data['paymentOrchestration'] : null;
        $this->container['payouts'] = isset($data['payouts']) ? $data['payouts'] : null;
        $this->container['differentialFee'] = isset($data['differentialFee']) ? $data['differentialFee'] : null;
        $this->container['payByLink'] = isset($data['payByLink']) ? $data['payByLink'] : null;
        $this->container['unifiedCheckout'] = isset($data['unifiedCheckout']) ? $data['unifiedCheckout'] : null;
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
     * Gets cardProcessing
     * @return \CyberSourceApi\Model\PaymentsProductsCardProcessing
     */
    public function getCardProcessing()
    {
        return $this->container['cardProcessing'];
    }

    /**
     * Sets cardProcessing
     * @param \CyberSourceApi\Model\PaymentsProductsCardProcessing $cardProcessing
     * @return $this
     */
    public function setCardProcessing($cardProcessing)
    {
        $this->container['cardProcessing'] = $cardProcessing;

        return $this;
    }

    /**
     * Gets cardPresentConnect
     * @return \CyberSourceApi\Model\PaymentsProductsCardPresentConnect
     */
    public function getCardPresentConnect()
    {
        return $this->container['cardPresentConnect'];
    }

    /**
     * Sets cardPresentConnect
     * @param \CyberSourceApi\Model\PaymentsProductsCardPresentConnect $cardPresentConnect
     * @return $this
     */
    public function setCardPresentConnect($cardPresentConnect)
    {
        $this->container['cardPresentConnect'] = $cardPresentConnect;

        return $this;
    }

    /**
     * Gets cybsReadyTerminal
     * @return \CyberSourceApi\Model\PaymentsProductsCybsReadyTerminal
     */
    public function getCybsReadyTerminal()
    {
        return $this->container['cybsReadyTerminal'];
    }

    /**
     * Sets cybsReadyTerminal
     * @param \CyberSourceApi\Model\PaymentsProductsCybsReadyTerminal $cybsReadyTerminal
     * @return $this
     */
    public function setCybsReadyTerminal($cybsReadyTerminal)
    {
        $this->container['cybsReadyTerminal'] = $cybsReadyTerminal;

        return $this;
    }

    /**
     * Gets eCheck
     * @return \CyberSourceApi\Model\PaymentsProductsECheck
     */
    public function getECheck()
    {
        return $this->container['eCheck'];
    }

    /**
     * Sets eCheck
     * @param \CyberSourceApi\Model\PaymentsProductsECheck $eCheck
     * @return $this
     */
    public function setECheck($eCheck)
    {
        $this->container['eCheck'] = $eCheck;

        return $this;
    }

    /**
     * Gets payerAuthentication
     * @return \CyberSourceApi\Model\PaymentsProductsPayerAuthentication
     */
    public function getPayerAuthentication()
    {
        return $this->container['payerAuthentication'];
    }

    /**
     * Sets payerAuthentication
     * @param \CyberSourceApi\Model\PaymentsProductsPayerAuthentication $payerAuthentication
     * @return $this
     */
    public function setPayerAuthentication($payerAuthentication)
    {
        $this->container['payerAuthentication'] = $payerAuthentication;

        return $this;
    }

    /**
     * Gets digitalPayments
     * @return \CyberSourceApi\Model\PaymentsProductsDigitalPayments
     */
    public function getDigitalPayments()
    {
        return $this->container['digitalPayments'];
    }

    /**
     * Sets digitalPayments
     * @param \CyberSourceApi\Model\PaymentsProductsDigitalPayments $digitalPayments
     * @return $this
     */
    public function setDigitalPayments($digitalPayments)
    {
        $this->container['digitalPayments'] = $digitalPayments;

        return $this;
    }

    /**
     * Gets secureAcceptance
     * @return \CyberSourceApi\Model\PaymentsProductsSecureAcceptance
     */
    public function getSecureAcceptance()
    {
        return $this->container['secureAcceptance'];
    }

    /**
     * Sets secureAcceptance
     * @param \CyberSourceApi\Model\PaymentsProductsSecureAcceptance $secureAcceptance
     * @return $this
     */
    public function setSecureAcceptance($secureAcceptance)
    {
        $this->container['secureAcceptance'] = $secureAcceptance;

        return $this;
    }

    /**
     * Gets virtualTerminal
     * @return \CyberSourceApi\Model\PaymentsProductsVirtualTerminal
     */
    public function getVirtualTerminal()
    {
        return $this->container['virtualTerminal'];
    }

    /**
     * Sets virtualTerminal
     * @param \CyberSourceApi\Model\PaymentsProductsVirtualTerminal $virtualTerminal
     * @return $this
     */
    public function setVirtualTerminal($virtualTerminal)
    {
        $this->container['virtualTerminal'] = $virtualTerminal;

        return $this;
    }

    /**
     * Gets currencyConversion
     * @return \CyberSourceApi\Model\PaymentsProductsCurrencyConversion
     */
    public function getCurrencyConversion()
    {
        return $this->container['currencyConversion'];
    }

    /**
     * Sets currencyConversion
     * @param \CyberSourceApi\Model\PaymentsProductsCurrencyConversion $currencyConversion
     * @return $this
     */
    public function setCurrencyConversion($currencyConversion)
    {
        $this->container['currencyConversion'] = $currencyConversion;

        return $this;
    }

    /**
     * Gets tax
     * @return \CyberSourceApi\Model\PaymentsProductsTax
     */
    public function getTax()
    {
        return $this->container['tax'];
    }

    /**
     * Sets tax
     * @param \CyberSourceApi\Model\PaymentsProductsTax $tax
     * @return $this
     */
    public function setTax($tax)
    {
        $this->container['tax'] = $tax;

        return $this;
    }

    /**
     * Gets customerInvoicing
     * @return \CyberSourceApi\Model\PaymentsProductsTax
     */
    public function getCustomerInvoicing()
    {
        return $this->container['customerInvoicing'];
    }

    /**
     * Sets customerInvoicing
     * @param \CyberSourceApi\Model\PaymentsProductsTax $customerInvoicing
     * @return $this
     */
    public function setCustomerInvoicing($customerInvoicing)
    {
        $this->container['customerInvoicing'] = $customerInvoicing;

        return $this;
    }

    /**
     * Gets recurringBilling
     * @return \CyberSourceApi\Model\PaymentsProductsTax
     */
    public function getRecurringBilling()
    {
        return $this->container['recurringBilling'];
    }

    /**
     * Sets recurringBilling
     * @param \CyberSourceApi\Model\PaymentsProductsTax $recurringBilling
     * @return $this
     */
    public function setRecurringBilling($recurringBilling)
    {
        $this->container['recurringBilling'] = $recurringBilling;

        return $this;
    }

    /**
     * Gets paymentOrchestration
     * @return \CyberSourceApi\Model\PaymentsProductsTax
     */
    public function getPaymentOrchestration()
    {
        return $this->container['paymentOrchestration'];
    }

    /**
     * Sets paymentOrchestration
     * @param \CyberSourceApi\Model\PaymentsProductsTax $paymentOrchestration
     * @return $this
     */
    public function setPaymentOrchestration($paymentOrchestration)
    {
        $this->container['paymentOrchestration'] = $paymentOrchestration;

        return $this;
    }

    /**
     * Gets payouts
     * @return \CyberSourceApi\Model\PaymentsProductsPayouts
     */
    public function getPayouts()
    {
        return $this->container['payouts'];
    }

    /**
     * Sets payouts
     * @param \CyberSourceApi\Model\PaymentsProductsPayouts $payouts
     * @return $this
     */
    public function setPayouts($payouts)
    {
        $this->container['payouts'] = $payouts;

        return $this;
    }

    /**
     * Gets differentialFee
     * @return \CyberSourceApi\Model\PaymentsProductsDifferentialFee
     */
    public function getDifferentialFee()
    {
        return $this->container['differentialFee'];
    }

    /**
     * Sets differentialFee
     * @param \CyberSourceApi\Model\PaymentsProductsDifferentialFee $differentialFee
     * @return $this
     */
    public function setDifferentialFee($differentialFee)
    {
        $this->container['differentialFee'] = $differentialFee;

        return $this;
    }

    /**
     * Gets payByLink
     * @return \CyberSourceApi\Model\PaymentsProductsTax
     */
    public function getPayByLink()
    {
        return $this->container['payByLink'];
    }

    /**
     * Sets payByLink
     * @param \CyberSourceApi\Model\PaymentsProductsTax $payByLink
     * @return $this
     */
    public function setPayByLink($payByLink)
    {
        $this->container['payByLink'] = $payByLink;

        return $this;
    }

    /**
     * Gets unifiedCheckout
     * @return \CyberSourceApi\Model\PaymentsProductsTax
     */
    public function getUnifiedCheckout()
    {
        return $this->container['unifiedCheckout'];
    }

    /**
     * Sets unifiedCheckout
     * @param \CyberSourceApi\Model\PaymentsProductsTax $unifiedCheckout
     * @return $this
     */
    public function setUnifiedCheckout($unifiedCheckout)
    {
        $this->container['unifiedCheckout'] = $unifiedCheckout;

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


