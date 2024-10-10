<?php

add_action('wp_ajax_hosting_event_form', 'hosting_event_form_callback');
add_action('wp_ajax_nopriv_hosting_event_form', 'hosting_event_form_callback');

//https://support.tripleseat.com/hc/en-us/articles/212528787-Leads-API
function hosting_event_form_callback() {


    $author_id = 1;
    $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => $author_id,
                'post_title' => $_POST['first_name'] . ' ' . $_POST['lastName'],
                'post_content' => $_POST['comment'],
                'post_status' => 'publish',
                'post_type' => 'host_event'
            )
    );
    if ($post_id) {
        foreach ($_POST as $key => $value) {
            if ($key != 'action' && $key != 'first_name' && $key != "lastName" && $key != "comment" && $key != "selected_location")
                update_post_meta($post_id, $key, $value);
        }
        $loc = array($_POST['selected_location']);
        $location = serialize($loc);
        update_post_meta($post_id, 'selected_location', $location);
    }
    $reponse = array("message" => "ok", "redirect" => home_url() . "/thanks/?from=event");

    if ('27800' != $_POST['selected_location']) {
        //echo json_encode($reponse);
        //$url = 'https://api.tripleseat.com/v1/leads/create.js/?public_key=8f4e72736624f30d49b8ad28c093cc5a98803994';
        $url = 'https://api.tripleseat.com/v1/leads/create.js?lead_form_id=2029&public_key=8f4e72736624f30d49b8ad28c093cc5a98803994';
        $lead = array(
            'lead[first_name]' => $_POST['first_name'],
            'lead[last_name]' => $_POST['lastName'],
            'lead[email_address]' => $_POST['client_email'],
            'lead[phone_number]' => $_POST['client_phone'],
            'lead[event_description]' => $_POST['nature_of_event'],
            'lead[event_date]' => $_POST['event_date'],
            'lead[start_time]' => $_POST['start_time'],
            'lead[end_time]' => $_POST['end_time'],
            'lead[location_id]' => $_POST['selected_location'],
            'lead[guest_count]' => $_POST['number_of_guests'],
            'lead[additional_information]' => $_POST['comment'],
            'lead[gdpr_consent_granted]' => isset($_POST['gdpr_consent_granted']) ? 1 : 0,
        );
        $company = trim($_POST['company']);
        if (!empty($company)) {
            $lead['lead[company]'] = $company;
        }
        //echo json_encode($lead);die();
        $response = wp_remote_post($url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => $lead,
            'cookies' => array()
                )
        );
    } else {
        $body = include(get_template_directory() . '/emails/brief_hosting_template.php');

        if ($_POST['client_email'] == 'franworkspace@gmail.com')
            $toEmail = $_POST['client_email'];
        else
            $toEmail = 'manny.cournede@unionmak.com';

        $from = get_post_meta($post_id, 'client_email', true);
        $subject = 'Host event form Submission';
        $headers = 'Reply-To: ' . $from;
        wp_mail($toEmail, $subject, $body, $headers);
    }
//    error_log('hosting_event_form_callback api.tripleseat $_POST: ' . print_r($_POST, true));
//    error_log('hosting_event_form_callback api.tripleseat Request: '.print_r($lead,true));
//    error_log('hosting_event_form_callback api.tripleseat Response: '.print_r($response,true));
    //var_dump($response);die();
    if ($_POST['client_email'] != 'franworkspace@gmail.com')
        send_email_notification($post_id);
    echo json_encode($reponse);
    die();
}

add_action('wp_ajax_catering_event_form', 'catering_event_form_callback');
add_action('wp_ajax_nopriv_catering_event_form', 'catering_event_form_callback');

function catering_event_form_callback() {
    $author_id = 1;
    $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => $author_id,
                'post_title' => $_POST['first_name'] . ' ' . $_POST['lastName'],
                'post_content' => $_POST['comment'],
                'post_status' => 'publish',
                'post_type' => 'catering_submission'
            )
    );
    if ($post_id) {
        foreach ($_POST as $key => $value) {
            if ($key != 'action' && $key != 'firstname' && $key != "lastName" && $key != "comment" && $key != "selected_location")
                update_post_meta($post_id, $key, $value);
        }
        $loc = array($_POST['selected_location']);
        $location = serialize($loc);
        update_post_meta($post_id, 'selected_location', $location);
    }
    $reponse = array("message" => "ok", "redirect" => home_url() . "/thanks/?from=catering");
    //$url = 'https://api.tripleseat.com/v1/leads/create.js/?public_key=8f4e72736624f30d49b8ad28c093cc5a98803994';
    $url = 'https://api.tripleseat.com/v1/leads/create.js?lead_form_id=2867&public_key=8f4e72736624f30d49b8ad28c093cc5a98803994';
    $lead = array(
        'lead[first_name]' => $_POST['first_name'],
        'lead[last_name]' => $_POST['lastName'],
        'lead[email_address]' => $_POST['client_email'],
        'lead[phone_number]' => $_POST['client_phone'],
        'lead[event_description]' => $_POST['nature_of_event'],
        'lead[event_date]' => $_POST['event_date'],
        'lead[start_time]' => $_POST['start_time'],
        'lead[end_time]' => $_POST['end_time'],
        'lead[location_id]' => $_POST['selected_location'],
        'lead[guest_count]' => $_POST['number_of_guests'],
        'lead[additional_information]' => $_POST['comment'],
        'lead[gdpr_consent_granted]' => isset($_POST['gdpr_consent_granted']) ? 1 : 0,
    );

    $company = trim($_POST['company']);
    if (!empty($company)) {
        $lead['lead[company]'] = $company;
    }

    $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => $lead,
        'cookies' => array()
            )
    );
    if ($_POST['client_email'] != 'franworkspace@gmail.com')
        send_email_notification($post_id);

