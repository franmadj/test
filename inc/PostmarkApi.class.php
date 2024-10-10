<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Inc;

/**
 * Description of PostmarkApi
 *
 * @author USER
 */
class PostmarkApi {

    private $cronTable = 'cronjob_emails';

    public function __construct() {
        global $wpdb;
        $this->cronTable = $wpdb->prefix . 'cronjob_emails';
        if (!empty($_GET['add_messages'])) {
            $orderId = 422047;
            $data = ['email' => 'vixlyfe@yahoo.com', 'message_id' => '05835854-fae7-4ae7-a845-c49885cd78bc', 'card_number' => '15700033777747', 'type' => 'Unkown', 'item_id' => '1077197'];
            //update_post_meta($orderId, 'postmarkmessage_' . $itemId . '_' . $cardNumber, $response->Messages[0]->MessageID);


            $messages = get_post_meta($orderId, 'postmark_messages_meta', true);
            if ($messages && is_array($messages)) {
                $messages[] = $data;
            } else {
                $messages = [$data];
            }
            $this->log('postmark_messages_meta');
            $this->log($data);
            update_post_meta($orderId, 'postmark_messages_meta', $messages);
            var_dump('add_messages');
        }
        add_action('init', [$this, 'checkEmailStatus'], 10, 1);
        add_action('admin_footer', [$this, 'displayEmailStatus']);
        add_action('admin_footer', [$this, 'displayOldEmailStatus']);
        //add_action('store_postmark_message_id', [$this, 'storePostmarkMessageId'], 10, 4);
        add_action('queue_postmark_message_id', [$this, 'queuePostmarkMessageId'], 10, 2);

        add_action('mycronjobtimefive', array($this, 'triggerCron'));
    }

    public function triggerCron() {
        $this->log('trigger crone');
        $data = $this->getNextEmailToProcess();
        $this->log('getNextEmailToProcess data');
        $this->log($data);
        if ($data) {
            $this->retreivePostmarkMessageId($data['email'], $data['order_id'], $data['date']);
            $this->deleteOrderCrone($data['id']);
        }
    }

    function queuePostmarkMessageId($toEmail, $orderId) {
        $this->log('queuePostmarkMessageId ');
        global $wpdb;
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $this->cronTable WHERE order_id=$orderId AND email='$toEmail'");
        $this->log('queuePostmarkMessageId count ' . $count);
        if ($count == 0) {
            $insert = $wpdb->insert($this->cronTable, array('id' => '', 'order_id' => $orderId, 'email' => $toEmail, 'date' => time()));
            $this->log('$insert');
            $this->log($insert);
        }
    }

    private function getNextEmailToProcess() {
        global $wpdb;
        $date = strtotime('-7 minutes');
        $this->log('getNextEmailToProcess ' . "SELECT * FROM $this->cronTable where date > $date order by date ASC limit 1");
        $data = $wpdb->get_results("SELECT * FROM $this->cronTable where $date > date order by date ASC limit 1", ARRAY_A);

        if (empty($data[0])) {
            $this->log("no cron jobs wp_die..");
            return false;
        }
        return $data[0];
    }

