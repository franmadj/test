<?php
function disable_refund_button_for_shop_manager( $actions, $order ) {
    $user = wp_get_current_user();
    if ( in_array( 'shop_manager', (array) $user->roles ) ) {
        unset( $actions['refund'] );
    }
    return $actions;
}
add_filter( 'woocommerce_order_actions', 'disable_refund_button_for_shop_manager', 10, 2 );
//clear sale
add_action('woocommerce_order_status_changed', 'so_status_completed', 10, 3);

function so_status_completed($order_id, $old_status, $new_status) {
    error_log('so_status_completed.' . print_r([$new_status], true));
    if ('denied-clearsale' == $new_status) {
        $order = wc_get_order($order_id);
        $toEmail = $order->get_billing_email();
        $orderIdentifyer = $toEmail;
        $eDepositItem = false;
        foreach ($order->get_items() as $item) {
            $orderIdentifyer .= $item['product_id'];
            if ($item['product_id'] == EVENT_DEPOSIT)
                $eDepositItem = $item;
        }
        //$headers = 'Bcc: franworkspace@gmail.com'.PHP_EOL;
        $headers = '';
        $denied_order = get_option($orderIdentifyer, false);
        error_log('$denied_order ' . print_r($denied_order, true));
        if ($denied_order && isset($denied_order['time']) && $denied_order['time'] > (time() - DAY_IN_SECONDS)) {
            if (1 == $denied_order['step']) {
                $denied_order['step'] = 2;
                update_option($orderIdentifyer, $denied_order);
                //send email v1
                if ($eDepositItem)
                    do_action('tx_process_denied_by_clearsale_email', $eDepositItem);
                else {
                    $body = include(get_template_directory() . '/emails/denied-by-clearsale-retry.php');
                    //$toEmail = 'franworkspace@gmail.com';//*************************************
                    error_log("denied clear sale step2 to: " . $toEmail);
                    $subject = "Action Required: There's been an issue with your recent order";
                    $e = wp_mail($toEmail, $subject, $body, $headers);
                }
            } else {
                delete_option($orderIdentifyer);
                //send email v2
                $body = include(get_template_directory() . '/emails/denied-by-clearsale-failed.php');
                //$toEmail = 'franworkspace@gmail.com';//*************************************
                error_log("denied clear sale step3 to: " . $toEmail);
                $subject = 'Your recent order has failed';
                $e = wp_mail($toEmail, $subject, $body, $headers);
            }
        } else {
            update_option($orderIdentifyer, ['time' => time(), 'order_id' => $order_id, 'step' => 1]);
            if ($eDepositItem)
                do_action('tx_process_denied_by_clearsale_email', $eDepositItem);
            else {
                $body = include(get_template_directory() . '/emails/denied-by-clearsale-retry.php');
                //$toEmail = 'franworkspace@gmail.com';//*************************************
                error_log("denied clear sale step1 to: " . $toEmail);
                $subject = "Action Required: There's been an issue with your recent order";
                $e = wp_mail($toEmail, $subject, $body, $headers);
            }
        }
    }
}

//\wp-content\plugins\clearsale-usa\clearsale-usa.php L - 324, 824
add_filter('wc_clearsale_usa_approved_clearsale_filter', function($status, $order) {
    $requires_shipping = false;
    foreach ($order->get_items() as $item) {
        if ($requires_shipping = get_field('requires_shipping', $item['product_id']))
            break;
    }
    if (!$requires_shipping)
        return $status;
    return 'wc-processing';
}, 10, 2);

//add_filter('wc_clearsale_skip_order__', function($skip, $order_id) {
//    $order = wc_get_order($order_id);
//    $items = $order->get_items();
//    return array_filter($items, function($item) {
//        return EVENT_DEPOSIT == $item['product_id'];
//    });
//    return false;
//    
//}, 10, 2);



add_action('woocommerce_payment_complete_', function($order_id) {
    $order = wc_get_order($order_id);
    $items = $order->get_items();
    $event_deposit = array_filter($items, function($item) {
        return EVENT_DEPOSIT == $item['product_id'];
    });
    if ($event_deposit) {
        $order->update_status('completed');
        wp_mail('franworkspace@gmail.com', 'woocommerce_payment_complete event deposit', '$order_id: ' . $order_id);
        //$order->set_status( 'completed' );
    }
}, 11, 1);


add_action('woocommerce_order_status_changed', function($order_id, $old_status, $new_status) {
    error_log('woocommerce_order_status_changed ' . $order_id);
    //wp_mail('franworkspace@gmail.com', 'woocommerce_payment_complete hook', '$order_id: ' . $order_id);
    $order = wc_get_order($order_id);
    $items = $order->get_items();
    $event_deposit = array_filter($items, function($item) {
        return EVENT_DEPOSIT == $item['product_id'];
    });
    if ($event_deposit && $new_status == 'on-hold') {
        //wp_mail('franworkspace@gmail.com', 'woocommerce_order_status_changed event deposit to complete', '$order_id: ' . $order_id);
        $order->update_status('completed');
    }
}, 10, 3);


//$order_status = apply_filters( 'wc_' . $this->get_id() . '_held_order_status', $order_status, $order, $response );
add_filter('wc_cybersource_held_order_status_', function($status, $order) {
    error_log('wc_cybersource_held_order_status');
    wp_mail('franworkspace@gmail.com', 'woocommerce_payment_complete hook', '$order_id: ' . $order->get_id());
    $items = $order->get_items();
    $event_deposit = array_filter($items, function($item) {
        return EVENT_DEPOSIT == $item['product_id'];
    });
    if ($event_deposit) {
        wp_mail('franworkspace@gmail.com', 'woocommerce_payment_complete event deposit', '$order_id: ' . $order->get_id());
        return 'wc-completed';
    }
}, 10, 2);


