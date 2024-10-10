<?php
add_action( 'init', 'add_special_post_type' );
/**
 * Register a Special post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function add_special_post_type() {
  $labels = array(
    'name'               => _x( 'Specials', 'post type general name', 'texas' ),
    'singular_name'      => _x( 'Special', 'post type singular name', 'texas' ),
    'menu_name'          => _x( 'Specials', 'admin menu', 'texas' ),
    'name_admin_bar'     => _x( 'Special', 'add new on admin bar', 'texas' ),
    'add_new'            => _x( 'Add New', 'Special', 'texas' ),
    'add_new_item'       => __( 'Add New Special', 'texas' ),
    'new_item'           => __( 'New Special', 'texas' ),
    'edit_item'          => __( 'Edit Special', 'texas' ),
    'view_item'          => __( 'View Special', 'texas' ),
    'all_items'          => __( 'All Specials', 'texas' ),
    'search_items'       => __( 'Search Specials', 'texas' ),
    'parent_item_colon'  => __( 'Parent Specials:', 'texas' ),
    'not_found'          => __( 'No Specials found.', 'texas' ),
    'not_found_in_trash' => __( 'No Specials found in Trash.', 'texas' )
  );

  $args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'texas' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'specials' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields')
  );

  register_post_type( 'specials', $args );
}
//Register custom post Locations

function custom_post_type_locations() {
  $labels = array(
    'name'               => 'Locations',
    'singular_name'      => 'Location',
    'menu_name'          => 'Location',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Location',
    'add_new'            => 'Add New Location',
    'add_new_item'       => 'Add New Location',
    'new_item'           => 'New Location',
    'edit_item'          => 'Edit Location',
    'view_item'          => 'View Location',
    'all_items'          => 'All Locations',
    'search_items'       => 'Search Locations',
    'parent_item_colon'  => 'Parent Locations:',
    'not_found'          => 'No Locations found.',
    'supports'           =>array('title','description','custom-fields','thumbnail','author'),
    'not_found_in_trash' => 'No Locations found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Locations will be published using this post type'
  );
      register_post_type( 'locations', $args );
}
add_action( 'init', 'custom_post_type_locations' );
add_action( 'init', 'host_event_submission' );
add_action( 'init', 'catering_event_submission' );
function host_event_submission(){
  $labels = array(
    'name'               => 'Host Event Submission',
    'singular_name'      => 'Host Event',
    'menu_name'          => 'Host Event',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Host Event',
    'add_new'            => 'Add Host Event',
    'add_new_item'       => 'Add Host Event',
    'new_item'           => 'New Host Event',
    'edit_item'          => 'Edit Host Event',
    'view_item'          => 'View Host Event',
    'all_items'          => 'All Host Event',
    'supports'           =>array('title','description','custom-fields'),
    'not_found_in_trash' => 'No Host Event found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Host Event will be published using this post type'
  );
      register_post_type( 'host_event', $args );
}

function catering_event_submission(){
  $labels = array(
    'name'               => 'Catering ',
    'singular_name'      => 'Catering ',
    'menu_name'          => 'Catering ',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Catering ',
    'add_new'            => 'Add Catering ',
    'add_new_item'       => 'Add Catering ',
    'new_item'           => 'New Catering ',
    'edit_item'          => 'Edit Catering',
    'view_item'          => 'View Catering ',
    'all_items'          => 'All Catering',
    'supports'           =>array('title','description','custom-fields'),
    'not_found_in_trash' => 'No Catering Submission found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Catering Submission will be published using this post type'
  );
      register_post_type( 'catering_submission', $args );
}

add_action( 'init', 'na_submission' );

function na_submission(){
  $labels = array(
    'name'               => 'NA Submission',
    'singular_name'      => 'NA Submission ',
    'menu_name'          => 'NA Submission ',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'NA Submission',
    'add_new'            => 'Add NA Submission',
    'add_new_item'       => 'Add NA Submission',
    'new_item'           => 'New NA Submission',
    'edit_item'          => 'Edit NA Submission',
    'view_item'          => 'View NA Submission',
    'all_items'          => 'All NA Submission',
    'supports'           =>array('title','description','custom-fields'),
    'not_found_in_trash' => 'No NA Submission Submission found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'NA Submission will be published using this post type'
  );
  register_post_type( 'na_submission', $args );
}

add_action( 'init', 'award_callback' );

function award_callback(){
  $labels = array(
    'name'               => 'Awards',
    'singular_name'      => 'Awards',
    'menu_name'          => 'Awards',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Awards',
    'add_new'            => 'Add Award',
    'add_new_item'       => 'Add Award',
    'new_item'           => 'New Award',
    'edit_item'          => 'Edit Awards',
    'view_item'          => 'View Awards',
    'all_items'          => 'All Awards',
    'supports'           =>array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields'),
    'not_found_in_trash' => 'No Awards found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Awards will be published using this post type',
    'supports'           =>array( 'title', 'editor', 'author','custom-fields'),
  );
  register_post_type( 'awards', $args );
}

add_action( 'init', 'faq_callback' );

function faq_callback(){
  $labels = array(
    'name'               => 'Faq',
    'singular_name'      => 'Faq',
    'menu_name'          => 'Faq',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Faq',
    'add_new'            => 'Add Faq',
    'add_new_item'       => 'Add Faq',
    'new_item'           => 'New Faq',
    'edit_item'          => 'Edit Faq',
    'view_item'          => 'View Faq',
    'all_items'          => 'All Faq',
    'not_found_in_trash' => 'No Faq found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Faq will be published using this post type',
    'supports'           =>array( 'title', 'editor', 'author','custom-fields'),
  );
  register_post_type( 'faqs', $args );
}
add_action( 'init', 'contact_submission' );

function contact_submission(){
  $labels = array(
    'name'               => 'Contact Submission',
    'singular_name'      => 'Contact Submission ',
    'menu_name'          => 'Contact Submission ',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Contact Submission',
    'add_new'            => 'Add Contact ',
    'add_new_item'       => 'Add Contact ',
    'new_item'           => 'New Contact Submission',
    'edit_item'          => 'Edit Contact Submission',
    'view_item'          => 'View Contact Submission',
    'all_items'          => 'All Contact ',
    'supports'           =>array('title','description','custom-fields'),
    'not_found_in_trash' => 'No Contact Submission Submission found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Contact Submission will be published using this post type'
  );
  register_post_type( 'contact_submission', $args );
}

add_action( 'init', 'card_theme_callback' );

function card_theme_callback(){
  $labels = array(
    'name'               => 'Card Themes',
    'singular_name'      => 'Card Theme',
    'menu_name'          => 'Card Themes',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Card Themes',
    'add_new'            => 'Add Card Themes',
    'add_new_item'       => 'Add Card Themes',
    'new_item'           => 'New Card Themes',
    'edit_item'          => 'Edit Card Themes',
    'view_item'          => 'View Card Themes',
    'all_items'          => 'All Card Themes',
    'not_found_in_trash' => 'No Card Themes found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Card Themes will be published using this post type',
    'supports'           =>array( 'title', 'author','thumbnail'),
  );
  register_post_type( 'themes', $args );
}

add_action( 'init', 'leasing_expansion_callback' );

function leasing_expansion_callback(){
  $labels = array(
    'name'               => 'Leasing & Expansion',
    'singular_name'      => 'Leasing & Expansion',
    'menu_name'          => 'Leasing & Expansions',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Leasing & Expansion',
    'add_new'            => 'Add Leasing & Expansions',
    'add_new_item'       => 'Add Leasing & Expansion',
    'new_item'           => 'New Leasing & Expansion',
    'edit_item'          => 'Edit Leasing & Expansion',
    'view_item'          => 'View Leasing & Expansion',
    'all_items'          => 'All Leasing & Expansion',
    'not_found_in_trash' => 'No Leasing & Expansion found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Leasing and Expension will be published using this post type',
    'supports'           =>array( 'title','editor', 'author','custom-fields'),
  );
  register_post_type( 'leasing_expansion', $args );
}

add_action( 'init', 'joineclub_callback' );

function joineclub_callback(){
  $labels = array(
    'name'               => 'E-Club',
    'singular_name'      => 'E-Club',
    'menu_name'          => 'E-Club',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'E-Club',
    'add_new'            => 'Add E-Club',
    'add_new_item'       => 'Add E-Club',
    'new_item'           => 'New E-Club',
    'edit_item'          => 'Edit E-Club',
    'view_item'          => 'View E-Club',
    'all_items'          => 'All E-Club',
    'not_found_in_trash' => 'No E-Club found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'E-Club will be published using this post type',
    'supports'           =>array( 'title','author','custom-fields'),
  );
  register_post_type( 'e_club', $args );
}

add_action( 'init', 'donation_callback' );

function donation_callback(){
  $labels = array(
    'name'               => 'Donation',
    'singular_name'      => 'Donation',
    'menu_name'          => 'Donation',
    'menu_icon'          =>'dashicons-id-alt',
    'name_admin_bar'     => 'Donation',
    'add_new'            => 'Add Donation',
    'add_new_item'       => 'Add Donation',
    'new_item'           => 'New Donation',
    'edit_item'          => 'Edit Donation',
    'view_item'          => 'View Donation',
    'all_items'          => 'All Donation',
    'not_found_in_trash' => 'No Donation found in Trash.'
  );

  $args = array( 
    'public'      => true, 
    'labels'      => $labels,
    'description' => 'Donation will be published using this post type',
    'supports'           =>array( 'title','editor', 'author','custom-fields'),
  );
  register_post_type( 'donations', $args );
}