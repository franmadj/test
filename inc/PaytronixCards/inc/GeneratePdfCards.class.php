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
class GeneratePdfCards extends CreateCards {

    private $emailsFolder;
    //private $testing = 'franworkspace@gmail.com';

    private $testing = '';
    private $sentAnyCards = false;
    private $type;

    private $targetItemId;

    public function __construct($orderId, $targetItemId, $type) {
        
        parent::__construct($orderId);
        $this->targetItemId = $targetItemId;
        $this->type = $type;
        $this->emailsFolder = dirname(__FILE__) . '/../emails/';
    }

    public function generateEmailPdf() {
        if ('bonus' == $this->type)
            $this->generatePdfBonusCard();
        else
            $this->generatePdfPaytronixCards();
    }

    public function generatePdfPaytronixCards(): void {
        $this->order = wc_get_order($this->orderId);
        $this->log('generatePdfPaytronixCards: ' . $this->orderId);
        $items = $this->order->get_items();
        $cardName = 'PaytronixCardNumber';
        $regName = 'paytronixRegCode';

        foreach ($items as $itemId => $item) {
            if ($this->targetItemId != $itemId)
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



                    if ($this->isEventDepoist()) {
                        do_action('tx_automatic_checkout_generate_pdf_card_email', $cardNumber, $regCode, $amount, $itemId, $this);
                        return;
                    }


                    if ($this->isVipCard()) {

                        $showPdfLinks = false;
                        $page = include($this->emailsFolder . 'paytronix/texas-email-template-vip-dinning-card.php');
                    } else {


                        $showPdfLinks = false;
                        $page = include($this->emailsFolder . 'paytronix/texas-email-template-test.php');
                    }

                    $this->generatePdf($page);

                    //$this->storePostmarkMessageId($toEmail, $this->orderId, 'PaytronixCardNumber: '.$cardnumber, $this->itemId);
                }
            }
        }
    }
    
    public function generatePdfBonusCard(): void {
        global $wpdb;
        $this->order = wc_get_order($this->orderId);
        $this->log('generatePdfBonusCard: ' . $this->orderId);
        $items = $this->order->get_items();
        $toEmail = $this->order->get_billing_email();

        foreach ($items as $itemId => $item) {
            if ($this->targetItemId != $itemId)
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




                    if (!$this->isIcloudEmail($toEmail)) {

                        $ruleimage = home_url() . '/wp-content/uploads/2022/10/Holiday-Sale-ROU-2022.jpg';
                        
                        $showPdfLinks = false;
                        $page = include($this->emailsFolder . 'bonus/texas-bonus-email-template-pdf.php');
                        
                    } 


                    $this->generatePdf($page);
                    
                    //$this->storePostmarkMessageId($toEmail, $this->orderId, 'BonusCardNumber: ' . $cardnumber, $this->itemId);
                    //do_action('queue_postmark_message_id', $toEmail, $this->orderId);
                }
            }
        }
        do_action('queue_postmark_message_id', $toEmail, $this->orderId);
    }

    function generatePdf($page) {
        require_once get_template_directory() . '/inc/MPDF57/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($page);
        $mpdf->Output('Your-Texas-de-Brazil-Card.pdf', 'D');
        exit;
    }

}
