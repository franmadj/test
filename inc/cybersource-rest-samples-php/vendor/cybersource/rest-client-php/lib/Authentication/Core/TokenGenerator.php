<?php

namespace CyberSourceApi\Authentication\Core;

interface TokenGenerator
{
    public function generateToken($resourcePath, $payloadData, $method, $merchantConfig);
}

?>