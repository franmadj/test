<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AutomaticCheckout {

    private $fields = ['guest_name', 'guest_email', 'guest_phone', 'location_name', 'location_address', 'location_phone', 'location_website', 'location_email', 'date_event', 'start_end_time_event', 'nature_of_event', 'no_of_people',
        'package_ordered', 'deposit_amount', 'user_name', 'user_email'];
    private $test = false;

    const CHECKOUT_PAGE = '517';
    const CART_PAGE = '516';

    public function __construct() {
        add_action('wp_ajax_event_deposit_link', [$this, 'event_deposit_generate_link']);
        add_action('wp_ajax_nopriv_event_deposit_link', [$this, 'event_deposit_generate_link']);

        add_action('tx_automatic_checkout_send_receipt_email', [$this, 'send_receipt_email'], 10, 1);
        add_action('tx_automatic_checkout_send_card_email', [$this, 'send_card_email'], 10, 5);
        add_action('tx_automatic_checkout_generate_pdf_card_email', [$this, 'generate_pdf_card_email'], 10, 5);
        //add_action('tx_automatic_send_card_manually_email', [$this, 'send_card_manually_email'], 10, 5);



        add_action('woocommerce_checkout_create_order_line_item', [$this, 'checkout_create_order_line_item'], 10, 4);

        add_filter('woocommerce_get_price', [$this, 'return_custom_price'], 10, 2);

        add_action('tx_after_checkout_order_review_item', [$this, 'after_checkout_order_review_item'], 10, 1);

        add_filter('tx_event_deposit_public_fields', [$this, 'event_deposit_public_fields'], 10, 2);

        add_action('tx_process_denied_by_clearsale_email', [$this, 'process_denied_by_clearsale_email'], 10, 1);

        //apply_filters( 'woocommerce_order_item_display_meta_key', $display_key, $meta, $this ),
        add_filter('woocommerce_order_item_display_meta_key', [$this, 'order_item_display_meta_key'], 10, 3);

        add_filter('woocommerce_add_to_cart_validation', [$this, 'avoid_add_other_itmes_to_cart'], 20, 3);

        add_action('tx_thankyou_page', [$this, 'new_order'], 10, 1);

        add_action('woocommerce_order_status_completed', [$this, 'event_deposit_event_register'], 1, 1);
        add_action('woocommerce_order_status_refunded', [$this, 'event_deposit_event_register'], 1, 1);

//        add_action('init', [$this, 'checkEmailStatus'], 10, 1);
//        add_action('admin_footer', [$this, 'displayEmailStatus']);
        //add_action('woocommerce_order_status_processing', [$this, 'new_order'], 10, 1);
        //woocommerce_order_status_processing
//        add_action('wp_footer', [$this, 'hide_back_to_cart_button']);
//        add_action('template_redirect', [$this, 'hide_cart_page']);
//        add_action('init', function() {
//            $this->send_card_email(454242552454, 5487, 20, 1043010);
//        });
//        if (!empty($_GET['test_statuses'])) {
//            add_action('init', function() {
//                $order = wc_get_order(464068);
//                var_dump($order->get_status());
//                exit;
//            });
//        }
    }

    public function event_deposit_event_register($order_id) {
        $order = wc_get_order($order_id);
        $status = $order->get_status();
        if ($item = $this->order_is_event_deposit($order)) {
            $item_id = array_key_first($item);
            $curl = curl_init();
            $this->log('event_deposit_event_register token');
            $token = wc_get_order_item_meta($item_id, 'ac_token', true);
            $this->log($token);
            if (!$token)
                $token = wc_get_order_item_meta($item_id, 'ac_token_bk', true);
            
            
            $this->log($token);

            $fields = '{
                    "token": "' . $token . '",
                    "order_status": "' . $status . '",
                    "order_number": "' . $order_id . '",
                    "billing_email": "' . $order->get_billing_email() . '",
                    "billing_name" : "' . ucwords($order->get_billing_first_name()) . ' ' . ucwords($order->get_billing_last_name()) . '"
                }';
            $this->log('event_deposit_event_register request:');
            $this->log($fields);

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://admin.tdb.app/api/webhook/woocommerce/event',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $fields,
                CURLOPT_HTTPHEADER => array(
                    'x-signature: sha256=694724f1237f3a12aef9831fe85b32c1e5560384713ae184355a566b3fb637e7',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $res = json_decode($response);

            if ($res && !empty($res->error)) {
                wp_mail('jadizzedin@texasdebrazil.com', 'TDB event deposit webhook ERROR', 'Order_id: ' . $order_id . ', Webhook failed with Error: ' . $res->error);
            }

            $this->log('event_deposit_event_register response:');
            $this->log($response);
        }
    }

    public function isIcloudEmail($email) {
        return stripos($email, '@icloud.com') !== FALSE && stripos($email, '@me.com') !== FALSE && stripos($email, '@mac.com') !== FALSE;
    }

    protected function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_edeposit-debug.log');
        error_log('----------Event Deposit: ' . $value);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_debug.log');
    }

    function avoid_add_other_itmes_to_cart($passed, $product_id, $quantity) {
        if ($this->cart_is_event_deposit()) {
            wc_add_notice(__('In order to add other items to your cart, first complete your checkout with the event deposit.'), 'error');
            $passed = false;
        }
        return $passed;
    }

    function hide_back_to_cart_button() {
        if (self::CHECKOUT_PAGE == get_the_ID()) {
            if ($this->cart_is_event_deposit()) {
                ?>
                <style>
                    .checkout-back-cart{
                        display: none;
                    }
                </style>
                <?php

            }
        }
    }

    function hide_cart_page() {
        if (self::CART_PAGE == get_the_ID()) {
            if ($this->cart_is_event_deposit()) {
                wp_redirect('/');
            }
        }
    }

    function cart_is_event_deposit() {
        if ($cart = WC()->cart) {
            $eventDeposit = array_filter($cart->get_cart(), function($cartItem) {
                if ($cartItem['product_id'] == EVENT_DEPOSIT && !empty($cartItem['ac_token']))
                    return true;
                return false;
            });
            return $eventDeposit;
        }
        return false;
    }

    public function order_is_event_deposit(WC_Order $order) {
        $items = $order->get_items();
        return array_filter($items, function($item) {
            return EVENT_DEPOSIT == $item['product_id'];
        });
    }

    function order_item_display_meta_key($display_key, $meta, $el) {
        global $pagenow;
        if (is_admin() && $pagenow == 'post.php') {
            if (in_array($display_key, $this->fields)) {
                if ($display_key == 'no_of_people')
                    $display_key = 'Number of people';
                if ($display_key == 'start_end_time_event')
                    $display_key = 'Time of the event';
                if ($display_key == 'package_ordered')
                    $display_key = 'Event package';
                $display_key = ucfirst(str_replace('_', ' ', $display_key));
            }
        }
        return $display_key;
    }

    function event_deposit_public_fields($fields, $exlude) {
        $result = [];
        foreach ($fields as $key => $val) {
            if (in_array($key, $exlude))
                continue;
            if ($key == 'user_name')
                $key = 'Manager name';
            if ($key == 'user_email')
                $key = 'Manager email';

            if ($key == 'no_of_people')
                $key = 'Number of people';
            if ($key == 'start_end_time_event')
                $key = 'Time of the event';
            if ($key == 'package_ordered')
                $key = 'Event package';


            $key = ucfirst(str_replace('_', ' ', $key));
            $result[$key] = $val;
        }
        return $result;
    }

    function after_checkout_order_review_item($cartItem) {
        //$this->log('after_checkout_order_review_item ' . print_r($cartItem, true));

        if ($cartItem['product_id'] != EVENT_DEPOSIT || empty($cartItem['ac_token']))
            return;



        if ($token = $cartItem['ac_token']) {

            $fields = get_option($token, false);
            if ($fields && !empty($fields['location_email'])) {
                $fields = apply_filters('tx_event_deposit_public_fields', $fields, ['location_name', 'location_phone', 'location_website', 'location_email', 'deposit_amount', 'url']);
                //$this->log("after_checkout_order_review_item fields " . print_r($fields, true));
                echo '<div style="padding-left:15px;border-bottom: 1px solid rgba(0,0,0,.1);padding-bottom:20px;">';
                foreach ($fields as $key => $val) {

                    echo '<p style="margin-bottom:3px;">' . $key . ': <b>' . $val . '</b></p>';
                }
                echo '</div>';
            }
        }
    }

    function return_custom_price($price, $product) {

        if (!WC()->session)
            return $price;

        $dynamic_price = WC()->session->get('event_deposit_price');
        //var_dump($dynamic_price);exit;

        if ($dynamic_price && $product->get_id() == EVENT_DEPOSIT)
            return $dynamic_price;
        return $price;
    }

    /**
     * Add custom meta to order
     */
    function checkout_create_order_line_item($item, $cart_item_key, $values, $order) {
        if (isset($values['ac_token'])) {
            $item->add_meta_data(
                    __('ac_token', 'tx'),
                    $values['ac_token'],
                    true
            );


            if ($fields = get_option($values['ac_token'], false)) {
                foreach ($fields as $key => $field) {
                    if ($key == 'depoist_amount')
                        update_post_meta($order->get_id(), 'depoist_amount', $field);
                    $item->add_meta_data(
                            $key,
                            $field,
                            true
                    );
                }
            }
        }
    }

    function new_order($order_id) {
        $this->log('new_order ' . $order_id);
        if ($item = $this->order_is_event_deposit(wc_get_order($order_id))) {
            $this->log('is deposit');
            $item_id = array_key_first($item);
            if ($token = wc_get_order_item_meta($item_id, 'ac_token', true)) {
                $fields = get_option($token, false);
                wc_update_order_item_meta($item_id, 'ac_token_bk', $token);
                wc_delete_order_item_meta($item_id, 'ac_token');
                $fields['url'] = false;
                update_option($token, $fields);
            }
        }
    }

    function process_denied_by_clearsale_email($item) {
        $this->log("process_denied_by_clearsale_email " . $item->get_id());


        $token = wc_get_order_item_meta($item->get_id(), 'ac_token_bk', true);
        if ($token) {
            $this->log("process_denied_by_clearsale_email token " . $token);
            $fields = get_option($token, false);
            $this->log("process_denied_by_clearsale_email fields " . print_r($fields, true));
            $order = $item->get_order();
            if ($fields && !empty($fields['location_email'])) {
                $originalFields = $fields;
                $this->log("process_denied_by_clearsale_email fields " . print_r($fields, true));
                $customer_email = $order->get_billing_email();
                $order_data = $order->get_data();
                $body = include(get_template_directory() . '/emails/denied-by-clearsale-retry-edeposit.php');
                $toEmail = $customer_email;
                //$toEmail = 'franworkspace@gmail.com';//*************************************
                $this->log($order->get_id() . " process_denied_by_clearsale_email to: " . $toEmail);
                $subject = "Action Required: There's been an issue with your recent order";
                $headers[] = 'Cc: ' . $originalFields['location_email'];
                wp_mail($toEmail, $subject, $body, $headers);
                $this->adminNotify($order->get_id());
            }
            //delete_option($token);
        }
    }

    function adminNotify($order_id) {
        $body = 'Order deposit: ' . $order_id . ' denied by clear sale https://texasdebrazil.com/wp-admin/post.php?post=' . $order_id . '&action=edit';
        $subject = 'Order deposit: ' . $order_id . ' denied by clear sale';
        $emailTo = 'jadizzedin@texasdebrazil.com';
        wp_mail($emailTo, $subject, $body);
    }

    function send_receipt_email($order) {
        global $wpdb;
        $item_id = 0;
        $items = $order->get_items();
        foreach ($items as $item_id => $item) {
            if (EVENT_DEPOSIT == $item->get_product_id()) {
                break;
            }
        }
        //$this->log("notifyRecipientOrderDetails item_id " . $item_id);
        $token = wc_get_order_item_meta($item_id, 'ac_token_bk', true);
        if ($token) {
            //$this->log("notifyRecipientOrderDetailsd token " . $token);
            $fields = get_option($token, false);
            //$this->log("notifyRecipientOrderDetails fields " . print_r($fields, true));
            if ($fields && !empty($fields['location_email'])) {
                $originalFields = $fields;
                //$this->log("notifyRecipientOrderDetails fields " . print_r($fields, true));
                $customer_email = $order->get_billing_email();
                $order_data = $order->get_data();
                $body = include(get_template_directory() . '/emails/event-deposit/order-detail.php');
                $toEmail = $customer_email;
                //$toEmail = 'franworkspace@gmail.com';//*************************************
                //$this->log($order->get_id() . " notifyRecipientOrderDetails to: " . $toEmail);
                $subject = 'Order #' . $order->get_id() . ' Receipt';
                $headers[] = 'Bcc: ' . $originalFields['location_email'];
                wp_mail($toEmail, $subject, $body, $headers);
            }
            //delete_option($token);
        }
    }

    function generate_pdf_card_email($cardNumber, $regCode, $amount, $item_id, $pdf_generate) {
        $this->log('generate_pdf_card_email');
        $orderItem = new WC_Order_Item_Data_Store();
        $orderId = $orderItem->get_order_id_by_order_item_id($item_id);
        $order = wc_get_order($orderId);
        $toEmail = $order->get_billing_email();
        $guestEmail = wc_get_order_item_meta($item_id, 'guest_email', true);
        $toGuestEmail = ($guestEmail != $toEmail) ? $guestEmail : '';
        $amount = wc_get_order_item_meta($item_id, 'deposit_amount', true);

        $this->log('generate_pdf_card_email $item_id: ' . $item_id);

        $page = include(get_template_directory() . '/emails/event-deposit/card-template.php');
        $pdf_generate->generatePdf($page);
    }

    function send_card_email($cardNumber, $regCode, $amount, $item_id, $print_pdf) {
        $this->log('send_card_email');
        $orderItem = new WC_Order_Item_Data_Store();
        $orderId = $orderItem->get_order_id_by_order_item_id($item_id);
        $order = wc_get_order($orderId);
        $toEmail = $order->get_billing_email();
        $guestEmail = wc_get_order_item_meta($item_id, 'guest_email', true);
        $toGuestEmail = ($guestEmail != $toEmail) ? $guestEmail : '';
        $subject = wc_get_order_item_meta($item_id, 'guest_name', true) . ', your event at Texas de Brazil is confirmed!';
        $amount = wc_get_order_item_meta($item_id, 'deposit_amount', true);

        if ($cardNumber == 'TEST15700020013' && $regCode == 'TEST6') {
            $this->log('send_card_email TEST15700020013');
            $id = $orderId . '-' . $item_id . '-card';
            require_once get_template_directory() . '/inc/functions.php';
            $id = urlencode(\Inc\TxFunctions\encrypt($id));
            if ($print_pdf && !$this->isIcloudEmail($toEmail) && !$this->isIcloudEmail($toGuestEmail)) {
                $this->log('send_card_email $print_pdf');
            } else {
                $print_pdf = false;
            }
            $showPdfLink = $print_pdf;
            $body = include(get_template_directory() . '/emails/event-deposit/card-template.php');
        } else {
            $this->log('send_card_email NOOOO TEST15700020013');
            $id = $cardNumber . $regCode;
            $id = preg_replace('/\s+/', '', $id);

            if ($print_pdf && !$this->isIcloudEmail($toEmail) && !$this->isIcloudEmail($toGuestEmail)) {
                $filePathName = WP_CONTENT_DIR . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                $fileUrlName = WP_CONTENT_URL . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                $showPdfLinks = false;
                $page = include(get_template_directory() . '/emails/event-deposit/card-template.php');
                file_put_contents($filePathName, $page);
            } else {
                $print_pdf = false;
            }
            $showPdfLinks = $print_pdf;
            $body = include(get_template_directory() . '/emails/event-deposit/card-template.php');
        }



        //$toEmail = 'franworkspace@gmail.com'; //*************************************
        $this->log("send_card_email orderId " . $orderId . ' To: ' . $toEmail);

        if ($this->test) {
            $headers[] = 'Bcc: fmdavodafone1@gmail.com' . $toGuestEmail;
            if ($toGuestEmail)
                $headers[] = 'Cc: ' . $toGuestEmail;
        } else {
            $headers[] = 'Bcc: onlineorders@texasdebrazil.com';
            if ($toGuestEmail)
                $headers[] = 'Cc: ' . $toGuestEmail;
        }
        //$headers[] = 'Bcc: fmdavodafone1@gmail.com, fmc03@hotmail.es';
        wp_mail($toEmail, $subject, $body, $headers);
        //$this->storePostmarkMessageId($toEmail, $orderId, 'PaytronixCardNumber: '.$cardNumber, $item_id);
        //do_action('store_postmark_message_id', $toEmail, $orderId, 'PaytronixCardNumber: ' . $cardNumber, $item_id);
        do_action('queue_postmark_message_id', $toEmail, $orderId);
    }

    function send_card_manually_email($toEmail, $cardNumber, $regCode, $amount, $item_id) {
        $orderItem = new WC_Order_Item_Data_Store();
        $orderId = $orderItem->get_order_id_by_order_item_id($item_id);

        $guestEmail = wc_get_order_item_meta($item_id, 'guest_email', true);
        $toGuestEmail = ($guestEmail != $toEmail) ? $guestEmail : '';
        $subject = wc_get_order_item_meta($item_id, 'guest_name', true) . ', your event at Texas de Brazil is confirmed!';

        if ($cardNumber == 'TEST2513195965' && $regCode == '7181') {
            $id = $orderId . '-' . $item_id . '-card';
            require_once get_template_directory() . '/inc/functions.php';
            $id = urlencode(\Inc\TxFunctions\encrypt($id));
            if ($print_pdf && !$this->isIcloudEmail($toEmail) && !$this->isIcloudEmail($toGuestEmail)) {
                
            } else {
                $print_pdf = false;
            }
            $showPdfLink = $print_pdf;
            $body = include(get_template_directory() . '/emails/event-deposit/card-template.php');
        } else {

            $id = $cardNumber . $regCode;
            $id = preg_replace('/\s+/', '', $id);

            if (!$this->isIcloudEmail($toEmail) && !$this->isIcloudEmail($toGuestEmail)) {
                $filePathName = WP_CONTENT_DIR . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                $fileUrlName = WP_CONTENT_URL . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                $showPdfLinks = false;
                $page = include(get_template_directory() . '/emails/event-deposit/card-template.php');
                file_put_contents($filePathName, $page);
            } else {
                $print_pdf = false;
            }
            $showPdfLinks = $print_pdf;
            $body = include(get_template_directory() . '/emails/event-deposit/card-template.php');
        }




        //$toEmail = 'franworkspace@gmail.com'; //*************************************
        $this->log("send_card_email orderId " . $orderId . ' To: ' . $toEmail);

        if ($this->test) {
            $headers[] = 'Bcc: fmdavodafone1@gmail.com' . $toGuestEmail;
            if ($toGuestEmail)
                $headers[] = 'Cc: ' . $toGuestEmail;
        } else {
            $headers[] = 'Bcc: onlineorders@texasdebrazil.com';
            if ($toGuestEmail)
                $headers[] = 'Cc: ' . $toGuestEmail;
        }
        //$headers[] = 'Bcc: fmdavodafone1@gmail.com, fmc03@hotmail.es';
        wp_mail($toEmail, $subject, $body, $headers);
        //$this->storePostmarkMessageId($toEmail, $orderId, 'PaytronixCardNumber: '.$cardNumber, $item_id);
        //do_action('store_postmark_message_id', $toEmail, $orderId, 'PaytronixCardNumber: ' . $cardNumber, $item_id);
        do_action('queue_postmark_message_id', $toEmail, $orderId);
    }

    function event_deposit_generate_link() {
        //Guest Name, Guest Email, Guest Phone, Location, Location Phone number, Date of Event, start/end time of event, nature of event, Number of people, package ordered, deposit amount, Manager name & manager email
//        $fields = !empty($_POST['guest_name']) && !empty($_POST['guest_email']) && !empty($_POST['guest_phone']) && !empty($_POST['location']) && !empty($_POST['location_phone']) && !empty($_POST['date_event']) &&
//                !empty($_POST['start_end_time_event']) && !empty($_POST['nature_of_event']) && !empty($_POST['no_of_pople']) && !empty($_POST['package_ordered']) && !empty($_POST['deposit_amount']) && !empty($_POST['manager_name_and_email']);
        $fields = [];
        if (!empty($_POST['password']) && 'MXmUkqfgy3vktIu' == $_POST['password']) {
            if (!empty($_POST['user_email']) && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['deposit_amount']) && $this->isValidAmount($_POST['deposit_amount'])) {


                foreach ($this->fields as $field) {
                    if (empty($_POST[$field])) {
                        $fieldText = str_replace('_', ' ', $field);
                        wp_send_json([
                            'success' => 'false',
                            'message' => 'Invalid request data, ' . ucfirst($fieldText) . ' field is required field'
                                ], 400);
                    }
                    $fields[$field] = $_POST[$field];
                }
                $fields['url'] = time();


                $token = 'AC_' . time() . rand(0, 9999);
                update_option($token, $fields);
                $linkUrl = get_bloginfo('url') . '/automatic-checkout/?amount=' . $_POST['deposit_amount'] . '&token=' . $token;
                $body = include(get_template_directory() . '/emails/event-deposit/link-url.php');
                $sent = wp_mail($_POST['user_email'], 'Event deposit link - ' . $fields['guest_name'], $body);


                $return = array(
                    'success' => 'true',
                    'data' => $linkUrl
                );
                wp_send_json($return, 200);
            } else {
                $return = array(
                    'success' => 'false',
                    'message' => 'email not sent, enter a valid email and valid amount value'
                );
                wp_send_json($return, 400);
            }
        }
        wp_send_json([
            'success' => 'false',
            'message' => 'Unauthorized'
                ], 401);
    }

    private function isValidAmount($amount) {
        return floatval($amount);
        //return !empty($this->validAmounts[$amount]);
    }

    public function addItemToCart($data) {
        //var_dump(get_option($data['token']));exit;
        $amount = $this->isValidAmount($data['amount']);
        $fields = get_option($data['token']);
        if (!empty($fields['url']) && intVal($fields['url']) && strtotime('- 7 days') < $fields['url'] && !empty($data['token']) && !empty($fields['deposit_amount']) && $fields['deposit_amount'] == $amount) {
            WC()->session->set('event_deposit_price', $amount);
            WC()->cart->empty_cart();
            WC()->cart->add_to_cart(EVENT_DEPOSIT, 1, 0, [], ['ac_token' => $data['token']]);
            //var_dump(EVENT_DEPOSIT,$this->validAmounts[$data['amount']]);
            wp_redirect(wc_get_checkout_url());
        }
    }

}

if (empty($_GET['tttttt']))
    $GLOBALS['autCheckout'] = new AutomaticCheckout();

