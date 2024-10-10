<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Inc\Traits;

/**
 * Description of PostmarkApi
 *
 * @author USER
 */
trait PostmarkApi {

    function displayEmailStatus() {
        $this->log('displayEmailStatus');
        global $current_screen;
        if ($current_screen->id == 'shop_order') {
            $messages = get_post_meta($_GET['post'], 'postmark_messages_data', true);
            if ($messages && is_array($messages)) {
                $messageHtml = [];

                foreach ($messages as $message) {
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
            $this->log('checkEmailStatus-post: '.$_GET['post']);

            $messages = get_post_meta($_GET['post'], 'postmark_messages_data', true);
            if ($messages && is_array($messages)) {
                $newMessages = [];

                foreach ($messages as $message) {

                    if ($message['type'] != 'Delivered') {
                        $status = $this->getEmailStatus($message['email'], $message['message_id']);
                        $message['type'] = $status;
                    }
                    $newMessages[] = $message;
                }
                update_post_meta($_GET['post'], 'postmark_messages_data', $newMessages);
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
                'X-Postmark-Server-Token: 1e071319-49b1-4672-b924-0e2df4102ec9',
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

    function storePostmarkMessageId($toEmail, $orderId, $cardNumber, $itemId) {
        $this->log('storePostmarkMessageId $orderId: '.$orderId);
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
                'X-Postmark-Server-Token: 1e071319-49b1-4672-b924-0e2df4102ec9',
                'Accept: application/json'
            ),
        ));
        $response = json_decode(curl_exec($curl));
        curl_close($curl);
        //$this->log('storePostmarkMessageId: ' . print_r($response, true));
        if ($response && !empty($response->Messages[0]->MessageID)) {
            $data = ['email' => $toEmail, 'message_id' => $response->Messages[0]->MessageID, 'card_number' => $cardNumber, 'type' => 'Unkown', 'item_id' => $itemId];
            //update_post_meta($orderId, 'postmarkmessage_' . $itemId . '_' . $cardNumber, $response->Messages[0]->MessageID);
            

            $messages = get_post_meta($orderId, 'postmark_messages_data', true);
            if ($messages && is_array($messages)) {
                $messages[] = $data;
            } else {
                $messages = [$data];
            }
            $this->log('postmark_messages_data');
            $this->log($data);
            update_post_meta($orderId, 'postmark_messages_data', $messages);
            //wc_update_order_item_meta($item_id, 'postmark_message_id_' . $cardNumber, $response->Messages[0]->MessageID);
        }
    }

}
