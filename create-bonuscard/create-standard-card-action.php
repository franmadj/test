<?php

class CreateStandardCardAction {

    private static $initiated = false;
    private static $orderId = 0;
    private static $to_email = "";
    private static $from = '';
    private static $amount = '';
    private static $slug = '';
    private static $lineItemId = 0;
    private static $message = '';
    private static $username = '';
    private static $theme_id = 0;

    // public function __construct(){
    //   	self::init_hooks();
    // }
    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function set_user_message($message) {
        self::$message = $message;
    }

    public static function get_user_message() {
        return self::$message;
    }

    public static function set_user_name($username) {
        self::$username = $username;
    }

    public static function get_user_name() {
        return self::$username;
    }

    public static function set_card_theme($theme_id) {
        self::$theme_id = $theme_id;
    }

    public static function get_card_theme() {
        return self::$theme_id;
    }

    public static function set_order_id($orderId) {
        self::$orderId = $orderId;
    }

    public static function get_order_id() {
        return self::$orderId;
    }

    public static function set_to_email($to_email) {
        self::$to_email = $to_email;
    }

    public static function get_to_email() {
        return self::$to_email;
    }

    public static function set_from_email($from) {
        self::$from = $from;
    }

    public static function get_from_email() {
        return self::$from;
    }

    public static function set_slug($slug) {
        self::$slug = $slug;
    }

    public static function get_slug() {
        return self::$slug;
    }

    public static function set_product_id($lineItemId) {
        self::$lineItemId = $lineItemId;
    }

    public static function get_product_id() {
        return self::$lineItemId;
    }

    public static function is_vip_card($slug) {
        return strpos($slug, 'vip-dining-card') !== false;
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        add_action('woocommerce_order_actions', ['CreateStandardCardAction', 'add_order_meta_box_actions']);
        add_action('woocommerce_order_action_recreate_standard_cards', ['CreateStandardCardAction', 'recreate_standard_cards_callback'], 10, 1);
    }

    public static function add_order_meta_box_actions($actions) {

        $actions['recreate_standard_cards'] = __('Generate e-cards and send', 'woocommerce');
        return $actions;
    }

    public static function recreate_standard_cards_callback($order) {
        error_log("recreate_standard_cards_callback $order_id");
        $order_id = $order->ID;


        $items = $order->get_items();


        self::set_order_id($order_id);

        $from_email = $order->get_billing_email();
        self::set_from_email($from_email);


        foreach ($items as $item_id => $item) {

            error_log("inside foreach loop with item_id $item_id");
            $product_id = $item->get_product_id();
            $digitalProduct = get_field('digital_product', $product_id);
            
            if ($digitalProduct) {
                error_log("This is degital product");
                $product_id = $item->get_product_id();
                self::set_product_id($product_id);
                $qty = $item->get_quantity();
                $product_slug = get_post($product_id);
                $slug = $product_slug->post_name;
                self::set_slug($slug);
                $digitalProduct = get_field('digital_product', $product_id);
                $order_product_Id = $product_id;
                $orderId = $order_id;

                self::set_user_message($item['message']);
                self::set_user_name($item['firstname'] . ' ' . $item['lastname']);
                self::set_card_theme($item['theme_id']);

                if ($digitalProduct) {
                    $digitalItems[] = $digitalProduct;
                }


                $product__ = wc_get_product($product_id);
                if ($product__->get_type() != 'simple') {
                    $variation_id = $item->get_variation_id();


                    $product = new WC_Product_Variable($product_id);
                    $variations = $product->get_available_variations();
                    //Getting variation price of ordered product
                    foreach ($variations as $variation) {
                        if ($variation['variation_id'] == $variation_id) {
                            $amount = $variation['display_price'];
                        }
                    }
                } else {
                    $amount = $product__->get_price()*$qty;
                }
                // Creating Bonus Card
                $qty1 = $qty;

                //if PaytronixCardNumber is not created for this item
                $cards = wc_get_order_item_meta($item_id, 'PaytronixCardNumber', true);


//                 wc_update_order_item_meta($item_id, 'PaytronixCardNumber', '');
//                 wc_update_order_item_meta($item_id, 'paytronixRegCode', '');continue;
                if (!$cards) {
                    for ($i = 0; $i < $qty; $i++) {

                        //$amount = $item->get_total();
                        $isgiftcard = wc_get_order_item_meta($item_id, 'isGiftCard', true);
                        if ($isgiftcard == "No") {

                            $to_email = '';
                            error_log("Not a gift card---" . $item_id);
                        } else {
                            $to_email = wc_get_order_item_meta($item_id, 'user_email', true);
                            self::set_to_email($to_email);
                            error_log("A gift card---" . $item_id);
                        }



                        error_log("Booting task for Line Item {$product_id} Order #{$orderId})... Amount #{$amount}..) (Slug #{$slug})...");
                        $step = array('orderId' => $order_id,
                            'slug' => $slug,
                            'to' => $to_email,
                            'from' => $from_email,
                            'amount' => $amount,
                            'product_id' => $product_id,
                            'item_id' => $item_id
                        );
                        error_log("Runstep function is called with below data");

                        self::runStep($step);
                    }
                } else {
                    $cards = explode(', ', $cards);
                    $regCodes = wc_get_order_item_meta($item_id, 'paytronixRegCode', true);
                    $regCodes = explode(', ', $regCodes);
                    foreach ($cards as $key => $card) {
                        self::notifyRecipient($card, $regCodes[$key], $slug, $amount, $item_id);
                    }
                }
            }
        }

        // Trigerring order complete email
        //$email_oc = new WC_Email_Customer_Completed_Order();
        //$email_oc->trigger($order_id);
    }

