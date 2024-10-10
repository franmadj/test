<?php
add_action('wp_ajax_generate_bonus_card', 'generate_bonus_card_callback');
add_action('wp_ajax_nopriv_generate_bonus_card', 'generate_bonus_card_callback');

function generate_bonus_card_callback(){
	
	if($_POST['amount'] !="" && $_POST['quantity'] !="" && $_POST['user_email'] !="" ):
		echo "Success";
		$loopend = $_POST['quantity'];
		$amount = $_POST['amount'];
		$amount = number_format($amount, 2);
		$email = $_POST['user_email'];
		for($i=1;$i<=$loopend;$i++):
			$card = create_bonus_card($amount);
			if(!empty($card)){
				send_bonus_email($amount,$card['number'],$card['regCode'],$email);
			}
		endfor;
	else:
		echo "Validation failed";
	endif;

	die();
}

function create_bonus_card($amount){
	global $wpdb;
	$hasError=0;
	$walletCode = 4;
    $storeCode = 'BONUS';
    $programId = 'LP';
    $data = array(
        'authentication' => 'b2b',
        'headerInfo' => [
            'merchantId' => 570,
            'applicationId' => '',
            'applicationVersion' => '',
            'operatorId' => '0',
            'senderId' => 'PARTNER'
        ]
    );
    $getcard = $wpdb->get_row( "SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eComp'",ARRAY_A,50000);
    $card = $getcard['cardNumber'];
    $regCode = $getcard['registrationCode'];
    error_log("Card number $card and regcode $regCode");
    $data['headerInfo']['storeCode'] = $storeCode;
    $data['headerInfo']['programId'] = $programId;

    $data['cardInfo'] = [
        "swipeFlag" => false,
        "printedCardNumber" => $card,
        "cardRegCode" => $regCode
    ];

    $data['addWalletContents'] = [
        array(
        'walletCode' => $walletCode,
        'quantity' => $amount
    )];
    $endpoint = 'activateAdd.json';

    // Request to Paytronix server
    error_log("Manually generated crads");
    $response = query_paytronix_server($endpoint, $data);
    error_log(json_encode($response));
    if ( $response->result == 'userDataError' && $response->errorCode == 'transaction.card_already_active') {

            $hasError = 1;

            error_log('Paytronix Gift Card response is specifying Card Already Active Error. Re-alloting a new card.');

            
            $deletecard = $wpdb->delete( $wpdb->prefix.'paytronixgiftcards', array( 'cardNumber' => $card ) );

            error_log('Deleting already active card No.' . $card . ' from database...');
			
			error_log('Re-Alloting card');
            create_bonus_card($amount);

        }elseif ( $response->result != 'authorizedSuccess') {
        	$hasError = 1;
            error_log('Paytronix Gift Card response is specifying there\'s an error. Error: ');
            return false;
        }
        
        if ( $hasError == 0 ) {
           
            $deletecard = $wpdb->delete( $wpdb->prefix.'paytronixgiftcards', array( 'cardNumber' => $card ) );
            error_log('Deleting card No.' . $card . ' from database...');

            $card = [
                'number' => $getcard['cardNumber'],
                'regCode' => $regCode,
                'balance' => $response->addWalletContents[0]->quantity,
                'expiration' => "None"
            ];

            error_log('Card returned:'.json_encode($card));

            return $card;
        }
}

function query_paytronix_server($endpoint, $data){
	$headers = [
            'Content-Type: application/json',
        ];

    $username = get_field('user_name','options');
    $password = get_field('password','options');
    error_log("username --$username and password -- $password");
    // Staging URL
    //$url = 'https://api.pxslab.com:443/api/rest/16.3/transaction/'. $endpoint;
    // Live URL
    $url = 'https://api.pxsweb.com:443/api/rest/16.3/transaction/'. $endpoint;

    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_ENCODING, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);

    return json_decode($response);
}

function send_bonus_email($amount,$cardNumber,$regCode,$email){
	if($amount=='' || $cardNumber =='' || $regCode == ''){
		error_log('Missing arguments');
		return;
	}
	if ($amount == 25):
        $ruleimage = home_url() .'/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg';//home_url() . '/assets/img/25-bonus.jpg';
    elseif ($amount == 10):
        $ruleimage = home_url() .'/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg';//home_url() . '/assets/img/10-bonus.jpg';
    else:
        //Default $10 image
        $ruleimage = home_url() .'/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg';//home_url() . '/assets/img/10-bonus.jpg';
    endif;
    $subject = 'Your Texas de Brazil Bonus Card';

    $renderTemp = 'texas/bonus-card';

    $emailBcc_toEmail = 'onlineorders@texasdebrazil.com';

    $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $email;
    //$headers[] = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();;
    //$headers[] = 'Cc: '.$emailBcc_toEmail; // note 
    $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
    $body = include(get_template_directory() . '/emails/texas-bonus-email-template.php');

    $toEmail = $email;
    error_log("======================================================");
    error_log("sending bonus mail to--" . $email);



    if (wp_mail($toEmail, $subject, $body)) {
        $reponse = array("message"=>"ok","send_email"=>$toEmail);
        echo json_encode($reponse);
    } else {
        $reponse = array("message"=>"Error","send_email"=>$toEmail);
        echo json_encode($reponse);
    }
}

function paytronix_config()
{
    return array(
        'authentication' => 'b2b',
        'headerInfo' => [
            'merchantId' => 570,
            'applicationId' => '',
            'applicationVersion' => '',
            'operatorId' => '0',
            'senderId' => 'PARTNER'
        ]
    );
}