//add_action('wp_ajax_nopriv_update_gift_email', 'update_gift_email_call');
add_action('wp_ajax_update_gift_email', 'update_gift_email_call');

function update_gift_email_call() {
    if (empty($_POST['post_id']) || empty($_POST['item_id']) || empty($_POST['email']) || empty($_POST['item_name']))
        wp_die('ko');
    $order = wc_get_order($_POST['post_id']);
    $valid_item_id = false;
    foreach ($order->get_items() as $item) {
        if ($item->get_id()) {
            $valid_item_id = true;
            break;
        }
    }

    if ($valid_item_id) {
        $from = wc_get_order_item_meta($_POST['item_id'], 'user_email', true);
        wc_update_order_item_meta($_POST['item_id'], 'user_email', $_POST['email']);
        $order->add_order_note(sprintf(esc_html__('gift email Item %s updated from %s to %s', 'woocommerce-plugin-framework'), $_POST['item_name'], $from, $_POST['email']));
    }
    wp_die('ok');
}

// Backend: Updating Order data
add_action('save_post_shop_order', function ($post_id, $post, $update) {

    if (!$update || empty($_POST['_billing_email']))
        return $post_id;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    $_billing_email = get_post_meta($post_id, '_billing_email', true);
    $order = wc_get_order($post_id);
    //error_log('process_offline_order: ' . print_r([$_billing_email, $update, $post, $_POST], true));
    if ($_POST['_billing_email'] != $_billing_email)
        $order->add_order_note(sprintf(esc_html__('billing email updated from %s To %s', 'woocommerce-plugin-framework'), $_billing_email, $_POST['_billing_email']));
}, 3, 10);

function woocommerce_product_archive_description() {
    // Don't display the description on search results page 
    if (is_search()) {
        return;
    }

    if (is_post_type_archive('product') && 0 === absint(get_query_var('paged'))) {
        $shop_page = get_post(wc_get_page_id('shop'));
        if ($shop_page) {
            $description = wc_format_content($shop_page->post_content);
            if ($description) {
                echo '<div class="page-description c-page-header">' . $description . '</div>';
            }
        }
    }
}

add_action('admin_footer', function() {
    global $current_user;
    $is_admin = false;
    if (!empty($current_user->roles)) {
        foreach ($current_user->roles as $key => $value) {
            if ($value == 'administrator') {
                $is_admin = true;
            }
        }
    }

    if (!$is_admin) {
        ?>
        <script>
            jQuery(document).ready(function ($) {
                $('#woocommerce-order-items').find('.refund-items').remove();
            });
        </script>
        <?php
    }
});

//apply_filters( 'woocommerce_order_item_get_formatted_meta_data', $formatted_meta, $this );
add_filter('woocommerce_order_item_get_formatted_meta_data_', function($formatted_meta) {
    global $current_user;
    $is_admin = false;
    if (!empty($current_user->roles)) {
        foreach ($current_user->roles as $key => $value) {
            if ($value == 'administrator') {
                $is_admin = true;
            }
        }
    }

    if (!$is_admin) {
        //var_dump($formatted_meta);
        foreach ($formatted_meta as $key => $item) {
            if (in_array($item->key, ['paytronixRegCode', 'PaytronixCardNumber', 'isGiftCard'])) {
                unset($formatted_meta[$key]);
            }
        }
    }
    return $formatted_meta;
});

// To remove Breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
// To remove Sorting
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
// Result Count 
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
// Remove refund action when change status to refunded
remove_action('woocommerce_order_status_refunded', 'wc_order_fully_refunded');


//do_action( 'woocommerce_order_refunded', $order->get_id(), $refund->get_id() );



