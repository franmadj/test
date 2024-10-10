<?php

add_action('wp_ajax_join_eclub', 'join_eclub_callback');
add_action('wp_ajax_nopriv_join_eclub', 'join_eclub_callback');

function join_eclub_callback() {
    $author_id = 1;
    $post_id = wp_insert_post(
            array(
                'comment_status' => 'closed',
                'ping_status' => 'closed',
                'post_author' => $author_id,
                'post_title' => $_POST['firstName'] . ' ' . $_POST['lastName'],
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'e_club'
            )
    );
    //$location = array($_POST['selectedLocation']);

    if ($post_id) {
        foreach ($_POST as $key => $value) {
            if ($key != 'action' && $key != "selectedLocation")
                update_post_meta($post_id, $key, $value);
        }
        update_post_meta($post_id, 'fishbowlId', $_POST['selectedLocation']);
        $args = array(
            'post_type' => 'locations',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title',
            'meta_query' => array(
                array(
                    'key' => 'fishbowl_id',
                    'value' => $_POST['selectedLocation'],
                    'compare' => '='
                ),
            ),
        );
        $location = new WP_Query($args);
        while ($location->have_posts()) : $location->the_post();
            $loc = array(get_the_ID());
            update_post_meta($post_id, 'selectedLocation', serialize($loc));
        endwhile;
    }
    $reponse = array("message" => "ok", "redirect" => home_url() . "/thanks/?from=e-club");

    //echo json_encode($reponse);
    die();
}

add_action('wp_ajax_fishbowl_members_update', 'fishbowl_members_update_callback');
add_action('wp_ajax_nopriv_fishbowl_members_update', 'fishbowl_members_update_callback');

function fishbowl_members_update_callback() {
    if (!empty($_POST['email']) && !empty($_POST['storecode']) && !empty($_POST['anniversary']) && !empty($_POST['birthday'])) {
        require_once get_template_directory() . '/inc/FishBowl.class.php';
        $data = [
            'email' => $_POST['email'],
            'storecode' => $_POST['storecode'],
            'anniversary' => $_POST['anniversary'],
            'birthday' => $_POST['birthday'],
        ];
        $fishbowl = new FishBowl();
        $value = $fishbowl->updateMember($data);
        if (204 == $value)
            wp_die('ok');
        else
            wp_die('ko');
    }
}

add_action('wp_ajax_check_eclub_form_user_exists', 'check_eclub_form_user_exists_callback');
add_action('wp_ajax_nopriv_check_eclub_form_user_exists', 'check_eclub_form_user_exists_callback');

//add_action('init', 'check_eclub_form_user_exists_callback');

function check_eclub_form_user_exists_callback() {
    require_once get_template_directory() . '/inc/FishBowl.class.php';
    $fishbowl = new FishBowl();
    $value = $fishbowl->getMeberByEmail($_POST['eclub_email']);
    if ($value)
        wp_die('yes');
    else
        wp_die('no');
}
