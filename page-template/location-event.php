<?php
if (!get_query_var('locations-event'))
    exit('invalid request');
$the_query = new WP_Query(['name' => get_query_var('locations-event'), 'post_type' => 'locations']);

if (empty($the_query->post->ID))
    exit('invalid request');

$disable = get_field('disable_togo_event_pages', $the_query->post->ID);
if (is_array($disable) && !empty($disable[0]) && 'yes' == $disable[0])
    wp_redirect('/');

add_filter('wpseo_title', function()use($the_query) {
    return get_field('page_title_event', $the_query->post->ID);
});
add_filter('wpseo_metadesc', function()use($the_query) {
    return get_field('page_description_event', $the_query->post->ID);
});

get_header();
?>
<?php
if ($the_query->have_posts()) :
    $alternative_find_table = get_field('find_table_alternative_content_toggle');
    $alternative_find_table = !empty($alternative_find_table[0]) && 'yes' == $alternative_find_table[0];
    while ($the_query->have_posts()) : $the_query->the_post();
        ?>
        <div class="location-container location-event-container">
            <?php
            if (isMobileDevice()) {
                $slide_images = get_field('event_gallery_mobile');
            } else {
                $slide_images = get_field('event_gallery');
            }
            ?>
            <div class="location-slider" data-ref="slideshow">
                <?php
                if ($slide_images):