if (!function_exists('woocommerce_template_loop_product_title')) {

    /**
     * Show the product title in the product loop. By default this is an H2.
     */
    function woocommerce_template_loop_product_title() {
        echo '<span class="c-product__title">' . get_the_title() . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

}

if (!function_exists('woocommerce_template_loop_product_link_open')) {

    /**
     * Insert the opening anchor tag for products in the loop.
     */
    function woocommerce_template_loop_product_link_open() {
        global $product;

        $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

        echo '<a href="' . esc_url($link) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link c-product">';
    }

}

if (!function_exists('woocommerce_template_loop_price')) {

    /**
     * Get the product price for the loop.
     */
    function woocommerce_template_loop_price() {
        //wc_get_template( 'loop/price.php' );
    }

}

if (!function_exists('woocommerce_template_loop_add_to_cart')) {

    /**
     * Get the add to cart template for the loop.
     *
     * @param array $args Arguments.
     */
    function woocommerce_template_loop_add_to_cart($args = array()) {
        global $product;

        if ($product) {
            $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
            echo '<span class="c-product__teaser">' . get_field('product_teaser', get_the_ID()) . '</span>';
            echo '<a href="' . esc_url($link) . '" class="button button--small c-product__button">Purchase</a>';
        }
    }

}

if (!function_exists('woocommerce_below_shop_page_content_callback')) {

    function woocommerce_below_shop_page_content_callback() {

        $shop_page_id = wc_get_page_id('shop');
        ?>
        <img src="/assets/img/horizontal-decorator.svg" class="c-decorator">

        <div class="u-good-to-know">
            <span class="u-good-to-know__heading"><?php the_field('good_to_know_heading', $shop_page_id); ?></span>
            <?php the_field('good_to_know_text', $shop_page_id); ?>
        </div>

        <div class="u-card-support">
            <span class="t-heading-two u-card-support__heading">Gift Card Support</span>
            <span class="button button--alternate u-card-support__call">Call  <?php the_field('customer_service_phone', 'options'); ?></span>
            <span class="u-card-support__or">or</span>
            <a href="/contact/" class="button u-card-support__email">Contact a Gift Card Specialist</a>
        </div>
        <?php
    }

}
add_action('woocommerce_below_shop_page_content', 'woocommerce_below_shop_page_content_callback');

if (!function_exists('woocommerce_get_product_thumbnail')) {

    /**
     * Get the product thumbnail, or the placeholder if not set.
     *
     * @param string $size (default: 'woocommerce_thumbnail').
     * @param int    $deprecated1 Deprecated since WooCommerce 2.0 (default: 0).
     * @param int    $deprecated2 Deprecated since WooCommerce 2.0 (default: 0).
     * @return string
     */
    function woocommerce_get_product_thumbnail($size = 'woocommerce_thumbnail_new', $deprecated1 = 0, $deprecated2 = 0) {
        global $product;

        $image_size = apply_filters('single_product_archive_thumbnail_size', $size);

        return $product ? $product->get_image($image_size) : '';
    }

}

// Remove Related product from single product page
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

add_action('woocommerce_shop_page_link', 'woocommerce_shop_page_link_callback');

function woocommerce_shop_page_link_callback() {
    $shop_page_id = wc_get_page_id('shop');
    echo '<a href="' . get_the_permalink($shop_page_id) . '" class="u-promo-back u-step-back backto-all">Back to All Products</a>';
}

function disable_shipping_calc_on_cart($show_shipping) {
    if (is_cart()) {
        return false;
    }
    return $show_shipping;
}

add_filter('woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99);
add_filter('woocommerce_shipping_package_name', 'custom_shipping_package_name');

function custom_shipping_package_name($name) {
    return '<span class="t-heading-five shipping-title">Shipping Options</span>';
}

add_action('woocommerce_after_checkout_validation', 'misha_validate_fname_lname', 20, 2);

function misha_validate_fname_lname($fields, $errors) {
    require get_template_directory() . '/inc/us-zipcode.php';
    if ($fields['billing_postcode'] != "") {
        if (!in_array($fields['billing_postcode'], $validFedExZipCodes))
            $errors->add('validation', 'Wrong zip code');
    } else {
        $errors->add('validation', 'ZIP code is not valide');
    }
    if (get_field('ga_autocomplete_checkout_required', 'option')) {
        if (empty($_POST['place_changed'])) {
            $errors->add('validation', '<b>Billing Street address</b> Select a suggested google address');
        }
    }
}

//Signature Field
add_filter('woocommerce_checkout_fields', 'signature_field');

// Our hooked in function - $fields is passed via the filter!
function signature_field($fields) {
    $fields['billing']['signature'] = array(
        'label' => __('signature', 'woocommerce'),
        'placeholder' => _x('signature', 'placeholder', 'woocommerce'),
        'required' => false,
        'class' => array('form-row-wide'),
        'clear' => true,
        'type' => 'select',
        'options' => array(
            '' => __('Signature Option', 'woocommerce'),
            'Signature Required' => __('Signature Required', 'woocommerce'),
            'No Signature' => __('No Signature', 'woocommerce')
        )//end of options
    );
    $fields['billing']['optMarketing'] = array(
        'label' => __('OPT-IN FOR EXCLUSIVE DEALS AND OFFERS', 'woocommerce'),
        'placeholder' => '',
        'required' => false,
        'class' => array('form-row-wide', 'address-field'),
        'type' => 'text'
    );
    return $fields;
}

add_action('woocommerce_checkout_update_order_meta', 'signature_field_update_order_meta');

function signature_field_update_order_meta($order_id) {
    if (!empty($_POST['signature'])) {
        update_post_meta($order_id, 'signature', sanitize_text_field($_POST['signature']));
    }
    $val = !empty($_POST['optMarketing']) ? 'Yes' : 'No';
    update_post_meta($order_id, 'optMarketing', $val);

    if (!empty($_POST['order_comments'])) {
        $data = array(
            'ID' => $order_id,
            'post_excerpt' => $_POST['order_comments'],
        );
        wp_update_post($data);
    }

    $shippingEmailAddress = !empty($_POST['shipping_email']) ? $_POST['shipping_email'] : $_POST['billing_email'];
    update_post_meta($order_id, '_shipping_email', sanitize_text_field($shippingEmailAddress));
}

add_action('woocommerce_admin_order_data_after_shipping_address', 'edit_woocommerce_checkout_page', 10, 1);

function edit_woocommerce_checkout_page($order) {
    global $post_id;
    $order = new WC_Order($post_id);
    if (get_post_meta($order->get_id(), 'signature', true)):
        echo '<p><strong>' . __('Signature') . ':</strong> ' . get_post_meta($order->get_id(), 'signature', true) . '</p>';
    endif;
}

//Custom status

add_filter('woocommerce_register_shop_order_post_statuses', 'register_custom_order_status');

function register_custom_order_status($order_statuses) {

    // Status must start with "wc-"
    $order_statuses['wc-sent'] = array(
        'label' => _x('Issues', 'Order status', 'woocommerce'),
        'public' => false,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Issues <span class="count">(%s)</span>', 'Issues <span class="count">(%s)</span>', 'woocommerce'),
    );
    $order_statuses['wc-shipped'] = array(
        'label' => _x('Shipped', 'Order status', 'woocommerce'),
        'public' => false,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'woocommerce'),
    );
    $order_statuses['wc-denied-clearsale'] = array(
        'label' => _x('Denied by ClearSale', 'Order status', 'woocommerce'),
        'public' => false,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Denied by ClearSale <span class="count">(%s)</span>', 'Denied by ClearSale <span class="count">(%s)</span>', 'woocommerce'),
    );
    $order_statuses['wc-pending-fulfillment'] = array(
        'label' => _x('Pending Fulfillment', 'Order status', 'woocommerce'),
        'public' => false,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Pending Fulfillment <span class="count">(%s)</span>', 'Pending Fulfillment <span class="count">(%s)</span>', 'woocommerce'),
    );
    return $order_statuses;
}

// ---------------------
// 2. Show Order Status in the Dropdown @ Single Order and "Bulk Actions" @ Orders

add_filter('wc_order_statuses', 'show_custom_order_status');

function show_custom_order_status($order_statuses) {
    $order_statuses['wc-sent'] = _x('Issues', 'Order status', 'woocommerce');
    $order_statuses['wc-shipped'] = _x('Shipped', 'Order status', 'woocommerce');
    $order_statuses['wc-denied-clearsale'] = _x('Denied by ClearSale', 'Order status', 'woocommerce');
    $order_statuses['wc-pending-fulfillment'] = _x('Pending Fulfillment', 'Order status', 'woocommerce');
    return $order_statuses;
}

add_filter('bulk_actions-edit-shop_order', 'get_custom_order_status_bulk');

function get_custom_order_status_bulk($bulk_actions) {
    // Note: "mark_" must be there instead of "wc"
    $bulk_actions['mark_sent'] = 'Change status to Issues';
    $bulk_actions['mark_shipped'] = 'Change status to shipped';

    return $bulk_actions;
}

/*
  To add BCC email in completed order email template
 */
add_filter('woocommerce_email_headers', 'woocommerce_completed_order_email_bcc_copy', 10, 2);

function woocommerce_completed_order_email_bcc_copy($headers, $email) {
    if ($email == 'customer_completed_order') {
        $headers .= 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>' . "\r\n";
    }

    return $headers;
}

add_action('woocommerce_after_checkout_validation', 'woocommerce_after_checkout_validation_callback', 10, 2);

function woocommerce_after_checkout_validation_callback($fields, $errors) {


    $requiresSignature = false;
    $requires_shipping = false;
    foreach (WC()->cart->get_cart_contents() as $item) {
        if (get_field('requires_shipping', $item['product_id'])) {
            $requiresSignature = true;
            $requires_shipping = true;
            break;
        }
    }

    if ($requires_shipping) {
        if (
                (empty($_POST['shipping_address_1']) || empty($_POST['ship_to_different_address'])) &&
                (stripos(strtolower($_POST['billing_address_1']), 'po box') !== false ||
                stripos(strtolower($_POST['billing_address_1']), 'p.o box') !== false ||
                stripos(strtolower($_POST['billing_address_1']), 'po. box') !== false ||
                stripos(strtolower($_POST['billing_address_1']), 'p.o. box') !== false ||
                stripos(strtolower($_POST['billing_address_1']), 'P O Box') !== false ||
                stripos(strtolower($_POST['billing_address_1']), 'P. O. Box') !== false ||
                stripos(strtolower($_POST['billing_address_1']), 'Box 23') !== false ||
                stripos(strtolower($_POST['billing_address_1']), 'p.o.box') !== false)
        ) {

            $errors->remove('billing_address_1_validation');
            $errors->add('validation', '<b>Billing Address</b> is not valid. We do not ship to PO boxes.');
        }

        if (
                stripos(strtolower($_POST['shipping_address_1']), 'po box') !== false ||
                stripos(strtolower($_POST['shipping_address_1']), 'p.o box') !== false ||
                stripos(strtolower($_POST['shipping_address_1']), 'po. box') !== false ||
                stripos(strtolower($_POST['shipping_address_1']), 'p.o. box') !== false ||
                stripos(strtolower($_POST['shipping_address_1']), 'P O Box') !== false ||
                stripos(strtolower($_POST['shipping_address_1']), 'P. O. Box') !== false ||
                stripos(strtolower($_POST['shipping_address_1']), 'Box 23') !== false ||
                stripos(strtolower($_POST['shipping_address_1']), 'p.o.box') !== false) {

            $errors->remove('shipping_address_1_validation');
            $errors->add('validation', '<b>Shipping Address</b> is not valid. We do not ship to PO boxes.');
        }
    }

    if (strtolower($_POST['repeat_billing_email']) != strtolower($_POST['billing_email']) || 'gulnnlpelei@gmail.com' == strtolower($_POST['billing_email'])) {
        $errors->add('validation', '<b>Repeat email</b> needs to match with email field');
    }

    if (isset($_POST['signature']) && $_POST['signature'] == '' && $requiresSignature) {
        $errors->add('validation', '<b>Signature Option</b> is a required field.');
    }

    if (!empty($_POST['shipping_email']) && strtolower($_POST['repeat_shipping_email']) != strtolower($_POST['shipping_email'])) {
        $errors->add('validation', '<b>Shipping Repeat email</b> needs to match with shipping email field');
    }
}

add_filter('woocommerce_reports_get_order_report_data_args', 'woocommerce_reports_add_shipped_status', 1, 1);

function woocommerce_reports_add_shipped_status($args) {
    if (isset($args['order_status']) && is_array($args['order_status']) && !in_array('shipped', $args['order_status'])) {
        $args['order_status'][] = 'shipped';
    }

    if (isset($args['parent_order_status']) && is_array($args['parent_order_status']) && !in_array('shipped', $args['parent_order_status'])) {
        $args['parent_order_status'][] = 'shipped';
    }



    //var_dump($args);
    return $args;
}

//function wc_cancel_unpaid_orders_checking() {
//    $held_duration = get_option('woocommerce_hold_stock_minutes');
//    error_log('wc_cancel_unpaid_orders_checking: ' . $held_duration);
//
//    if ($held_duration < 1 || 'yes' !== get_option('woocommerce_manage_stock')) {
//        return;
//    }
//    if ($_GET['franview']) {
//        var_dump($held_duration);
//        exit;
//    }
//
//
//    $data_store = WC_Data_Store::load('order');
//    $unpaid_orders = $data_store->get_unpaid_orders(strtotime('-' . absint($held_duration) . ' MINUTES', current_time('timestamp')));
//
//    if ($unpaid_orders) {
//        foreach ($unpaid_orders as $unpaid_order) {
//            $order = wc_get_order($unpaid_order);
//
//            if (apply_filters('woocommerce_cancel_unpaid_order', 'checkout' === $order->get_created_via(), $order)) {
//                $order->update_status('cancelled', __('Unpaid order cancelled - time limit reached.', 'woocommerce'));
//            }
//        }
//    }
//    wp_clear_scheduled_hook('woocommerce_cancel_unpaid_orders');
//    wp_schedule_single_event(time() + ( absint($held_duration) * 60 ), 'woocommerce_cancel_unpaid_orders');
//}
//add_action( 'init', 'wc_cancel_unpaid_orders_checking' );



remove_action('woocommerce_shop_page_link', 'woocommerce_shop_page_link_callback');

add_action('woocommerce_shop_page_link', 'tx_woocommerce_shop_page_link_callback');

function tx_woocommerce_shop_page_link_callback() {

    echo '<a href="/shop/gift-cards/" class="u-promo-back u-step-back backto-all">Back to gift card proucts</a>';
}

add_filter('wc_add_to_cart_message_html', '__return_false');


add_filter('woocommerce_add_cart_item_data', 'custom_data_to_cart_item', 10, 3);

function custom_data_to_cart_item($cart_item_data, $product_id, $variation_id) {
    $theme_id = filter_input(INPUT_POST, 'theme_id');
    if ($product_id == 653 || $product_id == 63778 || $product_id == 23574) {
        $firstname = filter_input(INPUT_POST, 'firstName');
        $lastname = filter_input(INPUT_POST, 'lastName');
        $email = filter_input(INPUT_POST, 'email');
        $message = filter_input(INPUT_POST, 'message');
        $giftCard = filter_input(INPUT_POST, 'isGiftCard');
    }

    if (empty($theme_id)) {
        return $cart_item_data;
    }

    $cart_item_data['theme_id'] = $theme_id;

    if ($product_id == 653 || $product_id == 63778 || $product_id == 23574) {
        $cart_item_data['firstname'] = $firstname;
        $cart_item_data['lastname'] = $lastname;
        $cart_item_data['user_email'] = $email;
        $cart_item_data['message'] = $message;
        $cart_item_data['isGiftCard'] = $giftCard;
    }

    return $cart_item_data;
}

add_action('woocommerce_add_order_item_meta', 'wdm_add_values_to_order_item_meta', 1, 2);
if (!function_exists('wdm_add_values_to_order_item_meta')) {

    function wdm_add_values_to_order_item_meta($item_id, $values) {
        global $woocommerce, $wpdb;
        $theme_id = isset($values['theme_id']) ? $values['theme_id'] : false;
        if (!empty($theme_id)) {
            wc_add_order_item_meta($item_id, 'theme_id', $theme_id);
        }
        if (!empty($values['firstname']))
            wc_add_order_item_meta($item_id, 'firstname', $values['firstname']);
        if (!empty($values['lastname']))
            wc_add_order_item_meta($item_id, 'lastname', $values['lastname']);
        if (!empty($values['user_email']))
            wc_add_order_item_meta($item_id, 'user_email', $values['user_email']);
        if (!empty($values['message']))
            wc_add_order_item_meta($item_id, 'message', $values['message']);
        if (!empty($values['isGiftCard']))
            wc_add_order_item_meta($item_id, 'isGiftCard', $values['isGiftCard']);
    }

}


remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('woocommerce_after_order_notes', 'woocommerce_checkout_payment', 20);



add_filter('woocommerce_billing_fields', 'texas_move_checkout_email_field', 10, 1);

function texas_move_checkout_email_field($address_fields) {
    $address_fields['billing_email']['priority'] = 35;
    $address_fields['billing_address_1']['priority'] = 36;
    $address_fields['billing_address_2']['priority'] = 37;
    return $address_fields;
}

add_filter('woocommerce_checkout_fields', 'alter_woocommerce_checkout_fields');

function alter_woocommerce_checkout_fields($fields) {
    unset($fields['order']['order_comments']);
    return $fields;
}

add_filter('woocommerce_package_rates', 'businessbloomer_hide_free_shipping_for_shipping_class', 10, 2);

function businessbloomer_hide_free_shipping_for_shipping_class($rates, $package) {
    $shipping_class_target = 21; // shipping class ID (to find it, see screenshot below)
    $in_cart = false;
    foreach (WC()->cart->cart_contents as $key => $values) {
        if ($values['data']->get_shipping_class_id() == $shipping_class_target) {
            $in_cart = true;
            break;
        }
    }
    if ($in_cart) {
        unset($rates['free_shipping:4']);
    }
    return $rates;
}

add_action('woocommerce_payment_complete', 'texas_change_status_function', 10, 1);

function texas_change_status_function($order_id) {
    $order = wc_get_order($order_id);
    $order->update_status('completed');
}

add_filter('woocommerce_email_subject_customer_completed_order', 'change_customer_email_subject', 1, 2);

function change_customer_email_subject($subject, $order) {
    global $woocommerce;

    //$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $subject = sprintf(' Order #%s Receipt', $order->id);
    return $subject;
}

/*
  Remove Order Action from wp dashboard from left sidebar
  define the item in the meta box by adding an item to the $actions array
 */

add_action('woocommerce_order_actions', 'add_order_meta_box_actions');

function add_order_meta_box_actions($actions) {
    unset($actions['send_order_details_admin']);
    unset($actions['regenerate_download_permissions']);
    unset($actions['send_order_details']);
//    $actions['resend_physical_gift_card_emails'] = __('Resend physical gift card emails', 'woocommerce');
//    $actions['resend_bonus_card_emails'] = __('Resend bonus card emails', 'woocommerce');
    return $actions;
}

add_action('woocommerce_order_action_resend_bonus_card_emails', 'resend_bonus_card_emails_callback', 10, 1);

function resend_bonus_card_emails_callback($order) {
    global $wpdb;
    $getcards = $wpdb->get_results("SELECT bonuscard_number,reg_code, amount FROM " . $wpdb->prefix . "bonuscard WHERE order_id =" . $order->id, ARRAY_A);
    foreach ($getcards as $card) {
        $cardNumber = $card['bonuscard_number'];
        $regCode = $card['reg_code'];
        $amount = $card['amount'];
        if ($amount == 25):
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //() . '/assets/img/25-bonus.jpg';
        elseif ($amount == 10):
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
        else:
            //Default $10 image
            $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
        endif;
        $subject = 'Your Texas de Brazil Bonus Card';
        $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
        $body = include(WP_PLUGIN_DIR . '/texas/texas-bonus-email-template.php');
        $toEmail = $order->get_billing_email();
        error_log("======================================================");
        error_log("sending bonus mail to--" . $toEmail);
        if (wp_mail($toEmail, $subject, $body, $headers)) {
            $result = true;
        } else {
            $result = false;
        }
    }
    return $result;
}

add_action('woocommerce_order_action_resend_physical_gift_card_emails', 'physical_gift_card_meta_box_actions', 10, 1);

function physical_gift_card_meta_box_actions($order) {
    $customer_email = $order->get_billing_email();

    include(get_template_directory() . '/emails/resend-order-detail.php');

    $order->add_order_note(__('Physical gift card Order details manually sent to customer.', 'woocommerce'), false, true);
}

add_action('woocommerce_payment_complete', 'after_order_completed', 10, 1);

function after_order_completed($order_id) {
    if (!$order_id)
        return;

    $order = wc_get_order($order_id);
    $items = $order->get_items();
    $shipping = false;
    foreach ($items as $item) {
        if (get_post_meta($item['product_id'], 'requires_shipping', true) === '1') {
            $shipping = true;
            break;
        }
    }
    if ($shipping)
        $order->update_status('processing'); //processing
}

// Checking and validating when products are added to cart
add_filter('woocommerce_add_to_cart_validation', 'limit_cart_quantity', 10, 3);

function limit_cart_quantity($passed, $product_id, $quantity) {
    $cart = WC()->cart;
//    if($contents=$cart->get_cart_contents()){
//        foreach($contents as $content){
//            if($content['product_id']!=$product_id){
//                wc_add_notice(__("You can only have 1 type of card in the cart at the same time", "woocommerce"), "error");
//                $passed = false;
//            }
//        }
//    }

    $cart_items_count = $cart->get_cart_contents_count();
    $total_count = $cart_items_count + $quantity;
    if ($cart_items_count >= 10 || $total_count > 10) {
        // Set to false
        $passed = false;
        // Display a message
        wc_add_notice(__("You can’t have more than 10 items in the cart", "woocommerce"), "error");
    }
    return $passed;
}

function add_test_fraud_order_to_order_statuses($order_statuses) {
    $new_order_statuses = array();
    foreach ($order_statuses as $key => $status) {
        $new_order_statuses[$key] = $status;
        if ('wc-processing' === $key) {
            $new_order_statuses['wc-test-order'] = 'Test order';
            $new_order_statuses['wc-fraud'] = 'Fraud';
        }
    }
    if (!current_user_can('manage_options') && is_admin()) {
        unset($new_order_statuses['wc-completed']);
    }
    return $new_order_statuses;
}

add_filter('wc_order_statuses', 'add_test_fraud_order_to_order_statuses');

add_action('wp', function() {
    return;

    if (empty($_GET['fra']))
        return;


    // Get orders on hold.
    $args = array(
        'status' => 'on-hold',
        'numberposts' => '1447',
    );

    $orders = wc_get_orders($args);
    //Automattic\WooCommerce\Admin\Overrides\Order::class;

    foreach ($orders as $order) {
        var_dump($order->get_id());

        $order->update_status('fraud');
    }
    exit;
});




add_action('woocommerce_email', 'unhook_those_pesky_emails');

function unhook_those_pesky_emails($email_class) {

    remove_action('woocommerce_order_status_completed_notification', array($email_class->emails['WC_Email_Customer_Completed_Order'], 'trigger')); // cancels automatic email of order complete status update.
    remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_New_Order'], 'trigger')); // cancels automatic email of new order placed (when defined to procession status)
    remove_action('woocommerce_order_status_pending_to_processing_notification', array($email_class->emails['WC_Email_Customer_Processing_Order'], 'trigger')); // cancels automatic email of status update to processing.
}

add_action('woocommerce_checkout_order_processed', 'tx_count_orders', 10);

function tx_count_orders() {
    $count = get_option('tx_count_orders', []);
    $time = date('Y-F');
    if (is_array($count) && !empty($count) && !empty($count[$time])) {
        $count[$time] = (int) $count[$time];
        $count[$time]++;
    } else {
        $count[$time] = 1;
    }
    update_option('tx_count_orders', $count);
}

//log user views to orders
add_filter('replace_editor', function($replace, $post) {
    if ('shop_order' == $post->post_type) {
        $trace = debug_backtrace();
        if (!empty($trace[2]['file']) && strpos($trace[2]['file'], '/wp-admin/post.php') !== false) {
            $user = wp_get_current_user();


            if (!empty($_GET['replace_editor'])) {
                $order_log = get_option('order_log', []);
                unset($order_log[15]);
//            unset($order_log[12]);
//            unset($order_log[13]);
//            unset($order_log[14]);
                //update_option('order_log', $order_log);
                var_dump($order_log);
            }

//            if ('fran@thriveground.com' == $user->user_email)
//                return $replace;

            $time = current_time("F jS Y, H:i");
            //$location = $_SERVER['REQUEST_URI'];
//            $ban = "#$time visit from - $user->user_email to $location\r\n";
//            $file = dirname(__FILE__) . '/order_log.txt';
//            $open = fopen($file, "a");
//            $write = fputs($open, $ban);
//            fclose($open);

            $order_log = get_option('order_log', []);
            $order_log[] = [
                'time' => $time,
                'id' => $post->ID,
                'email' => $user->user_email,
            ];
            update_option('order_log', $order_log);
        }



        //var_dump('$user->user_email');
    }

    return $replace;
}, 10, 2);

add_action('admin_menu', function() {



    add_menu_page('Order log', 'Order log', 'manage_options', 'order_log', function() {
        ?>
        <h1 style="padding:20px;">
            Order page logger.
        </h1>
        <div id="search-logger">
            <input placeholder="search" type="text">
            <button type="button">Search</button>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                $('#search-logger button').click(function () {
                    let val = $('#search-logger input').val();
                    console.log('val', val);
                    if (val.length) {
                        $('.order-log-item').hide()
                        $('.' + val).show()
                    } else {
                        $('.order-log-item').show()
                    }

                });

            });
        </script>
        <style>
            #search-logger{
                display:flex;
            }
            #search-logger input{
                margin-right: 8px;
            }
        </style>
        <?php
//        $file = dirname(__FILE__) . '/order_log.txt';
//        $gestor = fopen($file, "rb");
//        if (FALSE === $gestor) {
//            return;
//        }
//        $contenido = '';
//        while ($búfer = fgets($gestor, 4096)) {
//            $contenido .= '<p style="margin:0;font-size:18px;">' . $búfer . '</p>';
//        }
//        fclose($gestor);
//        echo $contenido;


        if ($order_log = get_option('order_log', [])) {
            echo '<ul>';
            foreach ($order_log as $item) {
                echo '<li class="order-log-item ' . $item['id'] . '">Time: <b>' . $item['time'] . '</b>, Email: <b>' . $item['email'] . '</b>, ID: <b>' . $item['id'] . '</b></li>';
            }
            echo '</ul>';
        }
    }, null, 20);
}, 99999);


