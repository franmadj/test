<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderCardActions
 *
 * @author USER
 */
class OrderCardActions {

    private static $initiated = false;

    public static function init() {
        if (!self::$initiated) {
            self::$initiated = true;
            (new self)->initHooks();
        }
    }

    public function initHooks() {
        add_action('woocommerce_order_actions', [$this, 'addOrderMetaBoxActions']);

        add_action('woocommerce_order_action_resend_order_receipt', [$this, 'resendOrderReceipt']);
        add_action('woocommerce_order_action_generate_e_cards', [$this, 'generateEcards']);
        add_action('woocommerce_order_action_resend_cards', [$this, 'resendCards']);
        add_action('woocommerce_order_action_resend_refund_order', [$this, 'resendRefundOrder']);
        add_action('woocommerce_order_action_resend_all_order_emails', [$this, 'resendAllOrderEmails']);
        add_action('woocommerce_order_action_resend_all_order_emails_no_pdf', [$this, 'resendAllOrderEmailsNoPdf']);
        //add_action('woocommerce_order_action_recreate_standard_cards', [$this, 'recreateStandardCardsAndSend'], 10, 1);
        //add_action('woocommerce_order_action_recreate_bonus_cards', [$this, 'recreateBonusCardsAndSend'], 10, 1);
        add_action('admin_footer', [$this, 'admin_footer']);
        add_action('wp_ajax_nopriv_resend_item_cards', [$this, 'resend_item_cards']);
        add_action('wp_ajax_resend_item_cards', [$this, 'resend_item_cards']);
    }

    public function addOrderMetaBoxActions($actions) {
        $actions['resend_all_order_emails'] = __('Send all order emails', 'woocommerce'); //Re-send all order emails
        $actions['resend_all_order_emails_no_pdf'] = __('Send all order emails (no print feature)', 'woocommerce'); //Re-send all order emails
        $actions['resend_order_receipt'] = __('Send receipt email only', 'woocommerce');
        $actions['generate_e_cards'] = __('Generate Missing Cards (generate any card that\'s missing on the order)', 'woocommerce');
        $actions['resend_cards'] = __('Resend cards', 'woocommerce');
        $actions['resend_refund_order'] = __('Resend refund order', 'woocommerce');

//        $actions['recreate_standard_cards'] = __('Generate e-cards and send', 'woocommerce');
//        $actions['recreate_bonus_cards'] = __('Generate bonus cards and send', 'woocommerce');
        return $actions;
    }

    function resendCards($order) {
        require_once('inc/SendCards.class.php');
        $sendCards = new SendCards($order->get_id());
        $sendCards->sendPaytronixCards([], false);
        $sendCards->sendBonusCards([], false);
        $order->add_order_note(__('Send all order cards', 'woocommerce'), false, true);
    }

    function resend_item_cards() {
        if (!empty($_POST['item_id']) && !empty($_POST['post_id'])) {
            $order = wc_get_order($_POST['post_id']);

            require_once('inc/SendCards.class.php');
            $sendCards = new SendCards($_POST['post_id']);
            $sendCards->sendPaytronixCards([$_POST['item_id']], true);
            $sendCards->sendBonusCards([$_POST['item_id']], true);
            $order->add_order_note(__('Send all item cards', 'woocommerce'), false, true);
        }
        wp_die('ok');
    }

    function admin_footer() {
        global $current_screen;
        if ($current_screen->id == 'shop_order') {
            ?>
            <script>
                jQuery(document).ready(function ($) {
                    $('#order_line_items .item').each(function () {
                        const itemId = $(this).data('order_item_id');
                        const tr = $(this).find('.name .display_meta').find('tr').last().find('td');
                        console.log('tr', tr);
                        tr.css({'display': 'flex', 'justify-content': 'space-between'}).append(`<button type="button" class="button resend-item-cards" data-id="${itemId}">Re-Send Cards</button>`);
                    })
                    $('.resend-item-cards').click(function () {
                        const data = `action=resend_item_cards&post_id=${$('#post_ID').val()}&item_id=${$(this).data('id')}`;
                        const button = $(this);
                        $.ajax({
                            type: "POST",
                            url: '/wp-admin/admin-ajax.php',
                            data: data,
                            success: function (data)
                            {
                                if ('ok' == data) {
                                    button.attr('disabled', true).html('Sent!')

                                } else {


                                }
                            }
                        });
                    })
                });
            </script>
            <?php

        }
    }