//                if (!isMobileDevice()) {
//                    $newSlide=[];
//                    $newSlide[0]=$slide_images[0];
//                    $slide_images=$newSlide;
//                }
                    ?>
                    <div class="location-slider__slides" data-ref="slides">
                        <?php
                        $i = 1;
                        foreach ($slide_images as $slide_image):
                            ?>
                            <div class="location-slider__slide parallax <?php if ($i > 1) { ?> -disabled <?php } ?>" style="background-image: url(<?php echo $slide_image['url']; ?>);" data-ref="slide"></div>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </div>
                    <?php if (!isMobileDevice() && count($slide_images) > 1) : ?>
                        <div class="location-slider__buttons location-slider_events__buttons">
                            <?php
                            $j = 1;
                            $i = 0;
                            foreach ($slide_images as $slide_image):
                                ?>
                                <button aria-label="Slide <?= $j; ?>" class="location-slider__button<?php if ($i == 0) { ?> -active <?php } ?>" data-ref="slideButton" data-index="<?= $i; ?>">
                                    <span class="location-slider__thumbnail" style="background-image: url(<?php echo $slide_image['sizes']['thumbnail']; ?>)"></span>
                                </button>
                                <?php
                                $i++;
                                $j++;
                            endforeach;
                            ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <!--            <a href="/locations" class="location-image__button">Back to map</a>-->

            </div>

            <div class="location-info" data-ref="preventOverScroll">
                <div class="location-info__main">
                    <div style="display:flex;justify-content: center;">
                        <h1 class="location-info__title">
                            <?php the_title(); ?>
                            <span class="location-info__subtitle">
                                <?php if (get_field('location_subtitle')): ?>
                                    <?php the_field('location_subtitle'); ?>
                                <?php else: ?>

                                <?php endif; ?>
                            </span>
                        </h1>
                    </div>
                    <h2>Host An Event</h2>
                    <?php if (get_field('event_text')): ?>

                        <p><?php the_field('event_text'); ?></p>

                    <?php endif; ?>

                    <form id="host_event" method="POST" class="event-form">
                        <input type="hidden" name="redirect" value="thanks">
                        <div class="event-form__fieldset">
                            <h3 class="event-form__legend">Your contact details</h3>
                            <div class="event-form__field">
                                <div class="event-form__input-wrapper">
                                    <input aria-label="First Name" name="firstName" id="firstName" type="text" class="event-form__input" placeholder="First Name" required=""> <span aria-hidden='true'>*</span>
                                </div>
                            </div>
                            <div class="event-form__field">
                                <div class="event-form__input-wrapper">
                                    <input name="lastName" id="lastName" type="text" class="event-form__input" placeholder="Last Name" required=""> <span aria-hidden='true'>*</span>
                                </div>
                            </div>
                            <div class="event-form__field -full">
                                <div class="event-form__input-wrapper">
                                    <input name="email" type="email" id="email" class="event-form__input" placeholder="Email Address" required=""> <span aria-hidden='true'>*</span>
                                </div>
                            </div>
                            <div class="event-form__field">
                                <div class="event-form__input-wrapper">
                                    <input name="phone" type="text" id="phone" class="event-form__input" placeholder="Phone Number" required=""> <span aria-hidden='true'>*</span>
                                </div>
                            </div>
                            <div class="event-form__field">
                                <div class="event-form__input-wrapper">
                                    <input name="company" type="text" id="company" class="event-form__input" placeholder="Company">
                                </div>
                            </div>
                        </div>
                        <div class="event-form__fieldset">
                            <h3 class="event-form__legend">Your event details</h3>
                            <div class="event-form__field -full -select">
                                <!--                    <div class="event-form__input-wrapper">
                                                        <input name="natureofevent" id="natureofevent" placeholder="Nature of This Event*" type="text" class="event-form__input" required="">
                                                    </div>-->


                                <div class="unstyled">
            <!--                        <input name="natureofevent" placeholder="Nature of This Event*" type="text" class="event-form__input" required="">-->

                                    <select aria-label="Nature of this event" name="natureofevent" id="natureofevent" class="event-form__select natureofevent" data-ref="select" data-ignore="true" required="">
                                        <option value="" class="event-form__option">Nature of This Event</option>

                                        <?php
                                        $events = array(
                                            'Birthday', 'Cocktail Reception', 'Corporate/Business', 'Graduation', 'Holiday Party', 'Rehearsal Dinner', 'Social/Family', 'Wedding'
                                        );
                                        ?>
                                        <?php foreach ($events as $event) : ?>

                                            <option class="event-form__option" value="<?php echo $event; ?>"><?php echo $event; ?></option>

                                        <?php endforeach; ?>

                                    </select> <span aria-hidden='true'>*</span>
                                </div>


                            </div>
                            <div class="event-form__field -full -select">
                                <div class="unstyled">
                                    <select aria-label="Select a location" name="selectedLocation" id="selectedLocation" class="event-form__select" data-ref="select" data-ignore="true" required="">
                                        <option value="" class="event-form__option">Select a location</option>
                                        <?php if (get_field('tripleseat_id')): ?>
                                            <option class="event-form__option" selected="selected" value="<?php echo get_field('tripleseat_id'); ?>"><?php echo get_the_title(); ?></option>
                                            <?php
                                            if (8051888888888 == get_field('tripleseat_id'))
                                                echo '<option class="event-form__option" value="hawaii">Hawaii</option>';


                                        endif;
                                        ?>
                                    </select> <span aria-hidden='true'>*</span>
                                </div>
                            </div>
                            <div class="event-form__field -half" style="min-height:43px;">
                                <div class="event-form__input-wrapper" style="overflow:visible;">

                                    <?php if (isMobileDevice()) { ?> 
                                        <div style="position: relative;">
                                            <span aria-hidden="true" style="position: absolute;z-index: 9;left: 7px;top: 10px;">*</span>

                                            <label for="eventdate" class="label-trigger-date" style="padding: 6px 16px 6px 16px;display: block;position: absolute;background: #191919;margin: 5px 0 0 5px;font-size:13px;">PICK A DATE</label>
                                            <input type="date" name="event_date" class="event-form__input eventdate-mobile"  
                                                   id="eventdate" placeholder="MM/DD/YY" format="MM/DD/YY" min="<?php echo current_time('m/d/Y'); ?>" max="12-31-2030" required=""> 
                                        </div>

                                    <?php } else { ?>


                                        <script>
                                            var date_picker_only_future_dates = true;
                                            //var unset_current_date = true;
                                        </script>                                   
                                        <?php
                                        $input_name = 'event_date';
                                        $input_id = 'eventdate';
                                        $date_classes = 'no-default text-white';
                                        require_once(get_template_directory() . '/_includes/datepicker.php');
                                        ?>

                                    <?php } ?>
                                </div>
                            </div>



                            <div class="event-form__field -half -select">
                                <div class="unstyled">
                                    <select aria-label="Start Time" name="starttime" id="starttime" class="event-form__select" data-ref="select" data-ignore="true" required=""> 
                                        <option value="" class="event-form__option">Start Time</option>
                                        <?php get_template_part('template-parts/time', 'option'); ?>
                                    </select> <span aria-hidden='true'>*</span>
                                </div>
                            </div>
                            <div class="event-form__field -half -select">
                                <div class="unstyled">
                                    <select aria-label="End Time" name="endtime" id="endtime"  class="event-form__select" data-ref="select" data-ignore="true" required="">
                                        <option value="" class="event-form__option">End Time</option>
                                        <?php get_template_part('template-parts/time', 'option'); ?>
                                    </select> <span aria-hidden='true'>*</span>
                                </div>
                            </div>
                            <div class="event-form__field -half">
                                <div class="event-form__input-wrapper">
                                    <input name="numberofguests" id="numberofguests" placeholder="Number of Guests" type="number" class="event-form__input" min="14" required=""> <span aria-hidden='true'>*</span>
                                </div>




                            </div>
                            <div class="event-form__field -full">
                                <div class="event-form__input-wrapper">
                                    <textarea name="comments" id="comments" class="event-form__textarea" placeholder="Additional Comments" required=""></textarea> <span aria-hidden='true'>*</span>
                                </div>
                            </div>


                            <!--                <div class="gdpr_consent_granted">
                                                <input name="gdpr_consent_granted" id="gdpr_consent_granted" type="checkbox" >
                                                <label for="gdpr_consent_granted">* Consent to data collection as required by GDPR</label>
                                            </div>-->

                            <div class="u-form-check">
                                <span aria-hidden='true'>*</span>
                                <input type="checkbox" name="gdpr_consent_granted" id="gdpr_consent_granted"
                                       aria-label="Consent to data collection as required by GDPR" class="u-form-check__input" data-ref="conditionsChecked" >
                                <label for="gdpr_consent_granted" class="u-form-check__label u-conditions-text_">Consent to data collection as required by GDPR</label>
                            </div>


                        </div>
                        <div class="c-box__col mb-3">
                            <div id="recap1">

                            </div>
                            <div style="top: 20px;position: absolute;z-index: -1;" >
                                <input tabindex="-1" aria-label="Captcha validation" type="checkbox" aria-describedby="host-error-captcha" class="host-error-captcha">
                            </div>
                        </div>

                        <div class="c-box__col">
                            <div class="c-form-error error-form mb-0"></div>
                        </div>
                        <div class="event-form__buttons" style="position:relative">
                            <button type="button" class="event-form__submit hosting_submit">Submit</button>
                            <div class="last-element" style="color:black;width: 0;overflow: hidden;" tabindex="0">l</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="application/ld+json">
            {
            "@context": "http://schema.org",
            "@type": "LocalBusiness",
            "address": {
            "@type": "PostalAddress",
            "addressLocality": "{{ address.locality_short }}",
            "addressRegion": "{{ address.administrative_area_level_1 }}",
            "postalCode": "{{ address.postal_code }}",
            "streetAddress": "{{ address.street_number|default }} {{ address.route|default }}"
            },
            "description": "A superb collection of fine gifts and clothing to accent your stay in Mexico Beach.",
            "name": "Texas de Brazil",
            "telephone": "{{ entry.phoneNumbers[0] ? entry.phoneNumbers[0].number : '' }}",
            "image": "{{ entry.image.first.url }}",
            "priceRange": "$$$"
            }
        </script>
        <?php
        //get_template_part('_includes/table', 'finderpopup');
