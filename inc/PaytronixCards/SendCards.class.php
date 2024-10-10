<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CreateCards.class.php';

/**
 * Description of CreateCards
 *
 * @author USER
 */
class SendCards extends CreateCards {

    public function __construct($orderId) {
        parent::__construct($orderId);
    }

    public function sendPaytronixCards() {
        $this->order = wc_get_order($this->orderId);
        $this->log('sendPaytronixCards: ' . $this->orderId);
        $items = $this->order->get_items();
        $cardName = 'PaytronixCardNumber';
        $regName = 'paytronixRegCode';
        foreach ($items as $itemId => $item) {
            $this->productId = $productId = $item->get_product_id();
            $this->product = wc_get_product($productId);
            $this->item = $item;
            $this->itemId = $itemId;
            $this->themeId = $item['theme_id'];
            $this->setSlug();
            $this->itemQty = $item->get_quantity();
            $itemPrice = $this->getItemPrice();
            $billingEmail = $this->order->get_billing_email();
            $this->isGiftedCard = $this->isGiftedCard();
            $this->log('isGiftedCard: ' . $this->isGiftedCard);
            if ($this->isGiftedCard) {
                $this->log('isGiftedCard: ' . $this->orderId);
                $this->giftedName = $item['firstname'] . ' ' . $item['lastname'];
                $this->giftedMessage = $item['message'];
                $toEmail = $item['user_email'];
            } else {
                $toEmail = $billingEmail;
            }

            $cardnumbers = wc_get_order_item_meta($itemId, $cardName, true);
            if ($cardnumbers) {
                $cardnumbers = explode(', ', $cardnumbers);
            }
            $regcodes = wc_get_order_item_meta($itemId, $regName, true);
            if ($regcodes) {
                $regcodes = explode(', ', $regcodes);
            }

            if ($cardnumbers && is_array($cardnumbers) && $regcodes && is_array($regcodes)) {
                foreach ($cardnumbers as $key => $cardnumber) {
                    $regCode = $regcodes[$key];
                    $amount = $itemPrice;


                    if ($this->isEventDepoist()) {
                        do_action('tx_automatic_checkout_send_card_email', $cardnumber, $regCode, $amount, $itemId);
                        continue;
                    }
                    $subject = 'Your Texas de Brazil Gift Card sent by ' . $this->order->get_billing_email();

                    if ($this->isVipCard()) {
                        $subject = 'Your Texas de Brazil VIP Dining Card';
                        $body = include(dirname(__FILE__) . '/emails/paytronix/texas-email-template-vip-dinning-card.php');
                    } elseif (!$this->isIcloudEmail($toEmail) && $this->isHolidayCard()) {
                        $time = time();
                        $filePathName = WP_CONTENT_DIR . '/uploads/email-templates/texas-email-pdf-' . $time . '.html';
                        $fileUrlName = WP_CONTENT_URL . '/uploads/email-templates/texas-email-pdf-' . $time . '.html';
                        $showPdfLinks = false;
                        $page = include(dirname(__FILE__) . '/emails/paytronix/texas-email-template-test.php');
                        file_put_contents($filePathName, $page);
                        $showPdfLinks = true;
                        $body = include(dirname(__FILE__) . '/emails/paytronix/texas-email-template-test.php');
                    } else {
                        $body = include(dirname(__FILE__) . '/emails/paytronix/texas-email-template.php');
                    }

                    $this->sendEmail($toEmail, $subject, $body);
                }
            }
        }
    }