//apply_filters( 'woocommerce_checkout_posted_data', $data );
//add_filter('woocommerce_checkout_posted_data', function($data) {
//    error_log('woocommerce_checkout_posted_data: ' . print_r($data, true));
//    return $data;
//});
//update title for checkout payment page
add_action('wp', function() {
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    if (!empty($uri_segments[2]) && $uri_segments[2] == 'order-pay'):
        add_filter('wpseo_title', function($title) {
            return 'Checkout | Payment';
        }, 10, 1);
    endif;
});

add_action('_woocommerce_order_actions', function ($actions) {
    $actions['reverse_authorization'] = __('Revert credit cart authorization', 'woocommerce');
    return $actions;
});
add_action('_woocommerce_order_action_reverse_authorization', function($order) {
    include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/Payments/Reversal/ProcessAuthorizationReversal.php');
    $data = [
        'id' => get_post_meta($order->get_id(), '_transaction_id'),
        'code' => get_post_meta($order->get_id(), '_wc_cybersource_credit_card_authorization_code'),
        'reason' => 'Authorization reversal',
        'total' => $order->get_total(),
    ];
    error_log('cybersource_mark_order_as_failed: ' . print_r([$data], true));
    //$result = ProcessAuthorizationReversal($data);
    //error_log('ProcessAuthorizationReversal $result: ' . print_r($result, true));
}, 10, 1);

