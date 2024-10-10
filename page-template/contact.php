<?php
/*
  Template Name:Contact
 */

//$d=get_field('happyfox_location_id', 368);
//var_dump($d);
get_header();
while (have_posts()) :the_post();
    ?>
    <div class="o-container c-page-header">
        <div class="o-grid o-grid-contact">
            <div class="o-col">
                <h1 class="t-heading-one u-contact-heading">Contact Us</h1>
                <div class="u-contact-content" data-ref="contactContent">
                    <?php the_content(); ?>
                </div>
                <div class="u-contact-item u-social-icons" data-ref="socialIcons">
                    <div class="u-contact-item__left">
                        <h3 class="t-heading-six">Follow Us</h3>
                    </div>
                    <div class="u-contact-item__right">
                        <a href="<?php the_field('facebook_link', 'options'); ?>" class="u-contact-social -facebook" aria-label="Go to texas de brazil Facebook Page"></a>
                        <a href="<?php the_field('twitter_link', 'options'); ?>" class="u-contact-social -twitter" aria-label="Go to texas de brazil Twitter Page"></a>
                        <a href="<?php the_field('instagram_link', 'options'); ?>" class="u-contact-social -instagram" aria-label="Go to texas de brazil Instagram Page"></a>
                        <a href="<?php the_field('pinterest', 'options'); ?>" class="u-contact-social -pinterest" aria-label="Go to texas de brazil Pinterest Page"></a>
                    </div>
                </div>
                <div class="u-contact-item">
                    <div class="u-contact-item__left">
                        <h3 class="t-heading-six">Customer Service</h3>
                    </div>
                    <div class="u-contact-item__right">
                            <!-- <span class="u-contact-phone" tel="<?php the_field('customer_service_phone', 'options'); ?>"><?php the_field('customer_service_phone', 'options'); ?></span> -->
                        <a href="mailto:<?php the_field('customer_service_email', 'options'); ?>" class="u-contact-email"><?php the_field('customer_service_email', 'options'); ?></a>
                    </div>
                </div>
            </div>
            <div class="o-col u-contact-form-wrapper">
                <form id="contact-from" method="POST" data-ref="contactForm" class="form-with-labels">


                    <div class="c-box u-contact-form">
                        <div class="fields-group">

                            <div class="tx-form-group tx-form-group-full">
                                <label for="title">Name</label>
                                <input type="text" id="title" name="title" placeholder="Name" class="c-box__input" required >
                                <span aria-hidden='true'>*</span>
                            </div>

                            <div class="tx-form-group tx-form-group-full">
                                <label for="email-address">Email</label>
                                <input type="email" id="email-address" name="email" placeholder="Enter Your Email" class="c-box__input" required>
                                <span aria-hidden='true'>*</span>
                            </div>


                            <div class="tx-form-group tx-form-group-full">
                                <label for="subject">Subject</label>
                                <div class="unstyled">
                                    <select name="subject" id="subject" aria-label="Subject" class="c-box__input" data-ignore="true" data-ref="subject" required> 
                                        <option value="" selected>Subject</option>
                                        <option value="Guest Feedback">Guest Feedback</option>
                                        <option value="To-Go Order">To-Go Order</option>
                                        <option value="Catering Order">Catering Order</option>
                                        <option value="Online Gift Card Order">Online Gift Card Order</option>
                                        <option value="Online Butcher Shop Order">Online Butcher Shop Order</option>

                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="tx-form-group tx-form-group-full location-visited-content element-content" style="display:none;">
                                <label for="locationvisted">Location Visited</label>
                                <div class="unstyled">
                                    <select name="locationVisited" id="locationvisted" aria-label="Location Visited" class="c-box__input js-is-hidden" data-ignore="true" data-ref="conditionalField" data-error="Please select a location.">
                                        <option selected value="">Location Visited</option>
                                        <?php
                                        $args = array(
                                            'post_type' => 'locations',
                                            'post_status' => 'publish',
                                            'posts_per_page' => -1,
                                            'order' => 'ASC',
                                            'orderby' => 'post_title'
                                        );
                                        $location = new WP_Query($args);
                                        $i = 0;
                                        if ($location->have_posts()) :
                                            ?>
                                            <?php
                                            while ($location->have_posts()) : $location->the_post();
                                                $international = [430, 126933, 428, 749, 415, 72841, 426, 433, 417, 72830, 424];
                                                ?>

                                                <option value="<?php echo get_the_ID(); ?>" class="<?php echo in_array(get_the_ID(), $international) ? 'international' : ''; ?>">
                                                    <?php echo get_the_title(); ?>
                                                </option>

                                                <?php
                                            endwhile;
                                        endif;
                                        wp_reset_postdata();
                                        ?>
                                    </select>
                                </div>
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="tx-form-group tx-form-group-full date-visited-content element-content" style="display:none;">
                                <label for="eventdate">Date Visited/Order date</label>
        <!--                            <input type="text" id="datevisited" name="fields[dateVisited]" placeholder="Date Visited MM/DD/YYYY" aria-label="Date Visited" class="c-box__input js-is-hidden datepicker" max="<?php echo date('Y-m-d'); ?>" data-ref="conditionalField">-->
                                <script>
                                    var date_picker_only_past_dates = true;
                                    //var format_date = 'd/m/y';
                                </script>                    
                                <?php
                                $placeholder = 'Date Visited/Order date';
                                $data_el = 'orderdate';
                                $input_id = 'eventdate';
                                require_once(get_template_directory() . '/_includes/datepicker_.php');
                                ?>
                                <script src="<?php echo get_template_directory_uri() . '/assets/js/datePickerAda.js?a=8' ?>"></script>
                                <link href="<?php echo get_template_directory_uri() . '/assets/css/datePickerAda.css?v=3' ?>" rel="stylesheet">
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="tx-form-group tx-form-group-full order-platform-content element-content" style="display:none;">
                                <label for="order-platform">Order Platform</label>
                                <div class="unstyled">
                                    <select id="order-platform" name="order-platform" class="c-box__input js-is-hidden" data-ignore="true" data-ref="conditionalField" data-error="Please select a order platform." required="">
                                        <option value="">Order Platform</option>
                                        <option value="Website">Website</option>
                                        <option value="UberEats">UberEats</option>
                                        <option value="DoorDash">DoorDash</option>
                                        <option value="in-store">in-store</option>
                                    </select>
                                </div>
                                <span aria-hidden='true'>*</span>
                            </div>

                            <div class="tx-form-group tx-form-group-full order-number-content element-content" style="display: none;">
                                <label for="order_number">Order number</label>
                                <input type="text" name="order_number" id="order_number" placeholder="Order number" aria-label="Order number" class="c-box__input">
                                <span style="display: none;" aria-hidden='true'>*</span>
                            </div>



                            <div class="tx-form-group tx-form-group-full help-content element-content" style="display:none;">
                                <input type="hidden" data-ref="otherSubject">
                                <input type="hidden" data-ref="conditionalField">
                                <label for="help_you">How can we help?</label>
                                <input type="text" name="help_you" id="help_you" placeholder="How can we help?" class="c-box__input" required>
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="tx-form-group tx-form-group-full" data-ref="body">
                                <label for="body">Body</label>
                                <textarea name="body" id="body" class="c-box__textarea" rows="10" style="resize: none;" data-ref="limitScroll" required maxlength="200"></textarea>
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="c-box__col">
                                <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
                                <div class="c-form-error recaptcha-error mb-0"></div>

                            </div>
                            <div class="c-box__col">
                                <div class="c-form-error error-form mb-0"></div>
                            </div>
                            <div class="c-box__col">
                                <button class="button u-contact-submit" type="button">Submit</button>

                            </div>
                            <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
