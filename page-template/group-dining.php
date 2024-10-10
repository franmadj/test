<?php
/*
  Template Name:Group Dining
 */
get_header();
?>
<?php while (have_posts()) :the_post(); ?>
    <div class="s-group-dining">
        <?php
        if (have_rows('content')):
            // loop through the rows of data
            while (have_rows('content')) : the_row();
                ?>
                <div class="o-grid o-grid--gutters">
                    <div class="o-col">
                        <div class="c-promo c-promo--feature hero" data-ref="responsiveVisualElement" style="background-image: url(<?php echo get_sub_field('desktop_image'); ?>);" data-mobile="<?php echo get_sub_field('mobile_image'); ?>" data-desktop="<?php echo get_sub_field('desktop_image'); ?>">
                            <div class="c-promo__content">
                                <h1 class="c-promo__title" style="color: #FFF;"><?php the_sub_field('page_title'); ?></h1><span class="c-promo__teaser"><?php the_sub_field('teaser'); ?></span></div>
                        </div>
                    </div>
                    <a href="#host-an-event" class="hero__arrow" aria-label="Scroll down"></a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php
        while (the_flexible_field("block_body")):
            /* Banner Section  */
            if (get_row_layout() == "one_up"):
                ?>
                <?php $posts_id = get_sub_field('promotion'); ?>
                <?php
                foreach ($posts_id as $value):
                    $one_up_image = wp_get_attachment_image_src(get_post_thumbnail_id($value), 'full');
                    ?>

                    <div class="o-grid o-grid--gutters">
                        <div class="o-col">
                            <div class="c-promo c-promo--highlight" data-ref="responsiveVisualElement" style="background-image: url(<?php echo $one_up_image[0]; ?>);" data-mobile="<?php echo $one_up_image[0]; ?>" data-desktop="<?php echo $one_up_image[0]; ?>">
                                <div class="c-promo__content">
                                    <h2 class="c-promo__title" style="color: white;"><?php echo get_the_title($value); ?></h2><span class="c-promo__teaser">Reserve your experience for Sunday, May 12th</span><a href="<?php echo get_the_permalink($value); ?>" class="c-promo__button">
                                        Learn More
                                    </a></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php
            endif;
            if (get_row_layout() == "two_up"):
                ?>
                <div class="o-grid o-grid--gutters">
                    <?php $two_up_post = get_sub_field('promotion'); ?>
                    <?php
                    foreach ($two_up_post as $value):
                        $two_up_image = wp_get_attachment_image_src(get_post_thumbnail_id($value), 'full');
                        ?>
                        <div class="o-col">
                            <div class="c-promo" data-ref="responsiveVisualElement" style="background-image: url(<?php echo $two_up_image[0]; ?>);" data-mobile="<?php echo $two_up_image[0]; ?>" data-desktop="<?php echo $two_up_image[0]; ?>">
                                <div class="c-promo__content">
                                    <h2 class="c-promo__title" style="color: white;"><?php echo get_the_title($value); ?></h2><span class="c-promo__teaser"><?php echo get_field('teaser', $value); ?></span><a href="<?php echo get_the_permalink($value); ?>" class="c-promo__button">
                                        Learn More
                                    </a></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
            endif;
            if (get_row_layout() == "promo"):
                ?>
                <div class="o-grid o-grid--gutters">
                    <div class="o-col">
                        <?php
                        $promo_desktop_image = get_sub_field('promo_image');
                        $promo_mobile_image = get_sub_field('promo_mobile_image');
                        ?>
                        <section id="<?php echo str_replace(' ', '-', strtolower(get_sub_field('promo_heading'))); ?>" class="home-group-dining <?php if (get_sub_field('alignment') == 'right') { ?> u-right-promo<?php } ?>" style="background-image: url(<?php echo $promo_desktop_image; ?>)" data-ref="responsiveVisualElement" data-mobile="<?php echo $promo_mobile_image; ?>" data-desktop="<?php echo $promo_desktop_image; ?>">
                            <div class="home-group-dining__inner">
                                <h2 class="home-group-dining__title"><?php echo get_sub_field('promo_heading'); ?></h2>

                                <?php if (get_sub_field('promo_lead_text')): ?>
                                    <p class="home-group-dining__lead">
                                        <?php the_sub_field('promo_lead_text'); ?>
                                    </p>
                                <?php endif; ?>

                                <div class="home-group-dining__body">
                                    <?php the_sub_field('promo_content'); ?>
                                </div>
                                <?php
                                if (have_rows('button')):
                                    while (have_rows('button')):the_row();
                                        ?>
                                        <a <?php if(!in_array(get_sub_field('button_text'),['Order Online','Download PDF To-Go Menu','Download PDF Catering Menu'])): ?> role="button" <?php endif; ?>
                                           href="<?php the_sub_field('button_url'); ?>" 
                                           class="button custom-border-bottom <?php if (get_sub_field('style_type') == 'accent') { ?> button--accent-two custom-border-bottom-two <?php } ?> home-group-dining__cta" 
                                               <?php if (get_sub_field('button_target') == 'blank') { ?> target="_blank" <?php } ?> data-ref="openModal" data-type="hosting" data-ignore><?php the_sub_field('button_text'); ?></a>
                                        <br>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </section>

                    </div>
                </div>
                <?php
            endif;
        endwhile
        ?>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>

