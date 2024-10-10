<?php

class SendNonEgiftAction {

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

        add_action('woocommerce_order_actions', ['SendNonEgiftAction', 'add_order_meta_box_actions']);
        add_action('woocommerce_order_action_send_non_egift_cards', ['SendNonEgiftAction', 'send_non_egift_cards_callback'], 10, 1);
    }

    public static function add_order_meta_box_actions($actions) {

        $actions['send_non_egift_cards'] = __('Send non-gift e-card product emails', 'woocommerce');
        return $actions;
    }

    public static function send_non_egift_cards_callback($order) {
        $order_id = $order->id;
        error_log("send_non_egift_cards_callback $order_id");







        $items = $order->get_items();

        self::set_order_id($order_id);


//        $cardNumber = $_POST['cardnumber'];
//        $regCode = $_POST['regcode'];
//        $amount = $_POST['amount'];


        foreach ($items as $item_id => $item) {
            error_log("inside foreach loop with item_id $item_id ");
            $product_id = $item->get_product_id();
            $product = new WC_Product_Variable($product_id);
            $digitalProduct = get_field('digital_product', $product_id);
            $variation_id = $item->get_variation_id();
            if ($digitalProduct) {
                error_log("This is degital product");

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
                self::set_to_email($from_email);
                self::set_user_message($item['message']);
                self::set_user_name($item['firstname'] . ' ' . $item['lastname']);
                self::set_card_theme($product_id);

//                if ($digitalProduct) {
//                    $digitalItems[] = $digitalProduct;
//                }

                $variations = $product->get_available_variations();
                //Getting variation price of ordered product
                foreach ($variations as $variation) {
                    if ($variation['variation_id'] == $variation_id) {
                        $amount = $variation['display_price'];
                    }
                }
                $qty = 1; //limit to one card


                for ($i = 0; $i < $qty; $i++) {

                    //$amount = $item->get_total();



                    error_log("Booting task for Line Item {$product_id} Order #{$orderId})... Amount #{$amount}..) (Slug #{$slug})...");
                    $cardNumber = wc_get_order_item_meta($item_id, 'PaytronixCardNumber', true);
                    $regCode = wc_get_order_item_meta($item_id, 'paytronixRegCode', true);
                    $step = array(
                        'orderId' => $order_id,
                        'slug' => $slug,
                        'to' => $to_email,
                        'from' => $from_email,
                        'amount' => $amount,
                        'product_id' => $product_id,
                        'item_id' => $item_id,
                        'card' => $cardNumber,
                        'regcode' => $regCode
                    );
                    error_log("Runstep function is called with below data");

                    self::runStep($step);
                }
            }
            break; //limit to one card
        }
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

        $card = $step['card'];
        $regCode = $step['regcode'];

        error_log("Task for Line Item #{$product_id} (Order #{$orderId}) Amount #{$amount}) now running...");
        error_log("slug of product is--> $slug <----");
        $bonuscard = '';
        if ($slug == 'vip-card') {
            
        } elseif ($slug == 'e-gift-card') {
            
        } elseif ($slug == 'holiday-e-gift-card') {
            error_log("creating card for ecard");

            //$bonuscard = self::createCard($amount, $orderId, 'eComp');
        } else {
            
        }



        if (!self::notifyRecipient($card, $regCode, $slug, $amount)) {
            error_log('There was a problem with emailing');

            return true;
        }

        return true;
    }

    public static function notifyRecipient($cardNumber, $regCode, $slug, $amount) {

        /* BCC for Internal Records */

        $subject = 'Your Texas de Brazil Gift Card sent by ' . self::get_from_email();
        $renderTemp = 'texas/gift-card';
        if ($slug == 'vip-card') {
            $renderTemp = 'texas/vip-card';
            $subject = 'Your Texas de Brazil VIP Dining Card sent by ' . self::get_from_email();
        }

        $emailBcc_toEmail = 'onlineorders@texasdebrazil.com';

        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();
        //$headers[] = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();;
        //$headers[] = 'Cc: '.$emailBcc_toEmail; // note
        //$headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
        //var_dump(dirname(__FILE__) . '/texas-email-template.php');

        $toEmail = self::get_to_email();
        //$toEmail = 'franworkspace@gmail.com';
        error_log("======================================================");
        error_log("sending mail to--" . $toEmail);
        if ($cardNumber):

            $cardNumbers = explode(', ', $cardNumber);
            $regCodes = explode(', ', $regCode);
            foreach ($cardNumbers as $key => $cardNumber) {
                $regCode = $regCodes[$key];

                $body = include(dirname(__FILE__) . '/texas-email-template.php');

                if (wp_mail($toEmail, $subject, $body)) {
                    
                }
            }
            return true;








        endif;
    }

}

add_action('init', array('SendNonEgiftAction', 'init'));
