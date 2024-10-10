<?php
/*
  Template Name:Contact Catering
 */

//$d=get_field('happyfox_location_id', 368);
//var_dump($d);
get_header();
while (have_posts()) :the_post();
    ?>
    <div class="o-container c-page-header">
        <div class="o-grid o-grid-contact">
            <div class="o-col">
                <h1 class="t-heading-one u-contact-heading">Catering Contact Us</h1>
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
                <form id="contact-from" method="POST" data-ref="contactForm">


                    <div class="c-box u-contact-form">
                        <div class="c-box__col">
                            <input type="text" name="title" placeholder="Name" aria-label="Name" class="c-box__input" required> <span aria-hidden='true'>*</span>
                        </div>
                        <div class="c-box__col">
                            <input type="email" name="email" placeholder="Email" aria-label="Email" class="c-box__input" required> <span aria-hidden='true'>*</span>
                        </div>

                        <div class="c-box__col">
                            <div class="unstyled">
                                <select name="locationVisited" id="locationvisted" aria-label="Location" class="c-box__input" data-ignore="true" data-error="Please select a location.">
                                    <option selected value="">Location</option>
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
                                        <?php while ($location->have_posts()) : $location->the_post(); 
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
                        <div class="c-box__col">
    <!--                            <input type="text" id="datevisited" name="fields[dateVisited]" placeholder="Date Visited MM/DD/YYYY" aria-label="Date Visited" class="c-box__input js-is-hidden datepicker" max="<?php echo date('Y-m-d'); ?>" data-ref="conditionalField">-->
                            <script>
                                var date_picker_only_past_dates = true;
                                //var format_date = 'd/m/y';
                            </script>                    
                            <?php
                            $placeholder='Order date';
                            $data_el='orderdate';
                            $input_id='date-catering';
                            require_once(get_template_directory() . '/_includes/datepicker_.php');
                            ?>
                            <script src="<?php echo get_template_directory_uri() . '/assets/js/datePickerAda.js?a=8' ?>"></script>
                            <link href="<?php echo get_template_directory_uri() . '/assets/css/datePickerAda.css?v=3' ?>" rel="stylesheet">
                            <span aria-hidden='true'>*</span>
                        </div>


                        <div class="c-box__col order-number">
                            <input type="text" name="order_number" id="order_number" placeholder="Order number" aria-label="Order number" class="c-box__input">
                            <span aria-hidden='true'>*</span>


                        </div>

                                                                        <div class="c-box__col" data-ref="body">
                            <textarea name="body" id="body" aria-label="Body" class="c-box__textarea" rows="10" style="resize: none;" data-ref="limitScroll" required maxlength="200" placeholder="INQUIRY"></textarea>
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
        var firstname = form.find('input[name="title"]').val();
        var contact_email = form.find('input[name="email"]').val();

        var locationvisted = jQuery("#locationvisted").val();
        var contact_subject='contact-catering'

        var datevisited = jQuery('.datepicker-wai .date > input').val();
        var order_number = jQuery("#order_number").val();
        var body = jQuery("#body");

        var input_data = form.serialize();
        var error = false;


        if (!locationvisted.length || !isValidDate(datevisited) || !order_number.length) {
            error = true;
        }
        
        const bodyVal = body.val().trim();

        if (isValidEmail(contact_email) && contact_subject != "" && bodyVal != "" && !error) {

            $(".error-form").html("");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: 'contact_form',
                    contact_name: firstname,
                    contact_email: contact_email,
                    contact_subject,
                    
                    location_visited: locationvisted,
                    body: body.val(),
                    
                    date_visited: datevisited,
                    order_number: order_number,

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
            $(".error-form").html("<p>Please fill out the required fields.</p>");
            $(this).attr('disabled', false);
        }
    });



</script>
<style>
    option.international{
        display: none;
    }
    .c-box__input{
        padding-left: 17px;
        color:#efece966;
        font-weight: 100;
    }
    .datepicker-wai .date input{
        background: #191919;
        border: none;
        color: #b9b7b2;
        margin: 0.1rem;
        width: 100%;
        text-align: left;

    }

    #myDatepicker{
        width: 100%;
    }
    .u-contact-form > div {
        position: relative;

    }
    .u-contact-form > div.c-box__col > span{
        position: absolute;
        left: 4px;
        top: 6px;
        color:#efece966;
    }

    .u-contact-form textarea::-webkit-input-placeholder {
        color: #b9b7b2;
    }

    .u-contact-form textarea:-moz-placeholder { /* Firefox 18- */
        color: #b9b7b2; 
    }

    .u-contact-form textarea::-moz-placeholder {  /* Firefox 19+ */
        color: #b9b7b2; 
    }

    .u-contact-form textarea:-ms-input-placeholder {
        color: #b9b7b2;  
    }

    .u-contact-form textarea::placeholder {
        color: #b9b7b2;
    }
    /*.u-contact-form > div.c-box__col:nth-child(2) > span{
        left: 83px;
    }*/


</style>
