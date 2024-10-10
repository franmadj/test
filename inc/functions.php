<?php

namespace Inc\TxFunctions;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function date_time($timestamp, $timezone = 'America/Chicago') {
    $tz = new \DateTimeZone($timezone);
    $date = new \DateTime($timestamp);
    $date->setTimezone($tz);
    return $date;
}

function encrypt($value) {
    // Store the cipher method
    $ciphering = "AES-128-CTR";//aes-128-gcm
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    // Non-NULL Initialization Vector for encryption
    $encryption_iv = '1234567891011121';
    // Store the encryption key
    $encryption_key = "TXbrazil2024";
    // Use openssl_encrypt() function to encrypt the data
    return openssl_encrypt($value, $ciphering, $encryption_key, $options, $encryption_iv);
}

function decrypt($value) {
    // Store the cipher method
    $ciphering = "AES-128-CTR";
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    // Non-NULL Initialization Vector for decryption
    $decryption_iv = '1234567891011121';
    // Store the decryption key
    $decryption_key = "TXbrazil2024";
    // Use openssl_decrypt() function to decrypt the data
    return openssl_decrypt($value, $ciphering, $decryption_key, $options, $decryption_iv);
}

function slugify($text){
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicated - symbols
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
}

