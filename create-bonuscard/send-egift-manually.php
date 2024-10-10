<?php

class SendEgiftManually {

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
    private static $is_gift_card = false;
    private static $hasEventDeposit = false;

    // public function __construct(){
    //   	self::init_hooks();
    // }
    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function set_is_gift_card($value) {
        self::$is_gift_card = $value;
    }

    public static function get_is_gift_card() {
        return self::$is_gift_card;
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

    public static function logger($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_error_log_send_cards_manually.txt');
        error_log('----------SendEgiftManually: ' . $value);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_debug.log');
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;
        add_action('wp_ajax_send_egift_manually', ['SendEgiftManually', 'send_egift_manually_callback']);
        add_action('wp_ajax_nopriv_send_egift_manually', ['SendEgiftManually', 'send_egift_manually_callback']);


        add_action('wp_ajax_send_egift_manually_no_val', ['SendEgiftManually', 'send_egift_manually_no_val_callback']);
        add_action('wp_ajax_nopriv_send_egift_manually_no_val', ['SendEgiftManually', 'send_egift_manually_no_val_callback']);
    }

    public static function send_egift_manually_no_val_callback() {

        if (!$_POST['order_id'] || !$_POST['cardnumber'] || !$_POST['regcode'] || !$_POST['amount'])
            return;

        $order_id = $_POST['order_id'];
        $cardNumber = $_POST['cardnumber'];
        $regCode = $_POST['regcode'];
        $amount = $_POST['amount'];
        $email = $_POST['email'];

        self::logger("send_egift_manually_callback $order_id");

        $order = wc_get_order($order_id);
        if (!$order) {
            $reponse = array("message" => "Error", "send_email" => 'order ID is not valid');
            echo json_encode($reponse);
            wp_die();
        }
        $items = $order->get_items();
        self::set_order_id($order_id);

        self::logger("items" . print_r($items, true));

        foreach ($items as $item_id => $item) {
            self::logger("inside foreach loop with item_id $item_id");

            $is_gift_card = wc_get_order_item_meta($item_id, 'isGiftCard', true);
            self::set_is_gift_card($is_gift_card);

            $product_id = $item->get_product_id();
            $digitalProduct = get_field('digital_product', $product_id);
            $variation_id = $item->get_variation_id();
            //if ($digitalProduct) {
            //self::logger("This is degital product");
            $product_id = $item->get_product_id();
            self::set_product_id($product_id);
            $qty = $item->get_quantity();
            $product_slug = get_post($product_id);
            $slug = $product_slug->post_name;
            self::set_slug($slug);

            if ($product_id == EVENT_DEPOSIT) {
                do_action('tx_automatic_send_card_manually_email', $email, $cardNumber, $regCode, $amount, $item_id);
                continue;
            }

            $order_product_Id = $product_id;
            $orderId = $order_id;
            $from_email = $order->get_billing_email();
            self::set_from_email($from_email);
            if ($email != '')
                self::set_to_email($email);
            else
                self::set_to_email($from_email);
            self::set_user_message($item['message']);
            self::set_user_name($item['firstname'] . ' ' . $item['lastname']);
            self::set_card_theme($product_id);
            $qty = 1; //limit to one card
            for ($i = 0; $i < $qty; $i++) {
                //$amount = $item->get_total();
                self::logger("Booting task for Line Item {$product_id} Order #{$orderId})... Amount #{$amount}..) (Slug #{$slug})...");
                $step = array('orderId' => $order_id,
                    'slug' => $slug,
                    'to' => $to_email,
                    'from' => $from_email,
                    'amount' => $amount,
                    'product_id' => $product_id,
                    'item_id' => $item_id,
                    'card' => $cardNumber,
                    'regcode' => $regCode
                );
                self::logger("Runstep function is called with below data");
                self::runStep($step);
            }
            //}
            break; //limit to one card
        }

        $reponse = array("message" => "Error", "send_email" => 'Data in not valid');
        echo json_encode($reponse);
        wp_die();
    }

    public static function send_egift_manually_callback() {
        self::logger("send_egift_manually_callback $order_id");
        if (!$_POST['order_id'] || !$_POST['cardnumber'] || !$_POST['regcode'] || !$_POST['amount'])
            return;
        /* BCC for Internal Records */
        $order_id = $_POST['order_id'];
        $cardNumber = $_POST['cardnumber'];
        $regCode = $_POST['regcode'];
        $amount = $_POST['amount'];
        $email = $_POST['email'];
        $order = wc_get_order($order_id);
        if (!$order) {
            $reponse = array("message" => "Error", "send_email" => 'order ID is not valid');
            echo json_encode($reponse);
            wp_die();
        }
        $items = $order->get_items();
        self::set_order_id($order_id);
        foreach ($items as $item_id => $item) {
            self::logger("inside foreach loop with item_id $item_id");
            $cardCheck = $regCheck = false;


            $cardnumberCheck = wc_get_order_item_meta($item_id, 'PaytronixCardNumber', true);
            if ($cardnumberCheck) {
                $cardnumberCheck = explode(', ', $cardnumberCheck);
                if (is_array($cardnumberCheck) && in_array($cardNumber, $cardnumberCheck)) {
                    $cardCheck = true;
                }
            }

            $regnumberCheck = wc_get_order_item_meta($item_id, 'paytronixRegCode', true);
            if ($regnumberCheck) {
                $regnumberCheck = explode(', ', $regnumberCheck);
                if (is_array($regnumberCheck) && in_array($regCode, $regnumberCheck)) {
                    $regCheck = true;
                }
            }





            if (!$cardCheck || !$regCheck)
                continue;
            $product_id = $item->get_product_id();
            $digitalProduct = get_field('digital_product', $product_id);
            $variation_id = $item->get_variation_id();
            if ($digitalProduct) {
                self::logger("This is degital product");
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
                if ($email != '')
                    self::set_to_email($email);
                else
                    self::set_to_email($from_email);
                self::set_user_message($item['message']);
                self::set_user_name($item['firstname'] . ' ' . $item['lastname']);
                self::set_card_theme($product_id);
                $qty = 1; //limit to one card
                for ($i = 0; $i < $qty; $i++) {
                    //$amount = $item->get_total();
                    self::logger("Booting task for Line Item {$product_id} Order #{$orderId})... Amount #{$amount}..) (Slug #{$slug})...");
                    $step = array('orderId' => $order_id,
                        'slug' => $slug,
                        'to' => $to_email,
                        'from' => $from_email,
                        'amount' => $amount,
                        'product_id' => $product_id,
                        'item_id' => $item_id,
                        'card' => $cardNumber,
                        'regcode' => $regCode
                    );
                    self::logger("Runstep function is called with below data");
                    self::runStep($step);
                }
            }
            break; //limit to one card
        }

        $reponse = array("message" => "Error", "send_email" => 'Data in not valid');
        echo json_encode($reponse);
        wp_die();
    }

    public static function runStep($step = array()) {
        if (empty($step))
            return;

        self::logger("In side runStep function");
        $orderId = $step['orderId'];
        $product_id = $step['product_id'];
        $amount = $step['amount'];
        $slug = $step['slug'];
        $item_id = $step['item_id'];

        $card = $step['card'];
        $regCode = $step['regcode'];

        self::logger("Task for Line Item #{$product_id} (Order #{$orderId}) Amount #{$amount}) now running...");
        self::logger("slug of product is--> $slug <----");
        $bonuscard = '';
        if ($slug == 'vip-card') {
            
        } elseif ($slug == 'e-gift-card') {
            
        } elseif ($slug == 'holiday-e-gift-card') {
            self::logger("creating card for ecard");

            //$bonuscard = self::createCard($amount, $orderId, 'eComp');
        } else {
            
        }



        if (!self::notifyRecipient($card, $regCode, $slug, $amount)) {
            self::logger('There was a problem with emailing');

            return true;
        }

        return true;
    }

    public static function notifyRecipient($cardNumber, $regCode, $slug, $amount) {
        /* BCC for Internal Records */
        $subject = 'Your Texas de Brazil Gift Card sent by ' . self::get_from_email();
        if (strpos($slug, 'vip-dining-card') !== false) {
            $subject = 'Your Texas de Brazil VIP Dining Card';
            $body = include(get_template_directory() . '/create-bonuscard/texas-email-template-vip-dinning-card.php');
        } else {
            $body = include(dirname(__FILE__) . '/texas-email-template.php');
        }
        $toEmail = self::get_to_email();
        //$toEmail='franworkspace@gmail.com';
        self::logger("======================================================");
        self::logger("sending mail to--" . $toEmail);
        if ($cardNumber):
            if (wp_mail($toEmail, $subject, $body)) {
                $reponse = array("message" => "ok", "send_email" => $toEmail);
                echo json_encode($reponse);
            } else {
                $reponse = array("message" => "Error", "send_email" => $toEmail);
                echo json_encode($reponse);
            }
            die();
        endif;
    }

}

add_action('init', array('SendEgiftManually', 'init'));