    public static function runStep($step = array()) {
        if (empty($step))
            return;

        error_log("In side runStep function");
        $orderId = $step['orderId'];
        $product_id = $step['product_id'];
        $amount = $step['amount'];
        $slug = $step['slug'];
        $item_id = $step['item_id'];
        error_log("Task for Line Item #{$product_id} (Order #{$orderId}) Amount #{$amount}) now running...");
        error_log("slug of product is--> $slug <----");
        $bonuscard = '';
        if (self::is_vip_card($slug)) {

            error_log("creating card for vip-dining-card");
            $card = self::createCard($amount, $orderId, 'eGift-vip');
            $save = self::saveCardToOrder($card, $item_id);
        } elseif ($slug == 'e-gift-card') {

            $card = self::createCard($amount, $orderId, 'eGift');
            $save = self::saveCardToOrder($card, $item_id);
        } elseif ($slug == 'holiday-e-gift-card') {
            error_log("creating card for ecard");
            $card = self::createCard($amount, $orderId, 'eGift');
            $save = self::saveCardToOrder($card, $item_id);

            //$bonuscard = self::createCard($amount, $orderId, 'eComp');
        } else {
            
        }
        //$save = self::saveCardToOrder($card,$item_id);
        if (!$save) {
            error_log("No order found (or there was a problem saving) #{$orderId}");

            return true;
        }



        if (!self::notifyRecipient($card['number'], $card['regCode'], $slug, $amount, $item_id)) {
            error_log('There was a problem with emailing');

            return true;
        }

        return true;
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

    public static function createCard($amount, $orderId, $cardType) {
        global $wpdb;
        $origamount = $amount;
        $amount = number_format($amount, 2);
        $hasError = 0;

        error_log('Creating card for $' . $amount . ' and cardtype: ' . $cardType . '...');

        $data = self::config();
        $walletCode = 1;
        $storeCode = 'eGift';
        $programId = 'SV';
        //Get a Gift Card
        if ($cardType == 'eComp') {
            error_log('in Ecomp');
            $walletCode = 3;
            $storeCode = 'eComp';
            $programId = 'LP';
            $getcard = $wpdb->get_row("SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eComp'", ARRAY_A);
        } elseif ($cardType == 'eBonus') {
            error_log('in eBonus');
            $walletCode = 4;
            $storeCode = 'BONUS';
            $programId = 'LP';
            //$getcard = craft()->db->createCommand()->select('cardNumber, registrationCode')->from('paytronixgiftcards')->where("cardType = 'eBonus'")->limit('1')->queryRow();
            //$getcard = $wpdb->get_row( "SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eBonus'",ARRAY_A);
            $getcard = $wpdb->get_row("SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eComp'", ARRAY_A, 105000);
        } elseif ($cardType == 'eGift-vip') {
            error_log('in eGift-vip 50000');
            $walletCode = 3;
            $storeCode = 'eGift';
            $programId = 'SV';
            $amount = 12;
            $getcard = $wpdb->get_row("SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eVIP'", ARRAY_A, 25000);
        } else {
            error_log('in eGift');
            $walletCode = 1;
            $storeCode = 'eGift';
            $programId = 'SV';

            $getcard = $wpdb->get_row("SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eGift'", ARRAY_A);
        }
        $card = $getcard['cardNumber'];
        //Below line is commented because we are using eComp card number as bonus
        // if($cardType == 'eBonus'){
        //     $card = '0'.$card;
        // }
        $regCode = $getcard['registrationCode'];

        error_log('Alloting card No.--- ' . $card . ' ----');

        //$data['headerInfo']['posTransactionId'] = $orderId;
        $data['headerInfo']['storeCode'] = $storeCode;
        $data['headerInfo']['programId'] = $programId;

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
        //$response->errorCode == 'transaction.card_already_active'
        if ($response->result == 'userDataError' && $response->errorCode == 'transaction.card_not_in_required_state') {

            $hasError = 1;

            error_log('Paytronix Gift Card response is specifying Card Already Active Error. Re-alloting a new card.');

            //Below line is commented because we are using eComp card number as bonus
            // if($cardType == 'eBonus'){
            //     $card = '0'.$card;
            // }
            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));

            error_log('Deleting already active card No.' . $card . ' from database...');

            //Emailing Corporate
            if (!self::notifyCorporate($card)) {
                error_log('There was a problem with emailing.');
                return true;
            }

            error_log('Re-Alloting card');
            self::createCard($origamount, $orderId, $cardType);
        } elseif ($response->result != 'authorizedSuccess') {
            error_log('Paytronix Gift Card response is specifying there\'s an error. Error: ');
            return false;
        }

