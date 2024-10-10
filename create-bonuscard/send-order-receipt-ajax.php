<?php 
add_action('wp_ajax_send_order_receipt_manually', 'send_order_receipt_manually_callback');
add_action('wp_ajax_nopriv_send_order_receipt_manually', 'send_order_receipt_manually_callback');
function send_order_receipt_manually_callback() {
    error_log("inside send order email receipt function");
    if (!$_POST['order_id'] || !$_POST['cardnumber'] || !$_POST['regcode'] || !$_POST['amount'])
        return;
    /* BCC for Internal Records */
    $order_id = $_POST['order_id'];
    $cardNumber_new = $_POST['cardnumber'];
    $regCode_new = $_POST['regcode'];
    $amount = $_POST['amount'];
    
    $order = wc_get_order( $order_id );
    if($order):
        
        $mailer = WC()->mailer()->get_emails();

        $mailer['WC_Email_Customer_Completed_Order']->heading = "Order #$order_id Receipt";
        $mailer['WC_Email_Customer_Completed_Order']->settings['heading'] = "Order #$order_id Receipt";
        $mailer['WC_Email_Customer_Completed_Order']->subject = "Order #$order_id Receipt";
        $mailer['WC_Email_Customer_Completed_Order']->settings['subject'] = "Order #$order_id Receipt";

        $mailer['WC_Email_Customer_Completed_Order']->trigger( $order_id );
        $order->add_order_note(__('Manually send order receipt email with new card number.', 'woocommerce'), false, true);
        
        $reponse = array("message"=>"ok","send_email"=>'Send to Order receipt email.');
        echo json_encode($reponse);
       
    else:
        $reponse = array("message"=>"Error","send_email"=>'It seems Order ID is not valid.');
        echo json_encode($reponse);
    endif;
    die();
}