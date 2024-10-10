<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthReversal48hDelay
 *
 * @author USER
 */
class AuthReversal48hDelay {

    private static $initiated = false;
    private static $cron_table = 'pFXR8TXq7_failed_orders';

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    private static function init_hooks() {
        self::$initiated = true;
        global $wpdb;
        self::$cron_table = $wpdb->prefix . 'failed_orders';

        add_action('wp', array('AuthReversal48hDelay', 'cronstarter_activation'));
        add_filter('cron_schedules', array('AuthReversal48hDelay', 'cron_add_time'), 10, 1);
        add_action('mycronjobtime_everyhour', array('AuthReversal48hDelay', 'trigger_cron'));
        //add_action('cybersource_mark_order_as_failed', ['AuthReversal48hDelay', 'queue_failed_order'], 10, 2);
        add_action('woocommerce_order_status_denied-clearsale', ['AuthReversal48hDelay', 'queue_failed_order'], 10, 1);
        //woocommerce_order_status_completed

        if (!empty($_GET['reverse_transaction'])) {
            error_log('reverse_transaction');
            add_action('template_redirect', array('AuthReversal48hDelay', 'trigger_cron'));
        }

        if (!empty($_GET['refund_transaction'])) {
            error_log('refund_transaction');
            add_action('template_redirect', array('AuthReversal48hDelay', 'trigger_cron'));
        }

        if (!empty($_GET['retreive_transactions'])) {
            error_log('retreive_transaction');
            add_action('template_redirect', array('AuthReversal48hDelay', 'retreive_transaction'));
        }
    }

    public static function cronstarter_activation() {
        if (!wp_next_scheduled('mycronjobtime_everyhour')) {
            wp_schedule_event(time(), 'everyhour', 'mycronjobtime_everyhour');
        }
    }

    public static function cron_add_time($schedules) {
        $schedules['everyhour'] = array(
            'interval' => (60 * 2),
            'display' => __('Hourly')
        );
        return $schedules;
    }

    public static function trigger_cron() {
        error_log('AuthReversal48hDelay: trigger_cron called:');
        global $wpdb;
        $items = $wpdb->get_results("SELECT data,created_at FROM " . self::$cron_table . " where created_at < " . time() - (DAY_IN_SECONDS * 3) . ' limit 1');
        if (!$items) {
            return;
        }
        foreach ($items as $item) {
            self::reverse_transaction($item);
            //self::refund_transaction($item);
        }
    }

    public static function queue_failed_order($order_id) {
        global $wpdb;



        $order = wc_get_order($order_id);
        //wp_mail('franworkspace@gmail.com', 'queue_failed_order', 'order ' . $order_id . ' Status: ' . $order->get_status());
        if ('denied-clearsale' != $order->get_status())
            return;

        //Soft Decline

        if ($id = get_post_meta($order_id, '_wc_cybersource_credit_card_trans_id')) {
            $data = [
                'id' => get_post_meta($order_id, '_wc_cybersource_credit_card_trans_id'),
                'code' => $order_id,
                'reason' => 'Authorization_reversal',
                'total' => $order->get_total(),
            ];
            //wp_mail('franworkspace@gmail.com', 'queue_failed_order', 'order ' . $order_id . ' Data: ' . print_r($data, true));
            $wpdb->insert(self::$cron_table, array('data' => json_encode($data), 'created_at' => time()));
            error_log('AuthReversal48hDelay: queue_failed_order Soft: ' . print_r(['data' => $data], true));
        } else {
            //wp_mail('franworkspace@gmail.com', 'queue_failed_order', 'order ' . $order_id . ' Data: Empty');
        }
    }

