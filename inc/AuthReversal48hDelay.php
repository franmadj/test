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
    private static $cron_table = 'failed_orders';

    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    private static function init_hooks() {
        self::$initiated = true;

        add_action('wp', array('AuthReversal48hDelay', 'cronstarter_activation'));
        add_filter('cron_schedules', array('AuthReversal48hDelay', 'cron_add_time'), 10, 1);
        add_action('mycronjobtimeday', array('AuthReversal48hDelay', 'trigger_cron'));

        add_action('cybersource_mark_order_as_failed', ['AuthReversal48hDelay', 'queue_failed_order'], 10, 2);
    }

    public static function cronstarter_activation() {
        if (!wp_next_scheduled('mycronjobtimeday')) {
            wp_schedule_event(time(), 'everyday', 'mycronjobtimeday');
        }
    }

    public static function cron_add_time($schedules) {
        error_log('$schedules: '.print_r($schedules, true));
        $schedules['everyday'] = array(
            'interval' => (DAY_IN_SECONDS),
            'display' => __('Once A day')
        );
        return $schedules;
    }

    public static function trigger_cron() {
        error_log('AuthReversal48hDelay: trigger_cron called:');
        global $wpdb;
        $items = $wpdb->get_results("SELECT data FROM " . self::$cron_table . " where created_at < " . time() - (DAY_IN_SECONDS * 2));
        if (!$items) {
            return;
        }
        foreach ($items as $item) {
            self::reverse_transaction($item->data);
        }
    }

    public static function queue_failed_order($order, $response) {
        global $wpdb;
        if (!empty($response->response_data->errorInformation->reason) && 'AVS_FAILED' == $response->response_data->errorInformation->reason) {
            //Soft Decline
            $data = [
                'id' => $response->response_data->id,
                'code' => $order->get_id(),
                'reason' => 'Authorization reversal',
                'total' => $order->get_total(),
            ];
            $wpdb->insert(self::$cron_table, array('data' => json_encode($data), 'created_at' => time()));
            error_log('AuthReversal48hDelay: queue_failed_order Soft: ' . print_r(['data' => $data], true));
        }
    }

    private static function reverse_transaction($data) {

        if ($data = json_decode($data, true)) {
            error_log('AuthReversal48hDelay reverse_transaction item: ' . print_r($data, true));
            ProcessAuthorizationReversal($data);
            $order = wc_get_order($data['code']);
            $order->add_order_note(sprintf(esc_html__('(Authorization Reversal for Transaction ID %s)', 'woocommerce-plugin-framework'), $data->id));
        } else {
            error_log('AuthReversal48hDelay reverse_transaction item no json: ' . print_r($data, true));
        }
    }

}
