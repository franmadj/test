<?php
/*
Purpose: finding and Convertng request object
*/

namespace CyberSourceApi\Authentication\PayloadDigest;
use CyberSourceApi\Authentication\Util\GlobalParameter as GlobalParameter;
use CyberSourceApi\Authentication\Core\AuthException as AuthException;
use CyberSourceApi\Logging\LogFactory as LogFactory;

class PayloadDigest
{
    private static $logger = null;
    
    /**
     * Constructor
     */
    public function __construct(\CyberSourceApi\Logging\LogConfiguration $logConfig = null)
    {
        if (self::$logger === null) {
            self::$logger = (new LogFactory())->getLogger(\CyberSourceApi\Utilities\Helpers\ClassHelper::getClassName(get_class()), $logConfig);
        }
    }
    
    //Reading the payload Data
    public function getPayloadDigest($filePath, $merchantConfig)
    {
        $authType = $merchantConfig->getAuthenticationType();
        if(file_exists($filePath)){
            $inputData = file_get_contents($filePath);
            $postString = str_replace("\r", "", $inputData);
            return $postString;
        }
        else
        {
            $warning_message = "Input Json is not valid, So its taking Payload Data.";
            trigger_error($warning_message, E_USER_WARNING);//
            self::$logger->warning($warning_message);
            self::$logger->close();
        }

    }

    //Generated Encoded Payload Data
    public function generateDigest($payLoad)
    {
        $utf8EncodedString = utf8_encode($payLoad);
        $digestEncode = hash("sha256", $utf8EncodedString, true);
        self::$logger->close();
        return base64_encode($digestEncode);
    }
}
?>