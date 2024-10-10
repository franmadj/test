<div class="home-location parallax" data-ref="responsiveVisualElement" style="background-image: url(<?php the_field('responsive_desktop_image');?>);" data-mobile="<?php the_field('responsive_mobile_image');?>" data-desktop="<?php the_field('responsive_desktop_image');?>">
    <div class="home-location__inner">
        <h2 class="home-location__title"><?php the_field('home_location_title');?></h2>
        <p class="home-location__intro">
            <?php the_field('instructions');?>
        </p>
        <form class="location-finder" action="/locations">
            <div class="location-finder__field">
                <label for="location-distance" class="location-finder__label">Distance</label>
                <div class="location-finder__dropdown">
                    <select name="distance" id="location-distance" label="Select Distance" class="location-finder__select">
                        <option value="10" class="location-finder__option">Within 10 miles</option>
                        <option value="25" class="location-finder__option" selected>Within 25 miles</option>
                        <option value="50" class="location-finder__option">Within 50 miles</option>
                        <option value="100" class="location-finder__option">Within 100 miles</option>
                    </select>
                </div>
            </div>
            <div class="location-finder__field">
                <label for="location-location" class="location-finder__label">Location</label>
                <input class="location-finder__input" name="location" id="location-location" type="text" placeholder="Zip, City, or State&hellip;">
            </div>
            <button class="location-finder__submit" type="submit">
                Search
                <svg class="location-finder__submit-border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <title>location border</title>
                    <path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd" />
                </svg>
            </button>
        </form>
        <a href="/locations/" class="home-location__link">View all</a>
    </div>
    </div>