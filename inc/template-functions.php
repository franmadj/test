<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package texaswp
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function texaswp_body_classes($classes) {
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}

add_filter('body_class', 'texaswp_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function texaswp_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('wp_head', 'texaswp_pingback_header');

function texaswp_cart_is_digital() {
    //error_log('texaswp_cart_is_digital '.print_r(WC()->cart->get_cart_contents(),true));
    foreach (WC()->cart->get_cart_contents() as $cart_item_key => $values) {

        if (!get_field('digital_product', $values['product_id'])) {
            return false;
        }
    }
    return true;
}

function tx_connect_form_happyfox($category, $data) {
    ini_set('error_log', WP_CONTENT_DIR . '/tx_connect_form_happyfox.txt');

    error_log('tx_connect_form_happyfox');

    $url = 'https://texasdebrazil.happyfox.com/api/1.1/json/tickets/';
    $api_key = 'f083f11290e84fdcbaea63ebb3a1adc7';
    $auth_code = 'fdf8a3687e9b40ffb2df2d524d95bfb0';
    //{action: 'contact_form', contact_name: firstname, contact_email: contact_email, help_you: help_you, contact_subject: subject, location_visited: location_visited, body: body, date_visited: datevisited},

    $input = array(
        "name" => $data['contact_name'],
        "email" => $data['contact_email'],
        "subject" => $data['contact_subject'],
        "text" => $data['body'],
        //"html" => '<p>' . $data['body'] . '</p>',
        "category" => $category,
            //"created_at" => "Ignition issues with the millenium falcon",
    );
    $html_ = $input;
    if (!empty($data['location_visited'])) {
        $input["t-cf-1"] = $data['location_visited'];
    }
//    if (!empty($data['location_name'])) {
//        $html_['Location Visted'] = $data['location_name'];
//    }
    if (!empty($data['date_visited'])) {
        $input["t-cf-4"] = $html_['Date Visted'] = $data['date_visited'];
    }
    if (!empty($data['company'])) {
        $input["c-cf-1"] = $html_['Company'] = $data['company'];
    }
    if (!empty($data['phone'])) {
        $input["phone"] = $html_['Phone'] = $data['phone'];
    }
    if (!empty($data['order_date'])) {
        $input["t-cf-7"] = $data['order_date'];
    }
    if (!empty($data['order_platform'])) {

        if ('Website' == $data['order_platform']) {
            $input["tags"] = 'Olo To-Go';
            $input["t-cf-10"] = 96;
        } elseif ('in-store' == $data['order_platform']) {
            $input["tags"] = 'in-store To-Go';
            $input["t-cf-10"] = 94;
        } else {
            $input["tags"] = $data['order_platform'];
            $input["t-cf-10"] = $data['order_platform'] == 'DoorDash' ? 98 : 97;
        }
    }
    if (!empty($data['catering'])) {
        $input["tags"] = 'Olo Catering';
        $input["t-cf-10"] = 95;
    }
    if (!empty($data['contact-togo'])) {
        $input["tags"] = 'Olo To-Go';
        $input["t-cf-10"] = 96;
    }
    if (!empty($data['contact-catering'])) {
        $input["tags"] = 'Olo Catering';
        $input["t-cf-10"] = 95;
    }
    if (!empty($_POST['order_number']))
        $input["t-cf-8"] = $_POST['order_number'];

    $html = '';
    foreach ($html_ as $key => $item) {
        if (!in_array($key, ['text', 'category']))
            $html .= '<p><b>' . $key . '</b>: ' . $item . '</p>';
    }
    $input['html'] = $html . '<p><b>Message</b>: ' . $data['body'] . '</p>';

    $headers = array(
        "Content-Type:application/json"
    );


    if (!empty($data['attachments']) && $data['attachments']) {
        //$headers[] = 'Content-Type:multipart/form-datamultipart/form-data';
        $headers = array(
            "Content-Type:multipart/form-datamultipart/form-data"
        );

        $input["attachments"] = curl_file_create($data["attachments"]);
    } else {
        $input = json_encode($input);
    }

    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => true,
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $input,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_BINARYTRANSFER => true,
        CURLOPT_USERPWD => $api_key . ":" . $auth_code
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    if (!curl_errno($ch)) {
        $info = curl_getinfo($ch);
        if ($info['http_code'] == 500) {
            error_log('ERROR tx_connect_form_happyfox DATA: ' . print_r($data, true));
            error_log('ERROR tx_connect_form_happyfox $input: ' . print_r($input, true));
            error_log('ERROR tx_connect_form_happyfox Response: ' . print_r($result, true));

            return false;
        } else {
            error_log('OK tx_connect_form_happyfox DATA: ' . print_r($data, true));
            error_log('OK tx_connect_form_happyfox $input: ' . print_r($input, true));
            error_log('OK tx_connect_form_happyfox Response: ' . print_r($result, true));

            return true;
            //var_dump(json_decode($result, true));
        }
    }
    curl_close($ch);
}

add_action('init', function() {
    add_rewrite_rule('^locations/([a-z-]+)/to-go$', 'index.php?locations-togo=$matches[1]', 'top');
    add_rewrite_rule('^locations/([a-z-]+)/event$', 'index.php?locations-event=$matches[1]', 'top');
});

add_filter('query_vars', function($query_vars) {
    $query_vars[] = 'locations-togo';
    $query_vars[] = 'locations-event';
    return $query_vars;
});

add_action('template_include', function($template) {
    if (get_query_var('locations-event')) {
        return get_template_directory() . '/page-template/location-event.php';
    }
    if (get_query_var('locations-togo')) {
        return get_template_directory() . '/page-template/locations-togo.php';
    }
    return $template;
});
