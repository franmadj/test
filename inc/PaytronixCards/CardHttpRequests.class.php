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
class CardHttpRequests {

    private static $initiated = false;

    public static function init() {
        if (!self::$initiated) {
            self::$initiated = true;
            (new self)->initHooks();
        }
    }

    public function initHooks() {
        add_action('init', [$this, 'generateEmailPdf']);
    }

    function generateEmailPdf() {
        if (!empty($_GET['generate_egift_card_pdf'])) {
            
            



            $token = ($_GET['generate_egift_card_pdf']);
//            
//            var_dump($token,\Inc\TxFunctions\decrypt($token));
//            exit;
            $token = explode('-', \Inc\TxFunctions\decrypt($token));
            

            if (is_array($token) && 3 == count($token)) {
                $orderId = $token[0];
                $itemId = $token[1];
                $type = $token[2];
                require_once('inc/GeneratePdfCards.class.php');
                $GeneratePdfCards = new GeneratePdfCards($orderId, $itemId, $type);
                $GeneratePdfCards->generateEmailPdf();
            }else{
                echo 'invalid';
                exit;
            }
        }
    }

}

CardHttpRequests::init();
