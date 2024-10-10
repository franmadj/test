<?php
/*
  Template Name:Leasing & Expansions
 */
get_header();
while (have_posts()) :the_post();
    if (has_post_thumbnail($post->ID)):
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
        $hero_image = $image[0];
    else:
        $hero_image = home_url() . '/assets/img/about/about-bg.png';
    endif;
    if (get_field('leasing_expansions_bg_mobile')):
        $mobile_hero_image = get_field('leasing_expansions_bg_mobile');
    else:
        $mobile_hero_image = $hero_image;
    endif;
    ?>
    <div class="leasing">
        <div class="hero leasing-hero" style="background-image: url(<?php echo $hero_image; ?>);" data-ref="responsiveVisualElement" data-mobile="<?php echo $mobile_hero_image; ?>" data-desktop="<?php echo $hero_image; ?>">
            <div class="leasing-content">
                <div class="leasing-overlay">
                    <h1><?php the_field('leasing_expansions_title'); ?></h1>
                    <h2><?php the_field('leasing_expansions_subtitle'); ?></h2>

                    <div class="leasing-cols-frame">
                        <div class="leasing-cols leasing-desc">
                            <?php the_field('leasing_expansions_column_1'); ?>
                        </div>
                        <div class="leasing-cols leasing-qualifications">
                            <h3><?php the_field('leasing_expansions_column_2_title'); ?></h3>
                            <div class="leasing-qualifications-desc"><?php the_field('leasing_expansions_column_2'); ?></div>
                        </div>
                    </div>
                    <form id="leasingForm" method="POST" data-ref="leasingForm" class="form-with-labels">

                        <div class="c-box">
                            <div class="fields-group">
                                <div class="tx-form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" aria-label="Enter First Name" class="c-box__input" required >
                                    <span aria-hidden='true'>*</span>
                                </div>
                                <div class="tx-form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" aria-label="Enter Last Name" class="c-box__input" required >
                                    <span aria-hidden='true'>*</span>
                                </div>

                                <div class="tx-form-group tx-form-group-full">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" placeholder="Enter Your Email" class="c-box__input" required>
                                    <span aria-hidden='true'>*</span>
                                </div>

                                <div class="tx-form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" placeholder="Phone Number 999-999-9999" aria-label="Phone" class="c-box__input"  aria-describedby="error-phone">
                                    <span aria-hidden='true'>*</span>
                                </div>
                                <div class="tx-form-group">
                                    <label for="company">Company</label>
                                    <input type="text" id="company" name="company" class="c-box__input" placeholder="Company">
                                </div>
                                <div class="tx-form-group tx-form-group-full">
                                    <label for="comments">Inquiry</label>
                                    <textarea name="inquiry" id="inquiry" class="c-box__input" placeholder="Your Inquiry" required=""></textarea>
                                    <span aria-hidden='true'>*</span>
                                </div>




                               
                                
                            </div>
                            <div class="c-box__col">
                                <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
                                <div style="top: 20px;position: absolute;z-index: -1;" >
                                    <input tabindex="-1" aria-label="Captcha validation" type="checkbox" aria-describedby="host-error-captcha" class="host-error-captcha">
                                </div>
                            </div>

                            <div class="c-box__col">
                                <div class="c-form-error error-form mb-0"></div>
                            </div>
                        </div>
                        <button class="button leasing-submit" type="button">Submit</button>
                        <strong class="success-msg hidden" role="alert" aria-live="polite">Your submission has been successfully sent!<br><br></strong>


                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
<style>
    .leasing-overlay h1{
        margin-bottom: 2rem;
    }
    .leasing-overlay h2 {
        color: #8c908e;
        font-family: Oswald;
        font-size: 2rem;
        font-weight: 300;
        letter-spacing: .1rem;
        line-height: 3rem;
        margin: 0;
        text-transform: uppercase;
        display: block;
        text-align: center;
        margin-bottom: 3rem;
    }
    @media (max-width: 743px){
        .leasing-overlay h1 {
            margin-top: 63px;
        }
    }
    .leasing-overlay h3 {
        color: #8c908e;
        font-family: Oswald;
        font-size: 1.3rem;
        letter-spacing: .1rem;
        line-height: 2rem;
        margin: 0 0 2.1rem;
    }
</style>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">

    jQuery(document).ready(function ($) {
        jQuery.noConflict();

        jQuery('.leasing-submit').click(function () {
            response = grecaptcha.getResponse();

            if (response.length === 0) {

                jQuery(".error-form").html("<p id='host-error-captcha' class='errors'>reCAPTCHA is mandatory.</p>");
                jQuery('.host-error-captcha').attr('aria-invalid', "true").focus();
                return false;
            } else {
                jQuery(".error-form").text('');
            }
        });
        jQuery(document).on('click', '.leasing-submit', function (e) {
            e.preventDefault();
            var form = jQuery("#leasingForm");
            var firstname = jQuery('#leasingForm').find('input[name="first_name"]');
            var lastName = jQuery('#leasingForm').find('input[name="last_name"]');
            var email = jQuery('#leasingForm').find('input[name="email"]');
            var phone = jQuery('#leasingForm').find('input[name="phone"]');
            var company = jQuery('#leasingForm').find('input[name="company"]');
            var comment = jQuery("#inquiry");
            $('input,select').attr('aria-invalid', "false");

            if (firstname.val() != "" && lastName.val() != "" && email.val() != "" && phone.val() != "" && company.val() != "") {

                $(".error-form").html("");

                jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {action: 'leasing_expansions', first_name: firstname.val(), last_name: lastName.val(), email: email.val(), phone: phone.val(), company: company.val(), content: comment.val()},

                    success: function (data) {

                        var response = JSON.parse(data);
                        console.log(response.message + response.redirect);
                        jQuery(".success-msg").removeClass('hidden');
                        if (response.message == "ok") {
                            form.find('input, select, textarea').each(function () {

                                $(this).val('')
                            });
                            window.location = response.redirect;
                        }
                    }
                });

            } else {



                if (firstname.val() == "") {
                    jQuery("#leasingForm .error-form").html("<p role='alert' aria-live='polite' id='error-firstname' class='errors'>Please Enter First name.</p>");
                    firstname.attr('aria-describedby', "error-firstname").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (lastName.val() == "") {
                    jQuery("#leasingForm .error-form").html("<p role='alert' aria-live='polite' id='error-lastName' class='errors'>Please Enter Last name.</p>");
                    lastName.attr('aria-describedby', "error-lastName").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (email.val() == "") {
                    jQuery("#leasingForm .error-form").html("<p role='alert' aria-live='polite' id='error-email' class='errors'>Please Enter Email.</p>");
                    email.attr('aria-describedby', "error-email").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (phone.val() == "") {
                    jQuery("#leasingForm .error-form").html("<p role='alert' aria-live='polite' id='error-phone' class='errors'>Please Enter Phone number.</p>");
                    phone.attr('aria-describedby', "error-phone").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (company.val() == "") {
                    jQuery("#leasingForm .error-form").html("<p role='alert' aria-live='polite' id='error-company' class='errors'>Please Enter Company.</p>");
                    natureofevent.attr('aria-describedby', "error-company").attr('aria-invalid', "true").focus()
                    return false;
                }
                if (comment.val() == "") {
                    jQuery("#leasingForm .error-form").html("<p role='alert' aria-live='polite' id='error-inquiry' class='errors'>Please Enter Inquiry.</p>");
                    selectedLocation.attr('aria-describedby', "error-inquiry").attr('aria-invalid', "true").focus()
                    return false;
                }

            }


        });
    });
</script>
