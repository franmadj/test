<?php

ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_send-certificate-email.txt');

class SendCertificateEmail {

    private static $initiated = false;
    private static $cardType = 'ecert';
    private static $form_type = 'ecert';
    private static $wallet_code = 4;
    private static $is_cert_dinner = false;
    private static $expiration = '1 year';
    private static $notes = '';
    private static $dinner_discount = '';
    private static $location = '';

    // public function __construct(){
    //   	self::init_hooks();
    // }
    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    private static function set_location() {
        if (!empty($_POST['location']))
            self::$location = $_POST['location'];
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        self::registerPostType();


        add_action('wp_ajax_send_certificate_email', ['SendCertificateEmail', 'send_certificate_email_callback']);
        add_action('wp_ajax_send_certificate_email_dinner', ['SendCertificateEmail', 'send_certificate_email_dinner_callback']);

        /* REMOVE BULK AND DELETE ACTIONS FROM THE ADMIN PAGE */
        add_filter('bulk_actions-edit-email_certificates', '__return_empty_array', 100);
        add_action('wp_trash_post', array('SendCertificateEmail', 'disable_trash'));
        add_action('before_delete_post', array('SendCertificateEmail', 'disable_trash'));
    }

    /**
     * Disable trash
     */
    static function disable_trash($post_id) {
        global $post_type;

        if (in_array($post_type, array('email_certificates'))) {
            wp_die(__('You are not allowed to trash email certificates.'));
        }
    }