    function retreivePostmarkMessageId($toEmail, $orderId, $date) {
        $this->log('retreivePostmarkMessageId $orderId: ' . $orderId);
        $order = wc_get_order($orderId);
        $this->log('retreivePostmarkMessageId subtotal: ' . $order->get_subtotal());
        $date = \Inc\TxFunctions\date_time(date('c', $date), 'America/Detroit');
        $date->sub(new \DateInterval('PT1M'));
        $fromDate = $date->format('Y-m-d\TH:i:s');
        $date->add(new \DateInterval('PT5M'));
        $toDate = $date->format('Y-m-d\TH:i:s');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.postmarkapp.com/messages/outbound?recipient=' . $toEmail . '&count=1&offset=0&todate=' . $toDate . '&fromdate=' . $fromDate,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-Postmark-Server-Token: ' . get_field('x-postmark-server-token', 'option'),
                'Accept: application/json'
            ),
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        $this->log('retreivePostmarkMessageId response: ' . print_r([$response, 'https://api.postmarkapp.com/messages/outbound?recipient=' . $toEmail . '&count=1&offset=0&todate=' . $toDate . '&fromdate=' . $fromDate, get_field('x-postmark-server-token', 'option')], true));
        if ($response && !empty($response->Messages[0]->MessageID)) {
            $data = ['email' => $toEmail, 'message_id' => $response->Messages[0]->MessageID, 'type' => 'Sent'];
            //update_post_meta($orderId, 'postmarkmessage_' . $itemId . '_' . $cardNumber, $response->Messages[0]->MessageID);


            $messages = get_post_meta($orderId, 'postmark_messages_meta', true);
            if ($messages && is_array($messages)) {
                $messages[] = $data;
            } else {
                $messages = [$data];
            }
            $this->log('postmark_messages_meta');
            $this->log($data);
            update_post_meta($orderId, 'postmark_messages_meta', $messages);
            //wc_update_order_item_meta($item_id, 'postmark_message_id_' . $cardNumber, $response->Messages[0]->MessageID);
        }
    }

    private function deleteOrderCrone($cronId) {
        global $wpdb;
        $this->log("deleteEmailCrone " . $cronId);
        $wpdb->delete($this->cronTable, array('id' => $cronId));
    }

    protected function log($value) {
        if (is_array($value) || is_object($value))
            $value = print_r($value, true);
        ini_set('error_log', WP_CONTENT_DIR . '/'.date('Y_m_d').'_PostmarkApi-debug.log');
        error_log('----------PostmarkApi: ' . $value);
        ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_debug.log');
    }

    function displayEmailStatus() {
        $this->log('displayEmailStatus');
        global $current_screen;
        if ($current_screen->id == 'shop_order') {
            $messages = get_post_meta($_GET['post'], 'postmark_messages_meta', true);
            if ($messages && is_array($messages)) {
                $messageHtml = [];

                foreach ($messages as $message) {
                    $messageHtml[] = '<tr><th>' . $message['email'] . ': </th><td><p>' . $message['type'] . '</p></td></tr>';
                }
                ?>
                <script>
                    jQuery(document).ready(function ($) {
                        setTimeout(function () {
                            const messagesHtml = JSON.parse('<?php echo json_encode($messageHtml); ?>');
                            console.log(messagesHtml);
                            let items = '';
                            messagesHtml.forEach((item) => {
                                items += item;
                            });


                            const tbody = `<tbody id="order_emails">
                                <tr class="order_emails">
                                  <td class="thumb email-status">
                                    <div></div>
                                  </td>
                                  <td class="name" colspan="5">
                                    <div class="view"> Email Status </div>
                                    <div class="view">
                                      <table cellspacing="0" class="display_meta">
                                        <tbody>
                                          ${items}
                                        </tbody>
                                      </table>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>`



                            $('.woocommerce_order_items').append(tbody)

                        }, 500)


                    });
                </script>
                <style>
                    #woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items tr.order_emails .thumb.email-status div {
                        display: block;
                        text-indent: -9999px;
                        position: relative;
                        height: 1em;
                        width: 1em;
                        font-size: 1.5em;
                        line-height: 1em;
                        vertical-align: middle;
                        margin: 0 auto
                    }
                    #woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items tr.order_emails .thumb.email-status div::before {
                        font-family: WooCommerce;
                        speak: never;
                        font-weight: 400;
                        font-variant: normal;
                        text-transform: none;
                        line-height: 1;
                        margin: 0;
                        text-indent: 0;
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        text-align: center;
                        content: "\e02d" !important;
                        color: #ccc;


                    }
                </style>
                <?php
            }
        }
    }

    function displayOldEmailStatus() {
        $this->log('displayEmailStatus');
        global $current_screen;
        if ($current_screen->id == 'shop_order') {
            $messages = get_post_meta($_GET['post'], 'postmark_messages_meta', true);
            if ($messages && is_array($messages)) {
                $messageHtml = [];

                foreach ($messages as $message) {
                    if(empty($message['item_id']))
                        continue;
                    if (empty($messageHtml[$message['item_id']]))
                        $messageHtml[$message['item_id']] = '';
                    $messageHtml[$message['item_id']] .= '<p>' . $message['card_number'] . ' / ' . $message['email'] . ' / ' . $message['type'] . '</p>';
                }
                ?>
                <script>
                    jQuery(document).ready(function ($) {
                        setTimeout(function () {
                            const messagesHtml = JSON.parse('<?php echo json_encode($messageHtml); ?>');
                            console.log(messagesHtml);
                            $('#order_line_items .item').each(function () {
                                const itemId = $(this).data('order_item_id');
                                if (typeof messagesHtml[itemId] != 'undefined') {
                                    const meta_table = $(this).find('.name .display_meta');
                                    console.log('meta_table', meta_table);
                                    meta_table.append('<tr><th>Sent Emails: </th><td>' + messagesHtml[itemId] + '</td></tr>');
                                }
                            })





                            $('.woocommerce_order_items').append(`<tbody></tbody>`)

                        }, 500)


                    });
                </script>
                <?php
            }
        }
    }

    function checkEmailStatus() {
        global $pagenow, $wpdb;
        if (is_admin() && $pagenow == 'post.php' && !empty($_GET['post'])) {
            $this->log('checkEmailStatus-post: ' . $_GET['post']);
            $messages = get_post_meta($_GET['post'], 'postmark_messages_meta', true);
            if ($messages && is_array($messages)) {
                $newMessages = [];
                foreach ($messages as $message) {
                    if ($message['type'] != 'Delivered') {
                        $status = $this->getEmailStatus($message['email'], $message['message_id']);
                        $message['type'] = $status;
                    }
                    $newMessages[] = $message;
                }
                update_post_meta($_GET['post'], 'postmark_messages_meta', $newMessages);
            }
        }
    }

    function getEmailStatus($email, $messageId) {
        $this->log('getEmailStatus');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.postmarkapp.com/messages/outbound/' . $messageId . '/details',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'X-Postmark-Server-Token: ' . get_field('x-postmark-server-token', 'option'),
                'Accept: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl));
        //$this->log('$response: ' . print_r($response, true));
        curl_close($curl);
        if ($response && !empty($response->MessageEvents) && is_array($response->MessageEvents)) {
            foreach ($response->MessageEvents as $event) {
                if ($event->Recipient == $email)
                    return $event->Type;
            }
        }
        return 'No data';
    }

    /*
      function storePostmarkMessageId($toEmail, $orderId, $cardNumber, $itemId) {
      $this->log('storePostmarkMessageId $orderId: ' . $orderId);
      $order = wc_get_order($orderId);
      $this->log('storePostmarkMessageId subtotal: ' . $order->get_subtotal());
      if ($order->get_subtotal() <= 200)
      sleep(10);
      $curl = curl_init();
      $date = \Inc\TxFunctions\date_time(date('c'));
      curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.postmarkapp.com/messages/outbound?recipient=' . $toEmail . '&count=1&offset=0&todate=' . $date->format('Y-m-d') . '&fromdate=' . $date->format('Y-m-d'),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
      'X-Postmark-Server-Token: ' . get_field('x-postmark-server-token', 'option'),
      'Accept: application/json'
      ),
      ));
      $response = json_decode(curl_exec($curl));
      curl_close($curl);
      $this->log('storePostmarkMessageId response: ' . print_r([$response, 'https://api.postmarkapp.com/messages/outbound?recipient=' . $toEmail . '&count=1&offset=0&todate=' . $date->format('Y-m-d') . '&fromdate=' . $date->format('Y-m-d'), get_field('x-postmark-server-token', 'option')], true));
      if ($response && !empty($response->Messages[0]->MessageID)) {
      $data = ['email' => $toEmail, 'message_id' => $response->Messages[0]->MessageID, 'card_number' => $cardNumber, 'type' => 'Unkown', 'item_id' => $itemId];
      //update_post_meta($orderId, 'postmarkmessage_' . $itemId . '_' . $cardNumber, $response->Messages[0]->MessageID);


      $messages = get_post_meta($orderId, 'postmark_messages_meta', true);
      if ($messages && is_array($messages)) {
      $messages[] = $data;
      } else {
      $messages = [$data];
      }
      $this->log('postmark_messages_meta');
      $this->log($data);
      update_post_meta($orderId, 'postmark_messages_meta', $messages);
      //wc_update_order_item_meta($item_id, 'postmark_message_id_' . $cardNumber, $response->Messages[0]->MessageID);
      }
      }
     */
}

new PostmarkApi;
