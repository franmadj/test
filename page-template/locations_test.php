<?php
/*
  Template Name:Locations Test
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
            <a href="#locationbody" class="c-locations__finder-box show-only-desktop"><div class="u-reveal-locations"><div class="u-reveal-locations__reveal-button"><span class="u-reveal-locations__need-more-results">View a list of</span><span class="u-reveal-locations__show-more">our Locations</span></div></div></a>
            <div class="c-locations__item c-locations--finder u-finder" data-ref="locationFinder">
                <span class="t-heading-five u-finder__heading" data-ref="ajaxifiedTitle">Find locations near you</span>
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
                <div class="u-finder__options" role="tablist" aria-label="internationality">
                    <span class="t-heading-six u-options-label t-light-gray" data-ref="showLabel">Show</span>
                    <span class="t-heading-six u-options-label results-reset-button" data-ref="resultsResetBtn">RESET</span>

                    <span class="t-heading-six u-finder__option u-finder__option--selected tab-option" data-ref="filterMarkers" data-type="all"
                          id="no-international-tab-" type="button" role="tab" aria-selected="true" aria-controls="internationality">All</span>

                    <span class="t-heading-six u-finder__option selecting-international tab-option" data-ref="filterMarkers" data-type="international"
                          id="international-tab-" type="button" role="tab" aria-selected="false" aria-controls="internationality">International Only</span>
                </div>
            </div>
            <div class="c-locations" data-ref="locationList">
                <div class="u-ajax-container" data-ref="ajaxReplace">
                    <?php get_template_part('template-parts/location', 'marker'); ?>

                    <div class="u-reveal-locations" data-ref="revealLocations">
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
            <li data-ref="jumpToRegion" data-lat="39.689111" data-lng="-102.853950" data-zoom="5" role="button">United States</li>
            <li data-ref="jumpToRegion" data-lat="23.703503" data-lng="-102.590278" data-zoom="6" role="button">Mexico</li>
            <li data-ref="jumpToRegion" data-lat="29.2985" data-lng="42.5510" data-zoom="5" role="button">Middle East</li>
            <li data-ref="jumpToRegion" data-lat="38.794595" data-lng="106.534838" data-zoom="5" role="button">East Asia</li>
        </div>

        <div id="map" class="c-map__iframe-container">
        </div>
        <a href="#locationbody" class="hero__arrow" title="Scroll down"></a>
    </div>
    <div id="locationbody" class="c-locations__body">
        <div class="faq-landing-content locations-content-updated">
            <?php the_content(); ?>
        </div>
    </div>
<?php endwhile; ?>
<script>
    jQuery(document).ready(function ($) {
        $('.tab-option').click(function () {
            $('.tab-option').attr('aria-selected', 'false');
            $(this).attr('aria-selected', 'true');

        });

<?php if (isset($_GET['distance']) && isset($_GET['location'])) { ?>
        $('#u-finder__distance').val('<?php echo $_GET['distance']; ?>');
        $('.u-finder__address').val('<?php echo $_GET['location']; ?>');
        $(':fetchLocations').trigger('submit');

<?php } ?>

    })
</script>
<?php get_footer(); ?>
