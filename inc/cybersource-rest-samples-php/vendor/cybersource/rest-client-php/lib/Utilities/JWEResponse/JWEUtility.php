<?php

namespace CyberSourceApi\Utilities\JWEResponse;
use CyberSourceApi\Authentication\Core\MerchantConfiguration;
use CyberSourceApi\Authentication\Util\JWE\JWEUtility as AuthJWEUtility;
use Exception;

class JWEUtility {

    /**
     * @throws Exception
     */
    public static function decryptJWEResponse($encodedResponse, MerchantConfiguration $merchantConfig) {
        return AuthJWEUtility::decryptJWEUsingPEM($merchantConfig, $encodedResponse);
    }
}
