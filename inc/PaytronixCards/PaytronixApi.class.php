<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PaytronixApi
 *
 * @author USER
 */
class PaytronixApi {

    private $postFields;
    private $card;
    private $walletCode;
    private $storeCode;
    private $programId;
    private $posTransactionId;
    private $quantity;
    // Staging URL
    //$url = 'https://api.pxslab.com:443/api/rest/16.3/transaction/activateAdd.json';
    // Live URL
    private $url;

    public function __construct($card, $cardConfig, $orderId) {
        $this->log('__construct with $card, $cardConfig, $orderId:');
        $this->log([$card, $cardConfig, $orderId]);

        extract($cardConfig);
        $this->setEnv('prod');
        $this->card = $card;
        $this->walletCode = $walletCode;
        $this->storeCode = $storeCode;
        $this->programId = $programId;
        $this->posTransactionId = $orderId;
        $this->quantity = $quantity;
    }

    private function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/cards-debug.log');
        error_log('----------PaytronixApi: ' . $value);
    }

    public function setEnv($env) {
        if ('development' == $env) {
            $this->url = 'https://api.pxslab.com:443/api/rest/16.3/transaction/activateAdd.json';
        } else {
            $this->url = 'https://api.pxsweb.com:443/api/rest/16.3/transaction/activateAdd.json';
        }
    }

    public function setPostFields() {
        $this->log('setPostFields');
        $data = [
            'authentication' => 'b2b',
            'headerInfo' => [
                'posTransactionId' => $this->posTransactionId,
                'storeCode' => $this->storeCode,
                'programId' => $this->programId,
                'merchantId' => 570,
                'applicationId' => '',
                'applicationVersion' => '',
                'operatorId' => '0',
                'senderId' => 'PARTNER'
            ],
            'cardInfo' => [
                "swipeFlag" => false,
                "printedCardNumber" => $this->card['number'],
                "cardRegCode" => $this->card['regCode']
            ],
            'addWalletContents' => [
                'walletCode' => $this->walletCode,
                'quantity' => $this->quantity
            ],
        ];
        $this->postFields = json_encode($data);
        $this->log($this->postFields);
    }

    function activationRequest() {
        $result = new stdClass();
        $result->result = 'authorizedSuccess';
        return $result;
    }

    public function activationRequest_() {
        if (empty($this->card['number']) || empty($this->card['regCode'])) {
            $this->log('not provided number or regCode');
            return null;
        }
        $cardNumber = $this->card['number'];
        $regCode = $this->card['regCode'];
        $this->setPostFields();
        $response = $this->query();
    }

    private function query() {
        $headers = [
            'Content-Type: application/json',
        ];
        $username = get_field('user_name', 'options');
        $password = get_field('password', 'options');
        $this->log("username --$username and password -- $password");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->postFields));
        $response = curl_exec($ch);
        $result = json_decode($response);

        if (!$result) {
            $this->log('query for order had bad $response: ' . print_r($response, true));
            $this->log('query for order: ' . $this->posTransactionId . ', $response: ' . print_r($response, true));
        }

        $this->log('query Response: ' . $response);

        return $result;
        //return json_decode($response)->result;
    }

}
