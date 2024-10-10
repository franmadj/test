<?php
/*
  Template Name:Send BonusCard bulk
 */

//$start_time = microtime(true);
ini_set('max_execution_time', 0);
ini_set('error_log', WP_CONTENT_DIR . '/'.date('Y_m_d').'_error_log_bulk.txt');
//var_dump(ini_get_all());





$sent = false;
$success = 0;
$failed = 0;
if (!empty($_GET['sent'])) {
    $success = $_GET['success'] ?: 0;
    $failed = $_GET['failed'] ?: 0;
    $sent = true;
}
//echo phpinfo();exit;
//sleep(65);
if (!empty($_FILES['csv_file'])) {
    
    $gestor = fopen($_FILES['csv_file']['tmp_name'], "r");
    
    error_log('$gestor: '.print_r($gestor, true));

    if (($gestor = fopen($_FILES['csv_file']['tmp_name'], "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
            error_log('$datos: '.print_r($datos, true));
            $numero = count($datos);
            for ($c = 0; $c < $numero; $c++) {
                if (0 == $c) {
                    if (false === strpos($datos[$c], '$'))
                        continue;
                    $amount = $datos[$c];
                }
                if (1 == $c) {
                    if (false === strpos($datos[$c], '@'))
                        continue;
                    $email = $datos[$c];
                }
            }
            if (empty($email) || empty($amount))
                continue;
            if (SendBonusCardBulk::send_bonuscard_manually_bulk(intval(str_replace('$', '', $amount)), $email))
                $success++;
            else
                $failed++;
            //sleep(2);
        }
        fclose($gestor);
    }
//    $end_time = microtime(true);
//    $execution_time = ($end_time - $start_time);
//
//    echo " Execution time of script = " . $execution_time . " sec";
//    exit;
    header('location: /send-red-cross-bonus-cards?sent=1&success=' . $success . '&failed=' . $failed);

    //var_dump(SendBonusCardBulk::$logs);
}

class SendBonusCardBulk {

    static $logs = [];

    private static function log($data) {
        //self::$logs[] = print_r($data, true);
        error_log(print_r($data, true));
    }

    private static function query($endpoint, $data) {
        $headers = [
            'Content-Type: application/json',
        ];

        $username = get_field('user_name', 'options');
        $password = get_field('password', 'options');
        //self::log("username --$username and password -- $password");
        // Staging URL
        //$url = 'https://api.pxslab.com:443/api/rest/16.3/transaction/'. $endpoint;
        // Live URL
        $url = 'https://api.pxsweb.com:443/api/rest/16.3/transaction/' . $endpoint;


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
        //return json_decode($response)->result;
    }

    public static function createCard($amount, $email) {
        global $wpdb;
        $origamount = $amount;
        $amount = number_format($amount, 2);
        $hasError = 0;

//        self::log('Creating card for $' . $amount . ' and cardtype: eBonus...');
//        return true;
        //return self::notifyRecipientWithBonusCard_new('98723498237', '1244', $amount, $email);

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

        self::log('Creating card in eComp');
        $walletCode = 4;
        $storeCode = 'ecert';
        $programId = 'LP';//05700025000647
        $getcard = $wpdb->get_row("SELECT cardNumber,registrationCode FROM ".$wpdb->prefix."paytronixgiftcards WHERE cardType ='eComp'"
                . " AND 
cardNumber >= 05700065000002 AND 
cardNumber <= 05700069999969"
                . "", ARRAY_A);
        if (!$getcard) {
            echo 'Range from 05700025000027 to 05700049999915 is done, upload more cards';
            exit;
        }
        $card = $getcard['cardNumber'];
        $regCode = $getcard['registrationCode'];

        self::log('Alloting card No.--- ' . $card . ' ----');

        //$data['headerInfo']['posTransactionId'] = $orderId;
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

        self::log('Request Data: ' . json_encode($data) . '');

        $endpoint = 'activateAdd.json';

        $response = self::query($endpoint, $data);

        self::log('Response Data: ' . json_encode($response) . '');
        //$response->errorCode == 'transaction.card_already_active'
        if ($response->result == 'userDataError' && $response->errorCode == 'transaction.card_not_in_required_state') {

            $hasError = 1;

            self::log('Paytronix Gift Card response is specifying Card Already Active Error. Re-alloting a new card.');


            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));

            self::log('Deleting already active card No.' . $card . ' from database...');



            self::log('Re-Alloting card');
            return self::createCard($origamount, $email);
        } elseif ($response->result != 'authorizedSuccess') {
            self::log('Paytronix Gift Card response is specifying there\'s an error. Error: ');
            return false;
        }

        if ($hasError == 0) {

            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));
            self::log('Deleting card No.' . $card . ' from database...');



            //self::log('Card returned: ' . json_encode($card));
            return self::notifyRecipientWithBonusCard_new($card, $regCode, $amount, $email);
        }
    }

    public static function notifyRecipientWithBonusCard_new($cardNumber, $regCode, $amount, $email) {
        self::log("inside send bonus email function");
        /* BCC for Internal Records */


        $ruleimage = home_url() . '/wp-content/uploads/2024/07/red-cross-rules-of-use.png';
        $subject = 'Your Texas de Brazil x American Red Cross Bonus Card';

        $renderTemp = 'texas/bonus-card';

        $emailBcc_toEmail = 'onlineorders@texasdebrazil.com';

        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $email;
        //$headers[] = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();;
        //$headers[] = 'Cc: '.$emailBcc_toEmail; // note
        $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
        $body = include(WP_PLUGIN_DIR . '/texas/texas-bonus-bulk-email-template.php');

        $toEmail = $email;
        //$toEmail = 'franworkspace@gmail.com';
        self::log("======================================================");
        self::log("sending bonus mail to--" . $toEmail);



        if (wp_mail($toEmail, $subject, $body)) {
            self::log("sent Ok");
            return true;
        } else {
            self::log("sent NOT Ok");
            return false;
        }
    }

    public static function send_bonuscard_manually_bulk($amount, $email) {

//        var_dump(wp_mail($email, '$subject', '$body'));
//        return;
//    var_dump(($amount), $email, '***');
//    return;
        //self::log("inside send bonus email function");
        if (!$email || !$amount)
            return;



        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $email;
        $toEmail = $email;




        if (($amount % 150 == 0) && ($amount % 100 != 0)) {
            self::log("150 Bonus card");
            if (self::createCard(10, $email))
                return self::createCard(25, $email);
        } elseif (($amount == 250)) {
            self::log("250 Bonus card");
            if (self::createCard(10, $email))
                if (self::createCard(25, $email))
                    return self::createCard(25, $email);
        } else {
            self::log($amount . " bonus card");
            return self::createCard($amount, $email);
        }

        return false;
    }

}

