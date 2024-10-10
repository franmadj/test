<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CronProcessOrders
 *
 * @author USER
 */
class CronProcessOrders {

    private static $initiated = false;
    private $cronTable = 'texas_cronjob';
    private $testOrderId = 423899;

    //private $bonus

    public static function init() {
        if (!self::$initiated) {
            self::$initiated = true;
            (new self)->initHooks();
        }
    }

    private function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/cards-debug.log');
        error_log('----------CronProcessOrders: ' . $value);
    }

    /**
     * Initializes WordPress hooks
     */
    private function initHooks() {
        
        global $wpdb;
        $this->cronTable = $wpdb->prefix . 'cronjob';

        if (isset($_GET['insertinto5'])) {
            $e = $wpdb->insert($this->cronTable, array('id' => '', 'order_id' => 423899, 'bonus_cards' => ''));
            var_dump($e);
            exit;
        }
        if (isset($_GET['sendemail'])) {
            $s = wp_mail('franworkspace@gmail.com', 'hey', 'body');
            var_dump($s);
            exit;
        }
        



        add_action('woocommerce_order_status_completed', array($this, 'newOrderComplated'), 1, 1);
        add_action('woocommerce_order_status_processing', array($this, 'newOrdeProcessing'), 1, 1);

        add_filter('cron_schedules', array($this, 'cronAddMinute'), 10, 1);
        add_action('wp', array($this, 'cronstarterActivation'));
        if (isset($_GET['triger-cron-px'])) {
            add_action('init', array($this, 'triggerCron'));
        } else {
            add_action('mycronjobtimeminutecustom', array($this, 'triggerCron'));
        }
    }

    public function newOrderComplated($orderId) {
        $this->newOrder($orderId, 'completed');
    }

    public function newOrdeProcessing($orderId) {
        $this->newOrder($orderId, 'processing');
    }

    function newOrder($orderId, $status) {
        if ($this->testOrderId != $orderId)
            return;
        $this->log('newOrder');
        global $wpdb;
        $order = wc_get_order($orderId);
        if ('completed' == $status) {
            if ($this->orderRequiresShipping($order))
                return;
            $this->log("New Completed OrderId $orderId");
        }
        if ('processing' == $status) {
            if (!$this->orderRequiresShipping($order))
                return;
            $this->log("New Processing OrderId $orderId");
        }
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $this->cronTable WHERE order_id=" . $orderId);
        if ($count == 0):
            $this->log("Created cron job for $orderId");
            $wpdb->insert($this->cronTable, array('id' => '', 'order_id' => $orderId, 'bonus_cards' => ''));
        else:
            $this->log($orderId . " cron Already created");
        endif;
    }

    public function triggerCron() {
        $this->log('triggerCron called:');
        //$this->filterExecutionBySetOfSeconds([49, 50, 51, 52, 53, 54, 55]);
        $orderId = $this->getNextOrderToProcess();
        if ($this->testOrderId != $orderId)
            return;
        $this->log('triggerCron called order: ' . $orderId);
        //$this->subscribeMarketing($orderId);

        require_once('inc/GenerateCards.class.php');
        $GenerateCards = new GenerateCards($orderId);
        $GenerateCards->generatePaytronixCards();
        $GenerateCards->generateBonusCards();
        require_once('inc/SendCards.class.php');
        $sendCards = new SendCards($orderId);
        $sendCards->sendPaytronixCards();
        $sendCards->sendBonusCards();
        $sendCards->sendOrderDetails();
        $this->deleteOrderCrone($orderId);
        $this->log('End processing--------------------------------------------------------------------: ' . $orderId);
    }

    private function filterExecutionBySetOfSeconds(Array $setOfSeconds) {
        if (!in_array(date('s'), $setOfSeconds)) {
            error_log('trigger_cron called: not allow sec: ' . date('s'));
            wp_die();
        }
    }

    private function getNextOrderToProcess() {
        global $wpdb;
        $ordersToExclude = 0;
        $orderId = $wpdb->get_var("SELECT order_id FROM $this->cronTable where order_id not in($ordersToExclude) order by order_id ASC limit 1");

        if (!$orderId) {
            $this->log("no cron jobs wp_die..");
            update_option('orders_croned', '');
            wp_die();
        }


        $ordersCroned = false;
        get_option('orders_croned', '');

        if (is_array($ordersCroned)) {
            if (in_array($orderId, $ordersCroned)) {
                if ($attempts = get_post_meta($orderId, 'trigger_cron_attempts', true)) {
                    if ($attempts > 4) {
                        wp_mail('franworkspace@gmail.com', 'ERROR TDB TRIGGER CRON ATTEMPTS', 'There has been more than 5 attempts for order ' . $orderId . ', create these cards manually. https://texasdebrazil.com/wp-admin/post.php?post=' . $orderId . '&action=edit');
                        //wp_mail('jadizzedin@texasdebrazil.com, matt@thriveground.com, franworkspace@gmail.com', 'ERROR TDB TRIGGER CRON ATTEMPTS', 'There has been more than 5 attempts for order ' . $orderId . ', create these cards manually. https://texasdebrazil.com/wp-admin/post.php?post=' . $orderId . '&action=edit');
                        $this->deleteOrderCrone($orderId);
                        $this->log("ERROR TDB TRIGGER CRON ATTEMPTS: " . $orderId);
                        unset($ordersCroned[$orderId]);
                        update_option('orders_croned', $ordersCroned);
                    } else {
                        $attempts++;
                        update_post_meta($orderId, 'trigger_cron_attempts', $attempts);
                    }
                } else {
                    update_post_meta($orderId, 'trigger_cron_attempts', 1);
                }
                $this->log("trigger_cron $orderId already processed");
                $processed = true;
                wp_die();
            } else {
                $ordersCroned[] = $orderId;
            }
        } else {
            $ordersCroned = [$orderId];
        }
        update_option('orders_croned', $ordersCroned);
        return $orderId;
    }

    private function deleteOrderCrone($orderId) {
        global $wpdb;
        $this->log("deleteOrderCrone " . $orderId);
        $wpdb->delete($this->cronTable, array('order_id' => $orderId));
    }

    function subscribeMarketing($orderId) {
        $optMarketing = get_post_meta($orderId, 'optMarketing', true);
        if ($optMarketing == 'Yes') {
            $order = wc_get_order($orderId);
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
    }

    public function cronAddMinute($schedules) {
        $schedules['everyminutecustom'] = array(
            'interval' => (60),
            'display' => __('Once Every Minute')
        );
        return $schedules;
    }

    public function cronstarterActivation() {
        if (!wp_next_scheduled('mycronjobtimeminutecustom')) {
            wp_schedule_event(time(), 'everyminutecustom', 'mycronjobtimeminutecustom');
        }
    }

    public function orderRequiresShipping($order) {
        //wp_mail('franworkspace@gmail.com', 'new order', 'new order');
        $items = $order->get_items();
        foreach ($items as $item_id => $item) {
            $product_id = $item->get_product_id();
            $digitalProduct = get_field('digital_product', $product_id);
            if (!$digitalProduct) {
                return true;
            }
        }
        return false;
    }

}

CronProcessOrders::init();
