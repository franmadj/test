<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//add_action('init', 'inicioo');

function inicioo() {

    if ($_GET['testing-agent']) {
        //$action='https://texasdebrazil.com/';
        //$dateFormat = 'yyyy/MM/dd';
        var_dump('*****', isMobileDevice(), isIosDevice(), $_SERVER['HTTP_USER_AGENT']);
        exit;
    }


    if (isset($_GET['frt'])) {
        global $wpdb;

        $getcard = $wpdb->get_results("SELECT cardNumber,registrationCode FROM texas_paytronixgiftcards WHERE cardType ='eComp'"
                . " AND 
cardNumber >= 05700065000002 AND 
cardNumber <= 05700069999969"
                . "", ARRAY_A);

        var_dump($getcard);
        exit;
        return;

//        $order = wc_get_order(68051);
//        $items = $order->get_items();
//        var_dump($items);
        //var_dump(wc_get_order_item_meta(69078, 'BonusCardNumber')); //PaytronixCardNumber
        echo '<pre>';


        global $wp;
        var_dump(isMobileDevice());
        //var_dump($_SERVER);
        exit;
    }
}

add_action('inittest', function() {
    if ($_GET['get_ip']) {
        echo '<pre>';
        var_dump($_SERVER);
        exit;
    }
    if (false) {

        setcookie('franview', 'cookieValue', [
            'expires' => time() + (60 * 64 * 24 * 100),
            'path' => '/',
            'domain' => '.butchershoptdb.wpengine.com',
            'samesite' => 'None',
            'secure' => true,
            'httponly' => true
        ]);


        exit;
    }
});