//wp-content\plugins\woocommerce-gateway-cybersource\vendor\skyverge\wc-plugin-framework\woocommerce\payment-gateway\class-sv-wc-payment-gateway.php L 288
add_action('_cybersource_mark_order_as_failed', function($order, $response) {
    if (!empty($response->response_data->errorInformation->reason) && 'AVS_FAILED' == $response->response_data->errorInformation->reason) {
        //Soft Decline
        $data = [
            'id' => $response->response_data->id,
            'code' => $order->get_id(),
            'reason' => 'Authorization reversal',
            'total' => $order->get_total(),
        ];
        error_log('cybersource_mark_order_as_failed Soft: ' . print_r(['data' => $data, 'response' => $response->response_data], true));
        //$result = ProcessAuthorizationReversal($data);
        error_log('ProcessAuthorizationReversal $result: ' . print_r($result, true));
        $order->add_order_note(sprintf(esc_html__('(Authorization Reversal for Transaction ID %s)', 'woocommerce-plugin-framework'), $response->response_data->id));
    }

    //include_once(get_template_directory() . '/inc/cybersource-rest-samples-php/Samples/Payments/Reversal/ProcessAuthorizationReversal.php');
//    $data = [
//        'id' => $response->response_data->id,
//        'code' => $response->response_data->clientReferenceInformation->code,
//        'reason' => $response->response_data->errorInformation->message,
//        'total' => $order->get_total(),
//    ];
//    error_log('cybersource_mark_order_as_failed: ' . print_r([$data], true));
//    error_log('ProcessAuthorizationReversal $result: ' . print_r($result, true));
    //$order->add_order_note( sprintf( esc_html__( '(Authorization Reversal for Transaction ID %s)', 'woocommerce-plugin-framework' ), $transactionId )  );
    //SkyVerge\WooCommerce\Cybersource\API\Responses\Payments\Credit_Card_Payment::class;
//    Automattic\WooCommerce\Admin\Overrides\Order::class;
}, 10, 2);


