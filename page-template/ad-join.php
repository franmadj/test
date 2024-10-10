<?php
/*
  Template Name:Ad join
 */
get_header();
?>
<?php while (have_posts()) :the_post(); ?>
    <div class="c-page-header">
        <h1 class="c-page-header__heading">Join Our eClub for Exclusive Deals</h1>
    </div>
    <div class="u-highlights eclub-icons-frame tx-desktop-view">
        <div class="u-highlights__item">
            <img src="/assets/img/discount.svg" class="u-highlights__image" alt="Discount icon">
            <span class="t-heading-six u-highlights__text">$20.00 Discount</span>
        </div>
        <div class="u-highlights__item">
            <img src="/assets/img/date.svg" class="u-highlights__image" alt="Calendar icon">
            <span class="t-heading-six u-highlights__text">Birthday &amp; Anniversary Offers</span>
        </div>
        <div class="u-highlights__item">
            <img src="/assets/img/offers.svg" class="u-highlights__image" alt="Offers icon">
            <span class="t-heading-six u-highlights__text">Exclusive Promotions</span>
        </div>
    </div>

    <div class="o-container">
        <div class="o-grid u-eclub-wrapper">
            <div class="o-col" data-el="target-o-col-first">
                <div class="c-box u-eclub-form">
                    <form  id="u-eclub-submit1" action="https://TexasdeBrazil.fbmta.com/members/subscribe.aspx" method="post">
