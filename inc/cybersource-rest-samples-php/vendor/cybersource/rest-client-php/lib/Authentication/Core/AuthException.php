<?php
/**
 * ApiException

 */
namespace CyberSourceApi\Authentication\Core;

use \Exception;

/**
 * ApiException Class Doc Comment
 *
 * @category Class
 * @package  CyberSourceApi
 */
class AuthException extends Exception
{

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
   
    
}


