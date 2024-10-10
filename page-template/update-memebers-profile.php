<?php
/*
  Template Name: Update members profile
 */

if (empty($_GET['email_member']))
    wp_die('Invalid member');

get_header('single');
?>



<?php
require_once get_template_directory() . '/inc/FishBowl.class.php';
$fishbowl = new FishBowl();
$fields = ['StoreCode', 'Anniversary', 'Birthdate'];
$values = $fishbowl->GetMeberByEmail($_GET['email_member'], $fields);
if (!$values)
    wp_die('Invalid email member');








while (have_posts()) :
    the_post();
    ?>

    <div class="o-container">
        <h1 style="text-align: center;margin-bottom: 40px;"><?php the_title(); ?></h1>
        <div class="o-grid u-eclub-wrapper">
            <div class="o-col" data-el="target-o-col-first">
                <div class="c-box u-eclub-form">

                    <form id="members-update-form" action="#" method="post">



                        <div class="c-box__col">
                            <input type="email" name="EmailAddress" id="email-address" placeholder="Your Email" aria-label="Email" class="c-box__input" readonly="" disabled="" value="<?php echo $_GET['email_member']; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>


                        <div class="c-box__col">
                            <input type="input" name="Birthdate" aria-label="Birthdate" id="birthday" class="c-box__input u-date-input date-formatted" 
                                   required placeholder="Birthdate  <?php echo date('m/d/Y'); ?>" value="<?php echo $values['Birthdate']; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>
                        <div class="c-box__col">
                            <input type="input" name="Anniversary" aria-label="Anniversary" id="anniversary" class="c-box__input u-date-input date-formatted" 
                                   placeholder="Anniversary <?php echo date('m/d/Y'); ?>" value="<?php echo $values['Anniversary']; ?>">
                        </div>
                        <div class="c-box__col">
                            <div class="unstyled">
                                <select id="store-code" name="StoreCode" data-ignore="true" aria-label="Favorite Location" required aria-describedby="error-location">
                                    <option value="">Favorite Location</option>
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

                                            <option value="<?php the_field('fishbowl_id'); ?>" <?php selected($values['StoreCode'], get_field('fishbowl_id'), true) ?>><?php echo get_the_title(); ?></option>
                                            <?php
                                        endwhile;
                                    endif;
                                    wp_reset_postdata();
                                    ?>
                                </select>

                            </div>
                            <span aria-hidden='true'>*</span>

                        </div>

                        <!--                        <div class="u-form-check">
                                                    <input type="checkbox" name="acceptedConditions" aria-describedby="error-conditions" aria-required="true" 
                                                           aria-label="By checking this box, you agree to receive promotional emails and other marketing materials from Texas de Brazil. The information that is requested will not be sold or shared with a third party; it is for Texas de Brazil marketing purposes ONLY. If you wish to unsubscribe, Texas de Brazil provides an easy one-click method to be removed from the distribution list." id="conditions" name="conditions" class="u-form-check__input" data-ref="conditionsChecked" >
                        
                        
                                                    <label for="conditions" class="u-form-check__label u-conditions-text">By checking this box, you agree to receive promotional emails and other marketing materials from Texas de Brazil. The information that is requested will not be sold or shared with a third party; it is for Texas de Brazil marketing purposes ONLY. If you wish to unsubscribe, Texas de Brazil provides an easy one-click method to be removed from the distribution list.</label>
                                                </div>
                        
                                                <div class="c-box__col" style="position: relative;display: block;">
                                                    <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
                                                    
                        
                                                    <div style="top: 20px;position: absolute;z-index: -1;" >
                                                        <label for="recaptcha_validation">Captcha validation</label>
                                                        <input aria-label="Captcha validation" type="checkbox" aria-describedby="error-captcha" id="recaptcha_validation">
                                                    </div>
                        
                                                </div>-->

                        <div class="u-errors" data-ref="generalErrors"></div>
                        <div class="u-success"></div>
                        <button type="submit" class="button u-eclub-submit" id="members-update" >Submit</button>
                    </form>

                </div>
            </div>
            <div class="o-col" data-el="target-o-col-second">

                <div class="u-eclub-content">
                    <?php the_content(); ?>
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
    </div><?php
endwhile; // End of the loop.
?>



<?php
get_footer();
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {


        $("#members-update-form").submit(function (e) {
            e.preventDefault()
            $("#members-update-form .u-errors,#members-update-form .u-success").empty()
            if (!$('#store-code').val().length) {
                $("#members-update-form .u-errors").html("<p id='error-store-code' class='errors'>Please select location.</p>");
                $('#store-code').attr('aria-invalid', "true").focus()
                return false;
            }
            if (!$('#anniversary').val().length) {
                $("#members-update-form .u-errors").html("<p id='error-anniversary' class='errors'>Please enter Aniversary.</p>");
                $('#anniversary').attr('aria-invalid', "true").focus()
                return false;
            }
            if (!$('#store-code').val().length) {
                $("#members-update-form .u-errors").html("<p id='error-store-code' class='errors'>Please select Store Code.</p>");
                $('#store-code').attr('aria-invalid', "true").focus()
                return false;
            }

            var settings = {
                "url": "/wp-admin/admin-ajax.php",
                "method": "POST",
                "timeout": 0,
                "data": "action=fishbowl_members_update&email=<?php echo $_GET['email_member']; ?>&storecode=" + $('#store-code').val() + "&anniversary=" + $('#anniversary').val() + "&birthday=" + $('#birthday').val(),
            };

            $.ajax(settings).done(function (updated) {
                if ('ok' == updated)
                    $(".u-success").html("<p class='success-message'>Member updated.</p>");
                else
                    $(".u-errors").html("<p id='error-store-code' class='errors'>An error ocurred, please try again later.</p>");
            });


        });


    });
</script>
<style>
    .success-message{
        color:white;
    }
    #members-update-form .c-box__col input, #members-update-form .c-box__col select{
        padding-left: 20px;
        
    }
    #members-update-form .c-box__col > span, #leasingForm .c-box__col > span {
        position: absolute;
        top: 6px;
        left: 4px;
    }
    #members-update-form .c-box__col, #leasingForm .c-box__col {
        position: relative;
    }
</style>