<?php endwhile; ?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<?php get_footer(); ?>
<script type="text/javascript">

</script>
<script type="text/javascript">
    jQuery(".u-contact-submit").click(function (e) {
        $(this).attr('disabled', true);





        e.preventDefault(); // avoid to execute the actual submit of the form.

        response = grecaptcha.getResponse();
        if (response.length === 0) {
            jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
            $(this).attr('disabled', false);
            return false;
        } else {
            jQuery('.recaptcha-error').text('');
        }


        var form = jQuery('#contact-from');
        var firstname = form.find('input[name="title"]');
        var contact_email = form.find('input[name="email"]');
        var help_you = jQuery('#help_you');
        var subject = jQuery("#subject");
        var locationvisted = jQuery("#locationvisted");
        var body = jQuery("#body");
        var datevisited = jQuery('.datepicker-wai .date > input');
        var order_number = jQuery("#order_number");
        var order_platform = jQuery("#order-platform");
        var input_data = form.serialize();
        var error = false;
        $('input,select').attr('aria-invalid', "false");


        if (subject.val() == 'Other') {
            if (!help_you.val().length) {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-help_you' class='errors'>Please Enter Help.</p>");
                help_you.attr('aria-describedby', "error-help_you").attr('aria-invalid', "true").focus()
                error = true;
            }//Guest Feedback
        } else if (subject.val() == 'Guest Feedback') {
            if (!locationvisted.val().length || !datevisited.val().length) {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-locationvisted' class='errors'>Please Enter Location and Date.</p>");
                locationvisted.attr('aria-describedby', "error-locationvisted").attr('aria-invalid', "true").focus()
                error = true;
            }
        } else if (subject.val() == 'To-Go Order') {
            if (!locationvisted.val().length || !datevisited.val().length || !order_platform.val().length) {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-locationvisted' class='errors'>Please Enter Location, order platform and Date.</p>");
                locationvisted.attr('aria-describedby', "error-locationvisted").attr('aria-invalid', "true").focus()
                error = true;
            }
        } else if (subject.val() == 'Catering Order') {
            if (!locationvisted.val().length || !datevisited.val().length || !order_number.val().length) {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-locationvisted' class='errors'>Please Enter Location, order number and Date.</p>");
                locationvisted.attr('aria-describedby', "error-locationvisted").attr('aria-invalid', "true").focus()
                error = true;
            }
        }

        const bodyVal = body.val().trim();

        let errorDate = false;

        if (datevisited.val() != '') {
            if (!isValidDate(datevisited.val())) {
                error = true;
                errorDate = true;

            }

        }





        if (firstname.val() != "" && isValidEmail(contact_email.val()) && subject.val() != "" && bodyVal != "" && !error) {




            $(".error-form").html("");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: 'contact_form',
                    contact_name: firstname.val(),
                    contact_email: contact_email.val(),
                    help_you: help_you.val(),
                    contact_subject: subject.val(),
                    location_visited: locationvisted.val(),
                    body: body.val(),
                    date_visited: datevisited.val(),
                    order_number: order_number.val(),
                    order_platform: order_platform.val()
                },
                success: function (data)
                {
                    console.log(data);
                    var response = JSON.parse(data);
                    console.log(response.message + response.redirect);
                    if (response.message == "ok") {
                        form.find('input, select, textarea').each(function () {
                            console.log(this);
                            $(this).val('')
                        });

                        window.location = response.redirect;
                    }


                }
            });
        } else {
            $(this).attr('disabled', false);
            if (errorDate) {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-date' class='errors'>Enter a valid date.</p>");
                firstname.attr('aria-describedby', "error-date").attr('aria-invalid', "true").focus()
                return false;
            }
            if (firstname.val() == "") {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-firstname' class='errors'>Please Enter Name.</p>");
                firstname.attr('aria-describedby', "error-firstname").attr('aria-invalid', "true").focus()
                return false;
            }
            if (contact_email.val() == "") {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-email' class='errors'>Please Enter Email.</p>");
                contact_email.attr('aria-describedby', "error-email").attr('aria-invalid', "true").focus()
                return false;
            }
            if (subject.val() == "") {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-subject' class='errors'>Please Enter Subject.</p>");
                subject.attr('aria-describedby', "error-subject").attr('aria-invalid', "true").focus()
                return false;
            }
            if (body.val() == "") {
                jQuery(".error-form").html("<p role='alert' aria-live='polite' id='error-body' class='errors'>Please Enter INQUIRY.</p>");
                body.attr('aria-describedby', "error-body").attr('aria-invalid', "true").focus()
                return false;
            }


        }
    });

    function reveal_field(el) {
        console.log(el, el[0].nodeName, el[0].parentNode);
        setTimeout(function () {
            el.removeClass('js-is-hidden')
            el[0].required = true
            if (el[0].nodeName == 'SELECT') {
                el[0].parentNode.style.display = 'block'
                el.parent().show()
            }
        }, 500)

    }


    $('#subject').change(function () {
        console.log($(this).val());
        $('.element-content').hide();
        $('.international').show();
        $('#order_number').attr('required', false);
            $('.order-number-content').find('span').hide();


        if ($(this).val() == 'Guest Feedback')
            $('.location-visited-content,.date-visited-content').show();
            $('.datepicker-wai .date > input').attr('placeholder', 'Date Visited');
        if ($(this).val() == 'To-Go Order') {
            reveal_field($('select[name*="order-platform"]'))
            $('.datepicker-wai .date > input').attr('placeholder', 'Order date');
            $('.order-number-content,.order-platform-content,.location-visited-content,.date-visited-content').show();
            $('.international').hide();
        }
        if ($(this).val() == 'Catering Order') {
            $('.datepicker-wai .date > input').attr('placeholder', 'Order date');
            $('.order-number-content,.location-visited-content,.date-visited-content').show();
            $('#order_number').attr('required', 'required');
            $('.order-number-content').find('span').show();
            $('.international').hide();
        }
        if ($(this).val() == 'Online Gift Card Order')
            $('.order-number-content').show();
        if ($(this).val() == 'Online Butcher Shop Order')
            $('.order-number-content').show();
        if ($(this).val() == 'Other')
            $('.help-content').show();
        //

    });

</script>
<style>
    


</style>
