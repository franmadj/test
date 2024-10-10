<?php

// ONLY MOVIE CUSTOM TYPE POSTS
add_filter('manage_host_event_posts_columns', 'ST4_columns_head_only_host_event', 10);
add_action('manage_host_event_posts_custom_column', 'ST4_columns_content_only_host_event', 10, 2);
 
// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
function ST4_columns_head_only_host_event($defaults) {

    $defaults['reply'] = 'Reply';
    
    return $defaults;
}
function ST4_columns_content_only_host_event($column_name, $post_ID) {
    if ($column_name == 'reply') {
        // show content of 'directors_name' column
    	echo '<a class="button" href="mailto:'.get_field('client_email',$post_ID).'" target="_blank">Reply</a>';
    }
}

add_filter('manage_catering_submission_posts_columns', 'catering_submission_column', 10);
add_action('manage_catering_submission_posts_custom_column', 'catering_submission_column_content', 10, 2);

function catering_submission_column($defaults){
	$defaults['location'] = "Selected Location";
	$defaults['expiry_date'] = "Expiry Date";
	$defaults['reply'] = "Reply";
	return $defaults;
}

function catering_submission_column_content($column_name, $post_ID){
	if ($column_name == 'reply') {
      // show content of 'directors_name' column
  	echo '<a class="button" href="mailto:'.get_field('client_email',$post_ID).'" target="_blank">Reply</a>';
  }
  if ($column_name == 'location') {
        // show content of 'directors_name' column
  	$location = get_field('selected_location',$post_ID);
    	echo get_the_title($location[0]);
    }
}


add_filter('manage_contact_submission_posts_columns', 'contact_submission_column', 10);
add_action('manage_contact_submission_posts_custom_column', 'contact_submission_column_content', 10, 2);

function contact_submission_column($defaults){
	$defaults['subject'] = "Subject";
	$defaults['section'] = "Section";
	$defaults['reply'] = "Reply";
	return $defaults;
}

function contact_submission_column_content($column_name, $post_ID){
	if ($column_name == 'reply') {
     
  	echo '<a class="button" href="mailto:'.get_field('contact_email',$post_ID).'" target="_blank">Reply</a>';
  }
  if ($column_name == 'subject') {
    echo get_field('contact_subject',$post_ID);
  }
  if ($column_name == 'section') {
    echo "Contact Submissions";
  }
}

add_filter('manage_na_submission_posts_columns', 'na_submission_column', 10);
add_action('manage_na_submission_posts_custom_column', 'na_submission_column_content', 10, 2);

function na_submission_column($defaults){
	
	$defaults['expiry_date'] = "Expiry Date";
	$defaults['author'] = "Author";
	$defaults['link'] = "Link";
	$defaults['reply'] = "Reply";
	return $defaults;
}

function na_submission_column_content($column_name, $post_ID){
	if ($column_name == 'reply') {
      // show content of 'directors_name' column
  	echo '<a class="button" href="mailto:'.get_field('na_email',$post_ID).'" target="_blank">Reply</a>';
  }
  if ($column_name == 'author') {
        // show content of 'directors_name' column

    }
  if ($column_name == 'link') {
  }
  if ($column_name == 'expiry_date') {
  }
}