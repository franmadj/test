<?php
/*
Template Name:Locations
*/
get_header();
//$latlong = file_get_contents('https://ipapi.co/103.97.185.85/latlong/');
//print_r($latlong);
?>
<?php
while ( have_posts() ) :the_post(); ?>
<div class="c-map" data-ref="map">
	<meta name="apiKey" value="https://maps.googleapis.com/maps/api/js?key=AIzaSyAR0JcTIISM1lfgw7BDmHe97lva61zGKKY">
	<meta name="lat" value="31.169621">
	<meta name="lng" value="-99.683617">
	<div class="c-locations__wrap">
		<div class="c-locations__item c-locations--finder u-finder" data-ref="locationFinder">
			<span class="t-heading-five u-finder__heading" data-ref="ajaxifiedTitle">Find locations near you</span>
			<form method="POST" action="<?php echo home_url();?>/locations/" data-ref="fetchLocations">
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
				<span class="t-heading-six u-options-label results-reset-button" data-ref="resultsResetBtn">RESET</span>
				<span class="t-heading-six u-finder__option u-finder__option--selected" data-ref="filterMarkers" data-type="all">All</span>
				<span class="t-heading-six u-finder__option" data-ref="filterMarkers" data-type="international">International Only</span>
			</div>
		</div>
		<div class="c-locations" data-ref="locationList">
			<div class="u-ajax-container" data-ref="ajaxReplace">
				<?php get_template_part('template-parts/location','marker');?>
				
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
		<li data-ref="jumpToRegion" data-lat="39.689111" data-lng="-102.853950" data-zoom="5">United States</li>
		<li data-ref="jumpToRegion" data-lat="23.703503" data-lng="-102.590278" data-zoom="6">Mexico</li>
		<li data-ref="jumpToRegion" data-lat="29.2985" data-lng="42.5510" data-zoom="5">Middle East</li>
		<li data-ref="jumpToRegion" data-lat="38.794595" data-lng="106.534838" data-zoom="5">East Asia</li>
	</div>
	
	<div id="map" class="c-map__iframe-container">
	</div>
</div>
<div id="locationbody" class="c-locations__body">
	<div class="faq-landing-content locations-content-updated">
		<?php the_content();?>
	</div>
</div>
<?php endwhile;?>
<?php get_footer();?>
<script type="text/javascript">
// 	 jQuery(".u-finder__submit").click(function(e) {

//   e.preventDefault(); // avoid to execute the actual submit of the form.
//   jQuery.ajax({
  
//   type:    "POST",
//   url:     "<?php echo admin_url('admin-ajax.php'); ?>",
//   data:    {action:'location_search'}, 
// 	  success: function(data)
// 			{
// 				jQuery(".u-ajax-container").empty();

// 				console.log(data);
// 			  jQuery('.u-ajax-container').append(data);
// 			  updateLocationData(true);
// 			}
// 	});
// });
</script>