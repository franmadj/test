<?php
/*
*Purpose : Generating token for OAuth
*/
namespace CyberSourceApi\Authentication\OAuth;
use CyberSourceApi\Authentication\Core\TokenGenerator as TokenGenerator;
use CyberSourceApi\Authentication\Core\AuthException as AuthException;
use CyberSourceApi\Authentication\Log\Logger as Logger;
use CyberSourceApi\Authentication\Util\GlobalParameter as GlobalParameter;
 
class OAuthTokenGenerator implements TokenGenerator
{
	private static $logger = null;
	/**
     * Constructor
     */
    public function __construct()
    {
    	if(self::$logger === null){
        	self::$logger = new Logger(OAuthTokenGenerator::class);
    	}
    }

	//Generate OAuth Token Function
	public function generateToken($resourcePath, $payloadData, $method, $merchantConfig) //add 
	{		
        $accessToken = $merchantConfig->getAccessToken();
        if(isset($accessToken))
		    return "Bearer ".$accessToken;
	}
	

}
?>