    static function registerPostType() {
        $labels = array(
            'name' => _x('Email Certificates', 'post type general name'),
            'singular_name' => _x('Email Certificate', 'post type singular name'),
            'add_new' => _x('Add New', 'Email Certificate'),
            'add_new_item' => __('Add New Email Certificate'),
            'edit_item' => __('Edit Email Certificate'),
            'new_item' => __('New Email Certificate'),
            'all_items' => __('All Email Certificates'),
            'view_item' => __('View Email Certificate'),
            'search_items' => __('Search Email Certificates'),
            'not_found' => __('No Email Certificates found'),
            'not_found_in_trash' => __('No Email Certificates found in the Trash'),
            'parent_item_colon' => '',
            'menu_name' => 'Sent Email Certificates'
        );
        $args = array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title', 'editor'),
        );
        register_post_type('email_certificates', $args);
    }

    private static function set_expiration_date() {
        if (!empty($_POST['expiration']) && in_array($_POST['expiration'], ['3 months', '6 months', '1 year'])) {
            self::$expiration = $_POST['expiration'];
        }
    }

    public static function send_certificate_email_callback() {
        error_log("send_egift_manually_callback");
        if (!$_POST['amount'] || !$_POST['email'] || !$_POST['form_type'])
            return;

        self::set_location();

        $amount = intVal($_POST['amount']);
        $email = $_POST['email'];
        self::$form_type = $_POST['form_type'];
        if (self::$form_type == 'early-booking') {
            self::$cardType = 'ecomp';
        } else {
            if (empty($_POST['expiration']))
                return;
            self::set_expiration_date();
            if (self::$form_type == 'dollar') {
                if ($amount > 100)
                    $amount = 100;
            }
        }
        $content = !empty($_POST['content']) ? $_POST['content'] : 'No Content';
        self::$notes = $content;
        if ($email == 'franworkspace@gmail.com') {
            var_dump($_POST, self::$expiration);
            $card = [];
            $card['number'] = '534354354Test';
            $card['regCode'] = '5343Test';
        } else {
            
            $orderId = self::getNextCertificate();
            
            if (self::$form_type == 'early-booking')
                $card = self::createCard($amount, $orderId);
            else
                $card = self::createCardExpiration($amount);
            $save = self::saveCardToOrder($card, $email, $content, $amount);
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

    public static function send_certificate_email_dinner_callback() {
        error_log("send_certificate_email_dinner_callback");
        if (!$_POST['quantity'] || !$_POST['discount'] || !$_POST['email'] || empty($_POST['expiration']))
            return;
        self::set_expiration_date();
        self::set_location();

        $discount = $_POST['discount'];
        $amount = $_POST['quantity'];
        $email = $_POST['email'];
        self::$form_type = 'dinner';
        self::$is_cert_dinner = true;
        self::$dinner_discount = $discount;
        if (100 == $discount)
            self::$wallet_code = 7;
        else
            self::$wallet_code = 3;
        $content = !empty($_POST['content']) ? $_POST['content'] : 'No Content';
        self::$notes = $content;
        if ($email == 'franworkspace@gmail.com_') {
            var_dump($_POST, self::$expiration);
            $card = [];
            $card['number'] = '534354354';
            $card['regCode'] = '534354354';
        } else {
            $orderId = self::getNextCertificate();
            $card = self::createCardExpiration($amount);
            $save = self::saveCardToOrder($card, $email, $content, $amount, $discount);
        }

        if ($card) {
            if (!self::notifyRecipient($card, $amount, $email, $discount)) {
                error_log('There was a problem with emailing');
                $reponse = array("message" => "There was a problem with emailing", "status" => 'failure');
            } else
                $reponse = array("message" => "Sent Successfully to Email: " . $email, "status" => 'success');
        } else
            $reponse = array("message" => "Something whent wrong.", "status" => 'failure');

        echo json_encode($reponse);
        wp_die();
    }

    private static function getNextCertificate() {
        global $wpdb;
        //var_dump("SELECT id FROM " . $wpdb->prefix . "posts order by id DESC");exit;
        $lastId = $wpdb->get_row("SELECT id FROM " . $wpdb->prefix . "posts order by id DESC limit 1", ARRAY_A);
        return intVal($lastId['id']) + 1;
    }

    private static function get_form_type_name($v1 = true) {
        $name = 'in-store';
        switch (self::$form_type) {
            case 'dollar':
                $name = 'in-store';
                $nameView = 'Dollar amount';
                break;
            case 'dinner':
                $name = 'in-store';
                $nameView = 'Dinner amount';
                break;
            case 'early-booking':
                $name = $nameView = 'Early Booking';
                break;
            case 'to-go':
                $name = $nameView = 'To Go';
                break;
        }
        if ($v1)
            return $name;
        else
            return $nameView;
    }

    private static function saveCardToOrder($card, $email, $content, $amount, $discount = '') {
        if (!empty($card['number']) && !empty($card['regCode'])) {
            $cardnumber = $card['number'];
            $regcode = $card['regCode'];
        } else {
            return false;
        }

        $current_user = wp_get_current_user();
        if ($discount) {
            $title = 'x' . $amount . ' %' . $discount . ' ' . self::get_form_type_name() . ' - Card:' . $cardnumber . ' - To: ' . $email . ' - From: ' . $current_user->user_email;
        } else {
            $title = '$' . $amount . ' ' . self::get_form_type_name() . ' - Card:' . $cardnumber . ' - To: ' . $email . ' - From: ' . $current_user->user_email;
        }

        //$content = 'Card #' . $cardnumber . ' with reg code #' . $regcode . ' Sent to: ' . $email;
        error_log('saveCardToOrder #' . $title);

        error_log('Saving card #' . $cardnumber . ' with reg code ' . $regcode . ' to certificate #');

        $args = array(
            'post_author' => get_current_user_id(),
            'post_content' => $content,
            'post_title' => $title,
            'post_excerpt' => '',
            'post_status' => 'publish',
            'post_type' => 'email_certificates',
        );

        $res = wp_insert_post($args);

        if (is_wp_error($res)) {
            error_log('Error insert post: ' . print_r($res->get_error_messages(), true) . print_r($args, true));
        } else {
            error_log('inserted post: ' . $res);
        }
        return true;
    }

    private static function getNextCard() {
        global $wpdb;
        //$sql = "SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType = BINARY 'newcert'";
        $sql = "SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType = BINARY '" . self::$cardType . "'";
        $getcard = $wpdb->get_row($sql, ARRAY_A);
        error_log('SQL Query card .--- ' . $sql . ' ----');
        return $getcard;
    }

    public static function createCardExpiration($amount) {
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
            ];

            error_log('Card returned: ' . json_encode($card));

            return $card;
        } else
            return false;
    }

    public static function config() {
        return array(
            'authentication' => 'b2b',
            'headerInfo' => [
                'merchantId' => 570,
                'applicationId' => '',
                'applicationVersion' => '',
                'operatorId' => '0',
                'senderId' => 'PARTNER'
            ]
        );
    }

    public static function createCard($amount, $orderId) {
        global $wpdb;
        $origamount = $amount;
        $amount = number_format($amount, 2);
        $hasError = 0;
        error_log('Creating card for $' . $amount . ' and cardtype: ' . self::$cardType . '... order Id: ' . $orderId);
        $data = self::config();
        $walletCode = self::$wallet_code;
        $storeCode = 'ecert';
        $programId = 'LP';
        if (self::$is_cert_dinner) {
            $storeCode = 'eGift';
            $programId = 'SV';
        }

        $sql = "SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType = BINARY '" . self::$cardType . "'";
        $getcard = $wpdb->get_row($sql, ARRAY_A);

        error_log('SQL Query card .--- ' . $sql . ' ----');


        $card = $getcard['cardNumber'];
        $regCode = $getcard['registrationCode'];

        error_log('Alloting card No.--- ' . $card . ' ----');


        $data['headerInfo']['storeCode'] = $storeCode;
        $data['headerInfo']['programId'] = $programId;
        $data['headerInfo']['posTransactionId'] = strVal($orderId);

        $data['cardInfo'] = [
            "swipeFlag" => false,
            "printedCardNumber" => $card,
            "cardRegCode" => $regCode
        ];

        $data['addWalletContents'] = [
            array(
                'walletCode' => $walletCode,
                'quantity' => $amount
        )];

        error_log('Data: ' . json_encode($data) . '');
        $endpoint = 'activateAdd.json';
        $response = self::query($endpoint, $data);
        error_log('Response: ' . json_encode($response) . '');

        if ($response->result == 'userDataError' && ($response->errorCode == 'transaction.card_not_in_required_state' or $response->errorCode == 'transaction.card_already_active')) {
            $hasError = 1;
            error_log('Paytronix Gift Card response is specifying ' . $response->errorCode . '. Re-alloting a new card.');
            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));
            error_log('Deleting card_not_in_required_state card No.' . $card . ' from database...');
            //Emailing Corporate
            if (!self::notifyCorporate($card)) {
                error_log('There was a problem with emailing.');
                //return true;
            }
            error_log('Re-Alloting card');
            return self::createCard($origamount, $orderId);
        } elseif ($response->result != 'authorizedSuccess') {

            error_log('Paytronix Gift Card response is specifying there\'s an error. Error: ');
            return false;
        }

        if ($hasError == 0) {
            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));
            error_log('Deleting card No.' . $card . ' from database...');
            $card = [
                'number' => $getcard['cardNumber'],
                'regCode' => $regCode,
                'balance' => $response->addWalletContents[0]->quantity,
                'expiration' => "None"
            ];
            error_log('Card returned: ' . json_encode($card));
            return $card;
        }
    }

    private static function notifyCorporate($cardNumber) {

        error_log('Sending mail to corporate for Already Active Card {$cardNumber}');

        $body = "<p>Hey,</p><p>Recently while ordering Paytronix Gift Card, a card number " . $cardNumber . " was found already active.<p>";



        $toEmail = 'onlineorders@texasdebrazil.com';

        $subject = 'Paytronix Gift Card Already Active Error';


        return true;
        return wp_mail($toEmail, $subject, $body);
    }

    public static function isIcloudEmail($email) {//@me.com,@mac.com
        return stripos($email, '@icloud.com') !== FALSE && stripos($email, '@me.com') !== FALSE && stripos($email, '@mac.com') !== FALSE;
    }

    public static function notifyRecipient($card, $amount, $toEmail, $discount = '') {
        error_log('SendCertificateEmail::notifyRecipient');
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
                $rule_image = site_url() . '/wp-content/uploads/2023/01/Dollars-In-Store-E-Cert-ROU-2023-768x536.png';
                break;
            case 'to-go':
                $top_image = site_url() . '/wp-content/uploads/2020/12/TDB_October2020_To_Go_E-Cert_Card_FINAL-600x367.png';
                $rule_image = site_url() . '/wp-content/uploads/2023/01/Dollars-To-Go-E-Cert-ROU-2023-768x536.png';
                break;
            case 'early-booking':
                //https://texasdebrazil.com/wp-content/uploads/2022/10/Early-Booking-ROU-2022.png
                $top_image = site_url() . '/wp-content/uploads/2020/12/TDB_October2020_Early_Booking_E-Cert_Card_FINAL-600x367.png';
                $rule_image = site_url() . '/wp-content/uploads/2022/10/Early-Booking-ROU-2022-768x536.png';
                $eb = '-eb';
                break;
            case 'dinner':
                $top_image = site_url() . '/wp-content/uploads/2020/08/e-certificate-600x378.png';
                $rule_image = site_url() . '/wp-content/uploads/2023/01/Percent-In-Store-E-Cert-ROU-2023-768x536.png';
                break;
        }


        if (!self::isIcloudEmail($toEmail)) {
            $id = trim($cardNumber) . trim($regCode);
            $filePathName = WP_CONTENT_DIR . '/uploads/email-card-certificates/texas-email-pdf-' . $id . '.html';
            $fileUrlName = WP_CONTENT_URL . '/uploads/email-card-certificates/texas-email-pdf-' . $id . '.html';
            $showPdfLinks = false;
            $page = include(get_template_directory() . '/create-bonuscard/texas-email-certificate' . $eb . '-template.php');
            file_put_contents($filePathName, $page);
            $showPdfLinks = true;
            $body = include(get_template_directory() . '/create-bonuscard/texas-email-certificate' . $eb . '-template.php');
        } else {
            $showPdfLinks = false;
            $body = include(get_template_directory() . '/create-bonuscard/texas-email-certificate' . $eb . '-template.php');
        }






        $toEmail = $toEmail;
        error_log("======================================================");
        error_log("sending mail to--" . $toEmail . " with card: " . $cardNumber);



        if ($cardNumber):
            if (wp_mail($toEmail, $subject, $body)) {
                self::report_data($toEmail, $card, $amount);
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

    static function report_data($toEmail, $card, $amount) {
        global $current_user;
        $report = get_option('report_certificates_forms', []);
        $report[] = [
            'Email To' => $toEmail,
            'Submitted from' => $current_user->user_email,
            'E-card' => $card['number'],
            'Amount' => $amount,
            'Date' => date('Y/m/d'),
            'Notes' => self::$notes,
            'Type' => self::get_form_type_name(false),
            'Dinner discount' => self::$dinner_discount,
            'Location' => self::$location
        ];
        update_option('report_certificates_forms', $report);
    }

    /*     * *************************API********************** */

    private static function queryApi($endpoint, $data) {
        $headers = [
            'Content-Type: application/json',
        ];

//        $username = 'rUYTFOdynKx_TF7NTJKjR0UoLB1qXWUE_t7saWe3fK';
//        $password = 'X1SMM63oPZW76sC851wom';
        $username = get_field('user_name', 'options');
        $password = get_field('password', 'options');
        error_log("username --$username and password -- $password");
        // Staging URL
        //$url = 'https://m570.api.pxslab.com:443/api/rest/22.23/transaction/' . $endpoint;
        // Live URL
        //$url = 'https://api.pxsweb.com:443/api/rest/16.3/transaction/' . $endpoint;
        $url = 'https://api.pxsweb.com:443/api/rest/22.23/transaction/' . $endpoint;

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
                $responseActivation->errorCode == 'transaction.card_already_active')
        ) {

            error_log('Paytronix Gift Card response is specifying ' . $responseActivation->errorCode . '. Re-alloting a new card.');
            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));
            error_log('Deleting card_not_in_required_state card No.' . $card . ' from database...');

            error_log('Re-Alloting card');
            self::createCardExpiration($origamount);
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
            "posTransactionId" => time() . '1',
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

    private static function query($endpoint, $data) {
        $headers = [
            'Content-Type: application/json',
        ];

        $username = get_field('user_name', 'options');
        $password = get_field('password', 'options');
        error_log("username --$username and password -- $password");
        // Staging URL
        //$url = 'https://api.pxslab.com:443/api/rest/16.3/transaction/'. $endpoint;
        // Live URL
        $url = 'https://api.pxsweb.com:443/api/rest/16.3/transaction/' . $endpoint;


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

}

add_action('init', array('SendCertificateEmail', 'init'));
