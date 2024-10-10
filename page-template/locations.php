<?php
/*
  Template Name:Locations
 */
get_header();
?>
<?php
//39.444427, -0.688478
//dumpp(@file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng=43.1234115,-77.61901699999999&key=AIzaSyAR0JcTIISM1lfgw7BDmHe97lva61zGKKY&sensor=true'));
while (have_posts()) :the_post();
    ?>
    <div class="c-map" data-ref="map">
        <meta name="apiKey" value="https://maps.googleapis.com/maps/api/js?key=AIzaSyAR0JcTIISM1lfgw7BDmHe97lva61zGKKY">
        <meta name="lat" value="31.169621">
        <meta name="lng" value="-99.683617">
        <?php get_template_part('inc/current-location'); ?>

        <div class="c-locations__wrap">
            <a href="#locationbody" class="c-locations__finder-box show-only-desktop">
                <div class="u-reveal-locations">
                    <div class="u-reveal-locations__reveal-button">
                        <span class="u-reveal-locations__need-more-results">View a list of</span><span class="u-reveal-locations__show-more">our Locations</span>
                    </div>
                </div>
            </a>
            <div class="c-locations__item c-locations--finder u-finder" data-ref="locationFinder">
                <span class="t-heading-five u-finder__heading find-location-mobile">Find locations near you</span>
                <span class="t-heading-five u-finder__heading result-location-mobile" data-ref="ajaxifiedTitle"></span>
                <span class="t-heading-five u-finder__heading find-location-desktop" data-ref="ajaxifiedTitle">Find locations near you</span>
                <form method="POST" action="<?php echo home_url(); ?>/locations/" data-ref="fetchLocations">
                    <div class="u-finder__distance-wrapper">
                        <select id="u-finder__distance" name="distance" class="u-finder__distance" data-type="distanceParam" data-ignore="true" aria-label="Distance">
                            <option value="null" disabled>Distance</option>
                            <option value="10">Within 10 Miles</option>
                            <option value="25" selected>Within 25 Miles</option>
                            <option value="50">Within 50 Miles</option>
                            <option value="100">Within 100 Miles</option>
                        </select>
                    </div>
                    <input type="text" class="u-finder__address" name="address" placeholder="Zip, City, or State&hellip;" aria-label="Address" data-ref="address">
                    <button class="u-finder__submit" aria-label="Submit the location finder form"></button>
                </form>
                <div class="u-finder__options">
                    <span class="t-heading-six u-options-label t-light-gray" data-ref="showLabel">Show</span>
                    <span role="button" class="t-heading-six u-options-label results-reset-button" data-ref="resultsResetBtn">RESET</span>
                    <div style="display: inline;" role="tablist" class="tab-links">

                        <a href="JavaScript:void(0);" type="button" class="t-heading-six u-finder__option u-finder__option--selected tab-option" data-ref="filterMarkers" data-type="all"
                           id="no-international-tab-" role="tab">All</a>

                        <a href="JavaScript:void(0);" type="button" class="t-heading-six u-finder__option selecting-international tab-option" data-ref="filterMarkers" data-type="international"
                           id="international-tab-" role="tab" tabindex="-1">International Only</a>
                    </div>
                </div>
            </div>
            <div class="c-locations" data-ref="locationList">
                <div class="u-ajax-container" data-ref="ajaxReplace">
                    <?php get_template_part('template-parts/location', 'marker'); ?>

                    <div role="button" class="u-reveal-locations" data-ref="revealLocations" tabindex="0">
                        <div class="u-reveal-locations__reveal-button">
                            <span class="u-reveal-locations__need-more-results">Need more results?</span>
                            <span class="u-reveal-locations__show-more">Show more</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="locations-groups _dark">
            <h4>Select Region</h4>
            <li data-ref="jumpToRegion" data-lat="39.689111" data-lng="-102.853950" data-zoom="5" role="button" tabindex="0">United States</li>
            <li data-ref="jumpToRegion" data-lat="29.2985" data-lng="42.5510" data-zoom="5" role="button" tabindex="0">Middle East</li>
            <li data-ref="jumpToRegion" data-lat="38.794595" data-lng="106.534838" data-zoom="5" role="button" tabindex="0">East Asia</li>
        </div>

        <div id="map" class="c-map__iframe-container" tabindex="0" role="tabpanel" aria-labelledby="no-international-tab-">
        </div>

    </div>
    <div id="locationbody" class="c-locations__body">
        <div style="position:relative;width: 100%;height: 22px;margin: 0px 0 12px 0;"><a href="#locationbody" class="hero__arrow hide-on-mobile" title="Scroll down"></a></div>
        <div class="faq-landing-content locations-content-updated">
            <?php the_content(); ?>
        </div>
    </div>
    <?php
endwhile;
$user_ip = $_SERVER['REMOTE_ADDR'];

$ip_key = str_replace('.', '_', $user_ip) . 'the_city';

error_log___('$_COOKIE ' . print_r($_COOKIE, true));

if (isset($_COOKIE[$ip_key]) && false) { 
    $city = 'Null' == $_COOKIE[$ip_key] ? '' : $_COOKIE[$ip_key];
    error_log___('ipapicity**************FROM COOCKIE ' . $city);
} else { //var_dump('noisset');
    //$city = file_get_contents("https://ipapi.co/$user_ip/city/");
    $city = false;
    $city = $city ? $city : '';
    $cookie = setcookie($ip_key, $city, time() + (60 * 60 * 24 * 15));
    error_log___('ipapicity**************FROM IP ' . print_r([$city, $cookie], true));
    //error_log___('ipapicity**************FROM IP '.$city);
}
?>
<script>
    jQuery(document).ready(function ($) {


<?php if (isset($_GET['distance']) && isset($_GET['location'])) { ?>
            $('#u-finder__distance').val('<?php echo $_GET['distance']; ?>');
            $('.u-finder__address').val('<?php echo $_GET['location']; ?>');
            $(':fetchLocations').trigger('submit');

<?php } elseif (!empty($city) && $city) { ?>
            $('#u-finder__distance').val('100');
            $('.u-finder__address').val('<?php echo $city; ?>');
            $(':fetchLocations').trigger('submit');

<?php } ?>

    })
</script>
<script type="text/javascript" src="https://shop.texasdebrazil.com/wp-content/themes/texaswp/assets/js/info-tabs.js" id="texaswp-script-infotabs-js"></script>
<?php

function error_log___($value) {
    return;
    if ($_SERVER['REMOTE_ADDR'] == '77.228.116.64') {
        error_log($value);
    }
}

get_footer();
?>