    protected function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/'.date('Y_m_d').'_cards-debug.log');
        error_log('----------OrderCardActions: ' . $value);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_debug.log');
    }

    function resendAllOrderEmails($order) {
        $this->resendOrderReceipt($order);
        $this->resendEcards($order);
        $this->resendBonusCards($order);
        $order->add_order_note(__('Send all order emails', 'woocommerce'), false, true);
    }

    function resendAllOrderEmailsNoPdf($order) {
        $this->resendOrderReceipt($order);
        $this->resendEcards($order, false);
        $this->resendBonusCards($order, false);
        $order->add_order_note(__('Send all order emails (no print feature)', 'woocommerce'), false, true);
    }

    function generateEcards($order) {
        global $wpdb;
        require_once('inc/GenerateCards.class.php');
        $GenerateCards = new GenerateCards($order->get_id());
        $GenerateCards->generatePaytronixCards();
        $GenerateCards->generateBonusCards();
        $wpdb->delete($wpdb->prefix.'cronjob', array('order_id' => $order->get_id()));
        $order->add_order_note(__('Generate Missing Cards (generate any card that\'s missing on the order)', 'woocommerce'), false, true);
    }

//    function recreateStandardCardsAndSend($order) {
//        require_once('inc/GenerateCards.class.php');
//        $GenerateCards = new GenerateCards($orderId);
//        $GenerateCards->generatePaytronixCards();
//        require_once('inc/SendCards.class.php');
//        $sendCards = new SendCards($orderId);
//        $sendCards->sendPaytronixCards();
//    }
//
//    function recreateBonusCardsAndSend($order) {
//        require_once('inc/GenerateCards.class.php');
//        $GenerateCards = new GenerateCards($orderId);
//        $GenerateCards->generateBonusCards();
//        require_once('inc/SendCards.class.php');
//        $sendCards = new SendCards($orderId);
//        $sendCards->sendBonusCards();
//    }

    public function resendRefundOrder($order) {
        $this->log('resendRefundOrder');
        require_once('inc/SendCards.class.php');
        $sendCards = new SendCards($order->get_id());
        $sendCards->sendRefundOrder();
        $order->add_order_note(__('Resend order refund manually to customer.', 'woocommerce'), false, true);
    }

    public function resendOrderReceipt($order) {
        $this->log('resendOrderReceipt');
        require_once('inc/SendCards.class.php');
        $sendCards = new SendCards($order->get_id());
        $sendCards->sendOrderDetails();
        $order->add_order_note(__('Resend Order Receipt manually to customer.', 'woocommerce'), false, true);

    }

    public function resendEcards($order, $printPdf = true) {
        $this->log('resendEcards');
        require_once('inc/SendCards.class.php');
        $sendCards = new SendCards($order->get_id());
        $sendCards->sendPaytronixCards([], $printPdf);
        //$order->add_order_note(__('Resend E-Cards manually to customer.', 'woocommerce'), false, true);

    }

    public function resendBonusCards($order, $printPdf = true) {
        $this->log('resendBonusCards');
        require_once('inc/SendCards.class.php');
        $sendCards = new SendCards($order->get_id());
        $sendCards->sendBonusCards([], $printPdf);
        //$order->add_order_note(__('Resend Bonus Cards manually to customer.', 'woocommerce'), false, true);
    }

}

OrderCardActions::init();
