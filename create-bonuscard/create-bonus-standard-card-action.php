<?php

class CreateBonusStandardCardAction {

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

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;
        add_action('woocommerce_order_actions', ['CreateBonusStandardCardAction', 'add_order_meta_box_actions']);
        add_action('woocommerce_order_action_recreate_bonus_standard_cards', ['CreateBonusStandardCardAction', 'recreate_bonus_cards_callback'], 10, 1);
    }

    public static function add_order_meta_box_actions($actions) {

        $actions['recreate_bonus_standard_cards'] = __('Recreate bonus and standard cards', 'woocommerce');
        return $actions;
    }

    public static function subscribe_marketing($order_id) {
        $order = wc_get_order($order_id);

        $fields = [
            'EmailAddress' => $order->get_billing_email(),
            'firstName' => ucwords($order->get_billing_first_name()),
            'lastName' => ucwords($order->get_billing_last_name()),
            'Zip' => $order->get_billing_postcode(),
            'ListID' => '23622320156',
            'siteGUID' => '4E1BF72E-AE6F-45FA-A257-C55651B6770A',
            'JoinDate' => date('m/d/Y'),
            'SuppressConfirmation' => 'yes', // From current form
            '_InputSource_' => 'eCommerce', // From current form
            'action' => 'subscribe',
                // 'ReturnURL' => '', // Not needed, since we're sending directly
        ];

        $postString = '';

        foreach ($fields as $key => $value) {
            $postString .= $key . '=' . $value . '&';
        }

        $postString = rtrim($postString, '&');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://texasdebrazil.fbmta.com/members/subscribe.aspx');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        // Don't check an SSL Certificate
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

        $response = curl_exec($ch);

        curl_close($ch);
        error_log("After OPT Marketing subscribe");

        error_log($response);

        return;
    }

    public static function hasCards($item_id) {
        global $wpdb;
//        $sum = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) from ".$wpdb->prefix."paytronixgiftcards where post_status = 'publish' and user_id = %d", $user_id ) );
//        $wpdb->get_var('SELECT  FROM ".$wpdb->prefix."paytronixgiftcards where cardNumber in';);
        return false;
    }

    public static function recreate_bonus_cards_callback($order) {

        $order_id = $order->ID;
        error_log("recreate_bonus_standards_cards_callback $order_id");

        $items = $order->get_items();


        self::set_order_id($order_id);
        $optMarketing = get_post_meta($order_id, 'optMarketing', true);
        if ($optMarketing == 'Yes') {
            self::subscribe_marketing($order_id);
        }

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
                $from_email = $order->get_billing_email();
                self::set_from_email($from_email);
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
                if (self::isHolidayCard(self::get_slug())) {
                    error_log("Ecard bonus email");
                    if ($amount == 50) {
                        $b_amount = 10;
                    } elseif ($amount % 100 == 0 && $amount != 100) {
                        $qty1 = $qty1 * ($amount / 100);
                        $b_amount = 25;
                    } else {
                        $b_amount = 25;
                    }
                    global $wpdb;
                    $table = $wpdb->prefix."bonuscard";

                    //error_log('wc_get_order_item_meta '.wc_get_order_item_meta($item_id, 'BonusCardNumber', true));return;
                    //if BonusCardNumber is not created for this item
                    if (!wc_get_order_item_meta($item_id, 'BonusCardNumber', true))
                        for ($i = 0; $i < $qty1; $i++) {
                            if (($amount % 150 == 0) && ($amount % 100 != 0)) {
                                error_log("150 Bonus card");
                                $bonuscard1 = self::createCard(10, $orderId, 'eBonus');
                                if ($bonuscard1):
                                    self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                                    $data = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                                    $wpdb->insert($table, $data);
                                endif;
                                $bonuscard2 = self::createCard(25, $orderId, 'eBonus');
                                if ($bonuscard2):
                                    self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                                    $data2 = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                                    $wpdb->insert($table, $data2);
                                endif;
                            } elseif (($amount == 250)) {
                                error_log("250 Bonus card");
                                $bonuscard1 = self::createCard(10, $orderId, 'eBonus');
                                if ($bonuscard1):
                                    self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                                    $data = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                                    $wpdb->insert($table, $data);
                                endif;
                                $bonuscard2 = self::createCard(25, $orderId, 'eBonus');
                                if ($bonuscard2):
                                    self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                                    $data2 = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                                    $wpdb->insert($table, $data2);
                                endif;
                                $bonuscard = self::createCard(25, $orderId, 'eBonus');
                                if ($bonuscard):
                                    self::saveBonusCardToOrder($bonuscard, $item_id, 25);
                                    $data = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => 25);
                                    $wpdb->insert($table, $data);
                                endif;
                            } else {
                                error_log("else bonus card");
                                $bonuscard = self::createCard($b_amount, $orderId, 'eBonus');
                                if ($bonuscard):
                                    self::saveBonusCardToOrder($bonuscard, $item_id, $b_amount);
                                    $data3 = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => $b_amount);
                                    $wpdb->insert($table, $data3);
                                endif;
                            }
                        }
                }
                //if PaytronixCardNumber is not created for this item
                if (!wc_get_order_item_meta($item_id, 'PaytronixCardNumber', true))
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
            } elseif ($product_id == 63786) {
                $product_id = $item->get_product_id();
                self::set_product_id($product_id);
                $qty = $item->get_quantity();
                $product_slug = get_post($product_id);
                $slug = $product_slug->post_name;
                self::set_slug($slug);
                $order_product_Id = $product_id;
                $orderId = $order_id;
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
                $table = $wpdb->prefix."bonuscard";

                for ($i = 0; $i < $qty; $i++) {
                    if (($amount % 150 == 0) && ($amount % 100 != 0)) {
                        error_log("150 Bonus card");
                        $bonuscard1 = self::createCard(10, $orderId, 'eBonus');
                        if ($bonuscard1):
                            self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                            $data = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                            $wpdb->insert($table, $data);
                        endif;
                        $bonuscard2 = self::createCard(25, $orderId, 'eBonus');
                        if ($bonuscard2):
                            self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                            $data2 = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                            $wpdb->insert($table, $data2);
                        endif;
                    } elseif (($amount == 250)) {
                        error_log("250 Bonus card");
                        $bonuscard1 = self::createCard(10, $orderId, 'eBonus');
                        if ($bonuscard1):
                            self::saveBonusCardToOrder($bonuscard1, $item_id, 10);
                            $data = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10);
                            $wpdb->insert($table, $data);
                        endif;
                        $bonuscard2 = self::createCard(25, $orderId, 'eBonus');
                        if ($bonuscard2):
                            self::saveBonusCardToOrder($bonuscard2, $item_id, 25);
                            $data2 = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard2['number'], "reg_code" => $bonuscard2['regCode'], "amount" => 25);
                            $wpdb->insert($table, $data2);
                        endif;
                        $bonuscard = self::createCard(25, $orderId, 'eBonus');
                        if ($bonuscard):
                            self::saveBonusCardToOrder($bonuscard, $item_id, 25);
                            $data = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => 25);
                            $wpdb->insert($table, $data);
                        endif;
                    } else {
                        error_log("else bonus card");
                        $bonuscard = self::createCard($b_amount, $orderId, 'eBonus');
                        if ($bonuscard):
                            self::saveBonusCardToOrder($bonuscard, $item_id, $b_amount);
                            $data3 = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard['number'], "reg_code" => $bonuscard['regCode'], "amount" => $b_amount);
                            $wpdb->insert($table, $data3);
                        endif;
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
        if ($slug == 'vip-card') {
            
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

        // if (isset($bonuscard) && !empty($bonuscard)) {
        //     if (! self::saveBonusCardToOrder($bonuscard)) {
        //         error_log("No order found (or there was a problem saving bonus card) #{$orderId}");
        //         return true;
        //     }
        //     if (! self::notifyRecipientWithBonusCard($bonuscard['number'],$bonuscard['regCode'],$slug)) {
        //         error_log('There was a problem with emailing bonus card ');
        //         return true;
        //     }
        // }

        if (!self::notifyRecipient($card['number'], $card['regCode'], $slug, $amount)) {
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

    public static function redeemCard($card, $amount) {

        $amount = '1.00';

        error_log('Redeeming card for $' . $amount . ' ...', LogLevel::Info, true);

        $data = self::config();

        $card = '6000101001508756';

        $data['cardInfo'] = [
            "swipeFlag" => false,
            "printedCardNumber" => $card
        ];

        $data['addWalletContents'] = [];

        $data['redeemWalletContents'] = [
            array(
                'walletCode' => 1,
                'quantity' => $amount
        )];

        $endpoint = 'addRedeem.json';

        $response = self::query($endpoint, $data);

        error_log('Response: ' . json_encode($response) . '', LogLevel::Info, true);

        if ($response->result != 'authorizedSuccess') {
            error_log('Paytronix Gift Card response is specifying there\'s an error. Error: ' . json_encode($response->errorMessage));
            return false;
        }

        $card = [
            'number' => $response->printedCardNumber,
            'balance' => $response->svCurrentBalance,
            'expiration' => "None"
        ];

        error_log('Card returned: ' . json_encode($card));

        return $card;
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

    public static function importCards() {
        $cards = array();
        $row = 0;
        set_time_limit(0);
        if (( $handle = fopen($_FILES['csvfile']['tmp_name'], "r") ) !== FALSE) {
            while (( $data = fgetcsv($handle, 1000, ",") ) !== FALSE) {
                if ($row > 0) { // limit to ten while testing
                    $cards[] = array(
                        'internalCardNumber' => $data[0],
                        'cardNumber' => $data[1],
                        'registrationCode' => $data[2],
                        'cardType' => $data[3]
                    );
                }
                $row++;
            }
        }

        foreach ($cards as $card) {
            $internalCardNumber = $card['internalCardNumber'];
            $cardNumber = $card['cardNumber'];
            $registrationCode = $card['registrationCode'];
            $cardType = $card['cardType'];

            $paytronixGiftCardRecord = new PaytronixGiftCardRecord;
            $paytronixGiftCardRecord->setAttribute('internalCardNumber', $internalCardNumber);
            $paytronixGiftCardRecord->setAttribute('cardNumber', $cardNumber);
            $paytronixGiftCardRecord->setAttribute('registrationCode', $registrationCode);
            $paytronixGiftCardRecord->setAttribute('cardType', $cardType);

            // save record in DB
            $paytronixGiftCardRecord->save();
        }
        $total = $row - 1;
        $message = $total . " Cards Imported Successfully.";
        craft()->userSession->setFlash('importSuccess', $message);
        return true;
    }

    private static function notifyCorporate($cardNumber) {

        error_log('Sending mail to corporate for Already Active Card {$cardNumber}');

        $body = "<p>Hey,</p><p>Recently while ordering Paytronix Gift Card, a card number " . $cardNumber . " was found already active.<p>";



        $toEmail = 'onlineorders@texasdebrazil.com';

        $subject = 'Paytronix Gift Card Already Active Error';



        return wp_mail($toEmail, $subject, $body);
    }

    public static function checkBalance($cardNumber, $registrationCode) {
        $endpoint = 'accountInformation.json';

        $response = self::guestQuery($endpoint, $cardNumber, $registrationCode);

        error_log('Check Balance Response: ' . json_encode($response));

        if ($response->result == 'failed') {
            return $result = array(
                'status' => 'failure',
                'error' => "Unable to get Card Information {$response->errorMessage}. Please try again."
            );
        }

        if (array_key_exists('storedValueBalance', $response)) {
            $balance = '$' . $response->storedValueBalance->balance;
        } elseif (array_key_exists('rewardBalances', $response)) {
            $balance = $response->rewardBalances[0]->balance . ' "' . $response->rewardBalances[0]->name . '"';
        } else {
            $balance = '';
        }

        return $result = array(
            'status' => 'success',
            'balance' => $balance
        );
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

    public static function load() {
        $order = new WC_Order(742);
    }

    public static function notifyRecipient($cardNumber, $regCode, $slug, $amount) {
        return true;


    }

    private static function notifyRecipientWithBonusCard($cardNumber, $regCode, $slug) {
        return true;


    }

    private static function isHolidayCard($slug) {
        ////holiday-standard-gift-card,holiday-e-gift-card
        return in_array($slug, ['holiday-standard-gift-card', 'holiday-e-gift-card']);
    }

    private static function notifyRecipientWithBonusCard_new($cardNumber, $regCode, $amount, $order_id) {
        return true;
        
    }

}

add_action('init', array('CreateBonusStandardCardAction', 'init'));
