<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package texaswp
 */
?>

</main>
<?php get_template_part('_includes/checkout-first-modal'); ?>


<footer class="footer desktop-footer">

    <div class="footer__inner">
        <div class="left">
            <img src="/assets/img/logos/TDB-05.png" alt="Texas de brazil churrascaria steakhouse logo" class="footer__logo">
            <div class="footer__fine-print">
                <div class="footer__menus">
                    <ul class="footer__list -fine desktop-menu">


                        <li class="footer__list-item">

                            <a href="/accessibility/" class="footer__link animsition-link">Accessibility</a>
                        </li>
                        <li class="footer__list-item"><a href="https://privacy.texasdebrazil.com/privacy-policy" class="footer__link animsition-link">Privacy Policy</a></li>
                        <li class="footer__list-item"><a href="/terms-of-use/" class="footer__link animsition-link">Terms of Use</a></li>
                        <li class="footer__list-item"><a href="/required-disclosures/" class="footer__link animsition-link">Disclosures</a></li>
                    </ul>

                    <ul class="footer__list -fine desktop-menu desktop-menu desktop-menu-ea-icon">

                        <li class="footer__list-item ea-icon">

                            <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                               class="footer__link animsition-link">
                                <img alt="Download the Level Access eA accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                                     src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                            </a>
                            <?php
                            if (!empty($_GET['california-state'])) {

                                error_log('california-state' . print_r($_SERVER, true));
                                ?>
                                California State privacy link
                                <a class="truevault-polaris-optout" href="https://privacy.texasdebrazil.com/opt-out" noreferrer noopener hidden>
                                    <img src="https://polaris.truevaultcdn.com/static/assets/icons/optout-icon-transparent.svg" 
                                         alt="California Consumer Privacy Act (CCPA) Opt-Out Icon" 
                                         style="vertical-align:middle" height="14px"
                                         />
                                    Your Privacy Choices
                                </a>
                            <?php } ?>
                        </li>
                        <?php
                        do_action('carolina_privacy_links');

                        if (apply_filters('tx_check_ip_state', true, 'California')) {
                            ?>
                            <li>
                                <a class="truevault_polaris_optout" data-ignore="1"  href="https://privacy.texasdebrazil.com/opt-out" noreferrer noopener hidden>
                                    <img src="https://polaris.truevaultcdn.com/static/assets/icons/optout-icon-transparent.svg" 
                                         alt="California Consumer Privacy Act (CCPA) Opt-Out Icon" 
                                         style="vertical-align:middle" height="14px"
                                         />
                                    Your Privacy Choices
                                </a>
                            </li>

                            <li>
                                <a class="truevault-polaris-privacy-notice" data-ignore="1" 
                                   href="https://privacy.texasdebrazil.com/privacy-policy#california-privacy-notice" noreferrer noopener hidden>California Privacy Notice</a>
                            </li>
                        <?php } ?>

                    </ul>


                    <!--                    <div class="accessibility-icon desktop-menu desktop-menu-ea-icon">
                                            
                                            <a class="truevault-polaris-privacy-notice" href="https://privacy.texasdebrazil.com/privacy-policy#california-privacy-notice" noreferrer noopener hidden>California Privacy Notice</a>
                    
                                            <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                                               class="footer__link animsition-link">
                                                <img alt="Download the Level Access eA accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                                                     src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                                            </a>
                                            <a class="truevault-polaris-optout" href="https://privacy.texasdebrazil.com/opt-out" noreferrer noopener hidden>
                                                    <img src="https://polaris.truevaultcdn.com/static/assets/icons/optout-icon-transparent.svg" 
                                                         alt="California Consumer Privacy Act (CCPA) Opt-Out Icon" 
                                                         style="vertical-align:middle" height="14px"
                                                         />
                                                    Your Privacy Choices
                                                </a>
                    
                                        </div>-->

                </div>
            </div>
        </div>

        <div class="footer__links">
            <?php
            wp_nav_menu([
                'menu' => 'footer',
                'theme_location' => 'footer',
                'container' => 'footer__links',
                'container_id' => '',
                'container_class' => '',
                'menu_id' => false,
                'menu_class' => 'footer__list',
                'depth' => 1,
                'fallback_cb' => 'bs4navwalker::fallback',
                'walker' => new bs4navwalker()
            ]);
            ?>

            <ul class="footer__list -social">
                <li class="footer__list-item"><a href="<?php the_field('facebook_link', 'options'); ?>" target="_blank" class="footer__link -facebook" aria-label="Go to texas de brazil Facebook Page">Facebook</a></li>
                <li class="footer__list-item"><a href="<?php the_field('twitter_link', 'options'); ?>" target="_blank" class="footer__link -twitter" aria-label="Go to texas de brazil Twitter Page">Twitter</a></li>
                <li class="footer__list-item"><a href="<?php the_field('instagram_link', 'options'); ?>" target="_blank" class="footer__link -instagram" aria-label="Go to texas de brazil Instagram Page">Instagram</a></li>
                <li class="footer__list-item"><a href="<?php the_field('pinterest', 'options'); ?>" target="_blank" class="footer__link -pinterest" aria-label="Go to texas de brazil Pinterest Page">Pinterest</a></li>
                <li class="footer__list-item footer__list-item--translator">
                    <div id="google_translate_element"></div>
                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            //let google_translate_element

                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                includedLanguages: 'ar,de,es,fr,it,ja,ko,nl,pt,ru,zh-CN,zh-TW',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                            }, isMobileDevice() ? 'google_translate_element_mobile' : 'google_translate_element');

                            jQuery('#goog-gt-tt .top').html('<h2 class="title gray">Original text</h2>');
                            jQuery('.goog-te-spinner-pos').remove();
                        }
                    </script>

                    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                </li>
                <li class="footer__list-item mobile-menu">
                    <a href="/accessibility/" class="footer__link animsition-link">Accessibility</a>
                </li>
                <li class="footer__list-item mobile-menu"><a href="https://privacy.texasdebrazil.com/privacy-policy" class="footer__link animsition-link">Privacy Policy</a></li>
                <li class="footer__list-item mobile-menu"><a href="/terms-of-use/" class="footer__link animsition-link">Terms of Use</a></li>
                <li class="footer__list-item mobile-menu"><a href="/required-disclosures/" class="footer__link animsition-link">Disclosures</a></li>
            </ul>
            <div class="accessibility-icon mobile-menu-ea-icon">

                <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                   class="footer__link animsition-link">
                    <img alt="This icon serves as a link to download the eSSENTIAL Accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                         src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                </a>
            </div>

            <?php if (apply_filters('tx_check_ip_state', true, 'California')) { ?>
                <ul class="california-policy">
                    <li>
                        <a class="truevault_polaris_optout" data-ignore="1"  href="https://privacy.texasdebrazil.com/opt-out" noreferrer noopener hidden>
                            <img src="https://polaris.truevaultcdn.com/static/assets/icons/optout-icon-transparent.svg" 
                                 alt="California Consumer Privacy Act (CCPA) Opt-Out Icon" 
                                 style="vertical-align:middle" height="14px"
                                 />
                            Your Privacy Choices
                        </a>
                    </li>

                    <li>
                        <a class="truevault-polaris-privacy-notice" data-ignore="1" 
                           href="https://privacy.texasdebrazil.com/privacy-policy#california-privacy-notice" noreferrer noopener hidden>California Privacy Notice</a>
                    </li>
                </ul>
            <?php } ?>
        </div>

    </div>
