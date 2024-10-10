<?php

//$body = include(get_template_directory() . '/emails/order-detail.php'); //order receipt
//$body = include(plugin_dir_path(__FILE__) . '/texas-email-template.php');'/emails/egift-email-template.php' //standard card
//$body = include(plugin_dir_path(__FILE__) . '/texas-bonus-email-template.php'); //bonus card

class SendOrderReceiptAction {

    private static $initiated = false;
   
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

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;
        add_action('woocommerce_order_actions', ['SendOrderReceiptAction', 'add_order_meta_box_actions']);
        add_action('woocommerce_order_action_resend_order_receipt', ['SendOrderReceiptAction', 'resend_order_receipt_callback']);
    }

    public static function add_order_meta_box_actions($actions) {

        $actions['resend_order_receipt'] = __('Resend order receipt', 'woocommerce');
        return $actions;
    }

    public static function resend_order_receipt_callback($order) {
        global $wpdb;
        $customer_email = $order->get_billing_email();

        $order_data = $order->get_data();
        $body = include(get_template_directory() . '/emails/order-detail.php');
        $toEmail = $customer_email;
        //$toEmail = 'franworkspace@gmail.com';//*************************************
        $subject = 'Order #' . $order->get_id() . ' Receipt';
        wp_mail($toEmail, $subject, $body);

        $order->add_order_note(__('Resend order receipt manually to customer.', 'woocommerce'), false, true);
    }



}

add_action('init', array('SendOrderReceiptAction', 'init'));
