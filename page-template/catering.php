<?php
/*
  Template Name:Catering
 */
get_header();
?>
<?php
while (have_posts()) :the_post();
    if (has_post_thumbnail($post->ID)):
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
        $hero_image = $image[0];
    else:
        $hero_image = home_url() . '/assets/img/about/about-bg.png';
    endif;
    if (get_field('promotion_mobile_image'))
        $promotion_mobile_image = get_field('promotion_mobile_image');
    else
        $promotion_mobile_image = $hero_image;
    ?>
    <div class="o-grid o-grid--gutters s-promotions">
        <div class="o-col">
            <div class="c-promo c-promo--feature" data-ref="responsiveVisualElement" style="background-image: url(<?php echo $hero_image; ?>);" data-mobile="<?php echo $promotion_mobile_image; ?>" data-desktop="<?php echo $hero_image; ?>">
                <div class="c-promo__content">
                    <h1 class="c-promo__title" style="color: #FFF;"><?php the_field('promotion_heading'); ?></h1><span class="c-promo__teaser"><?php the_field('teaser'); ?></span></div>
            </div>
        </div>
    </div>
    <div class="autocomplete-catering autocomplete-catering-top">
        <span >Chose your Location</span> 
        <div  class="autocomplete-locations">
            <select class="search-location" name="location"  placeholder="Search Location" >
            </select>
        </div>
    </div>

<div class="search-results" >

        <div >
            <h4>Chose your location:</h4>
            <p class="data-description"></p>
            <div class="autocomplete-catering">

                <div  class="autocomplete-locations">
                    <select class="search-location" name="location"  placeholder="Search Location" >
                    </select>
                </div>
            </div>

        </div>
        <div>
            <h3 class="data-title"></h3>
            <div>
                <span>To order takeout please call the restaurant directly:</span> <span class="data-phone"></span>
            </div>
            <div>
                <span>To place a catering request, click the button to the right and fill out the form: </span> 
                <a data-ignore="1" href="#catering" class="button  home-group-dining__cta" data-ref="openModal" data-type="hosting" data-ignore="">Place Catering Request</a>
            </div>
            <div class="icon-links">
                <span>To order delivery, choose your service:</span>  
                <div class="data-links">


                </div>

            </div>
        </div>



    </div>


    <div class="o-grid o-grid--gutters">
        <div class="o-col">
            <div class="c-promo-catering takeout-box"  data-mobile="https://texasdebrazil.com/wp-content/uploads/2020/03/Guest-and-Gaucho-383-Edit-Copy-Web.jpg" data-desktop="https://texasdebrazil.com/wp-content/uploads/2020/03/Guest-and-Gaucho-383-Edit-Copy-Web.jpg">
                <div class="c-promo_inner">
                    <h2 class="c-promo__title" style="color: white;">Takeout</h2>
                    <span class="c-promo__teaser">Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text</span>
                    <a href="#" class="c-promo__button">Download takeout menu</a>
                    <h2 class="c-promo__title" style="color: white;">Delivery</h2>
                    <span class="c-promo__teaser">Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text</span>

                    <div style="margin-top:30px;">
                        <a href="https://uber.com" class="icon-link" data-ignore="1" style="display:block;margin: 10px;"><img width="75" height="75" src="https://texasdebrazil.com/wp-content/uploads/2019/12/Selection_276.png"></a>
                        <a href="https://postmates.com" class="icon-link" data-ignore="1"><img width="75" height="75" src="https://texasdebrazil.com/wp-content/uploads/2019/12/Selection_277.png"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="o-col">
            <div class="c-promo-catering catering-box"  data-mobile="https://texasdebrazil.com/wp-content/uploads/2020/03/Guest-and-Gaucho-383-Edit-Copy-Web.jpg" data-desktop="https://texasdebrazil.com/wp-content/uploads/2020/03/Guest-and-Gaucho-383-Edit-Copy-Web.jpg">
                <div class="c-promo_inner">
                    <h2 class="c-promo__title" style="color: white;">Catering</h2>
                    <span class="c-promo__teaser">Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text Descriptive Text</span>
                    <a data-ignore="1" href="#catering" class="button  home-group-dining__cta" data-ref="openModal" data-type="hosting" style="
                       display: block;
                       width: 50%;
                       margin: 45px auto 3px;
                       ">Place Catering Request</a>
                    <a href="#" class="c-promo__button c-promo__button-red" style="
                       width: 50%;margin-top: 5px;
                       ">Dowload catering menu</a>
                </div>
            </div>
        </div>
    </div>

    




