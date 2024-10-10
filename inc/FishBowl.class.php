<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FishBowl
 *
 * @author USER
 */
class FishBowl {

    public function __construct() {
        ;
    }

    private function getToken() {
        if ($this->hasTokenAlive())
            return $_SESSION['access_token'];
        else
            return $this->generateToken();
    }

    private function hasTokenAlive() {
        return (!empty($_SESSION['access_token']) && !empty($_SESSION['expires_at']) && time() < $_SESSION['expires_at']);
    }

    private function storeToken($accessToken, $expiresIn) {
        $_SESSION['access_token'] = $accessToken;
        $_SESSION['expires_at'] = time() + $expiresIn;
    }

    private function generateToken() {
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
        
        

        if (!empty($response->access_token) && !empty($response->expires_in)) {
            $this->storeToken($response->access_token, $response->expires_in);
            return $response->access_token;
        }
        return false;
    }

    public function getMeberByEmail($email, $fields = false) {
        $values = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://services.fishbowl.com/api/odata/v1/23622320153/Members?%24filter=EmailAddress%20eq%20%27' . $email . '%27',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->getToken()
            ),
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        if (!$fields)
            return !empty($response->value);



        if (!empty($response->value[0])) {
            $member = $response->value[0];
            //var_dump($response->value);
            foreach ($member as $key => $value) {
                if (in_array($key, $fields)) {
                    $values[$key] = $value;
                }
            }
            if (!empty($member->StringFields))
                foreach ($member->StringFields as $value) {
                    if (in_array($value->Name, $fields)) {
                        $values[$value->Name] = $value->Value;
                    }
                }
            if (!empty($member->DateFields))
                foreach ($member->DateFields as $value) {
                    if (in_array($value->Name, $fields)) {
                        $values[$value->Name] = date('m/d/Y', strtotime($value->Value));
                    }
                }
        }



        foreach ($fields as $field) {
            $values[$field] = !empty($values[$field]) ? $values[$field] : '';
        }

        //var_dump($values);exit;



        return $values;
    }

    public function updateMember($data) {
        $values = $this->getMeberByEmail($data['email'], ['MemberID']);
        if (!$memberId = $values['MemberID'])
            return false;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://services.fishbowl.com/api/odata/v1/23622320153/Members(' . $memberId . 'L)',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PATCH',
            CURLOPT_POSTFIELDS => '{
                "StringFields": [
                    {
                      "Name": "StoreCode",
                      "Value": "' . $data['storecode'] . '"
                    }
                ],
                "DateFields": [
                    {
                        "Name": "Birthdate",
                        "Value": "' . date('c', strtotime($data['birthdate'])) . '"
                    },
                    {
                        "Name": "Anniversary",
                        "Value": "' . date('c', strtotime($data['anniversary'])) . '"
                    }
                ]
              }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->getToken()
            ),
        ));
        
        //var_dump($this->hasTokenAlive(),$_SESSION['expires_at'],time(),time() < $_SESSION['expires_at'],$this->getToken());
        
        

        $response = curl_exec($curl);

        curl_close($curl);

        // Check HTTP status code
        if (!curl_errno($curl)) {
            return curl_getinfo($curl, CURLINFO_HTTP_CODE);
        }
        return 500;
    }

}