//if($_GET['testing']){
//    SendBonusCardBulk::notifyRecipientWithBonusCard_new('34534534', '435', '20.5', 'franworkspace@gmail.com');
//}

get_header();
while (have_posts()) :the_post();
    ?>
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h1><?php the_title(); ?></h1>
                <?php
                if ($sent) {
                    echo '<p style="color:green;margin-bottom:0;">' . $success . ' Success</p>';
                    echo '<p style="color:red;">' . $failed . ' Failure</p>';
                }
                ?>
                <form id="send-bonuscard" action="/send-red-cross-bonus-cards" method="POST" class="mt-4" enctype="multipart/form-data">
                   


                    <div class="c-box">
                        <div class="c-box__col">
                            <input type="file" name="csv_file" id="uploadFile" style="color:white;">
                        </div>


                        <div class="c-box__col">
                         <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>

                        </div>
                        <div class="c-box__col">
                            <div class="c-form-error error-form mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <button type="submit" class="button u-contact-submit">Send</button>

                        </div>
                        <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                    </div>
                </form>





            </div>
        </div>
    </div>
<?php endwhile; ?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<?php get_footer(); ?>
<style>

</style>

<script type="text/javascript">
    jQuery(document).ready(function ($) {


        jQuery(".u-contact-submit").click(function (e) {
            e.preventDefault();
            $(this).attr('disabled',true);


            var fileInput = document.getElementById('uploadFile');
            var filePath = fileInput.value;




            var allowedExtensions = /(\.csv)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $(".error-form").html("<p>Upload a correct csv file.</p>");
                fileInput.value = '';
                $(this).attr('disabled',false);
                return false;
            } else
                $(".error-form").html("");




            response = grecaptcha.getResponse();
            if (response.length === 0) {
                jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
                $(this).attr('disabled',false);
                return false;
            } else {
                $('#send-bonuscard').submit();
            }

        });
    });






</script>
