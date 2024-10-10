<?php
/*
  Template Name:TTJ
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
                    <form  id="u-eclub-submit1" class="form-with-labels" action="https://TexasdeBrazil.fbmta.com/members/subscribe.aspx" method="post">
                        <span class="help-required-fields">Required fields *</span>
                        <input type="hidden" name="Action" id="Action" value="subscribe">
                        <input type="hidden" name="_InputSource_" value="TTJ">
                        <input type="hidden" name="ListID" value="23622320156">
                        <input type="hidden" name="SiteGUID" value="4E1BF72E-AE6F-45FA-A257-C55651B6770A">
                        <input type="hidden" name="SuppressConfirmation" value="yes">
                        <input type="hidden" name="ReturnURL" value="https://texasdebrazil.com/thanks?from=eclub">
                        <div class="fields-group" style="display:flex;flex-wrap: wrap;">
                            <div class="tx-form-group tx-form-group-first">
                                <label for="email-address">Email</label>
                                <input type="email" id="email-address" name="EmailAddress" placeholder="Enter Your Email" class="c-box__input" required tabindex="1">
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="tx-form-group">
                                <label for="confirm-email-address">confirm Your Email</label>
                                <input type="email" id="confirm-email-address" name="EmailAddressConfirm" placeholder="confirm Your Email" class="c-box__input" required autocomplete="nope" tabindex="2">
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="tx-form-group">
                                <label for="phone-number">Mobile Phone</label>
                                <input type="text" name="MobilePhone" id="phone-number" placeholder="Phone Number 999-999-9999" class="c-box__input PhoneNumber" aria-describedby="error-phone" tabindex="3">
                            </div>
                            <div class="tx-form-group">
                                <label for="FirstName">First Name</label>
                                <input type="text" name="FirstName" id="FirstName" placeholder="Enter First Name" class="c-box__input" required >
                                <span aria-hidden='true'>*</span>

                            </div>
                            <div class="tx-form-group">
                                <label for="LastName">Last Name</label>
                                <input type="text" name="LastName" id="LastName" placeholder="Enter Last Name" class="c-box__input" required >
                                <span aria-hidden='true'>*</span>
                            </div>

                            

                            <div class="tx-form-group">
                                <label for="birthday">Birthdate</label>
                                <input type="input" name="Birthdate" id="birthday" tabindex="6" class="c-box__input u-date-input" 
                                       pattern="\d{1,2}/\d{1,2}/\d{4}" required placeholder="Birthdate * <?php echo date('m/d/Y'); ?>">
                                <span aria-hidden='true'>*</span>
                            </div>
                            <div class="tx-form-group">
                                <label for="anniversary">Anniversary</label>
                                <input type="input" name="Anniversary" tabindex="7" id="anniversary" class="c-box__input u-date-input" 
                                       pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="Anniversary <?php echo date('m/d/Y'); ?>">
                            </div>
                            <div class="tx-form-group">
                                <label for="anniversary">Favorite Location</label>
                                    <select id="location" name="StoreCode" required tabindex="8">
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
                                <span aria-hidden='true'>*</span>
                                
                                
                            </div>
                            <div class="tx-form-group">
                                <label for="zipcode">Zip Code</label>
                                <input type="text" name="Zip" id="zipcode" placeholder="Zip Code" class="c-box__input zip-code-input" tabindex="9" required>
                                <span aria-hidden='true'>*</span>
                            </div>
                        </div>

                        <div class="u-form-check">
                            <span aria-hidden='true'>*</span>
                            <input type="checkbox" name="acceptedConditions" aria-label="Accept Conditions?" id="conditions" name="conditions" class="u-form-check__input" data-ref="conditionsChecked" tabindex="10">
                            <label for="conditions" class="u-form-check__label u-conditions-text">By checking this box, you agree to receive promotional emails and other marketing materials from Texas de Brazil. The information that is requested will not be sold or shared with a third party; it is for Texas de Brazil marketing purposes ONLY. If you wish to unsubscribe, Texas de Brazil provides an easy one-click method to be removed from the distribution list.</label>
                        </div>

                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>

                        </div>

                        <div class="u-errors" data-ref="generalErrors"></div>
                        <button type="submit" class="button u-eclub-submit" id="u-eclub-submit" tabindex="9">Submit</button>
                    </form>
                </div>
            </div>
            <div class="o-col" data-el="target-o-col-second">
                <h2><?php the_field('lead'); ?></h2>
                <div class="u-eclub-content">
                    <?php the_field('main_content'); ?>
                    <p><a class="truevault-polaris-privacy-notice" data-ignore="1" href="https://privacy.texasdebrazil.com/privacy-policy#financial-incentive" noreferrer noopener hidden>Notice of Financial Incentive</a></p>
                </div>
                <div class="u-highlights eclub-icons-frame tx-mobile-view" data-ref="eclub-icons">
                    <div class="u-highlights__item">
                        <img src="/assets/img/discount.svg" class="u-highlights__image" alt="">
                        <span class="t-heading-six u-highlights__text">$20.00 Discount</span>
                    </div>
                    <div class="u-highlights__item">
                        <img src="/assets/img/date.svg" class="u-highlights__image" alt="">
                        <span class="t-heading-six u-highlights__text">Birthday &amp; Anniversary Promotion</span>
                    </div>
                    <div class="u-highlights__item">
                        <img src="/assets/img/offers.svg" class="u-highlights__image" alt="">
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
                jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
                return false;
            } else {
                jQuery('.recaptcha-error').text('');
            }

            //e.preventDefault();
            var selectedLocation = jQuery("#location").val();
            var phone = jQuery("#phone-number").val();
            var zip = jQuery(".zip-code-input").val();

            var email = jQuery(".your-email").val();
            var emailConfimration = jQuery(".your-email-confirmation").val();

            if ($('#conditions').not(':checked').length) {
                jQuery("#u-eclub-submit1 .u-errors").html("<p>Please accept the terms and conditions.</p>");
                return false;
            } else if (email == '' || email != emailConfimration) {
                jQuery("#u-eclub-submit1 .u-errors").html("<p>Email confirmation must match email.</p>");
                return false;
            } else if (selectedLocation == "") {
                jQuery("#u-eclub-submit1 .u-errors").html("<p>Please select Location.</p>");
                return false;
            } else if (zip == "") {
                jQuery("#u-eclub-submit1 .u-errors").html("<p>Please select Zip Code.</p>");
                return false;
            } else if (!validatePhone(phone)) {
                jQuery("#u-eclub-submit1 .u-errors").html("<p>Please enter valid format Phone Number 999-999-9999.</p>");
                return false;
            } else {//999-
                999 - 9999
                jQuery("#u-eclub-submit1 .u-errors").html("");
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