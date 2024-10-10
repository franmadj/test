<?php
$order_data = $order->get_data();
$body = include(get_template_directory() . '/emails/order-detail.php');
$toEmail = $customer_email;

$subject = 'Order #'.$order->get_id().' Receipt';

wp_mail( $toEmail, $subject, $body );
foreach ($order->get_items() as $item_key => $item ):
    $theme_id =  $item->get_meta('theme_id');
    $isGiftCard = $item->get_meta('isGiftCard');
    $cardNumber = $item->get_meta('PaytronixCardNumber');
    $regCode = $item->get_meta('paytronixRegCode');
    $amount = $item->get_total();
    if($isGiftCard == "Yes" && $item->get_product_id() == 653){
        $firstName = $item->get_meta('firstname');
        $lastName=$item->get_meta('lastname');
        $user_email = $item->get_meta('user_email');
        $message = $item->get_meta('message');
        $gift_body = include(get_template_directory() . '/emails/egift-email-template.php');
        $subject_gift = 'Your Texas de Brazil Gift Card sent by '.$customer_email;
        wp_mail( $user_email, $subject_gift,$gift_body );
    }
endforeach;