    public function sendBonusCards() {
        global $wpdb;
        $this->order = wc_get_order($this->orderId);
        $this->log('sendBonusCards: ' . $this->orderId);
        $items = $this->order->get_items();

        foreach ($items as $itemId => $item) {

            $this->productId = $productId = $item->get_product_id();
            $this->product = wc_get_product($productId);
            $this->item = $item;
            $this->itemId = $itemId;
            $this->setSlug();
            $this->itemQty = $item->get_quantity();


            //$data = array("id" => '', "order_id" => $orderId, "bonuscard_number" => $bonuscard1['number'], "reg_code" => $bonuscard1['regCode'], "amount" => 10, 'item_id' => $item_id);


            $cardsTf = $wpdb->get_results("SELECT * FROM $this->cardsBonusTable where item_id='$this->itemId' and amount=25", ARRAY_A);
            $cardsTen = $wpdb->get_results("SELECT * FROM $this->cardsBonusTable where item_id='$this->itemId' and amount=10", ARRAY_A);
            $cardnumbers = array_merge($cardsTf, $cardsTen);

            $this->log('$cardnumbers: ' . print_r($cardnumbers, true));




            if ($cardnumbers && is_array($cardnumbers)) {
                foreach ($cardnumbers as $key => $value) {
                    $regCode = $value['reg_code'];
                    $cardnumber = $value['bonuscard_number'];
                    $amount = $value['amount'];
                    $subject = 'Your Texas de Brazil Bonus Card';

                    if (!$this->isIcloudEmail($toEmail) && $this->isHolidayCard()) {
                        $ruleimage = home_url() . '/wp-content/uploads/2022/10/Holiday-Sale-ROU-2022.jpg';
                        $time = time();
                        $filePathName = WP_CONTENT_DIR . '/uploads/email-bonus-templates/texas-email-pdf-' . $time . '.html';
                        $fileUrlName = WP_CONTENT_URL . '/uploads/email-bonus-templates/texas-email-pdf-' . $time . '.html';
                        $showPdfLinks = false;
                        $page = include(dirname(__FILE__) . '/emails/bonus/texas-bonus-email-template-pdf.php');
                        file_put_contents($filePathName, $page);
                        $showPdfLinks = true;
                        $body = include(dirname(__FILE__) . '/emails/bonus/texas-bonus-email-template-pdf.php');
                    } else {
                        if ($amount == 25)
                            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/25-bonus_new.jpg';
                        elseif ($amount == 10)
                            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus_new.jpg';
                        else
                            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus_new.jpg';

                        $body = include(dirname(__FILE__) . '/emails/bonus/texas-bonus-email-template.php');
                    }

                    $toEmail = $this->order->get_billing_email();
                    $this->sendEmail($toEmail, $subject, $body);
                }
            }
        }
    }
    
    function sendRefundOrder() {
        global $wpdb;
        $this->order = $order = wc_get_order($this->orderId);

      
        $this->log('sendRefundOrder: ' . $this->orderId);
        $customer_email = $this->order->get_billing_email();
        $order_data = $this->order->get_data();
        $body = include(get_template_directory() . '/emails/customer-refunded-order.php');
        $toEmail = $customer_email;
        //$toEmail = 'franworkspace@gmail.com';//*************************************
        $this->log("$this->orderId sendRefundOrder to: " . $toEmail);
        $subject = 'Order #' . $this->orderId . ' Refund';
        $this->sendEmail($toEmail, $subject, $body);
    }

    function sendOrderDetails() {
        global $wpdb;
        $this->order = $order = wc_get_order($this->orderId);

        if ($this->isEventDepoist()) {
            $this->log('tx_automatic_checkout_send_receipt_email');
            do_action('tx_automatic_checkout_send_receipt_email', $order);
            return;
        }

        $this->log('sendOrderDetails: ' . $this->orderId);
        $customer_email = $this->order->get_billing_email();
        $order_data = $this->order->get_data();
        $body = include(get_template_directory() . '/emails/order-detail.php');
        $toEmail = $customer_email;
        //$toEmail = 'franworkspace@gmail.com';//*************************************
        $this->log("$this->orderId notifyRecipientOrderDetails to: " . $toEmail);
        $subject = 'Order #' . $this->orderId . ' Receipt';
        $this->sendEmail($toEmail, $subject, $body);
    }

    private function sendEmail($toEmail, $subject, $body) {
        $this->log('sendEmail: ' . $subject);
        $this->log("sending mail to--" . $toEmail);
        if ($toEmail)
            if (wp_mail($toEmail, $subject, $body)) {
                $this->log("Sent mail to--" . $toEmail);
                return true;
            } else {
                $this->log("Not Sent");
                return false;
            }
    }

}
