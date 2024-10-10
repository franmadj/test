<?php

class CreateBonusCardAction {

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

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;
        add_action('woocommerce_order_actions', ['CreateBonusCardAction', 'add_order_meta_box_actions']);
        add_action('woocommerce_order_action_recreate_bonus_cards', ['CreateBonusCardAction', 'recreate_bonus_cards_callback'], 10, 1);
    }

    private static function strval_l($t) {
        return "'" . $t . "'";
    }

    public static function add_order_meta_box_actions($actions) {

        $actions['recreate_bonus_cards'] = __('Generate bonus cards and send', 'woocommerce');
        return $actions;
    }

    public static function recreate_bonus_cards_callback($order) {

        global $wpdb;

        $table = $wpdb->prefix.'bonuscard';
        error_log("---------------------recreate_bonus_cards_callback----------------------------");
        $deleteOrder = false;

        $items = $order->get_items();
        self::set_order_id($order->id);
        foreach ($items as $item_id => $item) {

            error_log("inside foreach loop with item_id $item_id");
            $product_id = $item->get_product_id();
            $digitalProduct = get_field('digital_product', $product_id);


            $product_slug = get_post($product_id);
            $slug = $product_slug->post_name;
            $itemCards = wc_get_order_item_meta($item_id, 'BonusCardNumber', true);


//            wc_update_order_item_meta($item_id, 'BonusCardNumber', '');
//            wc_update_order_item_meta($item_id, 'BonusRegCode', '');
//            $wpdb->delete($table, array('order_id' => $order->id));
//            continue;


            if (!$itemCards) {


                if ($digitalProduct) {
                    error_log("This is degital product");
                    $product_id = $item->get_product_id();
                    self::set_product_id($product_id);
                    $qty = $item->get_quantity();

                    self::set_slug($slug);
                    $digitalProduct = get_field('digital_product', $product_id);
                    $order_product_Id = $product_id;
                    $from_email = $order->get_billing_email();
                    self::set_from_email($from_email);



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
                    if (self::get_slug() == "holiday-e-gift-card") {
                        error_log("Ecard bonus email");
                        if ($amount == 50) {
                            $b_amount = 10;
                        } elseif ($amount % 100 == 0 && $amount != 100) {
                            $qty = $qty * ($amount / 100);
                            $b_amount = 25;
                        } else {
                            $b_amount = 25;
                        }


                        for ($i = 0; $i < $qty; $i++) {
                            if (($amount % 150 == 0) && ($amount % 100 != 0)) {
                                error_log("150 Bonus card");
                                $bonuscard1 = self::createCard(10, $order->id, 'eBonus');
                                if ($bonuscard1):
                                    $deleteOrder = true;
                                    self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                                    $data = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                                    $wpdb->insert($table, $data);
                                endif;
                                $bonuscard2 = self::createCard(25, $order->id, 'eBonus');
                                if ($bonuscard2):
                                    $deleteOrder = true;
                                    self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                                    $data2 = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                                    $wpdb->insert($table, $data2);
                                endif;
                            } elseif (($amount == 250)) {
                                error_log("250 Bonus card");
                                $bonuscard1 = self::createCard(10, $order->id, 'eBonus');
                                if ($bonuscard1):
                                    $deleteOrder = true;
                                    self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                                    $data = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                                    $wpdb->insert($table, $data);
                                endif;
                                $bonuscard2 = self::createCard(25, $order->id, 'eBonus');
                                if ($bonuscard2):
                                    $deleteOrder = true;
                                    self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                                    $data2 = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                                    $wpdb->insert($table, $data2);
                                endif;
                                $bonuscard = self::createCard(25, $order->id, 'eBonus');
                                if ($bonuscard):
                                    $deleteOrder = true;
                                    self::saveBonusCardToOrder($bonuscard, $item_id, 25);
                                    $data = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => 25);
                                    $wpdb->insert($table, $data);
                                endif;
                            } else {
                                error_log("else bonus card");
                                $bonuscard = self::createCard($b_amount, $order->id, 'eBonus');
                                if ($bonuscard):
                                    $deleteOrder = true;
                                    self::saveBonusCardToOrder($bonuscard, $item_id, $b_amount);
                                    $data3 = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => $b_amount);
                                    $wpdb->insert($table, $data3);
                                endif;
                            }
                        }
                    }
                } elseif ($product_id == 63786) {
                    $product_id = $item->get_product_id();
                    self::set_product_id($product_id);
                    $qty = $item->get_quantity();
                    $product_slug = get_post($product_id);
                    $slug = $product_slug->post_name;
                    self::set_slug($slug);
                    $order_product_Id = $product_id;

                    $from_email = $order->get_billing_email();
                    self::set_from_email($from_email);


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
                    error_log("Ecard standard bonus email");
                    if ($amount == 50) {
                        $b_amount = 10;
                    } elseif ($amount % 100 == 0 && $amount != 100) {
                        $qty = $qty * ($amount / 100);
                        $b_amount = 25;
                    } else {
                        $b_amount = 25;
                    }
                    global $wpdb;
                    $table = $wpdb->prefix.'bonuscard';

                    for ($i = 0; $i < $qty; $i++) {
                        if (($amount % 150 == 0) && ($amount % 100 != 0)) {
                            error_log("150 Bonus card");
                            $bonuscard1 = self::createCard(10, $order->id, 'eBonus');
                            if ($bonuscard1):
                                $deleteOrder = true;
                                self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                                $data = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                                $wpdb->insert($table, $data);
                            endif;
                            $bonuscard2 = self::createCard(25, $order->id, 'eBonus');
                            if ($bonuscard2):
                                $deleteOrder = true;
                                self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                                $data2 = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                                $wpdb->insert($table, $data2);
                            endif;
                        } elseif (($amount == 250)) {
                            error_log("250 Bonus card");
                            $bonuscard1 = self::createCard(10, $order->id, 'eBonus');
                            if ($bonuscard1):
                                $deleteOrder = true;
                                self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                                $data = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                                $wpdb->insert($table, $data);
                            endif;
                            $bonuscard2 = self::createCard(25, $order->id, 'eBonus');
                            if ($bonuscard2):
                                $deleteOrder = true;
                                self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                                $data2 = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                                $wpdb->insert($table, $data2);
                            endif;
                            $bonuscard = self::createCard(25, $order->id, 'eBonus');
                            if ($bonuscard):
                                $deleteOrder = true;
                                self::saveBonusCardToOrder($bonuscard, $item_id, 25);
                                $data = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => 25);
                                $wpdb->insert($table, $data);
                            endif;
                        } else {
                            error_log("else bonus card");
                            $bonuscard = self::createCard($b_amount, $order->id, 'eBonus');
                            if ($bonuscard):
                                $deleteOrder = true;
                                self::saveBonusCardToOrder($bonuscard, $item_id, $b_amount);
                                $data3 = array("id" => '', "order_id" => $order->id, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => $b_amount);
                                $wpdb->insert($table, $data3);
                            endif;
                        }
                    }
                }
            } else {
                $itemCards = implode(', ', array_map(['CreateBonusCardAction', 'strval_l'], explode(', ', $itemCards)));

                $sql = "select * from $table where order_id=" . $order->get_id() . " and bonuscard_number in ($itemCards)";
                $bonusCards = $wpdb->get_results($sql, ARRAY_A);
                foreach ($bonusCards as $bonuscard) {


                    self::notifyRecipientWithBonusCard_new($bonuscard['bonuscard_number'], $bonuscard['reg_code'], $bonuscard['amount'], $order->id);
                }
            }
            //is digital product
        }//Order item foreach



        error_log("---------------------recreate_bonus_cards_callback----------------------------");
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
            $getcard = $wpdb->get_row("SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eComp'", ARRAY_A, 110000);
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

    public static function activateCard($amount, $cardNumber, $regcode, $orderId) {
        $origamount = $amount;
        $amount = number_format($amount, 2);
        $hasError = 0;

        //error_log('Creating card for $' . $amount . ' and cardtype: ' . $cardType . '...', LogLevel::Info, true);

        $data = self::config();
        $walletCode = 1;
        $storeCode = 'eGift';
        $programId = 'SV';

        $cardNumber = trim($cardNumber);
        $regcode = trim($regcode);

        $card = $cardNumber;
        $regCode = $regcode;

        error_log('Re activating card No.' . $card . ' ...');

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

        if ($response->result == 'userDataError' && $response->errorCode == 'transaction.card_already_active') {

            $hasError = 1;

            error_log('Paytronix Gift Card response is specifying Card is already activated.');

            return false;
        } elseif ($response->result != 'authorizedSuccess') {
            error_log('Paytronix Gift Card response is specifying there\'s an error. Error: ' . json_encode($response->errorMessage) . '');
            return false;
        }

        if ($hasError == 0) {
            error_log('Card No.' . $card . ' activated...');
            return true;
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

    private static function notifyCorporate($cardNumber) {

        error_log('Sending mail to corporate for Already Active Card {$cardNumber}');

        $body = "<p>Hey,</p><p>Recently while ordering Paytronix Gift Card, a card number " . $cardNumber . " was found already active.<p>";



        $toEmail = 'onlineorders@texasdebrazil.com';

        $subject = 'Paytronix Gift Card Already Active Error';



        return wp_mail($toEmail, $subject, $body);
    }

    private static function saveBonusCardToOrder($bonuscard, $item_id, $amount) {
        $order_id = self::$orderId;

        if (!$order_id) {
            return false;
        }
        if ($bonuscard):
            self::notifyRecipientWithBonusCard_new($bonuscard['number'], $bonuscard['regCode'], $amount, $orderId);
        endif;
        //$cardnumber = get_post_meta($order_id,'givexCardNumber',true);
        $cardnumber = wc_get_order_item_meta($item_id, 'BonusCardNumber', true);
        if ($cardnumber) {
            $cardnumber = $cardnumber . ', ' . $bonuscard['number'];
        } else {
            $cardnumber = $bonuscard['number'];
        }

        //$regcode = get_post_meta($order_id,'paytronixRegCode',true);
        $regcode = wc_get_order_item_meta($item_id, 'BonusRegCode', true);
        if ($regcode) {
            $regcode = $regcode . ', ' . $bonuscard['regCode'];
        } else {
            $regcode = $bonuscard['regCode'];
        }

        error_log('Saving card #' . $bonuscard['number'] . ' with reg code ' . $bonuscard['regCode'] . ' to order #');

        wc_update_order_item_meta($item_id, 'BonusCardNumber', $cardnumber);
        wc_update_order_item_meta($item_id, 'BonusRegCode', $regcode);

        return true;
    }



    private static function notifyRecipientWithBonusCard_new($cardNumber, $regCode, $amount, $order_id) {
        return true;
        error_log("inside send bonus email function");
        /* BCC for Internal Records */

        if ($amount == 25):
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/25-bonus.jpg';
        elseif ($amount == 10):
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
        else:
            //Default $10 image
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
        endif;
        $subject = 'Your Texas de Brazil Bonus Card';

        $renderTemp = 'texas/bonus-card';

        $emailBcc_toEmail = 'onlineorders@texasdebrazil.com';

        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();
        //$headers[] = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();;
        //$headers[] = 'Cc: '.$emailBcc_toEmail; // note
        $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
        $body = include(plugin_dir_path(__FILE__) . '/texas-bonus-email-template.php');

        $toEmail = self::get_from_email();
        //$toEmail = 'franworkspace@gmail.com';
        error_log("======================================================");
        error_log("sending bonus mail to--" . $toEmail);



        if (wp_mail($toEmail, $subject, $body)) {
            return true;
        } else {
            return false;
        }
    }

}

add_action('init', array('CreateBonusCardAction', 'init'));
