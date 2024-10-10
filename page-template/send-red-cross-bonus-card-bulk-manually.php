<?php
/*
  Template Name:Send Red Cross BonusCard bulk
 */


get_header();
while (have_posts()) :the_post();
    ?>
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h1><?php the_title(); ?></h1>
                <?php
                if (!empty($_GET['success'])) {
                    if ('ok' == $_GET['success'])
                        echo '<p style="color:green;margin-bottom:0;">You will get a report soon</p>';
                    else
                        echo '<p style="color:red;">Failure.</p>';
                }
                ?>
                <form id="send-bonuscard" action="/send-red-cross-bonus-cards" method="POST" class="mt-4" enctype="multipart/form-data">


                    <div class="c-box">
                        <div class="c-box__col">
                            <input type="file" name="red_cross_bonus_cards_csv_file" id="uploadFile" style="color:white;">
                        </div>


                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>

                        </div>
                        <div class="c-box__col">
                            <div class="c-form-error error-form mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <button type="submit" class="button u-contact-submit">Send</button>

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
<style>

</style>

<script type="text/javascript">
    jQuery(document).ready(function ($) {


        jQuery(".u-contact-submit").click(function (e) {
            e.preventDefault();
            $(this).attr('disabled', true);


            var fileInput = document.getElementById('uploadFile');
            var filePath = fileInput.value;




            var allowedExtensions = /(\.csv)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $(".error-form").html("<p>Upload a correct csv file.</p>");
                fileInput.value = '';
                $(this).attr('disabled', false);
                return false;
            } else
                $(".error-form").html("");




            response = grecaptcha.getResponse();
            if (response.length === 0) {
                jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
                $(this).attr('disabled', false);
                return false;
            } else {
                $('#send-bonuscard').submit();
            }

        });
    });






</script>
