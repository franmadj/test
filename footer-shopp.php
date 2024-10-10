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
            <img src="/assets/img/logos/TDB-05.png" alt="Texas de Brazil logo" class="footer__logo">
            <div class="footer__fine-print">
                <div class="footer__menus">
                    <ul class="footer__list -fine desktop-menu">


                        <li class="footer__list-item">

                            <a href="/accessibility/" class="footer__link animsition-link">Accessibility</a>
                        </li>
                        <li class="footer__list-item"><a href="/privacy-policy/" class="footer__link animsition-link">Privacy Policy</a></li>
                        <li class="footer__list-item"><a href="/terms-of-use/" class="footer__link animsition-link">Terms of Use</a></li>
                        <li class="footer__list-item"><a href="/required-disclosures/" class="footer__link animsition-link">Disclosures</a></li>
                    </ul>
                    <ul class="footer__list -fine desktop-menu desktop-menu-ea-icon">
                        <li class="footer__list-item ea-icon">

                            <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                               class="footer__link animsition-link">
                                <img alt="This icon serves as a link to download the eSSENTIAL Accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                                     src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                            </a>
                        </li>

                    </ul>

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
                <li class="footer__list-item"><a href="<?php the_field('facebook_link', 'options'); ?>" target="_blank" class="footer__link -facebook">Facebook</a></li>
                <li class="footer__list-item"><a href="<?php the_field('twitter_link', 'options'); ?>" target="_blank" class="footer__link -twitter">Twitter</a></li>
                <li class="footer__list-item"><a href="<?php the_field('instagram_link', 'options'); ?>" target="_blank" class="footer__link -instagram">Instagram</a></li>
                <li class="footer__list-item"><a href="<?php the_field('pinterest', 'options'); ?>" target="_blank" class="footer__link -pinterest">Pinterest</a></li>
                <li class="footer__list-item footer__list-item--translator">
                    <div id="google_translate_element"></div>
                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            //let google_translate_element
                            
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                includedLanguages: 'ar,de,es,fr,it,ja,ko,nl,pt,ru,zh-CN,zh-TW',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                            }, isMobileDevice()?'google_translate_element_mobile':'google_translate_element');
                            
                            jQuery('#goog-gt-tt .top').html('<h2 class="title gray">Original text</h2>');
                            jQuery('.goog-te-spinner-pos').remove();
                        }
                    </script>

                    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                </li>
                <li class="footer__list-item mobile-menu">
                    <a href="/accessibility/" class="footer__link animsition-link">Accessibility</a>
                </li>
                <li class="footer__list-item mobile-menu"><a href="/privacy-policy/" class="footer__link animsition-link">Privacy Policy</a></li>
                <li class="footer__list-item mobile-menu"><a href="/terms-of-use/" class="footer__link animsition-link">Terms of Use</a></li>
                <li class="footer__list-item mobile-menu"><a href="/required-disclosures/" class="footer__link animsition-link">Disclosures</a></li>
            </ul>
            <ul class="footer__list -fine mobile-menu mobile-menu-ea-icon">
                <li class="footer__list-item ea-icon">

                    <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                       class="footer__link animsition-link">
                        <img alt="This icon serves as a link to download the eSSENTIAL Accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                             src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                    </a>
                </li>

            </ul>
        </div>

    </div>
</footer>


<?php get_template_part('_includes/table', 'finderpopup'); ?>
</div>
<script type="text/javascript" src="https://shop.texasdebrazil.com/wp-content/themes/texaswp/assets/js/info-tabs.js" id="texaswp-script-infotabs-js"></script>
<?php wp_footer(); ?>

<script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery(".animsition").animsition({
                                timeout: true,
                                timeoutCountdown: 2000,
                                loadingInner: '<div class="u-preload-logo__container"><img src="/assets/img/logo-loader.svg" class="u-preload-logo__image" alt="Texas de Brazil is loading."></div>',
                                loadingClass: 'u-preload-logo__wrapper'
                            });
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
            
            
            response = grecaptcha.getResponse();
            if (response.length === 0) {
                jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
                return false;
            } else {
                jQuery('.recaptcha-error').text('');
            }
            
            $('.error-message').css('opacity',0)
            
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
            var billing_email = $('#customer-email');
            billing_email.removeClass("emailerror");
            if (billing_email.val() == "" || !filter.test(billing_email.val())) {
                billing_email.addClass("emailerror");
                $('#required_email').css('opacity',1)
                return false;
            }
            var order = $('#customer-order-number');
            order.removeClass("emailerror");
            if (order.val() == "") {
                order.addClass("emailerror");
                $('#required_order').css('opacity',1)
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
                        $(".message").text(data);
                    }
                });


        });



    });
</script>

</body>
</html>
