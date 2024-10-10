<?php
ini_set('error_log', WP_CONTENT_DIR . '/' . date('Y_m_d') . '_errorlogs.txt');

/* CONSTANTS */
require_once get_template_directory() . '/inc/constants.php';


add_filter('deprecated_constructor_trigger_error', '__return_false');
add_filter('deprecated_function_trigger_error', '__return_false');
add_filter('deprecated_file_trigger_error', '__return_false');
add_filter('deprecated_argument_trigger_error', '__return_false');
add_filter('deprecated_hook_trigger_error', '__return_false');
add_filter('acf/the_field/escape_html_optin', '__return_false');
add_filter('acf/admin/prevent_escaped_html_notice', '__return_true');

require_once get_template_directory() . '/inc/functions.php';


//$campaigns = apply_filters( 'optin_monster_api_final_output', $campaigns, $post_id );

add_filter('optin_monster_api_final_output', function($campaigns) {
    if ('yes' == get_field('block_optin_monster_popups')) {
//        var_dump(get_field('block_optin_monster_popups'));
//        error_log('optin_monster_api_final_output updatedfd: ' . print_r([$campaigns,get_field('block_optin_monster_popups')], true));
        return [];
    }
    return $campaigns;
}, 10, 1);








$debug = false;

add_filter('wc_payment_gateway_cybersource_activate_apple_pay', '__return_true');

add_filter("sv_wc_apple_pay_is_available", function($is_available) {
    if (current_user_can('manage_options')) {
        return $is_available;
    } else {
        return false;
    }
});



/**
 * texaswp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package texaswp
 */
