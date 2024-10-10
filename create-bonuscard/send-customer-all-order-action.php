<?php

//$body = include(get_template_directory() . '/emails/order-detail.php'); //order receipt
//$body = include(plugin_dir_path(__FILE__) . '/texas-email-template.php');'/emails/egift-email-template.php' //standard card
//$body = include(plugin_dir_path(__FILE__) . '/texas-bonus-email-template.php'); //bonus card


function action_woocommerce_order_edit_status($id, $new_status) {
    if ('refunded' != $new_status)
        return;
    error_log("action_woocommerce_order_edit_status======================================================");
    $order = wc_get_order($id);
    $toEmail = $order->get_billing_email();
    $subject = 'Order #' . $id . ' Refund';

    $body = include(get_template_directory() . '/emails/customer-refunded-order.php');

    $s = wp_mail($toEmail, $subject, $body);
    error_log("sent: " . print_r([$toEmail, $s], true));
}

// add the action 
add_action('woocommerce_order_edit_status', 'action_woocommerce_order_edit_status', 10, 2);

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
    private static $test = '';
    private static $is_gift_card = false;

    //private static $test = 'franworkspace@gmail.com';
    
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

    public static function send_non_egift_cards_callback($order, $test) {
        self::$test = $test;
        $order_id = $order->id;
        error_log("send_non_egift_cards_callback $order_id");


        $items = $order->get_items();

        error_log("order_id:" . $order_id . " items count:" . count($items));

        self::set_order_id($order_id);


//        $cardNumber = $_POST['cardnumber'];
//        $regCode = $_POST['regcode'];
//        $amount = $_POST['amount'];


        foreach ($items as $item_id => $item) {
            error_log("inside foreach loop with item_id $item_id theme ");
            $product_id = $item->get_product_id();



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
                //self::set_to_email($from_email);
                self::set_user_message($item['message']);
                self::set_user_name($item['firstname'] . ' ' . $item['lastname']);
                self::set_card_theme($product_id);



                $isgiftcard = wc_get_order_item_meta($item_id, 'isGiftCard', true);
                if ($isgiftcard == "Yes") {
                    $to_email = wc_get_order_item_meta($item_id, 'user_email', true);
                    error_log("A gift card---" . $item_id);
                } else {
                    $to_email = self::get_from_email();
                    error_log("Not a gift card---" . $item_id);
                }
                self::set_to_email($to_email);



//                if ($digitalProduct) {
//                    $digitalItems[] = $digitalProduct;
//                }


                $product__ = wc_get_product($product_id);

                //error_log('$product__'.$product__->get_type());
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
                $qty = 1; //limit to one card


                for ($i = 0; $i < $qty; $i++) {


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
            //break; //limit to one card
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



        if (!self::notifyRecipient($card, $regCode, $slug, $amount, $item_id)) {
            error_log('There was a problem with emailing');

            return true;
        }

        return true;
    }

    public static function notifyRecipient($cardNumber, $regCode, $slug, $amount, $item_id) {
        error_log("notifyRecipient ======================================================");

        /* BCC for Internal Records */
        $isgiftcard = wc_get_order_item_meta($item_id, 'isGiftCard', true);
        self::set_is_gift_card($isgiftcard);


        $toEmail = self::$test ?: self::get_to_email();
        error_log("toEmail :" . $toEmail);
        error_log("cardNumber :" . print_r($cardNumber, true));

        //error_log("sending mail to--" . $toEmail . " slug: " . $slug . " subject: " . $subject . " in cardNumber:" . print_r($cardNumber, true));
        if ($cardNumber):

            $cardNumbers = explode(', ', $cardNumber);
            $regCodes = explode(', ', $regCode);
            foreach ($cardNumbers as $key => $cardNumber) {
                $regCode = $regCodes[$key];





                if ($slug == 'vip-card') {
                    $renderTemp = 'texas/vip-card';
                    $subject = 'Your Texas de Brazil VIP Dining Card sent by ' . self::get_from_email();
                    $body = include(dirname(__FILE__) . '/texas-email-template.php');
                } else if (strpos($slug, 'vip-dining-card') !== false) {
                    $body = include(dirname(__FILE__) . '/texas-email-template-vip-dinning-card.php');
                    $subject = 'Your Texas de Brazil VIP Dining Card';
                } else {
                    $body = include(dirname(__FILE__) . '/texas-email-template.php');
                    $subject = 'Your Texas de Brazil Gift Card sent by ' . self::get_from_email();
                    $renderTemp = 'texas/gift-card';
                }



                if (wp_mail($toEmail, $subject, $body)) {
                    error_log("SENT");
                } else {

                    error_log("NO SENT");
                }
            }
            return true;
        endif;
    }

}

class SendCustomerAllOrderAction {

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
    private static $test = '';
    private static $is_gift_card = false;

    //private static $test = 'franworkspace@gmail.com';
    //private static $test = 'matt@thriveground.com, franworkspace@gmail.com';
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

    public static function manualInit($order) {
        self::send_customer_all_order_callback($order);
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
        add_action('woocommerce_order_actions', ['SendCustomerAllOrderAction', 'add_order_meta_box_actions']);
        add_action('woocommerce_order_action_send_customer_all_order', ['SendCustomerAllOrderAction', 'send_customer_all_order_callback']);
    }

    public static function add_order_meta_box_actions($actions) {

        $actions['send_customer_all_order'] = __('Re-send all order emails', 'woocommerce');
        return $actions;
    }
    
    
    //Order #XXX Receipt,  Your Texas de Brazil Bonus Card, Your Texas de Brazil...

    public static function send_customer_all_order_callback($order) {
        error_log("send_customer_all_order_callback======================================================");
        global $wpdb;
        $customer_email = $order->get_billing_email();
        $order_data = $order->get_data();
        $body = include(get_template_directory() . '/emails/order-detail.php');
        $toEmail = self::$test ?: $customer_email;
        $subject = 'Order #' . $order->get_id() . ' Receipt';
        $sent = wp_mail($toEmail, $subject, $body);
        error_log("send_customer_all_order_callback Order details email sent to $toEmail:" . print_r($sent, true));



        if (self::$test) {
            //error_log(plugin_dir_path(__FILE__) . '/texas-bonus-email-template.php');return;
//            SendNonEgiftAction::send_non_egift_cards_callback($order, self::$test);
//            return false;
            //return;
            $body = include(get_template_directory() . '/emails/customer-refunded-order.php');
            $subject = 'Order #' . $order->get_id() . ' Refund';
            wp_mail($toEmail, $subject, $body);
            //return;
        }
        /*
          if (false)
          foreach ($order->get_items() as $item_key => $item):
          $theme_id = $item->get_meta('theme_id');
          $isGiftCard = $item->get_meta('isGiftCard');
          $cardNumber = $item->get_meta('PaytronixCardNumber');
          $regCode = $item->get_meta('paytronixRegCode');
          $amount = $item->get_total();
          //if($isGiftCard == "Yes" && $item->get_product_id() == 653){
          $firstName = $item->get_meta('firstname');
          $lastName = $item->get_meta('lastname');
          $user_email = $item->get_meta('user_email');
          self::set_from_email($customer_email);
          $message = $item->get_meta('message');
          //$gift_body = include(get_template_directory() . '/emails/egift-email-template.php');
          $gift_body = include(dirname(__FILE__) . '/texas-email-template.php');
          $subject_gift = 'Your Texas de Brazil Gift Card sent by ' . $customer_email;

          $user_email = self::$test ?: $user_email;
          wp_mail($user_email, $subject_gift, $gift_body);
          endforeach;
         * 
         */




        //BONUS CARDS
        $table = $wpdb->prefix."bonuscard";
        $sql = "select * from $table where order_id=" . $order->get_id();
        $bonusCards = $wpdb->get_results($sql, ARRAY_A);
        error_log("send_customer_all_order_callback bonusCards:" . print_r($bonusCards, true));
        foreach ($bonusCards as $bonuscard) {

            $item = new WC_Order_Item_Product($bonuscard['item_id']);


            $product_slug = get_post($item->get_product_id());
            $slug = $product_slug->post_name;
            self::set_slug($slug);

            self::notifyRecipientWithBonusCard_new($bonuscard['bonuscard_number'], $bonuscard['reg_code'], $bonuscard['amount'], $order->get_id(), $bonuscard['item_id'], $toEmail);
        }
        $order->add_order_note(__('Order details manually sent to customer.', 'woocommerce'), false, true);


        SendNonEgiftAction::send_non_egift_cards_callback($order, self::$test);
    }

    private static function isHolidayCard($slug) {
        ////holiday-standard-gift-card,holiday-e-gift-card
        return in_array($slug, ['holiday-standard-gift-card', 'holiday-e-gift-card']);
    }

    private static function notifyRecipientWithBonusCard_new($cardNumber, $regCode, $amount, $order_id, $item_id, $toEmail) {
        error_log("inside send bonus email function");
        /* BCC for Internal Records */
        if (self::isHolidayCard(self::get_slug())) {
            $ruleimage = home_url() . '/wp-content/uploads/2022/10/Holiday-Sale-ROU-2022.jpg';
        } else if ($amount == 25):
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

        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $toEmail;
        //$headers[] = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();;
        //$headers[] = 'Cc: '.$emailBcc_toEmail; // note
        $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
        $body = include('/nas/content/live/texasdebrazil/wp-content/plugins/texas/texas-bonus-email-template.php');



        //$isgiftcard = wc_get_order_item_meta($item_id, 'isGiftCard', true);
//        if ($isgiftcard == "Yes") {
//            $to_email = wc_get_order_item_meta($item_id, 'user_email', true);
//            
//        } else {
//            $to_email = $toEmail;
//           
//        }

        $to_email = $toEmail;




        $toEmail = self::$test ?: $to_email;
        error_log("======================================================");
        error_log("sending bonus mail to--" . $toEmail);



        if (wp_mail($toEmail, $subject, $body)) {
            error_log("sent OK");
            return true;
        } else {
            error_log("NO sent");
            return false;
        }
    }

}

add_action('init', array('SendCustomerAllOrderAction', 'init'));
