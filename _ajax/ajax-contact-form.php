<?php

add_action('wp_ajax_contact_form', 'contact_form_callback');
add_action('wp_ajax_nopriv_contact_form', 'contact_form_callback');

function contact_form_callback() {

    if (!empty($_POST['date_visited'])) {
        $parts = explode('/', $_POST['date_visited']);
        if (!empty($parts[0]) && !empty($parts[1]) && !empty($parts[2]))
            $_POST['date_visited'] = $parts[1] . '/' . $parts[0] . '/' . $parts[2];
    }


    $author_id = 1;
    $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => $author_id,
                'post_title' => $_POST['contact_name'],
                'post_content' => $_POST['body'],
                'post_status' => 'publish',
                'post_type' => 'contact_submission'
            )
    );
    $location = array($_POST['locationvisted']);

    if ($post_id) {
        foreach ($_POST as $key => $value) {
            if ($key != 'action' && $key != 'contact_name' && $key != "body" && $key != "locationvisted")
                update_post_meta($post_id, $key, $value);
        }
        update_post_meta($post_id, 'locationvisited', serialize($location));
    }
    send_email_notification($post_id, $_POST['contact_email'], $_POST['contact_subject']);


    $category = 1;
    if ('Guest Feedback' == $_POST['contact_subject']) {
        $location_name = '';
        if ($location = get_post($_POST['location_visited'])) {
            $location_name = $location->post_title;
        }

        $location_visited = '';
        if ($location_api = get_field('happyfox_location_id', $_POST['location_visited']))
            $location_visited = $location_api;


        $category = 2;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'Guest Feedback - ' . $location_name . ' - ' . $_POST['date_visited'], //date_visited
            'body' => $_POST['body'],
            'location_visited' => $location_visited,
            'location_name' => $location_name,
            'date_visited' => $_POST['date_visited']
        ];
    } elseif ('To-Go Order' == $_POST['contact_subject']) {
        $location_name = '';
        if ($location = get_post($_POST['location_visited'])) {
            $location_name = $location->post_title;
        }

        $location_visited = '';
        if ($location_api = get_field('happyfox_location_id', $_POST['location_visited']))
            $location_visited = $location_api;


        $category = 15;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'To-Go Order - ' . $_POST['order_platform'] . ' - ' . $_POST['order_number'],
            'body' => $_POST['body'],
            'location_visited' => $location_visited,
            'location_name' => $location_name,
            'order_date' => $_POST['date_visited'],
            'order_platform' => $_POST['order_platform'],
            'contact-togo' => 1,
        ];
    } elseif ('Catering Order' == $_POST['contact_subject']) {
        $location_name = '';
        if ($location = get_post($_POST['location_visited'])) {
            $location_name = $location->post_title;
        }

        $location_visited = '';
        if ($location_api = get_field('happyfox_location_id', $_POST['location_visited']))
            $location_visited = $location_api;


        $category = 15;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'Catering Order - ' . $_POST['order_number'],
            'body' => $_POST['body'],
            'location_visited' => $location_visited,
            'location_name' => $location_name,
            'order_date' => $_POST['date_visited'],
            'catering' => 1
        ];
    } elseif ('Online Gift Card Order' == $_POST['contact_subject']) {
        $category = 3;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'Online Gift Card Order - ' . $_POST['order_number'],
            'body' => $_POST['body']
        ];
    } elseif ('Online Butcher Shop Order' == $_POST['contact_subject']) {
        $category = 3;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'Online Butcher Shop Order - ' . $_POST['order_number'],
            'body' => $_POST['body']
        ];
    } elseif ('contact-togo' == $_POST['contact_subject']) {
        //TOGO FORM
        $location_name = '';
        if ($location = get_post($_POST['location_visited'])) {
            $location_name = $location->post_title;
        }
        $location_visited = '';
        if ($location_api = get_field('happyfox_location_id', $_POST['location_visited']))
            $location_visited = $location_api;
        $category = 15;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'To-Go Order - Website - ' . $_POST['order_number'],
            'location_visited' => $location_visited,
            'location_name' => $location_name,
            'order_date' => $_POST['date_visited'],
            'contact-togo' => 1,
            'body' => $_POST['body'],
            'order_number' => $_POST['order_number']
        ];
    } elseif ('contact-catering' == $_POST['contact_subject']) {
        //CATERING FORM
        $location_name = '';
        if ($location = get_post($_POST['location_visited'])) {
            $location_name = $location->post_title;
        }
        $location_visited = '';
        if ($location_api = get_field('happyfox_location_id', $_POST['location_visited']))
            $location_visited = $location_api;
        $category = 15;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'Catering Order - ' . $_POST['order_number'],
            'location_visited' => $location_visited,
            'location_name' => $location_name,
            'order_date' => $_POST['date_visited'],
            'contact-catering' => 1,
            'body' => $_POST['body'],
            'order_number' => $_POST['order_number']
        ];
    } else {

        $category = 1;
        $data = [
            'contact_name' => $_POST['contact_name'],
            'contact_email' => $_POST['contact_email'],
            'contact_subject' => 'Contact Form Inquiry - ' . $_POST['help_you'],
            'body' => $_POST['body']
        ];
    }
    tx_connect_form_happyfox($category, $data);
    $reponse = array("message" => "ok", "redirect" => home_url() . "/thanks/");

    echo json_encode($reponse);
    die();
}
