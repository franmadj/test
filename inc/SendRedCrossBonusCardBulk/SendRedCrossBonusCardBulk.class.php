<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Inc;

/**
 * Description of SendBonusCardBulk
 *
 * @author USER
 */
class SendRedCrossBonusCardBulk {

    private static $initiated = false;
    private $cronTable = 'pFXR8TXq7_cron_red_cross_bonus_cards';
    private $createdCards = [];
    private $testing = false;

    public static function init() {
        if (!self::$initiated) {
            self::$initiated = true;
            (new self)->initHooks();
        }
    }

    private function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/' . 'red_cross_bulk.txt');
        error_log('----------SendBonusCardBulk: ' . $value);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_debug.log');
    }

    /**
     * Initializes WordPress hooks
     */
    private function initHooks() {
        global $wpdb;
        $this->cronTable = $wpdb->prefix . 'cron_red_cross_bonus_cards';
        add_action('wp', [$this, 'handleSubmission']);
        add_filter('cron_schedules', array($this, 'cronRedCrossAddMinute'), 10, 1);
        add_action('wp', array($this, 'cronRedCrossActivationCallback'));
        if (isset($_GET['triger_cron_red_cross_'])) {
            add_action('wp', array($this, 'triggerCron'));
        } else {
            add_action('cronRedCrossActivation', array($this, 'triggerCron'));
        }

        if (isset($_GET['send_rep_red_cros'])) {
            $this->sendReport(get_template_directory() . '/inc/SendRedCrossBonusCardBulk/reports/2024-06-30_6154.csv');
        }
    }

    public function cronRedCrossAddMinute($schedules) {
        $schedules['cron_red_cross_minute'] = array(
            'interval' => (60),
            'display' => __('Once Every Minute')
        );
        return $schedules;
    }

    public function cronRedCrossActivationCallback() {
        if (!wp_next_scheduled('cronRedCrossActivation')) {
            wp_schedule_event(time(), 'cron_red_cross_minute', 'cronRedCrossActivation');
        }
    }

    public function handleSubmission() {
        if (!empty($_FILES['red_cross_bonus_cards_csv_file'])) {
            $this->log('handleSubmission');
            global $wpdb;
            $success = 'ko';

            $gestor = fopen($_FILES['red_cross_bonus_cards_csv_file']['tmp_name'], "r");
            $this->log('$gestor');
            $this->log($gestor);
            if (($gestor = fopen($_FILES['red_cross_bonus_cards_csv_file']['tmp_name'], "r")) !== FALSE) {
                $batch = time();
                while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                    $this->log('$datos: ' . print_r($datos, true));
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
                    $amount = intval(str_replace('$', '', $amount));
                    if ($wpdb->insert($this->cronTable, array('id' => '', 'email' => $email, 'amount' => $amount, 'batch' => $batch))) {
                        $success = 'ok';
                    }
                }
                fclose($gestor);
            }
            header('location: /send-red-cross-bonus-cards?success=' . $success);
        }
    }

    public function triggerCron() {
        $this->log('triggerCron');
        global $wpdb;
        $batch = $wpdb->get_var("SELECT batch FROM $this->cronTable where card IS NULL order by id ASC limit 1");
        if (!$batch)
            return;

        $this->log('processing.. ' . $batch);

        $data = $wpdb->get_results("SELECT id, email, amount FROM $this->cronTable where card IS NULL AND batch=$batch order by id ASC limit 10");
        if (!$data)
            return;

        $this->log('with data.. ');
        $this->log($data);

        foreach ($data as $item) {
            if ($card = $this->createBonusCard($item->amount, $item->email)) {
                $cards = $this->getCreatedCards();
                $this->resetCards();
                $this->log('update with cards');
                $this->log($cards);
                $wpdb->update($this->cronTable, array('card' => $cards), array('id' => $item->id));
            }
        }

        $left = $wpdb->get_results("SELECT id FROM $this->cronTable where card IS NULL AND batch=$batch limit 1");
        $this->log('$left');
        $this->log($left);
        if ($left)
            return;

        $this->createReport($batch);
    }

    function createReport($batch) {
        global $wpdb;
        $this->log('createReport');

        $data = $wpdb->get_results("SELECT * FROM $this->cronTable where card IS NOT NULL AND batch='$batch' order by id ASC", ARRAY_A);
        if (!$data)
            return;
        $filename = get_template_directory() . '/inc/SendRedCrossBonusCardBulk/reports/' . date('Y-m-d') . '_' . rand(0, 9999) . '.csv';
        $file = fopen($filename, 'w');
        $items = [
            ['amount', 'email', 'card']
        ];
        foreach ($data as $row) {
            $items[] = ['$' . $row['amount'], $row['email'], $row['card']];
        }
        foreach ($items as $item) {
            fputcsv($file, $item);
        }
        fclose($file);
        $this->sendReport($filename);
    }

    function sendReport($filename) {
        $this->log('sendReport');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $attachments = array($filename);

        $this->log('$attachments');
        $this->log($attachments);
        if (!$this->testing)
            $emailTo = 'jadizzedin@texasdebrazil.com';
        else
            $emailTo = 'franworkspace@gmail.com';

        $sent = wp_mail($emailTo, 'Send red cross bonus cards report', 'find the rport attached', $headers, $attachments);
        $this->log('$sent');
        $this->log($sent);
        return $sent;
    }

    private function apiQuery($endpoint, $data) {
        $headers = [
            'Content-Type: application/json',
        ];
        $username = get_field('user_name', 'options');
        $password = get_field('password', 'options');
        //$this->log("username --$username and password -- $password");
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

    private function addCreatedCard($card) {
        $card = str_replace(' ', '', $card);
        $this->createdCards[$card] = $card;
    }

    private function getCreatedCards() {
        return (!empty($this->createdCards) && is_array($this->createdCards)) ? implode(', ', $this->createdCards) : '';
    }

    private function resetCards() {
        $this->createdCards = [];
    }

    public function createBonusCard($amount, $email) {
        $this->log('createBonusCard');
        $this->log([$amount, $email]);

        if (!$email || !$amount)
            return false;
        if (($amount % 150 == 0) && ($amount % 100 != 0)) {
            $this->log("150 Bonus card");
            if ($this->createCard(10, $email))
                return $this->createCard(25, $email);
        } elseif (($amount == 250)) {
            $this->log("250 Bonus card");
            if ($this->createCard(10, $email))
                if ($this->createCard(25, $email))
                    return $this->createCard(25, $email);
        } else {
            $this->log($amount . " bonus card");
            return $this->createCard($amount, $email);
        }

        return false;
    }

    public function createCard($amount, $email) {
        if ($this->testing) {
            $card = rand(1111111111, 9999999999);
            $this->addCreatedCard($card);
            return $card;
        }
        global $wpdb;
        $origamount = $amount;
        $amount = number_format($amount, 2);
        $hasError = 0;

//        $this->log('Creating card for $' . $amount . ' and cardtype: eBonus...');
//        return true;
        //return $this->notifyRecipient('98723498237', '1244', $amount, $email);

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

        $this->log('Creating card in eComp');
        $walletCode = 4;
        $storeCode = 'ecert';
        $programId = 'LP'; //05700025000647
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

        $this->log('Alloting card No.--- ' . $card . ' ----');

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

        $this->log('Request Data: ' . json_encode($data) . '');

        $endpoint = 'activateAdd.json';

        $response = $this->apiQuery($endpoint, $data);

        $this->log('Response Data: ' . json_encode($response) . '');
        //$response->errorCode == 'transaction.card_already_active'
        if ($response->result == 'userDataError' && $response->errorCode == 'transaction.card_not_in_required_state') {

            $hasError = 1;

            $this->log('Paytronix Gift Card response is specifying Card Already Active Error. Re-alloting a new card.');


            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));

            $this->log('Deleting already active card No.' . $card . ' from database...');



            $this->log('Re-Alloting card');
            return $this->createCard($origamount, $email);
        } elseif ($response->result != 'authorizedSuccess') {
            $this->log('Paytronix Gift Card response is specifying there\'s an error. Error: ');
            return false;
        }

        if ($hasError == 0) {

            $deletecard = $wpdb->delete($wpdb->prefix.'paytronixgiftcards', array('cardNumber' => $card));
            $this->log('Deleting card No.' . $card . ' from database...');



            //$this->log('Card returned: ' . json_encode($card));
            if ($this->notifyRecipient($card, $regCode, $amount, $email)) {
                $this->addCreatedCard($card);
                return $card;
            }
        }
        return false;
    }

    public function notifyRecipient($cardNumber, $regCode, $amount, $email) {
        $this->log("notifyRecipient");

        $ruleimage = home_url() . '/wp-content/uploads/2024/07/red-cross-rules-of-use.png';
        $subject = 'Your Texas de Brazil x American Red Cross Bonus Card';
        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $email;
        $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
        $body = include(WP_PLUGIN_DIR . '/texas/texas-bonus-bulk-email-template.php');

        $toEmail = $email;
        //$toEmail = 'franworkspace@gmail.com';
        $this->log("======================================================");
        $this->log("sending bonus mail to--" . $toEmail);

        if (wp_mail($toEmail, $subject, $body)) {
            $this->log("sent Ok");
            return true;
        } else {
            $this->log("sent NOT Ok");
            return false;
        }
    }

}

SendRedCrossBonusCardBulk::init();
