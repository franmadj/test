<?php

class SendIsGiftCardsAction {

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

    public static function set_is_gift_card($value) {
        self::$is_gift_card = $value;
    }

    public static function get_is_gift_card() {
        return self::$is_gift_card;
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

    public static function is_holiday_card($slug) {
        return strpos($slug, 'holiday') !== false;
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        add_action('woocommerce_order_actions', ['SendIsGiftCardsAction', 'add_order_meta_box_actions']);

        add_action('woocommerce_order_action_send_is_gift_cards_action', ['SendIsGiftCardsAction', 'send_is_gift_cards_action_callback'], 10, 1);
        add_action('woocommerce_order_action_send_nonegift_cards_action', ['SendIsGiftCardsAction', 'send_send_nonegift_cards_action_callback'], 10, 1);

        add_action('woocommerce_order_action_send_is_gift_vip_cards_action', ['SendIsGiftCardsAction', 'send_is_gift_vip_cards_action_callback'], 10, 1);
        add_action('woocommerce_order_action_send_nonegift_vip_cards_action', ['SendIsGiftCardsAction', 'send_none_gift_vip_cards_action_callback'], 10, 1);

        add_action('woocommerce_order_action_send_is_gift_bonus_cards_action', ['SendIsGiftCardsAction', 'send_is_gift_bonus_cards_action_callback'], 10, 1);
        add_action('woocommerce_order_action_send_nonegift_bonus_cards_action', ['SendIsGiftCardsAction', 'send_none_gift_bonus_cards_action_callback'], 10, 1);
    }

    public static function add_order_meta_box_actions($actions) {
        $actions['send_is_gift_cards_action'] = __('Send IsGift gift cards only', 'woocommerce');
        $actions['send_nonegift_cards_action'] = __('Send noneGift gift cards only', 'woocommerce');

        $actions['send_is_gift_vip_cards_action'] = __('Send IsGift VIP cards only', 'woocommerce');
        $actions['send_nonegift_vip_cards_action'] = __('Send nonGift VIP cards only', 'woocommerce');

        $actions['send_is_gift_bonus_cards_action'] = __('Send IsGift bonus cards only', 'woocommerce');
        $actions['send_nonegift_bonus_cards_action'] = __('Send nonGift bonus cards only', 'woocommerce');

        return $actions;
    }

    public static function send_is_gift_cards_action_callback($order) {
        self::send_cards_action_callback($order, [653], 'Yes');
    }

    public static function send_send_nonegift_cards_action_callback($order) {
        self::send_cards_action_callback($order, [653], 'No');
    }

    public static function send_is_gift_vip_cards_action_callback($order) {
        self::send_cards_action_callback($order, [23574], 'Yes');
    }

    public static function send_none_gift_vip_cards_action_callback($order) {
        self::send_cards_action_callback($order, [23574], 'No');
    }

    public static function send_is_gift_bonus_cards_action_callback($order) {
        self::send_cards_action_callback($order, [63786, 63778], 'Yes');
    }

    public static function send_none_gift_bonus_cards_action_callback($order) {
        self::send_cards_action_callback($order, [63786, 63778], 'No');
    }

    public static function send_cards_action_callback($order, $product_ids, $is_gift_card) {
        $order_id = $order->id;
        error_log("send_is_gift_cards_action_callback $order_id");
        $items = $order->get_items();
        self::set_order_id($order_id);
        foreach ($items as $item_id => $item) {





            $product_id = $item->get_product_id();
            if (!in_array($product_id, $product_ids))
                continue;

            if ($product_id != 63786) {
                $isgiftcard = wc_get_order_item_meta($item_id, 'isGiftCard', true);
                if ($is_gift_card != $isgiftcard)
                    continue;
                self::set_is_gift_card($is_gift_card);

                if ('Yes' == $isgiftcard)
                    self::set_to_email(wc_get_order_item_meta($item_id, 'user_email', true));
                else
                    self::set_to_email($order->get_billing_email());
            } else
                self::set_to_email($order->get_billing_email());



            error_log("inside foreach loop with item_id $item_id and Product_id " . $product_id);

            $product = wc_get_product($product_id);
            $qty = $item->get_quantity();



            $digitalProduct = get_field('digital_product', $product_id);
            $variation_id = $item->get_variation_id();
            if ($digitalProduct) {
                error_log("This is degital product");
                self::set_product_id($product_id);

                $product_slug = get_post($product_id);
                $slug = $product_slug->post_name;
                self::set_slug($slug);
                $order_product_Id = $product_id;
                $orderId = $order_id;
                $from_email = $order->get_billing_email();
                self::set_from_email($from_email);

                self::set_user_message($item['message']);
                self::set_user_name($item['firstname'] . ' ' . $item['lastname']);
                self::set_card_theme($product_id);
                if ($product->get_type() != 'simple') {

                    $variation_id = $item->get_variation_id();
                    $product = new WC_Product_Variable($product_id);
                    $variations = $product->get_available_variations();


                    foreach ($variations as $variation) {
                        if ($variation['variation_id'] == $variation_id) {
                            $amount = $variation['display_price'];
                            break;
                        }
                    }
                } else {
                    $amount = $product->get_price() * $qty;
                }

                error_log("Booting task for Line Item {$product_id} Order #{$orderId})... Amount #{$amount}..) (Slug #{$slug})...");
                $cardNumber = wc_get_order_item_meta($item_id, 'PaytronixCardNumber', true);
                $regCode = wc_get_order_item_meta($item_id, 'paytronixRegCode', true);
                if ($cardNumber && $regCode)
                    if (!self::notifyRecipient($cardNumber, $regCode, $amount)) {
                        error_log('There was a problem with emailing');
                    }


                if (self::is_holiday_card(self::get_slug())) {

                    error_log("Ecard bonus email");
                    if ($amount == 50) {
                        $b_amount = 10;
                    } elseif ($amount % 100 == 0 && $amount != 100) {
                        $b_amount = 25;
                    } else {
                        $b_amount = 25;
                    }

                    $cardnumber = wc_get_order_item_meta($item_id, 'BonusCardNumber', true);
                    $regcode = wc_get_order_item_meta($item_id, 'BonusRegCode', true);
                    if ($cardNumber && $regCode)
                        self::notifyRecipientWithBonusCard($cardnumber, $regcode, $b_amount);
                }
            } elseif ($product_id == 63786) {//Holiday Standard Gift Card
                error_log("Ecard bonus email");
                $amount = $product->get_price() * $qty;
                if ($amount == 50) {
                    $b_amount = 10;
                } elseif ($amount % 100 == 0 && $amount != 100) {
                    $b_amount = 25;
                } else {
                    $b_amount = 25;
                }

                $cardNumber = wc_get_order_item_meta($item_id, 'BonusCardNumber', true);
                $regcode = wc_get_order_item_meta($item_id, 'BonusRegCode', true);
                if ($cardNumber && $regcode)
                    self::notifyRecipientWithBonusCard($cardNumber, $regcode, $b_amount);
            }
            //break; //limit to one card
        }
    }

    public static function notifyRecipient($cardNumber, $regCode, $amount) {
        $isGiftCardItem = self::get_is_gift_card();

        if (self::is_vip_card(self::get_slug())) {
            $subject = 'Your Texas de Brazil VIP Dining Card';
            $body = include(get_template_directory() . '/create-bonuscard/texas-email-template-vip-dinning-card.php');
        } else {
            $subject = 'Your Texas de Brazil Gift Card sent by ' . self::get_from_email();
            $body = include(get_template_directory() . '/create-bonuscard/texas-email-template.php');
        }

        $toEmail = self::get_to_email();
        //$toEmail = 'franworkspace@gmail.com';
        error_log("======================================================");
        error_log("sending mail to-- " . self::get_to_email());
        if ($cardNumber):
            $cardNumbers = explode(', ', $cardNumber);
            $regCodes = explode(', ', $regCode);
            foreach ($cardNumbers as $key => $cardNumber) {
                $regCode = $regCodes[$key];

                if (wp_mail($toEmail, $subject, $body)) {
                    
                }
            }
            return true;
        endif;
    }

    private static function notifyRecipientWithBonusCard($cardNumber_, $regCode_, $amount) {
        error_log("inside send bonus email function with cards " . print_r([$cardNumber_, $regCode_], true));
        if (self::is_holiday_card(self::get_slug())) {
            $ruleimage = home_url() . '/wp-content/uploads/2022/10/Holiday-Sale-ROU-2022.jpg';
        } else if ($amount == 25):
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/25-bonus_new.jpg';
        elseif ($amount == 10):
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus_new.jpg';
        else:
            //Default $10 image
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus_new.jpg';
        endif;
        $subject = 'Your Texas de Brazil Bonus Card';
        
        $toEmail = self::get_to_email();
        //$toEmail = 'franworkspace@gmail.com';
        error_log("======================================================");
        error_log("sending bonus mail to-- " . self::get_to_email());

        if ($cardNumber_):
            $cardNumbers = explode(', ', $cardNumber_);
            $regCodes = explode(', ', $regCode_);
            foreach ($cardNumbers as $key => $cardNumber) {
                $regCode = $regCodes[$key];
                $body = include(get_template_directory() . '/create-bonuscard/texas-bonus-email-template.php');

                if (wp_mail($toEmail, $subject, $body)) {
                    
                }
            }
            return true;
        endif;
    }

}

add_action('init', array('SendIsGiftCardsAction', 'init'));