if (!function_exists('texaswp_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function texaswp_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on texaswp, use a find and replace
         * to change 'texaswp' to the name of your theme in all the template files.
         */
        load_theme_textdomain('texaswp', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'texaswp'),
            'footer' => esc_html__('Footer', 'texaswp'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('texaswp_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));

        add_image_size('homeslider_button', 232, 160, array('center', 'center'));
        add_image_size('woocommerce_thumbnail_new', 283, 180, array('center', 'center'));
        add_image_size('locations_togo', 420, 202, array('center', 'center'));
        add_theme_support('woocommerce');

        // This variable is intended to be overruled from themes.
        // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        $GLOBALS['content_width'] = apply_filters('texaswp_content_width', 640);
    }

endif;
add_action('after_setup_theme', 'texaswp_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
add_action('init', 'add_locations_to_json_api', 30);

function add_locations_to_json_api() {
//    if(isset($_GET['add_order'])){
//        Texas::woocommerce_new_order_callback(236302);
//    }
//    if (isset($_GET['get_status'])) {
//        $order = wc_get_order(263931);
//        var_dump($order->get_status());
//    }


    global $wp_post_types;
    $wp_post_types['locations']->show_in_rest = true;
}

function my_rest_prepare_post($data, $post, $request) {
    $_data = $data->data;
    $_data['state'] = get_post_meta($post->ID, 'state', true);
    $data->data = $_data;
    return $data;
}

add_filter('rest_prepare_post', 'my_rest_prepare_post', 10, 3);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function texaswp_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'texaswp'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'texaswp'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'texaswp_widgets_init');

function echo_locations_classes() {
    if ((is_single() && 'locations' == get_post_type()) || get_query_var('locations-togo') || get_query_var('locations-event')) {
        echo ' locations-custom';
    }
}

function extra_body_class() {
    global $wp;
    if ('locations/fort-lauderdale' == $wp->request)
        echo ' locations-custom-class';

    if ('health-and-safety' == $wp->request)
        echo ' health-safety';

    if ('specials' == $wp->request)
        echo ' specials-page';

    if ('reservations' == $wp->request)
        echo ' reservations-page';
}

/**
 * Enqueue scripts and styles.
 */
function texaswp_scripts() {
    $ver = time();
    wp_enqueue_style('texaswp-style2', get_stylesheet_uri(), array(), $ver, 'All');

    wp_enqueue_style('texaswp-style-min', get_template_directory_uri() . '/assets/css/style.css', array(), $ver, 'All');
    //wp_enqueue_style('texaswp-animsition-min', get_template_directory_uri() . '/assets/css/vendor/animsition.min.css', array(), wp_get_theme()->get('Version'), 'All');

    wp_enqueue_style('texaswp-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), $ver, 'All');
    //wp_enqueue_style('texaswp-shop-categories', get_template_directory_uri() . '/assets/css/shop-categories.css', array(), $ver, 'All');
wp_enqueue_script('texaswp-script', home_url() . '/public/assets/js/script.min.js', array(), $ver, false);
    wp_enqueue_script('texaswp-script-functions', get_template_directory_uri() . '/assets/js/functions.js', array(), $ver, false);
    wp_enqueue_script('texaswp-market-cluster', get_template_directory_uri() . '/assets/js/vendor/markerclusterer.js', array(), '20151215', true);
    

    wp_enqueue_script('texaswp-script-custom', get_template_directory_uri() . '/assets/js/script.custom.js', array(), $ver, true); 
    $block_chatbot = ('yes' == get_field('block_chatbot') || get_template_directory().'/page-template/menu-item.php' == get_page_template()) ? 'yes' : 'no';
    wp_localize_script('texaswp-script-custom', 'script_custom_object',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'block_chatbot' => $block_chatbot,
                'is_menu_item' => ('page-template/menu-item.php' == get_page_template_slug())
            )
    );

    wp_enqueue_script('texaswp-script-choices', get_template_directory_uri() . '/assets/js/Choices.js', array(), $ver, true);
    if (!is_checkout())
        wp_enqueue_script('texaswp-script-chatbot', get_template_directory_uri() . '/assets/js/chatbot.js', array(), $ver, true);

    wp_enqueue_script('texaswp-jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array(), '20151215', true);

    //wp_enqueue_script('texaswp-animsition', get_template_directory_uri() . '/assets/js/vendor/animsition.min.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'texaswp_scripts');

add_action('admin_enqueue_scripts', function() {
    $ver = time();
    wp_enqueue_script('texaswp-admin-custom', get_template_directory_uri() . '/assets/js/admin.custom.js', array(), $ver, true);
});



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/bs4navwalker.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

add_action('init', 'global_acf_init');

function global_acf_init() {

    if (function_exists('acf_add_options_page')) {

        $option_page = acf_add_options_page(array(
            'page_title' => __('Globals', 'texas'),
            'menu_title' => __('Globals', 'texas'),
            'menu_slug' => 'global-settings',
        ));
    }
}

add_filter('show_admin_bar', '__return_false');

add_filter('nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3);

function wpse156165_menu_add_class($atts, $item, $args) {
    $class = 'footer__link animsition-link'; // or something based on $item
    $atts['class'] = $class;
    return $atts;
}

require get_template_directory() . '/inc/custom-post-type.php';
require get_template_directory() . '/_ajax/ajax-popup-form.php';
require get_template_directory() . '/_ajax/ajax-contact-form.php';
require get_template_directory() . '/_ajax/eclub-ajax.php';
require get_template_directory() . '/inc/update-location-meta.php'; //
//Ajax search on location page
require get_template_directory() . '/inc/location-search.php';
require get_template_directory() . '/inc/post-column.php';
add_query_arg('from', 'eclub', home_url() . '/thanks/');

function my_acf_init() {

    acf_update_setting('google_api_key', 'AIzaSyAR0JcTIISM1lfgw7BDmHe97lva61zGKKY');
}

add_action('acf/init', 'my_acf_init');

//Award Image Sizes

if (function_exists('fly_add_image_size')) {
    fly_add_image_size('award_68', 9999, 68, false);
    fly_add_image_size('award_136', 9999, 136, false);
}

require get_template_directory() . '/inc/woocommerce-hooks.php';



add_action('wp_ajax_check_balance', 'check_balance_callback');
add_action('wp_ajax_nopriv_check_balance', 'check_balance_callback');

function check_balance_callback() {
    $cardNumber = $_POST['cardnumber'];
    $registrationCode = $_POST['regcode'];
    $headers = [
        'Content-Type: application/json',
    ];
    $endpoint = 'accountInformation.json';
    // Staging URL
    //$url = 'https://api.pxslab.com:443/api/rest/16.3/guest/'. $endpoint;
    // Live URL
    $url = 'https://api.pxsweb.com:443/api/rest/16.3/guest/' . $endpoint;
    if ($registrationCode != "") {
        $data = "authentication=card&merchantId=570&printedCardNumber={$cardNumber}&registrationCode={$registrationCode}";
    } else {
        $data = "authentication=card&merchantId=570&printedCardNumber={$cardNumber}";
    }
    //error_log('Check Balance Response: ' . json_encode($data));
    return;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . "?" . $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_ENCODING, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    //error_log('Check Balance Response: ' . json_encode($response));
    $response = json_decode($response);
    if ($response->result == 'failed') {
        $result = array(
            'status' => 'failure',
            'error' => "Unable to get Card Information {$response->errorMessage}. Please try again."
        );
        echo json_encode($result);
        die();
    }

    if (array_key_exists('storedValueBalance', $response)) {
        $balance = '$' . $response->storedValueBalance->balance;
    } elseif (array_key_exists('rewardBalances', $response)) {
        $balance = $response->rewardBalances[0]->balance . ' "' . $response->rewardBalances[0]->name . '"';
    } else {
        $balance = '';
    }

    $result = array(
        'status' => 'success',
        'balance' => $balance
    );
    echo json_encode($result);
    die();
}

function add_cors_http_header() {
    header("Access-Control-Allow-Origin: *");
}

add_action('init', 'add_cors_http_header');



add_filter('next_posts_link_attributes', 'posts_next_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_prev_link_attributes');

function posts_next_link_attributes() {
    return 'class="pagination__next"';
}

function posts_prev_link_attributes() {
    return 'class="pagination__prev"';
}

remove_post_type_support('e_club', 'editor');

add_filter('post_row_actions', 'remove_row_actions', 10, 1);

function remove_row_actions($actions) {
    if (get_post_type() === 'awards' || get_post_type() === 'faqs' || get_post_type() === 'themes')
        unset($actions['view']);
    return $actions;
}

add_filter('wp_mail_content_type', 'set_content_type');

function set_content_type($content_type) {
    return 'text/html';
}

add_action('wp_ajax_customer_order_detail', 'customer_order_detail_callback');
add_action('wp_ajax_nopriv_customer_order_detail', 'customer_order_detail_callback');

function customer_order_detail_callback() {
    $orders = false;
    if (!empty($_POST['order_number']) || !empty($_POST['billing_email'])) {
        $order = wc_get_order($_POST['order_number']);

        if ($order && in_array($order->get_status(), ['completed', 'shipped']) && $order->get_billing_email() == $_POST['billing_email']) {
            //SendCustomerAllOrderAction::manualInit($order);
            require_once('inc/PaytronixCards/inc/SendCards.class.php');
            $sendCards = new SendCards($order->get_id());
            $sendCards->sendOrderDetails();
            $order->add_order_note(__('Resend order receipt manually to customer from Recover order page.', 'woocommerce'), false, true);
            $sendCards->sendPaytronixCards([], false);
            $order->add_order_note(__('Resend E Cards manually to customer from Recover order page.', 'woocommerce'), false, true);
            $sendCards->sendBonusCards([], false);
            $order->add_order_note(__('Resend Bonus Cards manually to customer from Recover order page.', 'woocommerce'), false, true);
            if ($sendCards->sentAnyCards())
                echo "ok";
            else
                echo "ko";
            die();
        }
    }
    echo "ko";
    die();


//print_r($orders );
    if ($orders):
        foreach ($orders as $order) {
            SendCustomerAllOrderAction::manualInit($order);
            continue;

            $order_data = $order->get_data();
            $body = include(get_template_directory() . '/emails/order-detail.php');
            $toEmail = $_POST['billing_email'];

            $subject = 'Order #' . $order->get_id() . ' Receipt';
            $toEmail = 'franworkspace@gmail.com';
            wp_mail($toEmail, $subject, $body);
            foreach ($order->get_items() as $item_key => $item):
                $theme_id = $item->get_meta('theme_id');
                $isGiftCard = $item->get_meta('isGiftCard');
                $cardNumber = $item->get_meta('PaytronixCardNumber');
                $regCode = $item->get_meta('paytronixRegCode');
                $amount = $item->get_total();
                if ($isGiftCard == "Yes" && $item->get_product_id() == 653) {
                    $firstName = $item->get_meta('firstname');
                    $lastName = $item->get_meta('lastname');
                    $user_email = $item->get_meta('user_email');
                    $message = $item->get_meta('message');
                    $gift_body = include(get_template_directory() . '/emails/egift-email-template.php');
                    $subject_gift = 'Your Texas de Brazil Gift Card sent by ' . $toEmail;
                    wp_mail($user_email, $subject_gift, $gift_body);
                }

            endforeach;
        }
        echo "Emails have been sent please check your email.";
    else:
        echo "We could not find your order details. If you think this is a mistake, please email customerrelations@texasdebrazil.com.";
    endif;

    die();
}

//add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
//function custom_woocommerce_auto_complete_order($order_id) {
//    if (!$order_id) {
//        return;
//    }
//
//    $order = wc_get_order($order_id);
//    $order->update_status('completed');
//}

function send_email_notification($post_id, $concat_email = '', $concat_subject = '') {

    if ('e_club' == get_post_type($post_id)):

        $body = include(get_template_directory() . '/emails/brief_eclub_template.php');

        $toEmail = 'taylor@papertiger.com';

        $subject = 'New E-club form Submission';

    //wp_mail( $toEmail, $subject, $body );

    endif;

    if ('host_event' == get_post_type($post_id)):

        $body = include(get_template_directory() . '/emails/brief_hosting_template.php');

        $toEmail = get_field('hosting_notify_email', 'option');

        $from = get_post_meta($post_id, 'client_email', true);
        $subject = 'Host event form Submission';
        $headers = [];
        $headers[] = 'Reply-To: ' . $from;

        return wp_mail($toEmail, $subject, $body, $headers);
    endif;

    if ('catering_submission' == get_post_type($post_id)):

        $body = include(get_template_directory() . '/emails/brief_catering_template.php');

        $toEmail = get_field('catering_notify_email', 'option');

        $from = get_post_meta($post_id, 'client_email', true);
        $subject = 'Catering form Submission';
        $headers = 'Reply-To: ' . $from;
        return wp_mail($toEmail, $subject, $body, $headers);
    endif;

    if ('contact_submission' == get_post_type($post_id)):

        $body = include(get_template_directory() . '/emails/brief_contact_template.php');

        $toEmail = get_field('customer_service_email', 'option');
        //$toEmail = "franworkspace@gmail.com";
        $from = get_post_meta($post_id, 'contact_email', true);

        //var_dump($toEmail,$from);exit;

        $subject = 'Contact form Submission - ' . $concat_subject . ' - ' . $concat_email;
        $headers = "From: $from <$from> \r\n" .
                'Reply-To: ' . $from;

//        if ($concat_email == "franworkspace@gmail.com") {
//            send_auto_reply_notification($concat_email, $concat_subject);
//            return true;
//        }
        if (wp_mail($toEmail, $subject, $body, $headers)) {
            //send_auto_reply_notification($concat_email, $concat_subject);
            return true;
        }
    endif;
}

add_filter('wp_mail', 'forwarding_emails_to_admin', 10, 1);

function forwarding_emails_to_admin($args) {

    if (
            !in_array($args['to'], ['onlineorders@texasdebrazil.com', 'customerrelations@texasdebrazil.com', 'jadizzedin@texasdebrazil.com']) &&
            !in_array($args['subject'], ['Host event form Submission', 'Catering form Submission', 'NA Account Application', 'Donation Form submission', 'LEASING & EXPANSION Form submission',
                "Don't Forget Your Texas de Brazil Bonus!"])) {
        $email = 'onlineorders@texasdebrazil.com';
        //$email='franworkspace@gmail.com';
        if (!is_array($args['headers'])) {
            $newLine = $args['headers'] != '' ? " \r\n " : '';
            $args['headers'] .= $newLine . 'Bcc:  ' . $email;
        } elseif (is_array($args['headers'])) {
            $args['headers'][] = 'BCC: Texasdebrazil <' . $email . '>';
        }
    }
    return $args;
}

$autoreply = false;

function send_auto_reply_notification($toEmail, $subject) {
    global $autoreply;
    $autoreply = true;
    $body = include(get_template_directory() . '/emails/auto_reply_template.php');
    $from = 'customerrelations@texasdebrazil.com';
    $subject = "We've received your message!";
    $headers = "From: $from <$from> \r\n" .
            'Reply-To: <> \r\n' .
            'Bcc:  matt@thriveground.com';

    return wp_mail($toEmail, $subject, $body, $headers);
}

//require get_template_directory() . '/create-bonuscard/send-customer-all-order-action.php';
//require get_template_directory() . '/create-bonuscard/send-non-gift-e-card-product-emails.php';
//require get_template_directory() . '/create-bonuscard/create-standard-card-action.php';
//require get_template_directory() . '/create-bonuscard/create-bonus-card-action.php';
//require get_template_directory() . '/create-bonuscard/resend-order-receipt-action.php';
//require get_template_directory() . '/create-bonuscard/send-is-gift-cards-action.php';
//require_once get_template_directory() . '/inc/PaytronixCards/CronProcessOrders.class.php';
require_once get_template_directory() . '/inc/PostmarkApi.class.php';
//require_once get_template_directory() . '/inc/Traits/PostmarkApiTrait.php';
require_once get_template_directory() . '/inc/AutomaticCheckout.class.php';
require_once get_template_directory() . '/inc/PaytronixCards/OrderCardActions.class.php';
require_once get_template_directory() . '/inc/PaytronixCards/CardHttpRequests.class.php';
require_once get_template_directory() . '/inc/SendRedCrossBonusCardBulk/SendRedCrossBonusCardBulk.class.php';


//require_once get_template_directory() . '/inc/CroneGetEmailCards/CronGetEmailCards.class.php';






add_action('wp', 'remove_contact_submission_view');

function remove_contact_submission_view() {

    if (in_array(get_post_type(), ['na_submission', 'contact_submission', 'catering_submission', 'host_event', 'donations', 'leasing_expansion', 'e_club']) && !is_admin()) {
        wp_redirect(get_bloginfo('url'));
    }
}

function custom_pre_get_posts_query($q) {

    $tax_query = (array) $q->get('tax_query');

    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => array('cards'),
        'operator' => 'NOT IN'
    );


    $q->set('tax_query', $tax_query);
}

//add_action('woocommerce_product_query', 'custom_pre_get_posts_query');



add_action('wp_ajax_send_bonuscard_manually', 'send_bonuscard_manually_callback');
add_action('wp_ajax_nopriv_send_bonuscard_manually', 'send_bonuscard_manually_callback');

function send_bonuscard_manually_callback() {
    //error_log("inside send bonus email function");
    if ((!isset($_POST['order_id']) && !isset($_POST['email'])) || !$_POST['cardnumber'] || !$_POST['regcode'] || !$_POST['amount'])
        return;
    /* BCC for Internal Records */
    $order_id = $_POST['order_id'];
    $cardNumber = $_POST['cardnumber'];
    $regCode = $_POST['regcode'];
    $amount = $_POST['amount'];
    $email = $_POST['email'];
    if ($order_id) {
        $order = wc_get_order($order_id);
        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $order->get_billing_email();
        $toEmail = $order->get_billing_email();
    } else {
        $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $email;
        $toEmail = $email;
    }

    if ($amount == 25):
        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/25-bonus.jpg';
    elseif ($amount == 10):
        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
    else:
        //Default $10 image
        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
    endif;
    $subject = 'Your Texas de Brazil Bonus Card';

    $renderTemp = 'texas/bonus-card';

    $emailBcc_toEmail = 'onlineorders@texasdebrazil.com';


    //$headers[] = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();;
    //$headers[] = 'Cc: '.$emailBcc_toEmail; // note
    $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
    $body = include(get_template_directory() . '/emails/texas-bonus-email-template.php');


    error_log("======================================================");
    error_log("sending bonus mail to--" . $toEmail);



    if (wp_mail($toEmail, $subject, $body, $headers)) {
        $reponse = array("message" => "ok", "send_email" => $toEmail);
        echo json_encode($reponse);
    } else {
        $reponse = array("message" => "Error", "send_email" => $toEmail);
        echo json_encode($reponse);
    }
    die();
}

add_action('wp_ajax_send_bonuscard_manually_no_val', 'send_bonuscard_manually_callback_no_val');
add_action('wp_ajax_nopriv_send_bonuscard_manually_no_val', 'send_bonuscard_manually_callback_no_val');

function send_bonuscard_manually_callback_no_val() {
    error_log("inside send_bonuscard_manually_callback_no_val");
    if (!$_POST['email'] || !$_POST['cardnumber'])
        return;
    /* BCC for Internal Records */

    $cardNumber = $_POST['cardnumber'];
    $email = $_POST['email'];
    $amount = $_POST['amount'];
    $order = wc_get_order($order_id);

    if ($amount == 25):
        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/25-bonus.jpg';
    elseif ($amount == 10):
        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
    else:
        //Default $10 image
        $ruleimage = home_url() . '/wp-content/uploads/2021/10/bonux-card-rules-of-use-26_10-600x378.jpg'; //home_url() . '/assets/img/10-bonus.jpg';
    endif;
    $subject = 'Your Texas de Brazil Bonus Card';

    $renderTemp = 'texas/bonus-card';

    $emailBcc_toEmail = 'onlineorders@texasdebrazil.com';

    $emailBcc_subject = '(Internal Copy) - Gift Card sent by ' . $order->get_billing_email();
    //$headers[] = '(Internal Copy) - Gift Card sent by ' . self::get_from_email();;
    //$headers[] = 'Cc: '.$emailBcc_toEmail; // note
    $headers[] = 'BCC: Texasdebrazil <onlineorders@texasdebrazil.com>';
    $body = include(get_template_directory() . '/emails/texas-bonus-email-template.php');

    $toEmail = $order->get_billing_email();
    error_log("======================================================");
    error_log("sending bonus mail to--" . $toEmail);



    if (wp_mail($toEmail, $subject, $body, $headers)) {
        $reponse = array("message" => "ok", "send_email" => $toEmail);
        echo json_encode($reponse);
    } else {
        $reponse = array("message" => "Error", "send_email" => $toEmail);
        echo json_encode($reponse);
    }
    die();
}

require get_template_directory() . '/create-bonuscard/send-egift-manually.php';
require get_template_directory() . '/create-bonuscard/send-vip-manually.php';
require get_template_directory() . '/create-bonuscard/send-certificate-email.php';
require get_template_directory() . '/create-bonuscard/send-certificate-email-new.php';



require get_template_directory() . '/create-bonuscard/send-vip-manually-TEST.php';
require get_template_directory() . '/create-bonuscard/send-egift-manually-TEST.php';

function register_test_order_status() {
    register_post_status('wc-test-order', array(
        'label' => 'Test order',
        'public' => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list' => true,
        'exclude_from_search' => false,
        'label_count' => _n_noop('Test order <span class="count">(%s)</span>', 'Test order <span class="count">(%s)</span>')
    ));
}

add_action('init', 'register_test_order_status');

function register_fraud_order_status() {
    register_post_status('wc-fraud', array(
        'label' => 'Fraud order',
        'public' => true,
        'show_in_admin_status_list' => true,
        'show_in_all_admin_list' => true,
        'exclude_from_search' => false,
        'label_count' => _n_noop('Fraud order <span class="count">(%s)</span>', 'Fraud order <span class="count">(%s)</span>')
    ));
}

add_action('init', 'register_fraud_order_status');



require get_template_directory() . '/create-bonuscard/creat-card-ajax.php';
require get_template_directory() . '/create-bonuscard/send-order-receipt-ajax.php';

function isIosDevice() {
    $aMobileUA = array(
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
    );

    //Return true if Mobile User Agent is detected
    foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
        if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}

function isMobileDevice() {
    $aMobileUA = array(
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach ($aMobileUA as $sMobileKey => $sMobileOS) {
        if (preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])) {
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}

function dumpp($var) {

    if (isset($_GET['dump'])) {

        echo '<pre>';

        var_dump('$$var');
        var_dump($$var);
        var_dump($var);
        exit;
    }
}

require get_template_directory() . '/inc/functions-product-categories.php';

add_filter('post_type_link', function($url, $post, $leavename, $sample) {
    if (has_term('gift-cards', 'product_cat', $post)) {
        $parts = explode('/', $url);
        $parts[4] = 'gift-cards';
        return implode('/', $parts);
    }
    return $url;
}, 10, 4);

//base product category same base shop Page for woocommerce
function devvn_product_category_base_same_shop_base($flash = false) {
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'post_type' => 'product',
        'hide_empty' => false,
    ));
    if ($terms && !is_wp_error($terms)) {
        $siteurl = esc_url(home_url('/'));
        foreach ($terms as $term) {
            $term_slug = $term->slug;
            $baseterm = str_replace($siteurl, '', get_term_link($term->term_id, 'product_cat'));

            add_rewrite_rule($baseterm . '?$', 'index.php?product_cat=' . $term_slug, 'top');
            add_rewrite_rule($baseterm . 'page/([0-9]{1,})/?$', 'index.php?product_cat=' . $term_slug . '&paged=$matches[1]', 'top');
            add_rewrite_rule($baseterm . '(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?product_cat=' . $term_slug . '&feed=$matches[1]', 'top');
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}

add_filter('init', 'devvn_product_category_base_same_shop_base');

/* Sửa lỗi khi tạo mới taxomony bị 404 */
add_action('create_term', 'devvn_product_cat_same_shop_edit_success', 10, 2);

function devvn_product_cat_same_shop_edit_success($term_id, $taxonomy) {
    devvn_product_category_base_same_shop_base(true);
}

add_action('woocommerce_product_query', 'default_catalog_ordering_desc', 10, 2);

function default_catalog_ordering_desc($q, $query) {
    //if( $q->get( 'orderby' ) == 'menu_order title' )
    $q->set('orderby', 'post_title');
    $q->set('order', 'DESC');
}

add_action('admin_menu', 'add_submitted_form_pages');

function add_submitted_form_pages() {
    add_menu_page('no', 'Submitted Forms', 'manage_options', 'top-level-forms', '', '', 27);
    add_submenu_page('top-level-forms', 'My Custom Page', 'My Custom Page', 'manage_options', 'my-top-level-slug');
    add_submenu_page('my-top-level-slug', 'My Custom Submenu Page', 'My Custom Submenu Page', 'manage_options', 'my-secondary-slug');
    add_submenu_page('top-level-forms', 'Report ceritificates', 'Report ceritificates', 'manage_options', 'report-certificates', 'report_certificates_page');
}

function report_certificates_page() {
    ?>
    < div class = "report_certificates_page" >
    <h1 style="padding:20px;">
        Report ceritificates.
    </h1>
    <div id="filter">
        <form method="POST" action="">
            <div>
                <label>Date From</label>
                <input type="date" name="date_from" value="<?php
                if (isset($_POST['date_from'])) {
                    echo $_POST['date_from'];
                } else {
                    echo '';
                }
                ?>"  />
            </div>
            <div>
                <label>Date To</label>
                <input type="date" name="date_to" value="<?php
                if (isset($_POST['date_to'])) {
                    echo $_POST['date_to'];
                } else {
                    echo '';
                }
                ?>" />
            </div>
            <input type="submit" name="filter" value="filter"/>
            <input type="submit" name="export_cvs" value="export"/>
        </form>

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
        #filter{
            display:flex;
            margin: 10px 0;
        }
        #filter form{
            margin-right: 8px;
            display:flex;
        }
        #filter form > *{
            margin-right: 8px;

        }

        .report_certificates_page table{
            width: 100%;
        }
        .report_certificates_page table tr th,
        .report_certificates_page table tr td{
            text-align: left
        }
        .report_certificates_page table tr td{
            padding: 2px 7px;
            border:solid thin #ccc;
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

    $date_from = $date_to = '';

    if (isset($_POST['date_from'])) {
        $date_from = strtotime($_POST['date_from']);
    }

    if (isset($_POST['date_to'])) {
        $date_to = strtotime($_POST['date_to']);
    }


    if ($items = get_option('report_certificates_forms', [])) {
        echo '<table>'
        . '<tr>'
        . '<th>Email To</th>'
        . '<th>Submitted from</th>'
        . '<th>E-card</th>'
        . '<th>Amount</th>'
        . '<th>Date</th>'
        . '<th>Type</th>'
        . '<th>Dinner discount</th>'
        . '<th>Notes</th>'
        . '<th>Location</th>'
        . '</tr>';

        foreach (array_reverse($items) as $item) {
            $date = strtotime($item['Date']);
            if ($date_from) {
                if ($date < $date_from)
                    continue;
            }
            if ($date_to) {
                if ($date > $date_to)
                    continue;
            }

            //var_dump([$date, $date_from],[$date, $date_to]);
            echo '<tr>'
            . '<td>' . $item['Email To'] . '</td>'
            . '<td>' . $item['Submitted from'] . '</td>'
            . '<td>' . $item['E-card'] . '</td>'
            . '<td>' . $item['Amount'] . '</td>'
            . '<td>' . $item['Date'] . '</td>'
            . '<td>' . $item['Type'] . '</td>'
            . '<td>' . $item['Dinner discount'] . '</td>'
            . '<td>' . $item['Notes'] . '</td>'
            . '<td>' . $item['Location'] . '</td>'
            . '</tr>';
        }
        echo '</table>';
    }
    echo '</div>';
}

add_action('init', function() {
    if (isset($_POST['export_cvs'])) { //var_dump(wp_get_upload_dir()["basedir"]);exit;
        $csv = [];
        $items = get_option('report_certificates_forms', []);
        $file_name = wp_get_upload_dir()["basedir"] . '/cert_export.csv';

        $csv[] = ['Email To', 'Submitted from', 'E-card', 'Amount', 'Date', 'Notes', 'Type', 'Dinner discount'];
        $date_from = $date_to = '';

        if (isset($_POST['date_from'])) {
            $date_from = strtotime($_POST['date_from']);
        }

        if (isset($_POST['date_to'])) {
            $date_to = strtotime($_POST['date_to']);
        }
        foreach ($items as $item) {
            $date = strtotime($item['Date']);
            if ($date_from) {
                if ($date < $date_from)
                    continue;
            }
            if ($date_to) {
                if ($date > $date_to)
                    continue;
            }
            $csv[] = [$item['Email To'], $item['Submitted from'], $item['E-card'], $item['Amount'], $item['Date'], $item['Notes'], $item['Type'], $item['Dinner discount']];
        }






        header('Content-type: application/csv');

        header('Content-Disposition: attachment; filename=report.csv');

        header("Content-Transfer-Encoding: UTF-8");
        $output = fopen($file_name, 'w');

        foreach ($csv as $csv_) {
            fputcsv($output, $csv_);
            //echo $csv_;
        }
        fclose($output);
        readfile($file_name);
        die();
    } elseif (isset($_POST['date_to'])) {
        
    }
});

add_action('admin_footer', function() {
    ?>
    <script>
        jQuery(document).ready(function ($) {

            $('#menu-posts-specials,#menu-posts-host_event,#menu-posts-catering_submission,#menu-posts-na_submission,#menu-posts-awards,#menu-posts-faqs,#menu-posts-contact_submission,#menu-posts-themes,#menu-posts-leasing_expansion,#menu-posts-e_club,#menu-posts-dona                        tions').hide();
            var links = '<li class="wp-submenu-head" aria-hidden="true">                        Specials</li>';
            links += '<li class="wp-first-item"><a href="edit.php?post_type=specials" class="wp-first-item">Spec                        ials</a></li>';
            links += '<li><a href="edit.php?post_type=host_event">Host E                        vent</a></li>';
            links += '<li><a href="edit.php?post_type=catering">Cate                        ring</a></li>';
            links += '<li><a href="edit.php?post_type=na_submission">Na Subms                        sion</a></li>';
            links += '<li><a href="edit.php?post_type=awards">Aw                        ards</a></li>';
            links += '<li><a href="edit.php?post_type=faqs"                        >Faq</a></li>';
            links += '<li><a href="edit.php?post_type=contact_submission">Contact Submi                        sson</a></li>';
            links += '<li><a href="edit.php?post_type=themes">Card Th                        emes</a></li>';
            links += '<li><a href="edit.php?post_type=leasing_expansion">Leasing & Expans                        ions</a></li>';
            links += '<li><a href="edit.php?post_type=e_club">E-Club</a></li><li><a href="edit.php?post_type=donations">Dona                        tion</a></li>';
            links += '<li><a href="admin.php?page=report-certificates" class="current" aria-current="page">Report ceritific                        ates</a></li>';
            $('#toplevel_page_top-level-forms').find('ul                     ').html(links);
        });



    </script>
    <?php
});


add_filter('wp_mail_smtp_custom_options', 'wp_mail_smtp_custom_options', 10, 1);

function wp_mail_smtp_custom_options($phpmailer) {
    $server = 'default';

    //error_log('wp_mail_smtp_custom_options: '.print_r($phpmailer,true));

    $isResendCards = isset($_POST['item_id']) && isset($_POST['post_id']);

    if (wp_doing_ajax() && !empty($_POST) && strpos($phpmailer->Subject, 'Refunded') === false && !$isResendCards) {

        $phpmailer->Username = 'f0e3aebb-ea1a-46cb-b400-e3b7eb266c2c';
        $phpmailer->Password = 'f0e3aebb-ea1a-46cb-b400-e3b7eb266c2c';
        $server = 'form submissions';
    }
    //error_log('phpmailer' . print_r($phpmailer->getToAddresses(), true));
    $adminEmails = ['jadizzedin@texasdebrazil.com', 'itsystems@texasdebrazil.com'];

    $adminOrdersEmails = ['onlineorders@texasdebrazil.com'];

    $addresses = $phpmailer->getToAddresses();



//        if (is_array($addresses))
//            $addresses = $addresses[0];


    if (!$addresses)
        return $phpmailer;


    if (!is_array($addresses))
        $addresses = [$addresses];



    $addresses = array_filter($addresses, function ($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    });


    if (count(array_intersect((array) $addresses, (array) $adminEmails)) > 0 || strpos($phpmailer->Subject, 'Refunded') !== false) {
        $phpmailer->Username = 'f2aade9d-8f88-4a46-92fe-b13a589c3216';
        $phpmailer->Password = 'f2aade9d-8f88-4a46-92fe-b13a589c3216';
        $server = 'admin';
    }
    if (count(array_intersect((array) $addresses, (array) $adminOrdersEmails)) > 0) {
        $phpmailer->Username = 'a2573f85-292b-48da-8e2b-da0cc22a73f3';
        $phpmailer->Password = 'a2573f85-292b-48da-8e2b-da0cc22a73f3';
        $server = 'adminOrdersEmails';
    }
    //error_log('wp_mail_smtp_custom_options: ' . print_r([$phpmailer->Subject, $server], true));
//    if ('default' == $server)
//        error_log('wp_mail_smtp_custom_options: ' . print_r($phpmailer, true));
    return $phpmailer;
}

//add_filter('wp_mail_smtp_options_get', 'wp_mail_smtp_options_get_callback', 10, 3);

function wp_mail_smtp_options_get_callback($value, $group, $key) {
    if ('from_email' == $key && 'mail' == $group) {
        global $autoreply;
        if ($autoreply)
            $value = 'no.reply@texasdebrazil.com';
    }
    return $value;
}

///add_filter('views_edit-shop_order', 'views_edit_shop_order_callback', 1,1);
function views_edit_shop_order_callback($views) {
    //var_dump($views);
    $views['all-count'] = "<b>Orders count (1)</b>";
    return $views;
}

add_action('wp_ajax_catering_location', 'get_catering_location');
add_action('wp_ajax_nopriv_catering_location', 'get_catering_location');

function get_catering_location() {
    $data = [];
    if (isset($_POST['location'])) {
        $location = str_replace('locations', '', str_replace('/', '', $_POST['location']));
        $args = array(
            'post_type' => 'locations',
            'name' => $location
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $data['description'] = get_field('description') ?: ' - ';
                $data['title'] = get_the_title();
                $data['phone'] = get_field('phone_number') ?: ' - ';
                $data['links'] = '';
                $data['status'] = '200';
                $links = get_field('links');
                if ($links) {
                    foreach ($links as $link) {
                        $data['links'] .= '<a href="' . $link['link_url'] . '" class="icon-link" data-ignore="1"><img src="' . $link['icon'] . '"></a>';
                    }
                }
            }
        } else {
            $data['status'] = '404';
        }
    } else {
        $data['status'] = '400';
    }
    echo json_encode($data);
    wp_die();
}

function add_field_state() {
    register_rest_field(
            array('post', 'locations'), 'state', array(
        'get_callback' => 'get_field_state_id',
        'update_callback' => null,
        'schema' => null,
            )
    );
}

add_action('rest_api_init', 'add_field_state');

function get_field_state_id($object, $field_name, $request) {
    $fv_id = get_post_meta(get_the_ID(), 'state', true);
    return $fv_id;
}

//apply_filters( 'wp_insert_post_data', $data, $postarr );

add_filter('wp_insert_post_data', 'wp_insert_post_data_callback', 10, 2);

function wp_insert_post_data_callback($data, $postarr) {
    if (isset($postarr['save']) && 'Update' == $postarr['save'] && 'email_certificates' == $data["post_type"]) {
        if ($postarr["original_post_title"] != $postarr["post_title"]) {
            $data["post_title"] = $postarr["original_post_title"];
        }
        $post = get_post($postarr['ID']);

        if ($post && $postarr["post_content"] != $post->post_content) {
            $data["post_content"] = $post->post_content;
        }
    }
    return $data;
    //var_dump($data,$postarr);exit;
}

function tx_is_mobile() {
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }
    return $is_mobile;
}

add_filter("acf/format_value", function($value, $post_id, $field) {

    if (is_single() && 'post' == get_post_type()) {
        if ('main_class' == $field['name']) {
            $value .= ' main--interior';
        } elseif ('header_class' == $field['name']) {
            $value .= ' header--interior';
        }
    }
    return $value;
}, 10, 3);

// Cookie events - cart cookies need to be set before headers are sent.
/* add_action( 'woocommerce_add_to_cart', array( $this, 'maybe_set_cart_cookies' ) );
  add_action( 'wp', array( $this, 'maybe_set_cart_cookies' ), 99 );
  add_action( 'shutdown', array( $this, 'maybe_set_cart_cookies' ), 0 ); */




add_action('wp_loaded', function() {

    if (is_admin() || empty(WC()->cart))
        return;
    $count = WC()->cart->get_cart_contents_count();
    setcookie('gift_card_cart', $count, 0, '/', 'texasdebrazil.com');
});

add_action('wppp', function() {
    if ($_GET['test-cart']) {
        foreach (WC()->cart->get_cart_contents() as $item) {
            if (get_post_meta($item['product_id'], 'requires_shipping', true) === '1') {
                var_dump($item['product_id']);
            }
        }
        exit;
    }

//    if (isMobileDevice() && is_front_page()) {
//        if (empty($_GET['geolocation'])) {
//            global $wp;
//            $location = add_query_arg($wp->query_vars + ['geolocation' => rand(1, 999)], home_url($wp->request));
//            wp_redirect($location);
//        }
//    }
});




add_action('wp_ajax_nopriv_update_cart_custom', 'update_cart_custom_callback');
add_action('wp_ajax_update_cart_custom', 'update_cart_custom_callback');

function update_cart_custom_callback() {
    $error = false;
    $total_qty = 0;


    if ($_POST['cart']) {
        foreach ($_POST['cart'] as $key => $qty) {
            $qty = intVal($qty);

            $qty = abs($qty);
            $total_qty += $qty;
            if ($total_qty > 10) {

                $error = 'You can’t have more than 10 items in the cart';
                break;
            }

            WC()->cart->set_quantity($key, $qty);
        }
    }
    echo $error ? $error : 'ok';

    wp_die();
}

add_filter('tx_check_ip_state', function($validState, $state) {
    return false;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $ipapikey = get_field('ipapi_key', 'option');
    $state = file_get_contents("https://ipapi.co/$user_ip/region/?key=$ipapikey");
    if ($state == 'California')
        return true;
    else
        return false;
}, 10, 2);

add_action('carolina_privacy_links', function() {
    ?>
    <li>
        <a class="truevault-polaris-optout" href="https://privacy.texasdebrazil.com/opt-out" noreferrer noopener hidden>
            <img src="https://polaris.truevaultcdn.com/static/assets/icons/optout-icon-transparent.svg" 
                 alt="California Consumer Privacy Act (CCPA) Opt-Out Icon" 
                 style="vertical-align:middle" height="14px"
                 />
            Your Privacy Choices
        </a>
    </li>
    <li>
        <a class="truevault-polaris-privacy-notice" href="https://privacy.texasdebrazil.com/privacy-policy#california-privacy-notice" noreferrer noopener hidden>California Privacy Notice</a>

    </li>

    <?php
});


add_action('wp_ajax_get_locations_dropdown', 'get_locations_dropdown_callback');
add_action('wp_ajax_nopriv_get_locations_dropdown', 'get_locations_dropdown_callback');

function get_locations_dropdown_callback() {
    //error_log('get_locations_dropdown_callback');

    global $wpdb;
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $ipapikey = get_field('ipapi_key', 'option');
    //error_log('ip_test $user_ip: ' . "https://ipapi.co/$user_ip/latlong/?key=$ipapikey");
    if ($user_ip != '127.0.0.1') {

        $latlong = file_get_contents("https://ipapi.co/$user_ip/latlong/?key=$ipapikey");

        //error_log('ip_test $search_lat: ' . print_r($latlong, true));




        if ($latlong) {
            $location_array = explode(',', $latlong);
            $search_lat = $location_array[0];
            $search_long = $location_array[1];
        } else {
            $search_lat = 31.169621;
            $search_long = -99.683617;
        }
    } else {
        $search_lat = 31.169621;
        $search_long = -99.683617;
    }



    $search_radius = 9999999;
    $rand = $user_ip;
    $sql = "SELECT $wpdb->posts.ID,

                              ( 3959 * acos(

                              cos( radians(%s) ) *

                              cos( radians( latitude.meta_value ) ) *

                              cos( radians( longitude.meta_value ) - radians(%s) ) +

                              sin( radians(%s) ) *

                              sin( radians( latitude.meta_value ) )

                              ) )

                              AS distance, latitude.meta_value AS latitude, longitude.meta_value AS longitude

                              FROM $wpdb->posts

                              INNER JOIN $wpdb->postmeta

                              AS latitude

                              ON $wpdb->posts.ID = latitude.post_id

                              INNER JOIN $wpdb->postmeta

                              AS longitude

                              ON $wpdb->posts.ID = longitude.post_id

                              WHERE '$rand'='$rand'

                              AND ($wpdb->posts.post_status = 'publish' )

                              AND ($wpdb->posts.post_type = 'locations' )

                              AND latitude.meta_key='lat'

                              AND longitude.meta_key='lng'

                              HAVING distance < %s

                              ORDER BY $wpdb->posts.menu_order ASC, distance ASC";



    $sql = $wpdb->prepare($sql,
            $search_lat,
            $search_long,
            $search_lat,
            $search_radius
    );





    $post_ids = $wpdb->get_results($sql, OBJECT_K);
    //error_log('ip_test $post_ids: '.print_r($post_ids,true));
//echo '<script> alert("lat: '.$search_lat.' - long: '.$search_long.' - IP: '.$user_ip.'");</script>';exit;

    if ($post_ids):
        ob_start();


        foreach ($post_ids as $row):
            if (get_field('restaurant_id', $row->ID)):
                $id = get_the_title($row->ID);
                $id = str_replace('-', '', $id);
                ?>
                <option value="<?php echo get_field('restaurant_id', $row->ID); ?>" class="table-finder__option"><?php echo ucwords(strtolower(get_the_title($row->ID))) . ', ' . ucwords(strtolower(get_field('state', $row->ID))); ?></option>
            <?php endif; ?>
            <?php
        endforeach;
    endif;
    $contents = ob_get_contents();
    ob_end_clean();
    wp_reset_postdata();
    wp_die($contents);
}

require get_template_directory() . '/inc/functions-debug.php';

function tx_get_product_button_archive($product) {


    $qty = $product->get_stock_quantity();



    if ($qty > 0) {
        ?><span class="button button--small c-product__button">Purchase</span><?php
    } else {
        ?><span class="button button--small c-product__button">Out of Stock</span><?php
    }
}

function tx_get_product_button_single($product) {


    $out_of_stock = $product->get_stock_quantity() < 1 && $product->get_manage_stock();

    if (!$out_of_stock) {
        ?><button id="standard-card" class="button u-product-detail__confirm u-cart single_add_to_cart_button button alt wc-variation-selection-needed tx-desktop-view">Add to Cart</button><?php
    } else {
        ?><button disabled="" class="button c-card-form__submit u-product-detail__confirm1 single_add_to_cart_button button alt wc-variation-selection-needed out-of-stock">Out of Stock</button><?php
    }
}

add_action('wp', function() {

    /* ----318461 - 25700009195732 / 5469
      -----317506 - 25700009117348 / 6407
      -----317443 - 25700009110129 / 7553
      ----317366 - 25700009104775 / 8674
      ----316775 - 25700009060027 / 8493
      ----315469 - 25700008957132 / 1463
      ----315322 - 25700008944247 / 3936 */
    if (!empty($_GET['add_meta_now_new'])) {
        exit;

        $data = [
            901762 => ['c' => '25700008944247', 'r' => '3936'],
            902070 => ['c' => '25700008957132', 'r' => '1463'],
            905076 => ['c' => '25700009060027', 'r' => '8493'],
            906349 => ['c' => '25700009104775', 'r' => '8674'],
            906527 => ['c' => '25700009110129', 'r' => '7553'],
            906721 => ['c' => '25700009117348', 'r' => '6407'],
            908905 => ['c' => '25700009195732', 'r' => '5469'],
        ];

        foreach ($data as $item_id => $d) {

            $cardnumber = wc_get_order_item_meta($item_id, 'PaytronixCardNumber', true);
            if ($cardnumber) {
                $cardnumber = $cardnumber . ', ' . $d['c'];
            } else {
                $cardnumber = $d['c'];
            }

            //$regcode = get_post_meta($order_id,'paytronixRegCode',true);
            $regcode = wc_get_order_item_meta($item_id, 'paytronixRegCode', true);
            if ($regcode) {
                $regcode = $regcode . ', ' . $d['r'];
            } else {
                $regcode = $d['r'];
            }

            echo 'PaytronixCardNumber: ' . $cardnumber . '<br/>';
            echo 'paytronixRegCode ' . $regcode . '<br/>';

            wc_update_order_item_meta($item_id, 'PaytronixCardNumber', $cardnumber);
            wc_update_order_item_meta($item_id, 'paytronixRegCode', $regcode);
        }

        exit;
    }
    if (!empty($_GET['add_meta_now_'])) {




        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}posts WHERE post_type LIKE 'shop_order' and ID>319823");

// Loop through each order post object
        foreach ($results as $result) {
            $target = false;
            $order_id = $result->ID; // The Order ID
            // Get an instance of the WC_Order Object
            //WC_Order_Item_Product::class;
            $order = wc_get_order($result->ID);
            if ($order->get_status() == 'completed' && ($order->get_total() > 67.99)) {
                $cardnumber = $regcode = '';
                foreach ($order->get_items() as $item) {
                    if ($item->get_name() == 'E-VIP Dining Card') {
                        $cardnumber .= '<b>ID: ' . $item->get_id() . '</b> ' . wc_get_order_item_meta($item->get_id(), 'PaytronixCardNumber', true);
                        $regcode .= '<b>ID: ' . $item->get_id() . '</b> ' . wc_get_order_item_meta($item->get_id(), 'paytronixRegCode', true);
                        $target = true;
                    }
                }

                $array = explode(', ', $cardnumber);





                if ($target && count($array) < 2) {
                    echo 'Order_id: ' . $order_id . '<br/>';
                    echo 'Total: ' . $order->get_total() . '<br/>';
                    echo '$cardnumber: ' . $cardnumber . '<br/>';
                    echo '$regcode: ' . $regcode . '<br/>';
                    echo '<br/><br/><br/>';
                }
            }
        }


        //WC_Order::class;

        exit;
    }
});
