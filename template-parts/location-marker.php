<a href="#locationbody" class="c-locations__finder-box-mobile c-locations__item c-locations__item--first show-only-mobile">
    <div class="u-reveal-locations"><div class="u-reveal-locations__reveal-button"><span class="u-reveal-locations__need-more-results">View a list of</span><span class="u-reveal-locations__show-more">our Locations</span></div></div></a>
<?php
global $wpdb;
$user_ip = $_SERVER['REMOTE_ADDR'];
$ipapikey = get_field('ipapi_key', 'option');
if ($user_ip != '127.0.0.1') {
    $latlong = file_get_contents("https://ipapi.co/$user_ip/latlong/?key=$ipapikey");
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

$search_radius = 999999;

$sql = $wpdb->prepare("SELECT $wpdb->posts.ID,

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

					WHERE 1=1

						AND ($wpdb->posts.post_status = 'publish' )

						AND ($wpdb->posts.post_type = 'locations' )

						AND latitude.meta_key='lat'

						AND longitude.meta_key='lng'

					HAVING distance < %s

					ORDER BY distance ASC", $search_lat, $search_long, $search_lat, $search_radius
);


$post_ids = $wpdb->get_results($sql, OBJECT_K);



if ($post_ids) {
    $j = 0;
    foreach ($post_ids as $key => $value) {
        $map_location = get_field('location', $key);
        $slide_images = get_field('photo', $key);
        $phone = get_field('phone_numbers', $key);
        if (get_field('entry_type', $key)) {
            $entry_type = get_field('entry_type', $key);
        } else {
            $entry_type = "domestic";
        }
        if ($map_location):
            ?>
            <a href="<?php echo get_the_permalink($key); ?>" class="c-locations__item <?php if ($j > 3) echo 'c-locations__item--hidden'; ?>" data-ref="location" data-index="<?= $j; ?>" data-type="<?php echo $entry_type; ?>">
                <meta name="location[]" value='{"lat":"<?php echo $map_location['lat']; ?>","lng":"<?php echo $map_location['lng']; ?>","title":"<?php echo get_the_title($key); ?>","address":"<?php echo $map_location['address']; ?>","phone":"<?php
                if ($phone) {
                    echo $phone[0]['number'];
                }
                ?>","distance":"<?php echo number_format($value->distance); ?> mi. away","link":"<?php echo get_the_permalink($key); ?>"}'>
                      <?php if ($slide_images): ?>
                    <img src="<?php echo $slide_images[0]['sizes']['homeslider_button']; ?>" class="c-locations__image" alt="<?php the_title(); ?>" width="132px" height="69px;">
                <?php else: ?>
                    <img src="https://s3.amazonaws.com/texas-de-brazil-website/locations/International/Riyadh/_260x138_crop_center-center_50/KSA-Outside.jpg" class="c-locations__image" alt="<?php echo get_the_title($key); ?>">
                <?php endif; ?>
                <span class="c-locations__title"><?php echo get_the_title($key); ?></span>
                <span class="c-locations__state"><?php the_field('state', $key); ?></span>
            </a>
            <?php
        endif;
        $j++;
    }
}
?>
	