<?php endwhile; ?>


<div id="locationbody" class="c-locations__body">
    <div class="faq-landing-content locations-content-updated">
        <h1>For more information about your location please visit its page</h1>

        <div class="faqs all-location-links">
            <div class="faqs-entry">
                <h4>Alabama</h4>
                <div class="answer"><a href="/locations/birmingham/" data-redactor-span="true">Birmingham</a><br>
                    <a href="/locations/huntsville/" data-redactor-span="true">Huntsville</a><br>
                    <a href="/locations/mobile/" data-redactor-span="true">Mobile</a></div>
            </div>
            <div class="faqs-entry">
                <h4>California</h4>
                <div class="answer"><a href="/locations/carlsbad/" data-redactor-span="true">Carlsbad</a><br>
                    <a href="/locations/concord/" data-redactor-span="true">Concord (Coming Soon)</a><br>
                    <a href="/locations/fresno/" data-redactor-span="true">Fresno</a><br>
                    <a href="/locations/irvine/" data-redactor-span="true">Irvine</a><br>
                    <a href="/locations/oxnard/" data-redactor-span="true">Oxnard</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Colorado</h4>
                <div class="answer"><a href="/locations/denver/" data-redactor-span="true">Denver</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Connecticut</h4>
                <div class="answer"><a href="/locations/hartford/" data-redactor-span="true">Hartford</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Florida</h4>
                <div class="answer"><a href="/locations/dadeland-mall/" data-redactor-span="true">Dadeland Mall</a><br>
                    <a href="/locations/dolphin-mall/" data-redactor-span="true">Dolphin Mall</a><br>
                    <a href="/locations/fort-lauderdale/" data-redactor-span="true">Fort Lauderdale</a><br>
                    <a href="/locations/hallandale-beach/" data-redactor-span="true">Hallandale Beach</a><br>
                    <a href="/locations/jacksonville/" data-redactor-span="true">Jacksonville</a><br>
                    <a href="/locations/miami-beach/" data-redactor-span="true">Miami Beach</a><br>
                    <a href="/locations/orlando/" data-redactor-span="true">Orlando</a><br>
                    <a href="/locations/beach-gardens/" data-redactor-span="true">Palm Beach Gardens</a><br>
                    <a href="/locations/sunrise/" data-redactor-span="true">Sawgrass</a><br>
                    <a href="/locations/tampa/" data-redactor-span="true">Tampa</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Idaho</h4>
                <div class="answer"><a href="/locations/boise/" data-redactor-span="true">Boise</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Illinois</h4>
                <div class="answer"><a href="/locations/chicago/" data-redactor-span="true">Chicago</a><br>
                    <a href="/locations/orland-park/" data-redactor-span="true">Orland Park</a><br>
                    <a href="/locations/schaumburg/" data-redactor-span="true">Schaumburg</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Kentucky</h4>
                <div class="answer"><a href="/locations/lexington/" data-redactor-span="true">Lexington</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Louisiana</h4>
                <div class="answer"><a href="/locations/baton-rouge/" data-redactor-span="true">Baton Rouge</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Michigan</h4>
                <div class="answer"><a href="/locations/detroit/" data-redactor-span="true">Detroit</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Missouri</h4>
                <div class="answer"><a href="/locations/st-louis/" data-redactor-span="true">St. Louis</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Nevada</h4>
                <div class="answer"><a href="/locations/las-vegas/" data-redactor-span="true">Las Vegas</a></div>
            </div>
            <div class="faqs-entry">
                <h4>New York</h4>
                <div class="answer"><a href="/locations/albany/" data-redactor-span="true">Albany</a><br>
                    <a href="/locations/buffalo/" data-redactor-span="true">Buffalo</a><br>
                    <a href="/locations/long-island/" data-redactor-span="true">Long Island</a><br>
                    <a href="/locations/rochester/" data-redactor-span="true">Rochester</a><br>
                    <a href="/locations/syracuse/" data-redactor-span="true">Syracuse</a><br>
                    <a href="/locations/west-nyack/" data-redactor-span="true">West Nyack</a><br>
                    <a href="/locations/yonkers/" data-redactor-span="true">Yonkers</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Ohio</h4>
                <div class="answer"><a href="/locations/columbus/" data-redactor-span="true">Columbus</a><br>
                    <a href="/locations/westlake/" data-redactor-span="true">Westlake</a><br>
                    <a href="/locations/woodmere/" data-redactor-span="true">Woodmere</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Oklahoma</h4>
                <div class="answer"><a href="/locations/oklahoma-city/" data-redactor-span="true">Oklahoma City</a><br>
                    <a href="/locations/tulsa/" data-redactor-span="true">Tulsa</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Pennsylvania</h4>
                <div class="answer"><a href="/locations/pittsburgh/" data-redactor-span="true">Pittsburgh</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Tennessee</h4>
                <div class="answer"><a href="/locations/memphis/" data-redactor-span="true">Memphis</a><br>
                    <a href="/locations/nashville/" data-redactor-span="true">Nashville</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Texas</h4>
                <div class="answer"><a href="/locations/addison/" data-redactor-span="true">Addison</a><br>
                    <a href="/locations/dallas/" data-redactor-span="true">Dallas</a><br>
                    <a href="/locations/fort-worth/" data-redactor-span="true">Fort Worth</a><br>
                    <a href="/locations/houston/" data-redactor-span="true">Houston</a><br>
                    <a href="/locations/mcallen/" data-redactor-span="true">McAllen</a><br>
                    <a href="/locations/san-antonio/" data-redactor-span="true">San Antonio</a><br>
                    <a href="/locations/tyler/" data-redactor-span="true">Tyler</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Utah</h4>
                <div class="answer"><a href="/locations/lake-city/" data-redactor-span="true">Salt Lake City</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Virgina</h4>
                <div class="answer"><a href="/locations/fairfax/" data-redactor-span="true">Fairfax</a><br>
                    <a href="/locations/norfolk/" data-redactor-span="true">Norfolk</a><br>
                    <a href="/locations/richmond/" data-redactor-span="true">Richmond</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Washington</h4>
                <div class="answer"><a href="/locations/tacoma/" data-redactor-span="true">Tacoma</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Washington, DC</h4>
                <div class="answer"><a href="/locations/washington-dc/" data-redactor-span="true">Washington DC</a></div>
            </div>
            <div class="faqs-entry">
                <h4>Wisconsin</h4>
                <div class="answer"><a href="/locations/milwaukee/" data-redactor-span="true">Milwaukee</a></div>
            </div>
            <div class="faqs-entry">
                <h4>International</h4>
                <div class="answer"><a href="/locations/san-juan/" data-redactor-span="true">San Juan, Puerto Rico</a><br>
                    <a href="/locations/palm-beach/" data-redactor-span="true">Palm Beach, Aruba</a><br>
                    <a href="/locations/mexico-city-santa-fe/" data-redactor-span="true">Santa Fe, México City</a><br>
                    <a href="/locations/port-of-spain/" data-redactor-span="true">Port of Spain, Trinidad and Tobago</a><br>
                    <a href="/locations/riyadh/" data-redactor-span="true">Riyadh, Saudi Arabia</a><br>
                    <a href="/locations/dubai/" data-redactor-span="true">Dubai, United Arab Emirates</a><br>
                    <a href="/locations/abu-dhabi/" data-redactor-span="true">Abu Dhabi, United Arab Emirates</a><br>
                    <a href="/locations/seoul-central-city/" data-redactor-span="true">Seoul-Central City, South Korea</a><br>
                    <a href="/locations/seoul-apgujeong/" data-redactor-span="true">Seoul-Apgujeong, South Korea</a><br>
                    <a href="/locations/panama-city/" data-redactor-span="true">Panama City, Panama</a></div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>
<?php get_template_part('_includes/catering-modal'); ?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"></script>
<script type="text/javascript">






    var widgetId1;

    var onloadCallback = function () {

        widgetId1 = grecaptcha.render(document.getElementById('recap2'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });


    };
    jQuery(document).ready(function ($) {
        jQuery.noConflict();
        var verifyCallback = function (response) {
            console.log(response);
        };



        $('.catering_submit').click(function () {
            var response2 = grecaptcha.getResponse(0);

            if (response2.length === 0) {
                $('.recap2-error').text("reCAPTCHA is mandatory");
                return false;
            } else {
                $('.recap2-error').text('');
                doSumbitCattering();
            }
        })

        $('.home-group-dining__cta').click(function () {
            if ($('.event-modal').css('visibility') == 'hidden')
                $('.event-modal').css('visibility', 'visible');
            else
                $('.event-modal').css('visibility', 'hidden');
        });

        $('.event-modal__exit').click(function () {
            $('.event-modal').css('visibility', 'hidden');
        });


    });
</script>
