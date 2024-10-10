<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'PaytronixApi.class.php';

/**
 * Description of CreateCards
 *
 * @author USER
 */
class CreateCards {

    private $apiNullResponse = 0;
    private $cardsTable = 'texas_paytronixgiftcards';
    private $cardsBonusTable = 'texas_bonuscard';
    private $themeId = 0;

    public function __construct($orderId) {
        $this->orderId = $orderId;
    }

    private function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        echo '<pre>';

        var_dump('----------CreateCards: ' . $value);
        echo '</pre>';
    }

    private function log_($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/cards-debug.log');
        error_log('----------CreateCards: ' . $value);
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
        return $this->productId == EVENT_DEPOSIT;
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

    public function isGiftedCard() {
        return wc_get_order_item_meta($this->itemId, 'isGiftCard', true);
    }

    public function getItemPrice() {

        if ($this->isEventDepoist())
            return get_post_meta($this->productId, 'deposit amount', true);

        return $this->item['line_total'] / $this->itemQty;



        
    }

    function setSlug() {
        $post = get_post($this->productId);
        $this->slug = $post->post_name;
    }

    function generateBonusCards() {
        global $wpdb;
        $this->order = wc_get_order($this->orderId);
        $this->log('generateBonusCards: ' . $this->orderId);
        $items = $this->order->get_items();
        foreach ($items as $itemId => $item) {
            $this->log("inside foreach loop with item_id $itemId");
            $this->productId = $productId = $item->get_product_id();
            $this->product = wc_get_product($productId);
            $this->item = $item;
            $this->itemId = $itemId;
            $this->setSlug();
            $this->itemQty = $item->get_quantity();
            if ($this->itemQty > 10)
                continue;

            if ($this->isHolidayCard()) {
                $itemPrice = $this->getItemPrice();



                wc_delete_order_item_meta($itemId, 'BonusCardNumber');
                wc_delete_order_item_meta($itemId, 'BonusRegCode');
                $wpdb->get_results("Delete FROM $this->cardsBonusTable where item_id='$itemId'");

                $wpdb->get_results("SELECT * FROM $this->cardsBonusTable where item_id='$itemId' and amount=10");
                $processedTen = $wpdb->num_rows;
                $wpdb->get_results("SELECT * FROM $this->cardsBonusTable where item_id='$itemId' and amount=25");
                $processedTf = $wpdb->num_rows;

                $bonus25QtyTotal = $itemPrice / 100;
                $bonus25Qty = floor($bonus25QtyTotal);
                $left = $bonus25QtyTotal - $bonus25Qty;
                $bonus10Qty = $left == 0.5 ? 1 : 0;

                $cardConfig = [
                    'walletCode' => 4,
                    'storeCode' => 'BONUS',
                    'programId' => 'LP'
                ];
                $cardType = 'eComp';
                $offset = 105000;


                for ($i = 0; $i < $this->itemQty; $i++) {
                    if (!$this->allCardsCreated($i, $processedTf, $this->itemQty) && $bonus25Qty >= 1) {
                        $cardConfig['quantity'] = 25;
                        if ($card = $this->createCard($cardConfig, $cardType, $offset))
                            $this->saveCardToOrder($card, $itemId, 'bonus', 25);
                    }
                    if (!$this->allCardsCreated($i, $processedTen, $this->itemQty) && $left) {
                        $cardConfig['quantity'] = 10;
                        if ($card = $this->createCard($cardConfig, $cardType, $offset))
                            $this->saveCardToOrder($card, $itemId, 'bonus', 10);
                    }
                }
            }
        }
    }

    function generatePaytronixCards() {
        $this->log('generatePaytronixCards: ' . $this->orderId);
        $this->order = wc_get_order($this->orderId);
        $items = $this->order->get_items();

        foreach ($items as $itemId => $item) {
            $this->log("inside foreach loop with item_id $itemId");
            $this->productId = $productId = $item->get_product_id();
            $this->product = wc_get_product($productId);
            $this->item = $item;
            $this->itemId = $itemId;
            $this->setSlug();
            $this->itemQty = $item->get_quantity();
            if ($this->itemQty > 10)
                continue;

            if ($this->isDigitalProduct()) {
                $this->log("This is degital product");
                $itemPrice = $this->getItemPrice();
                wc_delete_order_item_meta($itemId, 'PaytronixCardNumber');
                wc_delete_order_item_meta($itemId, 'paytronixRegCode');
                $cards = wc_get_order_item_meta($itemId, 'PaytronixCardNumber', true);
                if ($cards) {
                    $cardsCount = count(explode(', ', $cards));
                } else {
                    $cardsCount = 0;
                }


                $offset = 0;
                if ($this->isItemPromotion()) {
                    $cardConfig = [
                        'walletCode' => get_field('wallet_code', $this->productId),
                        'storeCode' => get_field('store_code', $this->productId),
                        'programId' => get_field('program_id', $this->productId),
                        'quantity' => $itemPrice
                    ];
                    $cardType = get_field('card_type', $this->productId);
                } elseif ($this->isEVipCard()) {
                    $cardConfig = [
                        'walletCode' => 3,
                        'storeCode' => 'eComp',
                        'programId' => 'SV',
                        'quantity' => 12
                    ];
                    $cardType = 'eVIP';
                    $offset = 25000;
                } elseif ($this->isEgiftCard()) {
                    $cardConfig = [
                        'walletCode' => 1,
                        'storeCode' => 'eGift',
                        'programId' => 'SV',
                        'quantity' => $itemPrice
                    ];
                    $cardType = 'eGift';
                } elseif ($this->isEventDepoist()) {
                    $cardConfig = [
                        'walletCode' => 1,
                        'storeCode' => 'eGift',
                        'programId' => 'SV',
                        'quantity' => $itemPrice
                    ];
                    $cardType = 'eGiftDeposit';
                }
                for ($i = 0; $i < $this->itemQty; $i++) {
                    if ($this->allCardsCreated($i, $cardsCount, $this->itemQty)) {
                        $this->log('already created card ' . $i . ' for order #' . $this->orderId);
                        continue;
                    }

                    if ($card = $this->createCard($cardConfig, $cardType, $offset))
                        $this->saveCardToOrder($card, $itemId, 'main');
                }
            }
        }
    }

    function createCard($cardConfig, $cardType, $offset) {
        $card = $this->getCard($cardType, $offset);
        $this->log('createCard $cardType, $offset');
        $this->log([$cardType, $offset]);


        $paytronixApi = new PaytronixApi($card, $cardConfig, $this->orderId);
        $response = $paytronixApi->activationRequest();

        if ($response == null || $response == 'null') {
            $this->log('Paytronix Gift Card response is specifying null.');
            $this->deleteCard($card);
            $this->apiNullResponse++;
            if ($this->apiNullResponse > 1) {
                wp_mail('jadizzedin@texasdebrazil.com, matt@thriveground.com, franworkspace@gmail.com', 'Create Card API returned NULL Second attempt for order: ' . $orderId, 'Request: ' . json_encode($data));
                $this->log('Create Card API returned NULL Second attempt for order: ' . $orderId, 'Request: ' . json_encode($data));
                return false;
            }
            $this->log('Re-Alloting card: ' . $card['number'] . ' for NULL API response');
            return $this->createCard($cardConfig, $cardType, $offset);
        } elseif (($response->result == 'userDataError' && ($response->errorCode == 'transaction.card_not_in_required_state' or $response->errorCode == 'transaction.card_already_active'))) {
            $this->log('Paytronix Gift Card response is specifying ' . $response->errorCode . '. Re-alloting a new card.');
            $this->deleteCard($card);
            $this->log('Re-Alloting card: ' . $card['number']);
            return $this->createCard($cardConfig, $cardType, $offset);
        } elseif ($response->result != 'authorizedSuccess') {
            $this->log('Paytronix Gift Card response is specifying there\'s an error. not authorizedSuccess');
            $this->deleteCard($card);
            return false;
        } else {

//            $card['balance'] = $response->addWalletContents[0]->quantity;
//            $card['expiration'] = "None";
            $this->log('Card created Success returned: ' . print_r($card, true));
            $this->deleteCard($card);
            return $card;
        }
    }

    private function saveCardToOrder($card, $itemId, $type, $amount = 0) {
        $this->log('saveCardToOrder: ' . print_r([$card, $itemId, $type, $amount], true));
        if ($type == 'main') {
            $cardName = 'PaytronixCardNumber';
            $regName = 'paytronixRegCode';
        } else {
            $cardName = 'BonusCardNumber';
            $regName = 'BonusRegCode';
            global $wpdb;

            $data = array("id" => '', "order_id" => $this->orderId, "bonuscard_number" => $card['number'], "reg_code" => $card['regCode'], "amount" => $amount, 'item_id' => $itemId);
            $wpdb->insert($this->cardsBonusTable, $data);
        }
        $cardnumber = wc_get_order_item_meta($itemId, $cardName, true);
        if ($cardnumber) {
            $cardnumber = $cardnumber . ', ' . $card['number'];
        } else {
            $cardnumber = $card['number'];
        }
        $regcode = wc_get_order_item_meta($itemId, $regName, true);
        if ($regcode) {
            $regcode = $regcode . ', ' . $card['regCode'];
        } else {
            $regcode = $card['regCode'];
        }
        $this->log('Saving card #' . $cardnumber . ' with reg code ' . $regcode . ' to item #' . $itemId);
        wc_update_order_item_meta($itemId, $cardName, $cardnumber);
        wc_update_order_item_meta($itemId, $regName, $regcode);
        return true;
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
                    } elseif ($this->isHolidayCard()) {
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

                    if ($this->isHolidayCard()) {
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

    private function deleteCard($card) {
        global $wpdb;
        $this->log('Deleting card No.' . $card['number'] . ' from database...');
        $wpdb->delete('texas_paytronixgiftcards', array('cardNumber' => $card['number']));
    }

    private function getCard($cardType, $offset) {
        global $wpdb;
        $this->log('getCard' . " SELECT cardNumber,registrationCode FROM $this->cardsTable WHERE cardType ='$cardType'");
        $card = $wpdb->get_row("SELECT cardNumber,registrationCode FROM $this->cardsTable WHERE cardType ='$cardType'", ARRAY_A, $offset);
        if (!empty($card['cardNumber']) && !empty($card['registrationCode'])) {
            return ['number' => trim($card['cardNumber']), 'regCode' => trim($card['registrationCode'])];
        }
    }

    /**
     * true if not all cards are created yet
     * @param type $index
     * @param type $processed
     * @param type $totQty
     * @return boolean
     */
    private function allCardsCreated($index, $processed, $totQty) {
//        if (self::isHolidayCard(self::get_slug()))
//            return true;
        if (($index + $processed) < $totQty) {
            return false;
        }
        return true;
    }

}
