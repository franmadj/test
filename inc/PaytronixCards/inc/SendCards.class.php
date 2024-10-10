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

    private $emailsFolder;
    //private $testing = 'franworkspace@gmail.com';

    private $testing = '';
    private $sentAnyCards = false;

    public function __construct($orderId) {
        parent::__construct($orderId);
        $this->emailsFolder = dirname(__FILE__) . '/../emails/';
    }

    public function sentAnyCards() {
        return $this->sentAnyCards;
    }

    public function sendPaytronixCards(Array $allowedItems = [], bool $printPdf = true): void {
        $this->order = wc_get_order($this->orderId);
        $this->log('sendPaytronixCards: ' . $this->orderId);
        $items = $this->order->get_items();
        $cardName = 'PaytronixCardNumber';
        $regName = 'paytronixRegCode';
        $billingEmail = $this->order->get_billing_email();
        foreach ($items as $itemId => $item) {
            if ($allowedItems && !in_array($itemId, $allowedItems))
                continue;
            $this->productId = $productId = $item->get_product_id();
            $this->product = wc_get_product($productId);
            $this->item = $item;
            $this->itemId = $itemId;
            $this->themeId = $item['theme_id'];
            $this->setSlug();
            $this->itemQty = $item->get_quantity();
            $itemPrice = $this->getItemPrice();

            $this->isGiftedCard = $this->isGiftedCardUser();
            $this->log('isGiftedCard_: ' . $this->isGiftedCard);
            if ($this->isGiftedCard) {
                $this->log('isGiftedCard: ' . $this->orderId);
                $this->billingFullName = $this->order->get_billing_first_name() . ' ' . $this->order->get_billing_last_name();
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
                foreach ($cardnumbers as $key => $cardNumber) {
                    $regCode = $regcodes[$key];
                    $amount = $itemPrice;
                    $cardnumber = $cardNumber;

                    if ($cardNumber == 'TEST2513195965' && $regCode == '7181') {
                        $id = $this->orderId . '-' . $itemId . '-card';
                        require_once get_template_directory() . '/inc/functions.php';
                        $id = urlencode(\Inc\TxFunctions\encrypt($id));

                        if ($this->isEventDepoist()) {
                            do_action('tx_automatic_checkout_send_card_email', $cardNumber, $regCode, $amount, $itemId, $printPdf);
                            return;
                        }
                        $subject = 'Your Texas de Brazil Gift Card sent by ' . $billingEmail;

                        if ($this->isVipCard()) {
                            $subject = 'Your Texas de Brazil VIP Dining Card';

                            $showPdfLink = true;
                            $body = include($this->emailsFolder . 'paytronix/texas-email-template-vip-dinning-card.php');
                        } elseif ($printPdf && !$this->isIcloudEmail($toEmail)) {

                            $showPdfLink = true;
                            $body = include($this->emailsFolder . 'paytronix/texas-email-template-test.php');
                        } else {
                            $body = include($this->emailsFolder . 'paytronix/texas-email-template.php');
                        }
                    } else {


                        $id = $cardNumber . $regCode;
                        $id = preg_replace('/\s+/', '', $id);


                        if ($this->isEventDepoist()) {
                            do_action('tx_automatic_checkout_send_card_email', $cardNumber, $regCode, $amount, $itemId, $printPdf);
                            return;
                        }
                        $subject = 'Your Texas de Brazil Gift Card sent by ' . $billingEmail;

                        if ($this->isVipCard()) {
                            $subject = 'Your Texas de Brazil VIP Dining Card';

                            $filePathName = WP_CONTENT_DIR . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                            $fileUrlName = WP_CONTENT_URL . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                            $showPdfLinks = false;
                            $page = include($this->emailsFolder . 'paytronix/texas-email-template-vip-dinning-card.php');
                            file_put_contents($filePathName, $page);
                            $showPdfLinks = true;
                            $body = include($this->emailsFolder . 'paytronix/texas-email-template-vip-dinning-card.php');
                        } elseif ($printPdf && !$this->isIcloudEmail($toEmail)) {

                            $filePathName = WP_CONTENT_DIR . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                            $fileUrlName = WP_CONTENT_URL . '/uploads/email-templates/texas-email-pdf-' . $id . '.html';
                            $showPdfLinks = false;
                            $page = include($this->emailsFolder . 'paytronix/texas-email-template-test.php');
                            file_put_contents($filePathName, $page);
                            $showPdfLinks = true;
                            $body = include($this->emailsFolder . 'paytronix/texas-email-template-test.php');
                        } else {
                            $body = include($this->emailsFolder . 'paytronix/texas-email-template.php');
                        }
                    }

                    $this->sendEmail($toEmail, $subject, $body);
                    do_action('queue_postmark_message_id', $toEmail, $this->orderId);
                    $this->sentAnyCards = true;
                    //$this->storePostmarkMessageId($toEmail, $this->orderId, 'PaytronixCardNumber: '.$cardnumber, $this->itemId);
                }
            }
        }
    }

    public function sendBonusCards(Array $allowedItems = [], bool $printPdf = true): void {
        global $wpdb;
        $this->order = wc_get_order($this->orderId);
        $this->log('sendBonusCards: ' . $this->orderId);
        $items = $this->order->get_items();
        $toEmail = $this->order->get_billing_email();

        foreach ($items as $itemId => $item) {
            if ($allowedItems && !in_array($itemId, $allowedItems))
                continue;

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
                    $cardnumber = $cardNumber = $value['bonuscard_number'];
                    $amount = $value['amount'];
                    $subject = 'Your Texas de Brazil Bonus Card';


                    if ($this->isHolidayCard()) {
                        $ruleimage = home_url() . '/wp-content/uploads/2022/10/Holiday-Sale-ROU-2022.jpg';
                    } else if ($amount == 25):
                        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/25-bonus_new.jpg';
                    elseif ($amount == 10):
                        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus_new.jpg';
                    else:
                        //Default $10 image
                        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus_new.jpg';
                    endif;


                    if ($cardNumber == 'TEST2513195965' && $regCode == '7181') {
                        $id = $this->orderId . '-' . $itemId . '-bonus';
                        require_once get_template_directory() . '/inc/functions.php';
                        $id = urlencode(\Inc\TxFunctions\encrypt($id));
                        if ($printPdf && !$this->isIcloudEmail($toEmail)) {
                            $showPdfLink = true;
                            $body = include($this->emailsFolder . 'bonus/texas-bonus-email-template-pdf.php');
                        } else {
                            $body = include($this->emailsFolder . 'bonus/texas-bonus-email-template.php');
                        }
                    } else {
                        $id = $cardNumber . $regCode;
                        $id = preg_replace('/\s+/', '', $id);
                        if ($printPdf && !$this->isIcloudEmail($toEmail)) {
                            $ruleimage = home_url() . '/wp-content/uploads/2022/10/Holiday-Sale-ROU-2022.jpg';
                            $filePathName = WP_CONTENT_DIR . '/uploads/email-bonus-templates/texas-email-pdf-' . $id . '.html';
                            $fileUrlName = WP_CONTENT_URL . '/uploads/email-bonus-templates/texas-email-pdf-' . $id . '.html';
                            $showPdfLinks = false;
                            $page = include($this->emailsFolder . 'bonus/texas-bonus-email-template-pdf.php');
                            file_put_contents($filePathName, $page);
                            $showPdfLinks = true;
                            $body = include($this->emailsFolder . 'bonus/texas-bonus-email-template-pdf.php');
                        } else {
                            $body = include($this->emailsFolder . 'bonus/texas-bonus-email-template.php');
                        }
                    }


                    $this->sendEmail($toEmail, $subject, $body);
                    $this->sentAnyCards = true;
                    //$this->storePostmarkMessageId($toEmail, $this->orderId, 'BonusCardNumber: ' . $cardnumber, $this->itemId);
                    //do_action('queue_postmark_message_id', $toEmail, $this->orderId);
                }
            }
        }
        do_action('queue_postmark_message_id', $toEmail, $this->orderId);
    }

    function sendRefundOrder(): void {
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

    function sendOrderDetails(): void {
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
        if ($this->sendEmail($toEmail, $subject, $body))
            do_action('queue_postmark_message_id', $toEmail, $this->orderId);
    }

    private function sendEmail(string $toEmail, string $subject, string $body): bool {
        $this->log('sendEmail: ' . $subject);
        $this->log("sending mail to--" . $toEmail);
        if ($toEmail) {
            if ($this->testing)
                $toEmail = $this->testing;
            if (wp_mail($toEmail, $subject, $body)) {
                $this->log("Sent mail to--" . $toEmail);

                return true;
            } else {
                $this->log("Not Sent");
                return false;
            }
        }
    }

}
