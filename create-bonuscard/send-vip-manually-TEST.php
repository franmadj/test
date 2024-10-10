<?php

class SendVipManuallyTest {

    private static $initiated = false;
    private static $orderId = 0;
    private static $to_email = "";
    private static $from = '';
    private static $amount = '';
    private static $slug = '';
    private static $lineItemId = 0;
    private static $message = '';
    private static $username = '';
    private static $theme_id = 0;
    private static $is_gift_card = false;

    // public function __construct(){
    //   	self::init_hooks();
    // }
    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function set_is_gift_card($value) {
        self::$is_gift_card = $value;
    }

    public static function get_is_gift_card() {
        return self::$is_gift_card;
    }

    public static function set_user_message($message) {
        self::$message = $message;
    }

    public static function get_user_message() {
        return self::$message;
    }

    public static function set_user_name($username) {
        self::$username = $username;
    }

    public static function get_user_name() {
        return self::$username;
    }

    public static function set_card_theme($theme_id) {
        self::$theme_id = $theme_id;
    }

    public static function get_card_theme() {
        return self::$theme_id;
    }

    public static function set_order_id($orderId) {
        self::$orderId = $orderId;
    }

    public static function get_order_id() {
        return self::$orderId;
    }

    public static function set_to_email($to_email) {
        self::$to_email = $to_email;
    }

    public static function get_to_email() {
        return self::$to_email;
    }

    public static function set_from_email($from) {
        self::$from = $from;
    }

    public static function get_from_email() {
        return self::$from;
    }

    public static function set_slug($slug) {
        self::$slug = $slug;
    }

    public static function get_slug() {
        return self::$slug;
    }

    public static function set_product_id($lineItemId) {
        self::$lineItemId = $lineItemId;
    }

    public static function get_product_id() {
        return self::$lineItemId;
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;
        if (!empty($_GET['send-vip-manually-test']))
            self::send_vip_manually_callback();

        self::getEmailPdf();
    }

    public static function send_vip_manually_callback() {
        error_log("send_vip_manually_callback $order_id");
        if (!$_GET['order_id'] || !$_GET['cardnumber'] || !$_GET['regcode'] || !$_GET['amount'])
            return;

        $order_id = $_GET['order_id'];
        $cardNumber = $_GET['cardnumber'];
        $regCode = $_GET['regcode'];
        $amount = $_GET['amount'];
        $email = $_GET['email'];

        $order = wc_get_order($order_id);
        if (!$order) {
            $reponse = array("message" => "Error", "send_email" => 'order ID is not valid');
            echo json_encode($reponse);
            wp_die();
        }
        $items = $order->get_items();
        self::set_order_id($order_id);
        foreach ($items as $item_id => $item) {
            error_log("inside foreach loop with item_id $item_id");

            $product_id = $item->get_product_id();

            $variation_id = $item->get_variation_id();

            $isgiftcard = wc_get_order_item_meta($item_id, 'isGiftCard', true);
            self::set_is_gift_card($is_gift_card);


            self::set_product_id($product_id);
            $qty = $item->get_quantity();
            $product_slug = get_post($product_id);
            $slug = $product_slug->post_name;
            self::set_slug($slug);
            $digitalProduct = get_field('digital_product', $product_id);
            $order_product_Id = $product_id;
            $orderId = $order_id;
            $from_email = $order->get_billing_email();
            self::set_from_email($from_email);
            if ($email != '')
                self::set_to_email($email);
            else
                self::set_to_email($from_email);
            self::set_user_message($item['message']);
            self::set_user_name($item['firstname'] . ' ' . $item['lastname']);
            self::set_card_theme($product_id);
            $qty = 1; //limit to one card
            for ($i = 0; $i < $qty; $i++) {
                //$amount = $item->get_total();
                error_log("Booting task for Line Item {$product_id} Order #{$orderId})... Amount #{$amount}..) (Slug #{$slug})...");
                $step = array('orderId' => $order_id,
                    'slug' => $slug,
                    'amount' => $amount,
                    'card' => $cardNumber,
                    'regcode' => $regCode
                );
                error_log("Runstep function is called with below data");
                self::runStep($step);
            }

            break; //limit to one card
        }

        $reponse = array("message" => "Error", "send_email" => 'Data in not valid');
        echo json_encode($reponse);
        wp_die();
    }

    public static function runStep($step = array()) {
        if (empty($step))
            return;

        $amount = $step['amount'];
        $slug = $step['slug'];
        $card = $step['card'];
        $regCode = $step['regcode'];


        if (!self::notifyRecipient($card, $regCode, $slug, $amount)) {
            error_log('There was a problem with emailing');

            return true;
        }

        return true;
    }

    public static function sejda($sourceUrl) {
        $url = "https://api.sejda.com/v2/html-pdf";
        $content = json_encode(array('url' => $sourceUrl));

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-type: application/json",
            "Authorization: Token: " . $apiKey));

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status == 200) {
            $fp = fopen("out.pdf", "w");
            fwrite($fp, $response);
            fclose($fp);
            print("PDF saved to disk");
        } else {
            print("Error: failed with status $status, response $response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }
    }

    public static function getEmailPdf() {
        if (empty($_GET['download_pdf_file']))
            return;
        // Initialize a file URL to the variable
        $url = $_GET['download_pdf_file'];

//        self::sejda($url);
//        
//        exit;




        require_once __DIR__ . '/../inc/MPDF57/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(file_get_contents($url));
        $mpdf->Output('my-file.pdf', 'D');
        exit;

        // Use basename() function to return the base name of file
        $file_name = basename($url);

        //var_dump($file_name);

        // Use file_get_contents() function to get the file
        // from url and use file_put_contents() function to
        // save the file by using base name
        if (file_put_contents($file_name, file_get_contents($url))) {
            echo "File downloaded successfully";
        } else {
            echo "File downloading failed.";
        }
    }

    public static function notifyRecipient($cardNumber, $regCode, $slug, $amount) {
        $time = time();
        $filePathName = WP_CONTENT_DIR . '/uploads/email-templates/email_html_' . $time . '.html';
        $fileUrlName = WP_CONTENT_URL . '/uploads/email-templates/email_html_' . $time . '.html';

        

        $showPdfLinks = false;
        $page = include(get_template_directory() . '/create-bonuscard/texas-email-template-vip-dinning-card-test.php');
        file_put_contents($filePathName, $page);




        $subject = 'Your Texas de Brazil VIP Dining Card';
        $showPdfLinks = true;
        $body = include(get_template_directory() . '/create-bonuscard/texas-email-template-vip-dinning-card-test.php');

        



        $toEmail = self::get_to_email();
        //$toEmail = 'franworkspace@gmail.com';
        error_log("======================================================");
        error_log("sending mail to--" . $toEmail);
        if ($cardNumber):
            if (wp_mail($toEmail, $subject, $body)) {
                $reponse = array("message" => "ok", "send_email" => $toEmail);
                echo json_encode($reponse);
            } else {
                $reponse = array("message" => "Error", "send_email" => $toEmail);
                echo json_encode($reponse);
            }
            die();


        endif;
    }

}

add_action('init', array('SendVipManuallyTest', 'init'));
