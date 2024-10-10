<?php
/*
  Template Name:Send Certificate Email Test
 */
get_header();
while (have_posts()) :the_post();
    ?>
    <!--    <div class="o-container privacy-policy-content">
            <div class="o-grid">
                <div class="o-col">
                    <h2>SEND CERTIFICATE EMAIL</h2>
                    <form id="send-certificate" method="POST" class="mt-4" data-action="send_certificate_email" data-form="base" data-widget="0">
                        <div class="c-box">
                            <div class="c-box__col">
                                <select name="amount" required>
                                    <option value="">Amount</option>
                                    <option value="5">$5</option>
                                    <option value="10">$10</option>
                                    <option value="25">$25</option>
                                    <option value="50">$50</option>
                                </select>
                            </div>


                            <div class="c-box__col">
                                <input type="text" name="email" placeholder="Email" aria-label="Name" class="c-box__input" autocomplete="off">
                            </div>

                            <div class="c-box__col">
                                <textarea class="notes" placeholder="Notes" class="c-box__input" ></textarea>
                            </div>

                            <div class="c-box__col">
                                <div class="g-recaptcha mt-3" id="recaptcha-base"></div>
                                <div class="c-form-error recaptcha-error mb-0"></div>
                            </div>
                            <div class="c-box__col">
                                <div class="c-form-error error-form mb-0"></div>
                            </div>
                            <div class="c-box__col">
                                <button class="button u-contact-submit">Send</button>
                            </div>
                            <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                        </div>
                    </form>
                </div>
            </div>
        </div>-->

    <!--FORM 1-->
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h2>Send In-Store Certificate Dollar-Amounttt</h2>
                <form id="send-certificate-dollar" method="POST" class="mt-4" data-action="send_certificate_email_new" data-form="dollar" data-widget="0">
                    <div class="c-box">
                        <div class="c-box__col">
                            <input type="number" max="70" name="amount" required placeholder="Amount" class="c-box__input amount-in-store" autocomplete="off">

                        </div>


                        <div class="c-box__col">
                            <input type="text" name="email" placeholder="Email" aria-label="Name" class="c-box__input" autocomplete="off">
                        </div>

                        <div class="c-box__col">
                            <textarea class="notes" placeholder="Notes" class="c-box__input" ></textarea>
                        </div>
                        <div class="c-box__col">
                            <select name="expiration" required>
                                <option selected="" value="">Expiration</option>
                                <option value="3 months">3 months</option>
                                <option value="6 months">6 months</option>
                                <option value="1 year">1 year</option>
                            </select>
                        </div>

                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" id="recaptcha-dollar"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <div class="c-form-error error-form mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <button class="button u-contact-submit">Send</button>
                        </div>
                        <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--FORM 2-->
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h2>Send In-Store Certificate Dinner-Amount</h2>
                <form id="send-certificate-dinner" method="POST" class="mt-4" data-action="send_certificate_email_dinner" data-form="dinner" data-widget="1">
                    <div class="c-box">
                        <div class="c-box__col">
                            <select name="discount" required>
                                <option value="">Discount</option>
                                <option value="50">50%</option>
                                <option value="100">100%</option>
                            </select>
                        </div>

                        <div class="c-box__col">
                            <select name="quantity" required>
                                <option value="">Charge</option>
                                <?php
                                for ($i = 1; $i <= 10; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>

                            </select>
                        </div>
                        <div class="c-box__col">
                            <select name="expiration" required>
                                <option selected="" value="">Expiration</option>
                                <option value="3 months">3 months</option>
                                <option value="6 months">6 months</option>
                                <option value="1 year">1 year</option>
                            </select>
                        </div>


                        <div class="c-box__col">
                            <input type="text" name="email" placeholder="Email" aria-label="Name" class="c-box__input" autocomplete="off">
                        </div>

                        <div class="c-box__col">
                            <textarea class="notes" placeholder="Notes" class="c-box__input" ></textarea>
                        </div>

                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" id="recaptcha-dinner"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <div class="c-form-error error-form mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <button class="button u-contact-submit">Send</button>
                        </div>
                        <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--FORM 3-->
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h2>Send To-Go Certificate</h2>
                <form id="send-certificate-to-go" method="POST" class="mt-4" data-action="send_certificate_email" data-form="to-go" data-widget="2">
                    <div class="c-box">
                        <div class="c-box__col">
                            <input type="number" max="50" name="amount" required placeholder="Amount" class="c-box__input amount-to-go" autocomplete="off">
                        </div>


                        <div class="c-box__col">
                            <input type="text" name="email" placeholder="Email" aria-label="Name" class="c-box__input" autocomplete="off">
                        </div>

                        <div class="c-box__col">
                            <textarea class="notes" placeholder="Notes" class="c-box__input" ></textarea>
                        </div>
                        <div class="c-box__col">
                            <select name="expiration" required>
                                <option selected="" value="">Expiration</option>
                                <option value="3 months">3 months</option>
                                <option value="6 months">6 months</option>
                                <option value="1 year">1 year</option>
                            </select>
                        </div>

                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" id="recaptcha-to-go"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <div class="c-form-error error-form mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <button class="button u-contact-submit">Send</button>
                        </div>
                        <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--FORM 4-->
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h2>Send $100 Early Booking Certificate</h2>
                <form id="send-certificate-early-booking" method="POST" class="mt-4" data-action="send_certificate_email" data-form="early-booking" data-widget="3">
                    <div class="c-box">
                        <div class="c-box__col">
                            <select name="amount" required>
                                <option value="100">$100</option>
                            </select>
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="email" placeholder="Email" aria-label="Name" class="c-box__input" autocomplete="off">
                        </div>

                        <div class="c-box__col">
                            <textarea class="notes" placeholder="Notes" class="c-box__input" ></textarea>
                        </div>
                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" id="recaptcha-early-booking"></div>
                            <div class="c-form-error recaptcha-error mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <div class="c-form-error error-form mb-0"></div>
                        </div>
                        <div class="c-box__col">
                            <button class="button u-contact-submit">Send</button>
                        </div>
                        <svg class="u-contact-form__border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php endwhile; ?>

<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"></script>

<?php get_footer(); ?>
<style>
    .o-container{
        margin-bottom: 60px;
    }
    .o-container h2{
        text-align: center;
    }
    .o-container .notes{
        width: 100%;
    }
    form input[type="number"]{
        width: 100%;
    }
</style>

<script type="text/javascript">

    //var widgetId1;
    var widgetId2;
    var widgetId3;
    var widgetId4;
    var widgetId5;

    $('input[name="amount"]').keyup(function () {
        let max = $(this).hasClass('amount-in-store') ? 70 : 50
        if ($(this).val() > max)
            $(this).val(max);
    })


    var onloadCallback = function () {
//        widgetId1 = grecaptcha.render(document.getElementById('recaptcha-base'), {
//            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
//        });
        widgetId2 = grecaptcha.render(document.getElementById('recaptcha-dollar'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });
        widgetId3 = grecaptcha.render(document.getElementById('recaptcha-dinner'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });
        widgetId4 = grecaptcha.render(document.getElementById('recaptcha-to-go'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });
        widgetId5 = grecaptcha.render(document.getElementById('recaptcha-early-booking'), {
            'sitekey': '<?php echo get_field('google_captcha_key', 'option'); ?>'
        });

    };

    function check_captcha() {

    }
    jQuery(document).ready(function ($) {

        $("#send-certificate .u-contact-submit, #send-certificate-dollar .u-contact-submit, #send-certificate-to-go .u-contact-submit, #send-certificate-early-booking .u-contact-submit").click(function (e) {
            $(this).attr('disabled', true);
            e.preventDefault(); // avoid to execute the actual submit of the form.
            let form = $(this).closest('form');//('#send-certificate');
            var widget = form.data('widget');
            response = grecaptcha.getResponse(widget);

            console.log(widget, response);

            if (response.length === 0) {
                form.find('.recaptcha-error').text("reCAPTCHA is mandatory");
                $(this).attr('disabled', false);
                return false;
            } else {
                form.find('.recaptcha-error').text('');
            }

            var amount = form.find('input[name="amount"]').val();
            var content = form.find('.notes').val();
            var email = form.find('input[name="email"]').val();
            var action = form.data('action');
            var form_type = form.data('form');
            var expiration = form.find('select[name="expiration"]').val();

            if (amount != "" && email != "") {
                form.find(".error-form").html("");
                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {action: action, amount: amount, email: email, content: content, form_type: form_type, expiration: expiration},
                    dataType:'json',
                    success: function (response)
                    {
                        form.find(".error-form").html("");
                        //var response = JSON.parse(data);
                        console.log(response);
                        if (response.status == "success") {
                            var message = "<p style='color:#fff;font-weight:700;'>" + response.message + "</p>";
                            form.find(".error-form").html(message);
                        } else {
                            var message = "<p style='color:#fff;font-weight:700;'> " + response.message + "</p>";
                            form.find(".error-form").html(message);
                            $(this).attr('disabled', false);
                        }


                    }
                });
            } else {
                $(".error-form").html("<p>Please fill out the required fields.</p>");
                $(this).attr('disabled', false);
            }
        });


        $("#send-certificate-dinner .u-contact-submit").click(function (e) {
            $(this).attr('disabled', true);
            e.preventDefault(); // avoid to execute the actual submit of the form.
            let form = $(this).closest('form');//('#send-certificate');
            var widget = form.data('widget');
            response = grecaptcha.getResponse(widget);
            if (response.length === 0) {
                form.find('.recaptcha-error').text("reCAPTCHA is mandatory");
                $(this).attr('disabled', false);
                return false;
            } else {
                form.find('.recaptcha-error').text('');
            }

            var discount = form.find('select[name="discount"]').val();
            var quantity = form.find('select[name="quantity"]').val();
            var content = form.find('.notes').val();
            var email = form.find('input[name="email"]').val();
            var action = form.data('action');
            var expiration = form.find('select[name="expiration"]').val();



            if (discount != "" && quantity != "" && email != "") {
                form.find(".error-form").html("");
                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {action: action, discount: discount, quantity: quantity, email: email, content: content, expiration: expiration},
                    success: function (data)
                    {
                        form.find(".error-form").html("");
                        var response = JSON.parse(data);
                        console.log(response);
                        if (response.message == "ok") {
                            var message = "<p style='color:#fff;font-weight:700;'>Send Successfully to Email ID " + response.send_email + "</p>";
                            form.find(".error-form").html(message);
                        } else {
                            var message = "<p style='color:#fff;font-weight:700;'>Erro while sending to Email ID " + response.send_email + "</p>";
                            form.find(".error-form").html(message);
                        }


                    }
                });
            } else {
                $(".error-form").html("<p>Please fill out the required fields.</p>");
                $(this).attr('disabled', false);
            }
        });

    });





</script>
