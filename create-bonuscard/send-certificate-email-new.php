<?php

ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_send-certificate-email-new.txt');
/*
 * so as a reminder we will need a new form with the new endpoint of activate.json and then adminAdjust.json to add the expiration date. maybe if you could try it on a test page first that would be great

  DOCUMENTATION AND INTENDED CALLS
  As a quick reminder, our team is here to answer questions around the API, but ultimately the coding and testing are the responsibility of the partner and client. The Paytronix API documentation can be found at 
 * http://developers.paytronix.com.  As discussed on our call earlier in the process, we recommend implementing the following endpoints to support your integration:

  transaction/activate.json
  transaction/adminAdjust.json
  If you would like to add any new features to the scope of the project and/or would like access to additional API calls, please let me know and I’d be happy to discuss.
  If you need to add additional endpoints to your integration in the future, it will require a new certification.


  Welcome to the Paytronix Integration Documentation — Integrating to Paytronix 21.18 documentation
  http://developers.paytronix.com
  ACCESS & CREDENTIALS
  Domain: https://m570.api.pxslab.com
  Merchant ID: 570
  Store Code: Unique per location
  Card Template Code: 4
  Comp Dollars Wallet Code: 4
  API Version: 22.23

  Your existing test credentials have been updated to have access to the new endpoints. Please let me know if you need your API password reset.
 * 
 * 05700000030403 => 2067
  05700000030502 => 6147
  05700000030643 => 7123
  05700000030734 => 1160


 *  */

class SendCertificateEmailNew {

    private static $initiated = false;
    private static $cardType = 'ecert';
    private static $form_type = 'ecert';
    private static $wallet_code = 4;
    private static $is_cert_dinner = false;
    private static $expiration = '1 year';

    // public function __construct(){
    //   	self::init_hooks();
    // }
    public static function init() {

        if (!self::$initiated) {

            self::init_hooks();
        }
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        //self::registerPostType();


        add_action('wp_ajax_send_certificate_email_new', ['SendCertificateEmailNew', 'send_certificate_email_callback_new']);
        //add_action('wp_ajax_nopriv_send_certificate_email', ['SendCertificateEmail', 'send_certificate_email_callback']);
        //add_action('wp_ajax_send_certificate_email_dinner', ['SendCertificateEmail', 'send_certificate_email_dinner_callback']);



        /* REMOVE BULK AND DELETE ACTIONS FROM THE ADMIN PAGE */
//        add_filter('bulk_actions-edit-email_certificates', '__return_empty_array', 100);
//        add_action('wp_trash_post', array('SendCertificateEmail', 'disable_trash'));
//        add_action('before_delete_post', array('SendCertificateEmail', 'disable_trash'));
    }

    private static function set_expiration_date() {
        if (!empty($_POST['expiration']) && in_array($_POST['expiration'], ['3 months', '6 months', '1 year'])) {
            self::$expiration = $_POST['expiration'];
        }
    }

    public static function send_certificate_email_callback_new() {
        error_log("send_egift_manually_callback");
        if (!$_POST['amount'] || !$_POST['email'] || !$_POST['form_type'])
            return;
        self::set_expiration_date();

        $amount = $_POST['amount'];
        $email = $_POST['email'];
        self::$form_type = $_POST['form_type'];
        if (self::$form_type == 'early-booking')
            self::$cardType = 'ecomp';
        $content = !empty($_POST['content']) ? $_POST['content'] : 'No Content';
        
        if ($email == 'franworkspace@gmail.comm______') {
            var_dump($_POST, self::$expiration);
            $card = [];
            $card['number'] = '05700000030403';
            $card['regCode'] = '2067';
        } else {
            $card = self::createCard($amount);
        }
        if ($card) {
            if (!self::notifyRecipient($card, $amount, $email)) {
                error_log('There was a problem with emailing');
                $reponse = array("message" => "There was a problem with emailing", "status" => 'failure');
            } else
                $reponse = array("message" => "Sent Successfully to Email: " . $email, "status" => 'success');
        } else
            $reponse = array("message" => "Something whent wrong.", "status" => 'failure');


        echo json_encode($reponse);
        wp_die();
    }



    
    