add_action('wp_', function() {
    return;
    if (!empty($_GET['blacklist_test'])) {
        $controller = $GLOBALS[Aelia\WC\Blacklister\WC_Aelia_Blacklister::$plugin_slug]->settings_controller();
        $current_settings = $controller->current_settings();
        $current_settings["blacklisted_emails"] = $current_settings["blacklisted_emails"] . '
testemail@mail.com';
        $controller->save($current_settings);

        //var_dump($current_settings);

        var_dump(get_option('wc_aelia_blacklister'));
    }


    if (!empty($_GET['blacklist_block_froud'])) {

        var_dump('blacklist_block_froud');

        $loop = new WP_Query(array(
            'post_type' => 'shop_order',
            'post_status' => 'wc-fraud',
            'posts_per_page' => -1,
        ));

        //var_dump($loop);
// The Wordpress post loop
        if ($loop->have_posts()):

            $controller = $GLOBALS[Aelia\WC\Blacklister\WC_Aelia_Blacklister::$plugin_slug]->settings_controller();
            $current_settings = $controller->current_settings();

            //var_dump($current_settings); return;

            while ($loop->have_posts()) : $loop->the_post();
                $order = wc_get_order($loop->post->ID);
                $has_email = strpos($current_settings["blacklisted_emails"], $order->get_billing_email()) !== false;
                $has_ip = strpos($current_settings["blacklisted_ip_addresses"], $order->get_customer_ip_address()) !== false;
                $has_phone = strpos($current_settings["blacklisted_phone_numbers"], $order->get_billing_phone()) !== false;

                if ($has_phone && $has_email && $has_ip) {
                    //var_dump($loop->post->ID);
                } else {
                    var_dump('added: ' . $loop->post->ID);
//
                    $current_settings["blacklisted_emails"] = $current_settings["blacklisted_emails"] . '
' . $order->get_billing_email();

                    $current_settings["blacklisted_ip_addresses"] = $current_settings["blacklisted_ip_addresses"] . '
' . $order->get_customer_ip_address();

                    $current_settings["blacklisted_phone_numbers"] = $current_settings["blacklisted_phone_numbers"] . '
' . $order->get_billing_phone();

                    $current_settings["blacklisted_customer_names"] = $current_settings["blacklisted_customer_names"] . '
' . $order->get_shipping_first_name() . '|' . $order->get_shipping_last_name();

                    $current_settings["blacklisted_addresses"] = $current_settings["blacklisted_addresses"] . '
' . $order->get_shipping_address_1();
                }




            endwhile;

            $controller->save($current_settings);

            wp_reset_postdata();

        endif;
    }
});