<?php get_template_part('_includes/hosting-modal'); ?>
<?php get_template_part('_includes/catering-modal'); ?>
<?php get_template_part('_includes/accounts-modal'); ?>
<style>
    body.modal-enabled .Campaign{
        display: none !important;
        
    }
    body.modal-enabled .mobile-header{
        display: none !important;
        
    }
</style>
<script>
    jQuery(document).ready(function ($) {

//    $('.datepicker-wai .date').css('position','relative');
//    $('.datepicker-wai .date > input')
//         
//            .attr({'placeholder': "Pick a Date", "required": "true","style":'color:#fff;padding:14px 23px;font-size:1.3rem;font-wight:400'})
//            .after(" <span style='position:absolute;left:7px;top:11px' aria-hidden='true'>*</span>")
//    })

</script>
<script src="<?php echo get_template_directory_uri() . '/assets/js/datePickerAda.js?a=8' ?>"></script>
<link href="<?php echo get_template_directory_uri() . '/assets/css/datePickerAda.css?v=3' ?>" rel="stylesheet">
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"></script>
<script type="text/javascript">
    var widgetId1;
    var widgetId2;
    var widgetId3;
    var onloadCallback = function () {
        widgetId1 = grecaptcha.render(document.getElementById('recap1'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });
        widgetId2 = grecaptcha.render(document.getElementById('recap2'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });
        widgetId3 = grecaptcha.render(document.getElementById('recap3'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });
    };
    jQuery(document).ready(function ($) {
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
        })
        jQuery(document).on('click', '.catering_submit', function (e) {
            e.preventDefault();
            response2 = grecaptcha.getResponse(1);
            if (response2.length === 0) {
                jQuery("#catering_form").find(".error-form").html("<p id='cat-error-captcha' class='errors'>reCAPTCHA is mandatory.</p>");
                jQuery("#catering_form").find('.cat-error-captcha').attr('aria-invalid', "true").focus();
                return false;
            } else {
                jQuery("#catering_form").find('.cat-error-captcha').removeAttr('aria-invalid');
                return doSumbitCattering();
            }
        })

        jQuery(document).on('click', '.accounts_submit', function (e) {


            response3 = grecaptcha.getResponse(2);

            if (response3.length === 0) {
                jQuery("#na_accounts").find(".error-form").html("<p id='cont-error-captcha' class='errors'>reCAPTCHA is mandatory.</p>");
                jQuery("#na_accounts").find('.cont-error-captcha').attr('aria-invalid', "true").focus();
                return false;
            } else {
                jQuery("#na_accounts").find('.cont-error-captcha').removeAttr('aria-invalid');
                return doSumbitAccounts();
            }
        });
<?php
if (isset($_GET['modal']) && 'host-event' == $_GET['modal']) {
    ?>
            setTimeout(function () {

                jQuery('.event-modal[data-type="hosting"]').removeClass('-disabled');

            }, 1000);


    <?php
}
?>
    });
</script>