    private static function queryApi($endpoint, $data) {
        $headers = [
            'Content-Type: application/json',
        ];

        $username = 'rUYTFOdynKx_TF7NTJKjR0UoLB1qXWUE_t7saWe3fK';
        $password = 'X1SMM63oPZW76sC851wom';
        error_log("username --$username and password -- $password");
        // Staging URL
        $url = 'https://m570.api.pxslab.com:443/api/rest/22.23/transaction/' . $endpoint;
        // Live URL
        //$url = 'https://api.pxsweb.com:443/api/rest/16.3/transaction/' . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);

        return json_decode($response);
        //return json_decode($response)->result;
    }
    
    private static function callApiActiveCard($origamount, $storeCode, $programId, $card, $regCode) {
        global $wpdb;
        $data = array(
            'authentication' => 'b2b',
            'headerInfo' => [
                'merchantId' => 570,
                'applicationId' => '',
                'applicationVersion' => '',
                'operatorId' => '0',
                'senderId' => 'PARTNER',
                'storeCode' => $storeCode,
                'programId' => $programId,
            //'posTransactionId' => strVal($orderId)
            ],
            "cardInfo" => [
                "swipeFlag" => false,
                "printedCardNumber" => $card,
                "cardRegCode" => $regCode,
            ]
        );

        error_log('Data: ' . json_encode($data) . '');
        $endpoint = 'activate.json';
        $responseActivation = self::queryApi($endpoint, $data);
        error_log('Response: ' . json_encode($responseActivation) . '');
        if (
                $responseActivation->result == 'userDataError' &&
                ($responseActivation->errorCode == 'transaction.card_not_in_required_state' or
                $responseActivation->errorCode == 'transaction.card_already_active')) {

            error_log('Paytronix Gift Card response is specifying ' . $responseActivation->errorCode . '. Re-alloting a new card.');
            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));
            error_log('Deleting card_not_in_required_state card No.' . $card . ' from database...');