add_action('woocommerce_order_status_changed', 'manage_fraud_status_change', 10, 3);

function manage_fraud_status_change($order_id, $old_status, $new_status) {
    if ('fraud' == $old_status) {


        $order = wc_get_order($order_id);

        $controller = $GLOBALS[Aelia\WC\Blacklister\WC_Aelia_Blacklister::$plugin_slug]->settings_controller();
        $current_settings = $controller->current_settings();

        $current_settings["blacklisted_emails"] = str_replace('
' . $order->get_billing_email(), '', $current_settings["blacklisted_emails"]);

        $current_settings["blacklisted_ip_addresses"] = str_replace('
' . $order->get_customer_ip_address(), '', $current_settings["blacklisted_ip_addresses"]);

        $current_settings["blacklisted_phone_numbers"] = str_replace('
' . $order->get_billing_phone(), '', $current_settings["blacklisted_phone_numbers"]);


        $current_settings["blacklisted_customer_names"] = str_replace('
' . $order->get_shipping_first_name() . '|' . $order->get_shipping_last_name(), '', $current_settings["blacklisted_customer_names"]);


        $current_settings["blacklisted_addresses"] = str_replace('
' . $order->get_shipping_address_1(), '', $current_settings["blacklisted_addresses"]);
        $controller->save($current_settings);
    } elseif ('fraud' == $new_status) {


        $order = wc_get_order($order_id);
        /* ["blacklisted_emails"]=>
          string(103) "JimekaBroussard@hotmail.com
          ScottClark54125@hotmail.com
          MichaelCorbat522@hotmail.com
          testemail@mail.com"
          ["blacklisted_ip_addresses"]=>
          string(0) ""
          ["blacklisted_phone_numbers"]=>
          string(21) "5169039117
          4432553920"
          ["blacklisted_customer_names"]=>
          string(33) "Michael||Corbat
          Jennifer||Manzari"
          ["blacklisted_addresses"]=>
          string(38) "4405 Greens Pl Wilson
          45895 La Cruz Dr"

          } */
        $controller = $GLOBALS[Aelia\WC\Blacklister\WC_Aelia_Blacklister::$plugin_slug]->settings_controller();
        $current_settings = $controller->current_settings();
        $current_settings["blacklisted_emails"] = $current_settings["blacklisted_emails"] . '
' . $order->get_billing_email();
        $current_settings["blacklisted_ip_addresses"] = $current_settings["blacklisted_ip_addresses"] . '
' . $order->get_customer_ip_address();
        $current_settings["blacklisted_phone_numbers"] = $current_settings["blacklisted_phone_numbers"] . '
' . $order->get_billing_phone();
        $current_settings["blacklisted_customer_names"] = $current_settings["blacklisted_customer_names"] . '
' . $order->get_shipping_first_name() . '|' . $order->get_shipping_last_name();
        $current_settings["blacklisted_addresses"] = $current_settings["blacklisted_addresses"] . '
' . $order->get_shipping_address_1();
        $controller->save($current_settings);
    }
}

function add_to_bulk_actions_orders() {
    global $post_type;
    if ('shop_order' == $post_type) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('<option>').val('mark_fraud').text('<?php _e('Change status to fraud', 'texasdebrazil'); ?>').appendTo("select[name='action']");
                jQuery('<option>').val('mark_fraud').text('<?php _e('Change status to fraud', 'texasdebrazil'); ?>').appendTo("select[name='action2']");

                jQuery('<option>').val('mark_test-order').text('<?php _e('Change status to test', 'texasdebrazil'); ?>').appendTo("select[name='action']");
                jQuery('<option>').val('mark_test-order').text('<?php _e('Change status to test', 'texasdebrazil'); ?>').appendTo("select[name='action2']");
            });
        </script>
        <?php
    }
}

add_action('admin_footer', 'add_to_bulk_actions_orders');

require_once get_template_directory() . '/inc/AuthReversal48hDelay.class.php';

add_action('init', array('AuthReversal48hDelay', 'init'));


