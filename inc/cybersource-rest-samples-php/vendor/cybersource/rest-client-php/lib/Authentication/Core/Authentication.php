<?php
/*
Purpose : This is focusly on split the services HTTP or JWT or OAuth
*/
namespace CyberSourceApi\Authentication\Core;
use CyberSourceApi\Authentication\Http\HttpSignatureGenerator as HttpSignatureGenerator;
use CyberSourceApi\Authentication\Jwt\JsonWebTokenGenerator as JsonWebTokenGenerator;
use CyberSourceApi\Authentication\OAuth\OAuthTokenGenerator as OAuthTokenGenerator;
use CyberSourceApi\Authentication\Util\GlobalParameter as GlobalParameter;
use CyberSourceApi\Logging\LogFactory as LogFactory;

class Authentication 
{
    private static $logger = null;
    
    /**
    * Constructor
    */
    public function __construct(\CyberSourceApi\Logging\LogConfiguration $logConfig = null)
    {
        if (null !== $logConfig) {
            if (self::$logger === null) {
                self::$logger = (new LogFactory())->getLogger(\CyberSourceApi\Utilities\Helpers\ClassHelper::getClassName(get_class()), $logConfig);
            }
        }
    }

    //call http signature and jwt
    function generateToken($resourcePath, $inputData, $method, $merchantConfig)
    {  
        if(is_null($merchantConfig))
        {
            $exception = new AuthException(GlobalParameter::MERCHANTCONFIGERR, 0);
            if (null !== self::$logger) { self::$logger->error("Auth Exception : " . GlobalParameter::MERCHANTCONFIGERR); }
            throw $exception;
        }
    
        $tokenGenerator = $this->getTokenGenerator($merchantConfig);
        if (null !== self::$logger) { self::$logger->close(); }
        return $tokenGenerator->generateToken($resourcePath, $inputData, $method, $merchantConfig);
    }

    function getTokenGenerator($merchantConfig) {
        $authType = $merchantConfig->getAuthenticationType();
        if($authType == GlobalParameter::HTTP_SIGNATURE) {
            return new HttpSignatureGenerator($merchantConfig->getLogConfiguration());
        } else if($authType == GlobalParameter::JWT){
            return new JsonWebTokenGenerator($merchantConfig->getLogConfiguration());
        } else if($authType == GlobalParameter::OAUTH){
			return new OAuthTokenGenerator();
		} else {
            $exception = new AuthException(GlobalParameter::AUTH_ERROR, 0);
            if (null !== self::$logger) { self::$logger->error("Auth Exception : " . GlobalParameter::AUTH_ERROR); }
            throw $exception;
        }
    }
}
?>