            error_log('Re-Alloting card');
            self::createCard($origamount);
        } elseif ($responseActivation->result != 'authorizedSuccess') {

            error_log('Paytronix Gift Card response is specifying there\'s an error. Error: ');
            return false;
        }
        return $responseActivation;
    }
    
    private static function callApiAdminAdjust($storeCode, $programId, $card, $amount) {
        $dataAdjust = array(
            'authentication' => 'b2b',
            'headerInfo' => [
                'merchantId' => 570,
                'applicationId' => '',
                'applicationVersion' => '',
                'operatorId' => '0',
                'senderId' => 'PARTNER',
                'programId' => $programId
            ],
            'merchantId' => 570,
            "operatorId" => "0",
            "storeCode" => $storeCode,
            "posTransactionId" => time().'1',
            "printedCardNumber" => $card,
            "walletCode" => self::$wallet_code,
            "quantity" => $amount,
            "expiration" => [
                "date" => date('Y-m-d', strtotime('+ ' . self::$expiration)),
                "type" => "absolute"
            ],
            "activityType" => "ADD",
            "comment" => "This is an admin adjust"
        );
        $endpoint = 'adminAdjust.json';
        error_log('$dataAdjust: ' . json_encode($dataAdjust) . '');
        $responseAdjust = (self::queryApi($endpoint, $dataAdjust));
        error_log('$responseAdjust: ' . json_encode($responseAdjust) . '');

        if (empty($responseAdjust->result) || $responseAdjust->result == 'failure')
            return false;
        return true;
    }
    
    private static function callApiReverseActivation($storeCode, $pxTransactionId) {
        $data = array(
            'authentication' => 'b2b',
            'headerInfo' => [
                "merchantId" => 570,
                "storeCode" => $storeCode,
                "operatorId" => '0',
                "terminalId" => "0",
                "senderId" => "PARTNER",
                "programId" => "PX"
            ],
            'pxTransactionId' => $pxTransactionId,
        );
        $endpoint = 'reverse.json';
        error_log('$dataReverse: ' . json_encode($data) . '');
        $response = (self::queryApi($endpoint, $data));
        error_log('$responseReverse: ' . json_encode($response) . '');
    }

    private static function getNextCard() {
        global $wpdb;
        $sql = "SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType = BINARY 'newcert'";
        $getcard = $wpdb->get_row($sql, ARRAY_A);
        error_log('SQL Query card .--- ' . $sql . ' ----');
        return $getcard;
    }

    public static function createCard($amount) {
        $origamount = $amount;
        $amount = number_format($amount, 2);
        error_log('Creating card for $' . $amount . ' and cardtype: ' . self::$cardType);
        
        $storeCode = 'Lab';
        $programId = 'PX';
        if (self::$is_cert_dinner) {
            $storeCode = 'eGift';
            $programId = 'SV';
        }
        $getcard = self::getNextCard();
        $card = trim($getcard['cardNumber']);
        $regCode = trim($getcard['registrationCode']);
        error_log('Alloting card No.--- ' . $card . ' ----');
        if ($responseActivation = self::callApiActiveCard($origamount, $storeCode, $programId, $card, $regCode)) {
            //Delete Alloted Card
            // if($cardType == 'eBonus'){
            //     $card = ltrim($card,0);
            // }
            //ADMINADJUST
            if (!self::callApiAdminAdjust($storeCode, $programId, $card, $amount)) {
                self::callApiReverseActivation($storeCode, $responseActivation->pxTransactionId);
                return false;
            }
            
            global $wpdb;

            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));
            error_log('Deleting card No.' . $card . ' from database...');
            $card = [
                'number' => $card,
                'regCode' => $regCode,
                //'balance' => $responseActivation->addWalletContents[0]->quantity,
                //'expiration' => "None"
            ];

            error_log('Card returned: ' . json_encode($card));

            return $card;
        } else
            return false;
    }

    

    

    

    public static function notifyRecipient($card, $amount, $toEmail, $discount = '') {
        error_log('SendCertificateEmailNew::notifyRecipient');

        error_log('Params: ' . print_r(func_get_args(), true));



        $cardNumber = $card['number'];
        $regCode = $card['regCode'];
        $subject = 'Your Texas de Brazil E-Certificate';
        $form_type = self::$form_type;
        $eb = '';

        error_log('$form_type: ' . $form_type);


        switch ($form_type) {
            case 'base':
            case 'dollar':
                $top_image = site_url() . '/wp-content/uploads/2020/08/e-certificate-600x378.png';
                $rule_image = site_url() . '/wp-content/uploads/2020/07/e-cert-restrictions-scaled.jpg';
                break;
            case 'to-go':
                $top_image = site_url() . '/wp-content/uploads/2020/12/TDB_October2020_To_Go_E-Cert_Card_FINAL-600x367.png';
                $rule_image = site_url() . '/wp-content/uploads/2020/10/to-go-cert.jpg';
                break;
            case 'early-booking':
                $top_image = site_url() . '/wp-content/uploads/2020/12/TDB_October2020_Early_Booking_E-Cert_Card_FINAL-600x367.png';
                $rule_image = site_url() . '/wp-content/uploads/2021/08/early_booking_restrictions.jpeg';
                $eb = '-eb';
                break;
            case 'dinner':
                $top_image = site_url() . '/wp-content/uploads/2020/08/e-certificate-600x378.png';
                $rule_image = site_url() . '/wp-content/uploads/2020/07/e-cert-restrictions-scaled.jpg';
                break;
        }


        $body = include(get_template_directory() . '/create-bonuscard/texas-email-certificate' . $eb . '-template.php');



        //$toEmail='franworkspace@gmail.com';
        error_log("======================================================");
        error_log("sending mail to--" . $toEmail . " with card: " . $cardNumber);
        if ($cardNumber):
            if (wp_mail($toEmail, $subject, $body)) {
                error_log("Sent mail to--" . $toEmail);
                return true;
            } else {
                error_log("fail Sent mail to--" . $toEmail);
                return false;
            }
        //die();
        endif;
        error_log("notifyRecipient no card provided");
        return false;
    }

}

add_action('init', array('SendCertificateEmailNew', 'init'));




