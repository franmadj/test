<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateCards
 *
 * @author USER
 */
class CreateCards {

    protected $apiNullResponse = 0;
    protected $themeId = 0;
    protected $orderId;
    public $cardsBonusTable;

    public function __construct($orderId) {
        global $wpdb;
        $this->orderId = $orderId;
        $this->cardsBonusTable = $wpdb->prefix . "bonuscard";
    }

    protected function log_($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        echo '<pre>';

        var_dump('----------CreateCards: ' . $value);
        echo '</pre>';
    }

    protected function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_cards-debug.log');
        error_log('----------CreateCards: ' . $value);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_debug.log');
    }

    public function isVipCard() {
        return strpos($this->slug, 'vip-dining-card') !== false;
    }

    public function isEVipCard() {
        return strpos($this->slug, 'e-vip-dining-card') !== false;
    }

    public function isEgiftCard() {
        return strpos($this->slug, 'e-gift-card') !== false;
    }

    public function isHolidayCard() {
        return strpos($this->slug, 'holiday') !== false;
    }

    public function isHolidayEgiftCard() {
        return strpos($this->slug, 'holiday-e-gift-card') !== false;
    }

    public function isEventDepoist() {
        $items = $this->order->get_items();
        return array_filter($items, function($item) {
            return EVENT_DEPOSIT == $item['product_id'];
        });
    }

    public function isProductSimple() {
        return $this->product->get_type() == 'simple';
    }

    public function isItemPromotion() {
        return get_field('is_promotion', $this->productId);
    }

    public function isDigitalProduct() {
        return get_field('digital_product', $this->productId);
    }

    public function isGiftedCardUser() {
        return (bool) ('Yes' == wc_get_order_item_meta($this->itemId, 'isGiftCard', true));
    }

    public function isIcloudEmail($email) {
        return stripos($email, '@icloud.com') !== FALSE && stripos($email, '@me.com') !== FALSE && stripos($email, '@mac.com') !== FALSE;
    }

    public function getItemPrice() {

        if ($this->isEventDepoist())
            return wc_get_order_item_meta($this->itemId, 'deposit_amount', true);
        //return get_item($this->productId, 'deposit_amount', true);

        return $this->item['line_total'] / $this->itemQty;
    }

    function setSlug() {
        $post = get_post($this->productId);
        $this->slug = $post->post_name;
    }

    protected function deleteCard($card) {
        global $wpdb;
        $this->log('Deleting card No.' . $card['number'] . ' from database...');
        $wpdb->delete($wpdb->prefix . 'paytronixgiftcards', array('cardNumber' => $card['number']));
    }

}
