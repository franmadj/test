<div class="event-modal -disabled" data-ref="eventModal" data-type="hosting" role="dialog" aria-modal="true" aria-labelledby="Host an Event">
    <div class="event-modal__inner">
        <button class="event-modal__exit" aria-label="Exit" data-ref="eventModalExitButton"></button>
        <h2 class="event-modal__title">
            Host an Event
        </h2>
        <p>Many of our locations offer private or semi-private dining options, typically for groups of 15 or more. Some of our private dining options have different group minimums. For more information about private or semi-private dining options at the Texas de Brazil location closest to you, please call the restaurant directly. Or if you prefer, please complete the form below, and one of our managers will reach out to you within 24 hours.</p>
        <form id="host_event" method="POST" class="event-form form-with-labels">
            <input type="hidden" name="redirect" value="thanks">
            <div class="event-form__fieldset">
                <h3 class="event-form__legend">Your contact details</h3>

                <div class="fields-group">
                    <div class="tx-form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" aria-label="Enter First Name" class="c-box__input" required >
                        <span aria-hidden='true'>*</span>
                    </div>
                    <div class="tx-form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" aria-label="Enter Last Name" class="c-box__input" required >
                        <span aria-hidden='true'>*</span>
                    </div>
                    <div class="tx-form-group tx-form-group-full">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Your Email" class="c-box__input" required>
                        <span aria-hidden='true'>*</span>
                    </div>

                    <div class="tx-form-group">
                        <label for="phone">Mobile Phone</label>
                        <input type="text" name="phone" id="phone" placeholder="Phone Number 999-999-9999" aria-label="Phone" class="c-box__input"  aria-describedby="error-phone">
                        <span aria-hidden='true'>*</span>
                    </div>

                    <div class="tx-form-group">
                        <label for="company">Company / Organization</label>
                        <input type="text" id="company" name="company" class="c-box__input" placeholder="Company / Organization">
                    </div>

                </div>
            </div>
            <div class="event-form__fieldset">
                <h3 class="event-form__legend">Your event details</h3>
                <div class="fields-group">

                    <div class="tx-form-group">

                        <label for="natureofevent">Nature of This Event</label>
                        
                            <select name="natureofevent" id="natureofevent" class="event-form__select natureofevent" data-ref="select" required="">
                                <option value="" class="event-form__option">Nature of This Event</option>
                                <?php
                                $events = array(
                                    'Birthday', 'Cocktail Reception', 'Corporate/Business', 'Graduation', 'Holiday Party', 'Rehearsal Dinner', 'Social/Family', 'Wedding'
                                );
                                ?>
                                <?php foreach ($events as $event) : ?>
                                    <option class="event-form__option" value="<?php echo $event; ?>"><?php echo $event; ?></option>
                                <?php endforeach; ?>
                            </select>
                        
                        <span aria-hidden='true'>*</span>
                    </div>
                    
                    <div class="tx-form-group">
                        <label for="selectedLocation">Select a location</label>
                        
                            <select name="selectedLocation" id="selectedLocation" class="event-form__select" data-ref="select" required="">
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
                                            <?php
                                            if (8051 == get_field('tripleseat_id'))
                                                echo '<option class="event-form__option" value="27800">Hawaii</option>';
                                        endif;
                                        ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select> 
                        
                        <span aria-hidden='true'>*</span>
                    </div>
                    
                    <div class="tx-form-group">
                        <label for="eventdate">PICK A DATE</label>
                        <div class="event-form__input-wrapper" style="overflow:visible;">
                            <?php if (isMobileDevice()) { ?> 
                                <div style="position: relative;">
                                    
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
                                $date_classes = 'no-default';
                                require_once('datepicker.php');
                                ?>

                            <?php } ?>
                        </div>
                        <span aria-hidden='true'>*</span>
                    </div>
                    
                    <div class="tx-form-group">
                        <label for="numberofguests">Number of Guests</label>
                        <input name="numberofguests" id="numberofguests" placeholder="Number of Guests" type="number" class="c-box__input" min="14" required=""> 
                        <span aria-hidden='true'>*</span>
                    </div>



                    <div class="tx-form-group">
                        <label for="starttime">Start Time</label>
                        
                            <select name="starttime" id="starttime" class="event-form__select" data-ref="select" required=""> 
                                <option value="" class="event-form__option">Start Time</option>
                                <?php get_template_part('template-parts/time', 'option'); ?>
                            </select> 
                        
                        <span aria-hidden='true'>*</span>
                    </div>
                    
                    
                    <div class="tx-form-group">
                        <label for="endtime">End Time</label>
                       
                            <select name="endtime" id="endtime"  class="event-form__select" data-ref="select" required="">
                                <option value="" class="event-form__option">End Time</option>
                                <?php get_template_part('template-parts/time', 'option'); ?>
                            </select> 
                      
                        <span aria-hidden='true'>*</span>
                    </div>
                    
                    
                    
                    <div class="tx-form-group tx-form-group-full">
                        <label for="comments">Additional Comments</label>
                        <textarea name="comments" id="comments" class="c-box__input" placeholder="Additional Comments" required=""></textarea>
                        <span aria-hidden='true'>*</span>
                    </div>
                    
                    
                </div>




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

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.datepicker-wai .date > input').change(function () {
            console.log($(this).val())
            $(this).prev().css('padding-left', '22px').text($(this).val())
        })
//        jQuery("#selectedLocation").change(function ($) {
//            var form = jQuery("#host_event");
//
//            console.log(['15097', '8045', '15960', '4961', '8490', '10066'].includes(jQuery(this).val()));
//
//
//            if (['15097', '8045', '15960', '4961', '8490', '10066'].includes(jQuery(this).val())) {
//                form.find('.gdpr_consent_granted').show();
//
//            } else {
//                form.find('.gdpr_consent_granted').hide();
//            }
//
//        });
//        $('.eventdate-mobile').focus(function () {
//            $(this).attr('type', 'date').off('focus');
//            document.getElementById('eventdate').showPicker()
//
//        });
        $('.eventdate-mobile,.catering-eventdate-mobile').change(function () {
            $(this).prev().remove();
        })
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

</script>
<style>
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
