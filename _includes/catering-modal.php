<div class="event-modal -disabled" data-ref="eventModal" data-type="catering" role="dialog" aria-modal="true" aria-labelledby="Catering">
    <div class="event-modal__inner">
        <button class="event-modal__exit" aria-label="Exit" data-ref="eventModalExitButton"></button>
        <h2 class="event-modal__title">
            Catering
        </h2>
        <p>Each of our locations offers catering services for large groups. For more information, please call the restaurant directly. Or if you prefer, please complete the form below and one of our event managers will reach out to you within 24 hours.</p>
        <form method="POST" id="catering_form" class="event-form">
            <div class="event-form__fieldset">
                <h3 class="event-form__legend">Your contact details</h3>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="firstName" type="text" class="event-form__input" placeholder="First Name" required=""> <span aria-hidden='true'>*</span>
                    </div>
                </div>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="lastName" type="text" class="event-form__input" placeholder="Last Name" required=""> <span aria-hidden='true'>*</span>
                    </div>
                </div>
                <div class="event-form__field -full">
                    <div class="event-form__input-wrapper">
                        <input name="email" type="email" class="event-form__input" placeholder="Email Address" required=""> <span aria-hidden='true'>*</span>
                    </div>
                </div>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="phone" type="text" class="event-form__input" placeholder="Phone Number" required=""> <span aria-hidden='true'>*</span>
                    </div>
                </div>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="company" type="text" class="event-form__input company" placeholder="Company">
                    </div>
                </div>
            </div>
            <div class="event-form__fieldset">
                <h3 class="event-form__legend">Your event details</h3>
                <div class="event-form__field -full -select">
                    <div class="unstyled">


                        <select aria-label="Nature of this event" name="natureofevent"  class="event-form__select natureofevent" data-ref="select" data-ignore="true" required="">
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
                <div class="event-form__field -half -select">
                    <div class="unstyled">
                        <select aria-label="Select a location" name="selectedLocation" id="cateringLocation"class="event-form__select" data-ref="select" data-ignore="true" required="">
                            <option value="" class="event-form__option">Select a location</option>

                            <?php
                            $args = array(
                                'post_type' => 'locations',
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'order' => 'ASC',
                                'orderby' => 'title'
                            );
                            $location = new WP_Query($args);
                            $i = 0;
                            if ($location->have_posts()) :
                                ?>
                                <?php while ($location->have_posts()) : $location->the_post(); ?>
                                    <?php if (get_field('tripleseat_id')): ?>
                                        <option class="event-form__option" value="<?php echo get_field('tripleseat_id'); ?>"><?php echo get_the_title(); ?></option>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select> <span aria-hidden='true'>*</span>
                    </div>
                </div>
                <div class="event-form__field -half" style="min-height:43px;">
                    <div class="event-form__input-wrapper" style="overflow:visible;">

                        <?php if (isMobileDevice()) { ?> 
                                            <!--                            <input type="text" name="fields[eventDate][date]" class="event-form__input catering-eventdate-mobile" id="catering-date" placeholder="Pick a Date" required=""> <span aria-hidden='true'>*</span>-->
                            <div style="position: relative;">
                                <span aria-hidden="true" style="position: absolute;z-index: 9;left: 7px;top: 10px;">*</span>
                                <label for="eventdate" class="label-trigger-date" style="padding: 6px 16px 6px 16px;display: block;position: absolute;background: #191919;margin: 5px 0 0 5px;font-size:13px;">PICK A DATE</label>
                                <input type="date" name="event_date" class="event-form__input catering-eventdate-mobile" 
                                       
                                       id="catering-date" 
                                       min="<?php echo current_time('m/d/Y'); ?>" max="12-31-2030"
                                       placeholder="Pick a Date" required="">
                            </div>
                        <?php } else { ?>
    <!--                            <input type="text" name="fields[eventDate][date]" class="event-form__input datepicker" id="catering-date" placeholder="Pick a Date" readonly required=""> <span aria-hidden='true'>*</span>-->
                            <script>
                                var date_picker_only_future_dates = true;
                            </script>                      
                            <?php
                            $input_name = 'event_date';
                            $input_id = 'eventdate';
                            require('datepicker.php');
                            ?>

                        <?php } ?>
                    </div>
                </div>
                <div class="event-form__field -one-third -select">
                    <div class="unstyled">
                        <select aria-label="Start Time" name="starttime" id="catering_starttime" class="event-form__select" data-ref="select" data-ignore="true" required="">
                            <option value="" class="event-form__option">Start Time</option>
                            <?php get_template_part('template-parts/time', 'option'); ?>
                        </select> <span aria-hidden='true'>*</span>
                    </div>
                </div>
                <div class="event-form__field -one-third -select">
                    <div class="unstyled">
                        <select aria-label="End Time" name="endtime" id="catering_endtime" class="event-form__select" data-ref="select" data-ignore="true" required="">
                            <option value="" class="event-form__option">End Time</option>
                            <?php get_template_part('template-parts/time', 'option'); ?>
                        </select> <span aria-hidden='true'>*</span>
                    </div>
                </div>
                <div class="event-form__field -one-third">
                    <div class="event-form__input-wrapper">
                        <input name="numberofguests"  placeholder="Number of Guests" type="number" class="event-form__input" id="ca_numberofguests" required=""> <span aria-hidden='true'>*</span>
                    </div>

                </div>
                <div class="event-form__field -full">
                    <textarea name="comments" id="c_comments" class="event-form__textarea" placeholder="Additional Comments"></textarea>
                </div>
                <div class="gdpr_consent_granted">
                    <input name="gdpr_consent_granted" id="ca_gdpr_consent_granted" type="checkbox" >
                    <label for="ca_gdpr_consent_granted">* Consent to data collection as required by GDPR</label>

                </div>
            </div>
            <div class="c-box__col mb-3" style="position: relative;display: block;">
                <div id="recap2">

                </div>
                <div style="top: 20px;position: absolute;z-index: -1;" >
                    <input tabindex="-1" aria-label="Captcha validation" type="checkbox" aria-describedby="cat-error-captcha" class="cat-error-captcha">
                </div>
            </div>

            <div class="c-box__col">
                <div class="c-form-error error-form mb-0"></div>
            </div>
            <div class="event-form__buttons">
                <button class="event-form__submit catering_submit">Submit</button>
                <div class="last-element" style="color:black;width: 0;overflow: hidden;" tabindex="0">l</div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">


    jQuery(document).ready(function ($) {

        var form = jQuery("#catering_form");
//        jQuery("#cateringLocation").change(function () {
//            if (['15097', '8045', '15960', '4961', '8490', '10066'].includes(jQuery(this).val())) {
//                form.find('.gdpr_consent_granted').show();
//
//            } else {
//                form.find('.gdpr_consent_granted').hide();
//            }
//        });

        $('.catering-eventdate-mobile').focus(function () {
            $(this).attr('type', 'date').off('focus');
            document.getElementById('catering-date').showPicker()

        });


    });

    function doSumbitCattering() {
        var $ = jQuery;

        //e.preventDefault(); // avoid to execute the actual submit of the form.
        jQuery(".catering_submit").attr("disabled", true);

        var form = jQuery("#catering_form");
        var firstname = form.find('input[name="firstName"]');
        var lastName = form.find('input[name="lastName"]');
        var email = form.find('input[name="email"]');
        var phone = form.find('input[name="phone"]');
        var company = form.find('.company');
        var natureofevent = form.find('.natureofevent');
        var selectedLocation = jQuery("#cateringLocation");
        var eventdate = form.find('input[name="event_date"]');
        var starttime = jQuery("#catering_starttime");
        var endtime = jQuery("#catering_endtime");
        var numberofguests = jQuery("#ca_numberofguests");
        var comment = jQuery("#c_comments");
        var gdpr_consent_granted = jQuery("#ca_gdpr_consent_granted");

        console.log(eventdate + "event date");
        var error_no_of_guests = isNaN(numberofguests.val()) || numberofguests.val() < 1;

//        let has_gdpr = false;//Concord,Fresno,Rancho Cucamonga,Irvine,Carlsbad,Oxnard
//        if (['15097', '8045', '15960', '4961', '8490', '10066'].includes(selectedLocation.val())) {
        has_gdpr = true;
        if (!gdpr_consent_granted.is(':checked')) {
            form.find(".error-form").html("<p id='error-gdpr_consent_granted' class='errors'>Consent to data collection is required by GDPR.</p>");
            gdpr_consent_granted.attr('aria-describedby', "error-gdpr_consent_granted").attr('aria-invalid', "true").focus()
            jQuery(".catering_submit").removeAttr("disabled", false);
            return false;
        }
        //}





        if (!error_no_of_guests && firstname.val() != "" && lastName.val() != "" && email.val() != "" && phone.val() != "" && natureofevent.val() != "" && selectedLocation.val() != "" && eventdate.val() != "" && starttime.val() != "" && endtime.val() != "") {
            $(".error-form").html("");


            let payload = {action: 'catering_event_form', first_name: firstname.val(), lastName: lastName.val(), client_email: email.val(), client_phone: phone.val(), company: company.val(), nature_of_event: natureofevent.val(),
                selected_location: selectedLocation.val(), event_date: eventdate.val(), start_time: starttime.val(), end_time: endtime.val(), number_of_guests: numberofguests.val(), comment: comment.val()}
            if (has_gdpr)
                payload['gdpr_consent_granted'] = 1

//            console.log(payload);
//            return;

            jQuery.ajax({

                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: payload, // serializes the form's elements.
                async: false,
                success: function (data)
                {
                    console.log(data);
                    var response = JSON.parse(data);
                    console.log(response.message + response.redirect);
                    if (response.message == "ok") {
                        window.location = response.redirect;
                    }


                }
            });
        } else {

            jQuery(".catering_submit").attr("disabled", false);


            if (firstname.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-firstname' class='errors'>Please Enter First name.</p>");
                firstname.attr('aria-describedby', "error-firstname").attr('aria-invalid', "true").focus()
                return false;
            }
            if (lastName.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-lastName' class='errors'>Please Enter Last name.</p>");
                lastName.attr('aria-describedby', "error-lastName").attr('aria-invalid', "true").focus()
                return false;
            }
            if (email.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-email' class='errors'>Please Enter Email.</p>");
                email.attr('aria-describedby', "error-email").attr('aria-invalid', "true").focus()
                return false;
            }
            if (phone.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-phone' class='errors'>Please Enter Phone number.</p>");
                phone.attr('aria-describedby', "error-phone").attr('aria-invalid', "true").focus()
                return false;
            }
            if (natureofevent.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-natureofevent' class='errors'>Please Enter Nature of event.</p>");
                natureofevent.attr('aria-describedby', "error-natureofevent").attr('aria-invalid', "true").focus()
                return false;
            }
            if (selectedLocation.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-selectedLocation' class='errors'>Please Enter location.</p>");
                selectedLocation.attr('aria-describedby', "error-selectedLocation").attr('aria-invalid', "true").focus()
                return false;
            }
            if (eventdate.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-eventdate' class='errors'>Please Select Date of the Event.</p>");
                eventdate.attr('aria-describedby', "error-eventdate").attr('aria-invalid', "true").focus()
                return false;
            }
            if (starttime.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-starttime' class='errors'>Please Select event start time.</p>");
                starttime.attr('aria-describedby', "error-starttime").attr('aria-invalid', "true").focus()
                return false;
            }

            if (endtime.val() == "") {
                jQuery("#catering_form .error-form").html("<p id='error-endtime' class='errors'>Please Select event end time.</p>");
                endtime.attr('aria-describedby', "error-endtime").attr('aria-invalid', "true").focus()
                return false;
            }

            if (isNaN(numberofguests.val()) || numberofguests.val() < 15) {
                jQuery("#catering_form .error-form").html("<p id='error-numberofguests' class='errors'>Number Of guests field is required.</p>");
                numberofguests.attr('aria-describedby', "error-numberofguests").attr('aria-invalid', "true").focus()
                jQuery(".catering_submit").removeAttr("disabled", false);
                return false;

            }

        }


    }

</script>
<style>


</style>
