<?php
/*
  Template Name:Contact
 */
get_header();
while (have_posts()) :the_post();
    ?>
    <div class="o-container">
        <div class="o-grid">
            <div class="o-col">
                <h1 class="t-heading-one u-contact-heading">Contact Us</h1>
                <div class="u-contact-content" data-ref="contactContent">
    <?php the_content(); ?>
                </div>
                <div class="u-contact-item u-social-icons" data-ref="socialIcons">
                    <div class="u-contact-item__left">
                        <span class="t-heading-six">Follow Us</span>
                    </div>
                    <div class="u-contact-item__right">
                        <a href="<?php the_field('facebook_link', 'options'); ?>" class="u-contact-social -facebook" aria-label="Facebook"></a>
                        <a href="<?php the_field('twitter_link', 'options'); ?>" class="u-contact-social -twitter" aria-label="Twitter"></a>
                        <a href="<?php the_field('twitter_link', 'options'); ?>" class="u-contact-social -instagram" aria-label="Instagram"></a>
                        <a href="<?php the_field('pinterest', 'options'); ?>" class="u-contact-social -pinterest" aria-label="Pinterest"></a>
                    </div>
                </div>
                <div class="u-contact-item">
                    <div class="u-contact-item__left">
                        <span class="t-heading-six">Customer Service</span>
                    </div>
                    <div class="u-contact-item__right">
                        <span class="u-contact-phone" tel="<?php the_field('customer_service_phone', 'options'); ?>"><?php the_field('customer_service_phone', 'options'); ?></span>
                        <a href="mailto:<?php the_field('customer_service_email', 'options'); ?>" class="u-contact-email"><?php the_field('customer_service_email', 'options'); ?></a>
                    </div>
                </div>
            </div>
            <div class="o-col u-contact-form-wrapper">
                <form id="contact-from" method="POST" data-ref="contactForm">


                    <div class="c-box u-contact-form">
                        <div class="c-box__col">
                            <input type="text" name="title" placeholder="Name*" aria-label="Name" class="c-box__input" required>
                        </div>
                        <div class="c-box__col">
                            <input type="email" name="email" placeholder="Your Email*" aria-label="Email" class="c-box__input" required>
                        </div>
                        <div class="c-box__col">
                            <div class="unstyled">
                                <select name="subject" id="subject" aria-label="Subject" class="c-box__input" data-ignore="true" data-ref="subject" required>
                                    <option disabled selected>Subject</option>
                                    <option>Guest Feedback</option>
                                    <option>Gift Card Support</option>
                                    <option>Media Inquiry</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="c-box__col">
                            <div class="unstyled">
                                <select name="locationVisited" id="locationvisted" aria-label="Location Visited" class="c-box__input js-is-hidden" data-ignore="true" data-ref="conditionalField" data-error="Please select a location.">
                                    <option disabled selected>Location Visited</option>
                                    <?php
                                    $args = array(
                                        'post_type' => 'location',
                                        'post_status' => 'publish',
                                        'posts_per_page' => -1,
                                        'order' => 'ASC',
                                        'orderby' => 'date'
                                    );
                                    $location = new WP_Query($args);
                                    $i = 0;
                                    if ($location->have_posts()) :
                                        ?>
                                            <?php while ($location->have_posts()) : $location->the_post(); ?>

                                            <option value="<?php echo get_the_ID(); ?>">
                                            <?php echo get_the_title(); ?>
                                            </option>

        <?php endwhile;
    endif;
    wp_reset_postdata();
    ?>
                                </select>
                            </div>
                        </div>
                        <div class="c-box__col">
                            <input type="text" id="datevisited" name="fields[dateVisited]" placeholder="Date Visited MM/DD/YYYY" aria-label="Date Visited" class="c-box__input js-is-hidden datepicker" max="<?php echo date('Y-m-d'); ?>" data-ref="conditionalField">

                        </div>
                        <div class="c-box__col" data-ref="otherSubject">
                            <input type="text" name="subject" placeholder="How can we help?" aria-label="How can we help?" class="c-box__input js-is-hidden" data-ref="conditionalField" required>
                        </div>
                        <div class="c-box__col" data-ref="body">
                            <textarea name="body" id="body" aria-label="Body" class="c-box__textarea" rows="10" style="resize: none;" data-ref="limitScroll" required></textarea>
                        </div>
                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" data-sitekey="6LcnlqEUAAAAAI2gOBufXKF1IBQ1Bcqh8jOzjNte"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <button class="button u-contact-submit">Submit</button>

                        </div>
                        <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                    </div>
                </form>
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

        e.preventDefault(); // avoid to execute the actual submit of the form.



        response = grecaptcha.getResponse();
        //alert(response);
        if (response.length === 0) {
            jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
            return false;
        } else {
            jQuery('.recaptcha-error').text('');
        }



        var firstname = jQuery('#contact-from').find('input[name="title"]').val();

        var contact_email = jQuery('#contact-from').find('input[name="email"]').val();
        var help_you = jQuery('#contact-from').find('input[name="subject"]').val();
        var subject = jQuery("#subject").val();
        var locationvisted = jQuery("#locationvisted").val();
        var body = jQuery("#body").val();
        var datevisited = jQuery("#datevisited").val();

        var input_data = jQuery('#contact-from').serialize();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {action: 'contact_form', contact_name: firstname, contact_email: contact_email, help_you: help_you, contact_subject: subject, locationvisted: locationvisted, body: body, date_visited: datevisited},
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

    });

</script>