//require get_template_directory() . '/_includes/table-finderpopup.php';
        ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
<?php
if ($alternative_find_table)
    get_template_part('_includes/find-table-alternative-content');
?>
<script>

    $('.datepicker-wai .date').css('position', 'relative');
    $('.datepicker-wai .date > input')

            .attr({'placeholder': "Pick a Date", "required": "true", "style": 'color:#fff;padding:14px 23px;font-size:1.3rem;font-wight:400'})
            .after(" <span style='position:absolute;left:7px;top:11px' aria-hidden='true'>*</span>")

</script>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"></script>
<script>
    var widget;
    var onloadCallback = function () {
        widget = grecaptcha.render(document.getElementById('recap1'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });
        console.log('widget', widget);

    };
    console.log('onloadCallback', document.getElementById('recap1'));
    jQuery(document).ready(function ($) {
        $('.find-table-alt').click(function () {
            $('.find_table_text').removeClass('-disabled');
            $('body').addClass('modal-enabled');
        });
        $('.find_table_text_exit').click(function () {
            $('.find_table_text').addClass('-disabled');
            $('body').removeClass('modal-enabled');
        });

        $('.datepicker-wai .date > input').change(function () {
            console.log($(this).val())
            $(this).prev().css('padding-left', '22px').text($(this).val())
        })
        $('.eventdate-mobile').change(function () {
            $(this).prev().remove();
        })



        jQuery.noConflict();
        var verifyCallback = function (response) {
            console.log(response);
        };
        jQuery(document).on('click', '.hosting_submit', function (e) {
            response1 = grecaptcha.getResponse(0);
            if (response1.length === 0) {
                jQuery("#host_event").find(".error-form").html("<p id='host-error-captcha' class='errors'>reCAPTCHA is mandatory.</p>");
                jQuery("#host_event").find('.host-error-captcha').attr('aria-invalid', "true").focus();
                return false;
            } else {
                jQuery("#host_event").find('.host-error-captcha').removeAttr('aria-invalid');
                return doSumbitHosting();

            }
        });

        function doSumbitHosting() {
            var $ = jQuery;

            //e.preventDefault(); // avoid to execute the actual submit of the form.
            jQuery(".hosting_submit").attr("disabled", true);

            var form = jQuery("#host_event");
            var firstname = jQuery('#host_event').find('input[name="firstName"]');
            var lastName = jQuery('#host_event').find('input[name="lastName"]');
            var email = jQuery('#host_event').find('input[name="email"]');
            var phone = jQuery('#host_event').find('input[name="phone"]');
            var company = jQuery('#host_event').find('input[name="company"]');
            var natureofevent = form.find('.natureofevent');
            var selectedLocation = jQuery("#selectedLocation");
            var eventdate = form.find('input[name="event_date"]');
            var starttime = jQuery("#starttime");
            var endtime = jQuery("#endtime");
            var numberofguests = jQuery("#numberofguests");
            var comment = jQuery("#comments");
            var gdpr_consent_granted = jQuery("#gdpr_consent_granted");

            if (isNaN(numberofguests.val()) || numberofguests.val() < 15) {

                jQuery("#host_event .error-form").html("<p id='error-numberofguests' class='errors'>Number Of guests needs to be greater than 14.</p>");
                numberofguests.attr('aria-describedby', "error-numberofguests").attr('aria-invalid', "true").focus()
                jQuery(".hosting_submit").removeAttr("disabled", false);
                return false;

            }
//        let has_gdpr = false;//Concord,Fresno,Rancho Cucamonga,Irvine,Carlsbad,Oxnard
//        if (['15097', '8045', '15960', '4961', '8490', '10066'].includes(selectedLocation.val())) {
            has_gdpr = true;
            if (!gdpr_consent_granted.is(':checked')) {
                jQuery("#host_event .error-form").html("<p id='error-gdpr_consent_granted' class='errors'>Consent to data collection is required by GDPR.</p>");
                gdpr_consent_granted.attr('aria-describedby', "error-gdpr_consent_granted").attr('aria-invalid', "true").focus()
                jQuery(".hosting_submit").removeAttr("disabled", false);
                return false;

            }

            //}


            if (firstname.val() != "" && lastName.val() != "" && email.val() != "" && phone.val() != "" && natureofevent.val() != "" && selectedLocation.val() != "" && eventdate.val() != "" && starttime.val() != "" && endtime.val() != "" && comment.val() != "") {
                $(".error-form").html("");
                let payload = {action: 'hosting_event_form', first_name: firstname.val(), lastName: lastName.val(), client_email: email.val(), client_phone: phone.val(), company: company.val(),
                    nature_of_event: natureofevent.val(), selected_location: selectedLocation.val(), event_date: eventdate.val(), start_time: starttime.val(), end_time: endtime.val(), number_of_guests: numberofguests.val(),
                    comment: comment.val()};
                if (has_gdpr)
                    payload['gdpr_consent_granted'] = 1
                jQuery.ajax({

                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: payload, // serializes the form's elements.
                    success: function (data)
                    {
                        console.log(data);
                        var response = JSON.parse(data);
                        console.log(response.message + response.redirect);
                        if (response.message == "ok") {
                            window.location.replace(response.redirect);
                        }


                    }
                });
            } else {

                jQuery(".hosting_submit").removeAttr("disabled", false);

                if (firstname.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-firstname' class='errors'>Please Enter First name.</p>");
                    firstname.attr('aria-describedby', "error-firstname").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (lastName.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-lastName' class='errors'>Please Enter Last name.</p>");
                    lastName.attr('aria-describedby', "error-lastName").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (email.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-email' class='errors'>Please Enter Email.</p>");
                    email.attr('aria-describedby', "error-email").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (phone.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-phone' class='errors'>Please Enter Phone number.</p>");
                    phone.attr('aria-describedby', "error-phone").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (natureofevent.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-natureofevent' class='errors'>Please Enter Nature of event.</p>");
                    natureofevent.attr('aria-describedby', "error-natureofevent").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (selectedLocation.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-selectedLocation' class='errors'>Please Enter location.</p>");
                    selectedLocation.attr('aria-describedby', "error-selectedLocation").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (eventdate.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-eventdate' class='errors'>Please Select Date of the Event.</p>");
                    eventdate.attr('aria-describedby', "error-eventdate").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (starttime.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-starttime' class='errors'>Please Select event start time.</p>");
                    starttime.attr('aria-describedby', "error-starttime").attr('aria-invalid', "true").focus()
                    return false;
                }

                if (endtime.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-endtime' class='errors'>Please Select event end time.</p>");
                    endtime.attr('aria-describedby', "error-endtime").attr('aria-invalid', "true").focus()
                    return false;
                }

                if (comment.val() == "") {
                    jQuery("#host_event .error-form").html("<p id='error-comment' class='errors'>Please enter a comment.</p>");
                    comment.attr('aria-describedby', "error-comment").attr('aria-invalid', "true").focus()
                    return false;
                }


            }


        }






    });
</script>
<style>
    
    .location-info__main h2{
        color:white;
        text-transform: capitalize;
        text-align: center;
        margin-bottom: 25px;
    }
    .location-info__main p{
        text-align: center;
    }
    .location-info__main .event-form__input,.location-info__main .event-form__textarea,.location-info__main .event-form__field{
        background: #191919;

    }
    .unstyled select{}
    .event-form__input-wrapper, .unstyled {
        position: relative;

    }
    .event-form__input-wrapper > span, .unstyled > span{
        position: absolute;
        left: 5px;
        top: 9px;
        color: #fff;
        opacity: 1;
    }
    .unstyled > select{
        padding-left: 13px;
        color:#fff;
        font-weight: 400;
    }
    .unstyled > span{
        left: -2px;
        top: 6px;
    }

    .gdpr_consent_granted{
        margin-top: 5px;
    }
    #gdpr_consent_granted{
        margin-right: 5px;
    }

    .datepicker-wai .date > input{
        text-align: left;
    }

    eventdate-mobile::selection{
    }

    .datepicker-wai .date > input::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }
    .c-form-error{
        margin: 0;
    }
    .c-form-error p{
        padding: 10px;
        border:dotted thin red;
    }
</style>