<span class="help-required-fields">Required fields *</span>
                        <input type="hidden" name="Action" id="Action" value="subscribe">
                        <input type="hidden" name="_InputSource_" value="ad-join">
                        <input type="hidden" name="ListID" value="23622320156">
                        <input type="hidden" name="SiteGUID" value="4E1BF72E-AE6F-45FA-A257-C55651B6770A">
                        <input type="hidden" name="SuppressConfirmation" value="yes">
                        <input type="hidden" name="ReturnURL" value="https://texasdebrazil.com/thanks?from=eclub">
                        <div class="c-box__col">
                            <input type="email" name="EmailAddress" placeholder="Your Email" aria-label="Email" class="c-box__input your-email" required tabindex="1">
                             <span aria-hidden='true'>*</span>
                        </div>
                        <div class="c-box__col">
                                <input type="email" name="EmailAddressConfirm" placeholder="confirm Your Email" aria-label="Email" class="c-box__input your-email-confirmation" required autocomplete="nope">
                                <span aria-hidden='true'>*</span>
                            </div>
                        <div class="c-box__col">
                            <input type="text" name="MobilePhone" id="phone-number" placeholder="Phone Number 999-999-9999" aria-label="Phone" class="c-box__input PhoneNumber"  tabindex="2" aria-describedby="error-phone">
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="FirstName" placeholder="First Name" aria-label="First Name" class="c-box__input" required tabindex="3">
                            <span aria-hidden='true'>*</span>

                        </div>
                        <div class="c-box__col">

                            <input type="text" name="LastName" placeholder="Last Name" aria-label="Last Name" class="c-box__input" required tabindex="4">
                            <span aria-hidden='true'>*</span>
                        </div>

                        <div class="c-box__col">
                            <input type="input" name="Birthdate" aria-label="Birthdate" id="birthday" tabindex="5" class="c-box__input u-date-input date-formatted" 
                                   required placeholder="Birthdate  <?php echo date('m/d/Y'); ?>">
                            <span aria-hidden='true'>*</span>
                        </div>
                        <div class="c-box__col">
                            <input type="input" name="Anniversary" aria-label="Anniversary" tabindex="6" id="anniversary" class="c-box__input u-date-input date-formatted" 
                                    placeholder="Anniversary <?php echo date('m/d/Y'); ?>">
                        </div>
                        <div class="c-box__col">
                            <div class="unstyled">
                                <select id="location" name="StoreCode" data-ignore="true" aria-label="Favorite Location" required tabindex="7" aria-describedby="error-location">
                                    <option value="" selected>Favorite Location</option>
                                    <?php
                                    $args = array(
                                        'post_type' => 'locations',
                                        'post_status' => 'publish',
                                        'posts_per_page' => -1,
                                        'order' => 'ASC',
                                        'orderby' => 'title',
                                        'meta_query' => array(
                                            array(
                                                'key' => 'fishbowl_id',
                                                'value' => '',
                                                'compare' => '!='
                                            ),
                                        ),
                                    );
                                    $location = new WP_Query($args);
                                    $i = 0;
                                    if ($location->have_posts()) :
                                        ?>
                                        <?php while ($location->have_posts()) : $location->the_post(); ?>

                                            <option value="<?php the_field('fishbowl_id'); ?>"><?php echo get_the_title(); ?></option>
                                            <?php
                                        endwhile;
                                    endif;
                                    wp_reset_postdata();
                                    ?>
                                </select>
                                
                            </div>
                            <span aria-hidden='true'>*</span>
                            
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="Zip" id="zip" placeholder="Zip Code" aria-describedby="error-zip" aria-label="Zip Code" class="c-box__input zip-code-input" tabindex="7" required>
                            <span aria-hidden='true'>*</span>
                        </div>

                        <div class="u-form-check">
                            <span aria-hidden='true'>*</span>
                            <input type="checkbox" name="acceptedConditions" aria-describedby="error-conditions" 
                                   aria-label="By checking this box, you agree to receive promotional emails and other marketing materials from Texas de Brazil. The information that is requested will not be sold or shared with a third party; it is for Texas de Brazil marketing purposes ONLY. If you wish to unsubscribe, Texas de Brazil provides an easy one-click method to be removed from the distribution list." id="conditions" name="conditions" class="u-form-check__input" data-ref="conditionsChecked" tabindex="8">


                            <label for="conditions" class="u-form-check__label u-conditions-text">By checking this box, you agree to receive promotional emails and other marketing materials from Texas de Brazil. The information that is requested will not be sold or shared with a third party; it is for Texas de Brazil marketing purposes ONLY. If you wish to unsubscribe, Texas de Brazil provides an easy one-click method to be removed from the distribution list.</label>
                        </div>

                        <div class="c-box__col" style="position: relative;display: block;">
                            <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
                            <!--                            <div class="c-form-error recaptcha-error mb-0" id="recaptcha-error"></div>-->

                            <div style="top: 20px;position: absolute;z-index: -1;" >
                                <label for="recaptcha_validation">Captcha validation</label>
                                <input aria-label="Captcha validation" type="checkbox" aria-describedby="error-captcha" id="recaptcha_validation">
                            </div>

                        </div>

                        <div class="u-errors" data-ref="generalErrors"></div>
                        <button type="submit" class="button u-eclub-submit" id="u-eclub-submit" tabindex="9">Submit</button>
                    </form>
                </div>
            </div>
            <div class="o-col" data-el="target-o-col-second">
                <h2><?php the_field('lead',56981); ?></h2>
                <div class="u-eclub-content">
                    <?php the_field('main_content',56981); ?>
                    <p><a class="truevault-polaris-privacy-notice" data-ignore="1" href="https://privacy.texasdebrazil.com/privacy-policy#financial-incentive" noreferrer noopener hidden>Notice of Financial Incentive</a></p>
                </div>
                <div class="u-highlights eclub-icons-frame tx-mobile-view" data-ref="eclub-icons">
                    <div class="u-highlights__item">
                        <img src="/assets/img/discount.svg" class="u-highlights__image" alt="Discount icon">
                        <span class="t-heading-six u-highlights__text">$20.00 Discount</span>
                    </div>
                    <div class="u-highlights__item">
                        <img src="/assets/img/date.svg" class="u-highlights__image" alt="Calendar icon">
                        <span class="t-heading-six u-highlights__text">Birthday &amp; Anniversary Promotion</span>
                    </div>
                    <div class="u-highlights__item">
                        <img src="/assets/img/offers.svg" class="u-highlights__image" alt="Offers icon">
                        <span class="t-heading-six u-highlights__text">Exclusive Special Offers</span>
                    </div>
                </div>
                <?php if (get_field('tagline')): ?>
                    <p class="u-eclub-addendum"><?php the_field('tagline'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<?php
get_footer();
?>
<script type="text/javascript">


    jQuery(document).ready(function ($) {

        jQuery(".u-eclub-submit").click(function () {

            response = grecaptcha.getResponse();
            if (response.length === 0) {
                jQuery("#u-eclub-submit1 .u-errors").html("<p id='error-captcha' class='errors'>reCAPTCHA is mandatory.</p>");
                $('#recaptcha_validation').attr('aria-invalid', "true").focus();
                //jQuery('#recaptcha-error').text("reCAPTCHA is mandatory");
                return false;
            } else {
                $('#recaptcha_validation').removeAttr('aria-invalid');
                //jQuery('#recaptcha-error').text('');
            }


            //e.preventDefault();
            var selectedLocation = jQuery("#location").val();
            var phone = jQuery("#phone-number").val();
            var zip = jQuery(".zip-code-input").val();
            
            var email = jQuery(".your-email").val();
            var emailConfimration = jQuery(".your-email-confirmation").val();

            if ($('#conditions').not(':checked').length) {
                jQuery("#u-eclub-submit1 .u-errors").html("<p id='error-conditions' class='errors'>Please accept the terms and conditions.</p>");
                $('#conditions').attr('aria-invalid', "true").focus()

                return false;
            }else if (email=='' || email != emailConfimration) {
                jQuery("#u-eclub-submit1 .u-errors").html("<p>Email confirmation must match email.</p>");
                $('.your-email').attr('aria-invalid', "true").focus()
                return false;
            } else if (selectedLocation == "") {
                jQuery("#u-eclub-submit1 .u-errors").html("<p id='error-location' class='errors'>Please select Location.</p>");
                $('#location').attr('aria-invalid', "true").focus()
                return false;
            } else if (zip == "") {
                jQuery("#u-eclub-submit1 .u-errors").html("<p id='error-zip' class='errors'>Please select Zip Code.</p>");
                $('#zip').attr('aria-invalid', "true").focus()
                return false;
            } else if (!validatePhone(phone)) {
                jQuery("#u-eclub-submit1 .u-errors").html("<p id='error-phone' class='errors'>Please enter valid format Phone Number 999-999-9999.</p>");
                $('#phone-number').attr('aria-invalid', "true").focus()
                return false;
            } else {//999-
                //999 - 9999
                $("#u-eclub-submit1 .u-errors").html("");
                $('.errors').remove();
                $('*[aria-invalid="true"]').removeAttr('aria-invalid');
            }
            return true;

        });



    })


    function validatePhone(MobilePhone)
    {
        var PhoneNumber = /^\(?([0-9]{3})\)?[-]?([0-9]{3})[-]?([0-9]{4})$/;
        if (PhoneNumber.test(MobilePhone) || MobilePhone == '')
        {
            return true;
        } else {

            return false;
        }
    }


</script>