//    error_log('catering_event_form_callback api.tripleseat $_POST: ' . print_r($_POST, true));
//    error_log('catering_event_form_callback api.tripleseat Request: ' . print_r($lead, true));
//    error_log('catering_event_form_callback api.tripleseat Response: ' . print_r($response, true));

    echo json_encode($reponse);
    die();
}

add_action('wp_ajax_na_event_form', 'na_event_form_callback');
add_action('wp_ajax_nopriv_na_event_form', 'na_event_form_callback');

function na_event_form_callback() {
    $author_id = 1;
    $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => $author_id,
                'post_title' => $_POST['first_name'] . ' ' . $_POST['lastName'],
                'post_content' => $_POST['inquiry'],
                'post_status' => 'publish',
                'post_type' => 'na_submission'
            )
    );
    if ($post_id) {
        foreach ($_POST as $key => $value) {
            if ($key != 'action' && $key != "inquiry")
                update_post_meta($post_id, $key, $value);
        }
    }
    $body = include(get_template_directory() . '/emails/brief_na_template.php');
    $toEmail = get_field('national_account_notify_email', 'option');

    $subject = 'NA Account Application';
    $from = get_post_meta($post_id, 'na_email', true);
    $headers = 'Reply-To: ' . $from;

    wp_mail($toEmail, $subject, $body, $headers);

    tx_connect_form_happyfox(10, [
        'contact_name' => $_POST['first_name'] . ' ' . $_POST['lastName'],
        'contact_email' => $_POST['na_email'],
        'contact_subject' => 'National Accounts Inquiry - ' . $_POST['na_company'],
        'body' => $_POST['inquiry'],
        'phone' => $_POST['na_phone'],
        'company' => $_POST['na_company'],
    ]);

    $reponse = array("message" => "ok", "redirect" => home_url() . "/thanks/?from=na_account");
    echo json_encode($reponse);
    die();
}

add_action('wp_ajax_donaction_submission', 'donaction_submission_callback');
add_action('wp_ajax_nopriv_donaction_submission', 'donaction_submission_callback');

function donaction_submission_callback() {

    //require the needed files
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $author_id = 1;
    $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => $author_id,
                'post_title' => $_POST['first_name'] . ' ' . $_POST['last_name'],
                'post_content' => $_POST['content'],
                'post_status' => 'publish',
                'post_type' => 'donations'
            )
    );

    //then loop over the files that were sent and store them using  media_handle_upload();
    if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                echo "upload error : " . $_FILES[$file]['error'];
                die();
            }
            $attach_id = media_handle_upload($file, $post_id);
        }
    }
    if ($post_id) {
        foreach ($_POST as $key => $value) {
            if ($key != 'action' && $key != "content")
                update_post_meta($post_id, $key, $value);
        }
    }
    //and if you want to set that image as Post  then use:
    update_post_meta($post_id, 'attach_document', $attach_id);
    $body = include(get_template_directory() . '/emails/brief_donation_template.php');
    $toEmail = get_field('donation_notify_email', 'option');

    $subject = 'Donation Form submission';
    $from = get_post_meta($post_id, 'contact_email', true);
    $headers = 'Reply-To: ' . $from;

    wp_mail($toEmail, $subject, $body, $headers);



    tx_connect_form_happyfox(8, [
        'contact_name' => $_POST['first_name'] . ' ' . $_POST['last_name'],
        'contact_email' => $_POST['contact_email'],
        'contact_subject' => 'Donation Request - ' . $_POST['company'],
        'body' => $_POST['content'],
        'phone' => $_POST['contact_phone'],
        'attachments' => $attach_id ? get_attached_file($attach_id) : false,
        'company' => $_POST['company']
    ]);

    if (!empty($attach_id))
        wp_delete_attachment($attach_id, true);

    $reponse = array("message" => "ok", "redirect" => home_url() . "/thanks/?from=donation");
    echo json_encode($reponse);
    die();
}

add_action('wp_ajax_leasing_expansions', 'leasing_expansions_callback');
add_action('wp_ajax_nopriv_leasing_expansions', 'leasing_expansions_callback');

function leasing_expansions_callback() {

    $author_id = 1;
    $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => $author_id,
                'post_title' => $_POST['first_name'] . ' ' . $_POST['last_name'],
                'post_content' => $_POST['content'],
                'post_status' => 'publish',
                'post_type' => 'leasing_expansion'
            )
    );
    if ($post_id) {
        foreach ($_POST as $key => $value) {
            if ($key != 'action' && $key != "state")
                update_post_meta($post_id, $key, $value);
        }
        $loc = array($_POST['state']);
        $location = serialize($loc);
        update_post_meta($post_id, 'state', $location);
    }
    $body = include(get_template_directory() . '/emails/brief_leasing_template.php');
    $toEmail = get_field('leasing_expansions_notify_email', 'option');

    $subject = 'LEASING & EXPANSION Form submission';
    $from = get_post_meta($post_id, 'email', true);
    $headers = 'Reply-To: ' . $from;
    wp_mail($toEmail, $subject, $body, $headers);


    tx_connect_form_happyfox(7, [
        'contact_name' => $_POST['first_name'] . ' ' . $_POST['last_name'],
        'contact_email' => $_POST['email'],
        'contact_subject' => 'Leasing & Expansion Inquiry - ' . $_POST['company'],
        'phone' => $_POST['phone'],
        'body' => $_POST['content'],
        'company' => $_POST['company']
    ]);

    $reponse = array("message" => "ok", "redirect" => home_url() . "/thanks/?from=leasing-expansion");
    echo json_encode($reponse);

    die();
}