    private static function refund_transaction($item) {
        global $wpdb;
        if ($data = json_decode($item->data, true)) {
            //wp_mail('franworkspace@gmail.com', 'AuthReversal48hDelay reverse_transaction item:', 'Data ' . print_r($data, true));
            error_log('AuthRefund refund_transaction item: ' . print_r([$item, $data, $data['id'][0]], true));

            include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/TransactionDetails/RetrieveTransaction_.php');
            include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/Payments/Refund/RefundPayment_.php');



            $reansaction = RetrieveTransaction($data['id'][0] . '');
            $data['client_inf'] = $reansaction[0]->getClientReferenceInformation();
            $data['amount_details'] = $reansaction[0]->getOrderInformation()->getAmountDetails();

            $result = RefundPayment($data);

            $order = wc_get_order($data['code']);
            if ($result) {
                //wp_mail('franworkspace@gmail.com', 'refund_transaction success', 'order ' . $item->code);
                //$order->add_order_note(sprintf(esc_html__('(Authorization Reversal for Transaction ID %s)', 'woocommerce-plugin-framework'), $data['id'][0]));
                $order->add_order_note(esc_html__('(Authorization Refund for Transaction ID ' . $data['id'][0] . ' Completed)', 'woocommerce-plugin-framework'));
            } else {
                $order->add_order_note(esc_html__('(Refund for Transaction ID ' . $data['id'][0] . ' Failed)', 'woocommerce-plugin-framework'));
                // wp_mail('franworkspace@gmail.com', 'reverse_transaction failed', 'order ' . $item->code);
            }
            $wpdb->delete(self::$cron_table, array('created_at' => $item->created_at));
        } else {
            error_log('AuthReversal48hDelay refund_transaction item no json: ' . print_r($data, true));
        }
    }

    private static function reverse_transaction($item) {
        global $wpdb;
        if ($data = json_decode($item->data, true)) {
            //wp_mail('franworkspace@gmail.com', 'AuthReversal48hDelay reverse_transaction item:', 'Data ' . print_r($data, true));
            error_log('AuthReversal48hDelay reverse_transaction item: ' . print_r($data, true));
            include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/Payments/Reversal/ProcessAuthorizationReversal.php');
            include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/TransactionDetails/RetrieveTransaction_.php');


            $reansaction = RetrieveTransaction($data['id'][0] . '');
            $data['client_inf'] = $reansaction[0]->getClientReferenceInformation();
            $data['amount_details'] = $reansaction[0]->getOrderInformation()->getAmountDetails();
            $data['reason'] = 'Authorization_reversal';

            //\CyberSourceApi\Model\TssV2TransactionsGet200ResponseOrderInformation::class;
            $result = ProcessAuthorizationReversal($data);

            if ($result) {
                //wp_mail('franworkspace@gmail.com', 'reverse_transaction success', 'order ' . $item->code);
                $order = wc_get_order($data['code']);
                //$order->add_order_note(sprintf(esc_html__('(Authorization Reversal for Transaction ID %s)', 'woocommerce-plugin-framework'), $data['id'][0]));
                $order->add_order_note(esc_html__('(Authorization Reversal for Transaction ID ' . $data['id'][0] . ' Completed)', 'woocommerce-plugin-framework'));
                $order->update_status('cancelled');
            } else {
                //wp_mail('franworkspace@gmail.com', 'reverse_transaction failed', 'order ' . $item->code);
            }
            $wpdb->delete(self::$cron_table, array('created_at' => $item->created_at));
        } else {
            error_log('AuthReversal48hDelay reverse_transaction item no json: ' . print_r($data, true));
        }
    }

    public static function retreive_transaction() {
        include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/Payments/Reversal/ProcessAuthorizationReversal.php');
        include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/TransactionDetails/RetrieveTransaction_.php');
        $id = '6935039120586927004975';
        $reansaction = RetrieveTransaction($id);
        //var_dump($reansaction);exit;

        $data['id'] = $id;

        $data['client_inf'] = $reansaction[0]->getClientReferenceInformation();
        $data['amount_details'] = $reansaction[0]->getOrderInformation()->getAmountDetails();

        $data['reason'] = 'Authorization_reversal';

        $result = ProcessAuthorizationReversal($data);
        var_dump($result);

        //var_dump($result->getClientReferenceInformation());        exit();
        //CyberSourceApi\Model\TssV2TransactionsGet200Response::class;
    }

}