        if ($hasError == 0) {
            //Delete Alloted Card
            // if($cardType == 'eBonus'){
            //     $card = ltrim($card,0);
            // }

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

    private function guestQuery($endpoint, $cardNumber, $registrationCode) {
        $headers = [
            'Content-Type: application/json',
        ];

        // Staging URL
        $url = 'https://api.pxslab.com:443/api/rest/16.3/guest/' . $endpoint;
        // Live URL
        //$url = 'https://api.pxsweb.com:443/api/rest/16.3/guest/'. $endpoint;

        $data = "authentication=card&merchantId=570&printedCardNumber={$cardNumber}&registrationCode={$registrationCode}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "?" . $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    private static function notifyCorporate($cardNumber) {

        error_log('Sending mail to corporate for Already Active Card {$cardNumber}');

        $body = "<p>Hey,</p><p>Recently while ordering Paytronix Gift Card, a card number " . $cardNumber . " was found already active.<p>";



        $toEmail = 'onlineorders@texasdebrazil.com';

        $subject = 'Paytronix Gift Card Already Active Error';



        return wp_mail($toEmail, $subject, $body);
    }

    private static function saveCardToOrder($card, $item_id) {


        $order_id = self::$orderId;

        if (!$order_id) {
            return false;
        }
        //$cardnumber = get_post_meta($order_id,'givexCardNumber',true);
        $cardnumber = wc_get_order_item_meta($item_id, 'PaytronixCardNumber', true);
        if ($cardnumber) {
            $cardnumber = $cardnumber . ', ' . $card['number'];
        } else {
            $cardnumber = $card['number'];
        }

        //$regcode = get_post_meta($order_id,'paytronixRegCode',true);
        $regcode = wc_get_order_item_meta($item_id, 'paytronixRegCode', true);
        if ($regcode) {
            $regcode = $regcode . ', ' . $card['regCode'];
        } else {
            $regcode = $card['regCode'];
        }

        error_log('Saving card #' . $card['number'] . ' with reg code ' . $card['regCode'] . ' to order #');

        wc_update_order_item_meta($item_id, 'PaytronixCardNumber', $cardnumber);
        wc_update_order_item_meta($item_id, 'paytronixRegCode', $regcode);
        return true;
    }

    public static function notifyRecipient($cardNumber, $regCode, $slug, $amount, $item_id) {
        return true;

    }

}

add_action('init', array('CreateStandardCardAction', 'init'));
