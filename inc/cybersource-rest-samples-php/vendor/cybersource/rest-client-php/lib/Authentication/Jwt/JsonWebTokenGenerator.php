<?php
/*
*Purpose : calling the JWtoken 
*/
namespace CyberSourceApi\Authentication\Jwt;
use CyberSourceApi\Authentication\PayloadDigest\PayloadDigest as PayloadDigest;
use CyberSourceApi\Authentication\Core\TokenGenerator as TokenGenerator;
use CyberSourceApi\Authentication\Core\AuthException as AuthException;
use CyberSourceApi\Authentication\Jwt\JsonWebTokenHeader as JsonWebTokenHeader;
use CyberSourceApi\Authentication\Util\GlobalParameter as GlobalParameter;
use CyberSourceApi\Logging\LogFactory as LogFactory;

//calling the interface
class JsonWebTokenGenerator implements TokenGenerator
{
    private static $logger = null;
    
    /**
     * Constructor
     */
    public function __construct(\CyberSourceApi\Logging\LogConfiguration $logConfig)
    {
        if (self::$logger === null) {
            self::$logger = (new LogFactory())->getLogger(\CyberSourceApi\Utilities\Helpers\ClassHelper::getClassName(get_class()), $logConfig);
        }
    }

    //calling Signature
    public function generateToken($resourcePath, $payloadData, $method, $merchantConfig)
    {
        $date = date("D, d M Y G:i:s ").GlobalParameter::GMT;
        if($method==GlobalParameter::GET || $method==GlobalParameter::DELETE)
        {
            $jwtBody = array("iat"=>$date);
        }
        else if($method==GlobalParameter::POST || $method==GlobalParameter::PUT || $method==GlobalParameter::PATCH)
        {
            $digestObj = new PayloadDigest($merchantConfig->getLogConfiguration());
            $digest = $digestObj->generateDigest($payloadData);
            $jwtBody = array("digest"=>$digest,"digestAlgorithm"=>"SHA-256","iat"=>$date);
        }
        else
        {
            $exception = new AuthException(GlobalParameter::INVALID_REQUEST_TYPE_METHOD, 0);
            self::$logger->error("AuthException : " . GlobalParameter::INVALID_REQUEST_TYPE_METHOD);
            self::$logger->close();
            throw $exception;
        }
        $tokenHeader = $this->accessTokenHeader($jwtBody, $merchantConfig);
        self::$logger->close();
        return $tokenHeader;
    }

    public function accessTokenHeader($jwtBody, $merchantConfig){
        $gToken = $this->getJsonWebTokenHeader($merchantConfig);
        $generatedToken = $gToken->getJsonWebToken($jwtBody, $merchantConfig); 
        return "Bearer ".$generatedToken;
    }

    protected function getJsonWebTokenHeader($merchantConfig) {
        return new JsonWebTokenHeader($merchantConfig->getLogConfiguration());
    }
}
?>