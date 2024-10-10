<?php
/*
  Template Name:Email Customer Detail

 */
get_header('single');

while (have_posts()) :the_post();
    ?>

    <div class="faq-landing">
        <div class="faq-landing-content">

            <h1>Recover Order Details</h1>
            <div class="container">
                <?php echo the_content(); ?>
            </div>
            <div id="error-message" class="top-message mb-1" style="display: none;color:#9E0000;text-align: center;">Your order was either not found or is still processing. Please <a href="/contact"> contact us</a> if you need further assistance.</div>
            <div id="success-message" class="top-message" style="display: none;color:rgb(22 173 42);text-align: center;">Emails have been sent please check your email.</div>
            
            <form id="customer-order" method="post">

                <input type="text" name="order" class="width-100 mb-1" aria-describedby="required_order" aria-label="Enter Order Number" id="customer-order-number" placeholder="Enter Order Number" />
                <div id="required_order" class="error-message mb-1" style="opacity:0;color:#9E0000;">Order number is required</div>

                <input type="email" name="email" class="width-100 mb-1" aria-describedby="required_email" id="customer-email" aria-label="Enter Billing Email" placeholder="Enter Billing Email" />
                <div id="required_email" class="error-message mb-1" style="opacity:0;color:#9E0000;">Email is required</div>

                <div class="c-box__col">
                    <div class="g-recaptcha mb-3" data-theme="dark" data-sitekey="<?php echo get_field('google_captcha_key', 'options'); ?>"></div>
                    <div id="recap2">
                    </div>
                    <div style="top: 20px;position: absolute;z-index: -1;" >
                        <input aria-label="Captcha validation" type="checkbox" aria-describedby="g-recaptcha-error-captcha" class="g-recaptcha-error-captcha">
                    </div>
                    <div class="c-form-error recaptcha-error mb-0" style="color:#9E0000;"></div>
                </div>
                <button id="get-order" class="checkout-button button alt wc-forward button" type="submit" >CONTINUE </button>
                <img class="email-loader" src="/assets/img/Eclipse-loader.gif" />
                

            </form>

        </div>
    </div>
    <style>
        #customer-order {
            max-width: 306px;
        }
        #customer-order input{
            border-color:black;
        }
    </style>
<?php endwhile; ?>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<?php get_footer(); ?>
