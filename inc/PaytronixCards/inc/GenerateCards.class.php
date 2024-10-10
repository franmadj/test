<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CreateCards.class.php';
require_once 'PaytronixApi.class.php';

/**
 * Description of CreateCards
 *
 * @author USER
 */
class GenerateCards extends CreateCards {

    

    public function __construct($orderId) {
        parent::__construct($orderId);
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
                    if(!$itemPrice){
                        $this->log('Error getting event deposit quantity');
                        continue;
                    }
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
        
        $this->log('createCard $response: ' . print_r($response, true));

        if ($response == null || $response == 'null') {
            $this->log('Paytronix Gift Card response is specifying null.');
            $this->deleteCard($card);
            $this->apiNullResponse++;
            if ($this->apiNullResponse > 1) {
                wp_mail('jadizzedin@texasdebrazil.com, matt@thriveground.com, franworkspace@gmail.com', 'Create Card API returned NULL Second attempt for order: ' . $this->orderId, $this->orderId);
                $this->log('Create Card API returned NULL Second attempt for order: ' . $this->orderId, $this->orderId);
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

    

    

    private function getCard($cardType, $offset) {
        global $wpdb;
        $this->log('getCard' . " SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='$cardType'");
        $card = $wpdb->get_row("SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='$cardType'", ARRAY_A, $offset);
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
