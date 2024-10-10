<?php

namespace TxFishbowl;

function getFishbowlToken() {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://enterprise.fishbowl.com/api/oauth2/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=password&username=APITestTDB&password=Welcome@321',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic QUYwRjYwN0RDODlBNEVGNTg5REU0N0JENTY2NjFFNkQ6OUQ3MzhDOTA2RDMwNDBCOUFDNkUwM0U5NEQ5QUE5MzQ=',
            'Content-Type: text/plain'
        ),
    ));
    $response = json_decode(curl_exec($curl));

    curl_close($curl);
    return $response;
}