</footer>


<?php get_template_part('_includes/table', 'finderpopup'); ?>
</div>
<?php wp_footer(); ?>

<script type="text/javascript">
                        jQuery(document).ready(function () {
//                            jQuery(".animsition").animsition({
//                                timeout: true,
//                                timeoutCountdown: 2000,
//                                loadingInner: '<div class="u-preload-logo__container"><img src="/assets/img/logo-loader.svg" class="u-preload-logo__image" alt="Texas de Brazil is loading."></div>',
//                                loadingClass: 'u-preload-logo__wrapper'
//                            });
                            $(document).on('click', '.stepBack', function (e) {
                                console.log('dsf');
                                $(".stepBack").addClass("u-step-back--hidden");
                            });
                        });

                        jQuery(document).ready(function ($) {
                            jQuery('.datepicker').datepicker({
                                constrainInput: false,
                                minDate: 0
                            });

                            $('.g-dining-submenu').click(function () {
                                console.log('d');
                            });
                        });

                        jQuery('a[href*="#"]:not([data-ignore])').on('click', function (e) {

                            e.preventDefault();
                            var selector = this.href.match(/(#[[A-Za-z0-9-]*)$/),
                                    offsetDistance = document.querySelector(selector[1]).getBoundingClientRect().top + window.scrollY;

                            jQuery('html, body').animate({
                                scrollTop: offsetDistance - 150
                            }, 1000);
                        });
</script>
<script type="text/javascript">
    var $ = jQuery.noConflict();
    $.fn.isOnScreen = function () {
        var win = $(window);
        var viewport = {
            top: win.scrollTop(),
            left: win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();

        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

    };
    jQuery(document).ready(function () {
        jQuery(window).on('scroll', function () {
            var dynamicElements = jQuery('.enter-left, .enter-right, .fade-in-element');

            if (jQuery(window).width() > 991) {
                Array.prototype.forEach.call(dynamicElements, function (el) {
                    if (jQuery(el).isOnScreen()) {
                        jQuery(el).addClass('-is-visible');
                    }
                });

                // DEV: This is the parallax effect on the home slider.
                // TODO: Move into proper JS routing.
                // $('.parallax').css({backgroundPosition: 'center -' + window.pageYOffset / 10 + 'px'});
            } else {
                console.log('dynamicElements');
                console.log(dynamicElements);
                dynamicElements.addClass('-is-visible');
            }
        });
    });
    jQuery(document).ready(function () {
        $(document).on('click', '#get-order', function (e) {
            e.preventDefault();
            $('.top-message').hide();


            response = grecaptcha.getResponse();
            if (response.length === 0) {

                jQuery(".recaptcha-error").html("<p id='g-recaptcha-error-captcha' class='errors'>reCAPTCHA is mandatory.</p>");
                jQuery('.g-recaptcha-error-captcha').attr('aria-invalid', "true").focus();
                return false;
            } else {
                jQuery('.g-recaptcha-error-captcha').removeAttr('aria-invalid');
                jQuery('.recaptcha-error').empty();
            }

            $('.error-message').css('opacity', 0)

            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var billing_email = $('#customer-email');
            billing_email.removeClass("emailerror").attr('aria-invalid', "false");
            if (billing_email.val() == "" || !filter.test(billing_email.val())) {
                billing_email.addClass("emailerror").attr('aria-invalid', "true").focus();
                $('#required_email').css('opacity', 1)
                return false;
            }


            var order = $('#customer-order-number');
            order.removeClass("emailerror").attr('aria-invalid', "false");
            if (order.val() == "") {
                order.addClass("emailerror").attr('aria-invalid', "true").focus();
                $('#required_order').text('Order number is required').css('opacity', 1)
                return false;
            }

            $('.email-loader').addClass("show");


            $.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {action: 'customer_order_detail', billing_email: billing_email.val(), order_number: order.val()},
                success: function (data)
                {
                    $('.email-loader').removeClass("show");

                    if (data == 'ko') {
                        order.addClass("emailerror").attr('aria-invalid', "true").focus();
                        $('#error-message').show()
                        $("#success-message").hide()
                    } else {
                        $('#error-message').hide()
                        $("#success-message").show()
                    }



                }
            });
        });
    });
</script>
<style>
    button.bGiCuu{
        color:black !important;
    }
</style>

<?php
/* ADROL FOR THESE LOCATIONS PAGES
  Carlsbad
  Dallas
  Houston
  Jacksonville
  Lexington
  Long Island
  Memphis
  Miami Beach
  Miami Dadeland
  Oklahoma City
  Orland Park
  Oxnard
  Pittsburgh
  San Antonio
  Yonkers */

if (in_array(get_the_ID(), [1094, 397, 401, 368, 759, 1114, 391, 456, 452, 385, 941, 1312, 389, 403, 776])) {
    ?>
    <script type="text/javascript">
        

        jQuery(document).ready(function () {
            $('header [data-ref="reserveButton"]').click(function () {
                adroll.track("pageView", {
                    segment_name: "981453fe"
                });
            });
            
            $('main [data-ref="reserveButton"]').click(function () {
                adroll.track("pageView", {
                    segment_name: "c26a0417"
                });
            });
            

            $('.order-to-go').click(function () {
                adroll.track("pageView", {
                    segment_name: "8b3b8265"
                });
            });
            
            $('.order-catering').click(function () {
                adroll.track("pageView", {
                    segment_name: "f3b83b9c"
                });
            });
            
           
        })
    </script>
    <?php
}
?>


</body>
</html>
