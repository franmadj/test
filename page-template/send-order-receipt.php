<?php
/*
  Template Name:Send Order Receipt
 */
get_header();
while (have_posts()) :the_post();
    ?>
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h1><?php the_title();?></h1>
                <form id="send-order-receipt" method="POST" class="mt-4">


                    <div class="c-box">
                        <div class="c-box__col">
                            <input type="text" name="cardnumber" placeholder="Card Number*" aria-label="Name" class="c-box__input" required autocomplete="off">
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="regcode" placeholder="Reg Code*" aria-label="Email" class="c-box__input" required autocomplete="off">
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="amount" placeholder="Amount *" aria-label="Name" class="c-box__input" required autocomplete="off">
                        </div>
                        <div class="c-box__col">
                            <input type="text" name="order_id" placeholder="Order ID *" aria-label="Name" class="c-box__input" required autocomplete="off">
                        </div>
                        
                        <div class="c-box__col">
                            <div class="g-recaptcha mt-3" data-sitekey="<?php echo get_field('google_captcha_key', 'option'); ?>"></div>
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
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<?php get_footer(); ?>
<script type="text/javascript">
   jQuery('.u-contact-submit').click(function () {
       // response = grecaptcha.getResponse();
       // if (response.length === 0) {
       //     jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
       //     return false;
       // } else {
       //     jQuery('.recaptcha-error').text('');
       // }
   })
</script>
<script type="text/javascript">
    jQuery(".u-contact-submit").click(function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var cardnumber = jQuery('#send-order-receipt').find('input[name="cardnumber"]').val();
        var regcode = jQuery('#send-order-receipt').find('input[name="regcode"]').val();
        var amount = jQuery('#send-order-receipt').find('input[name="amount"]').val();
        var order_id = jQuery('#send-order-receipt').find('input[name="order_id"]').val();
        var input_data = jQuery('#send-order-receipt').serialize();
        if (cardnumber != "" && regcode != "" && amount != "" && order_id !="") {
            $(".error-form").html("");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {action: 'send_order_receipt_manually', cardnumber: cardnumber, regcode: regcode, amount: amount, order_id: order_id},
                success: function (data)
                {
                    $(".error-form").html("");
                    var response = JSON.parse(data);
                    console.log(response);
                    if (response.message == "ok") {
                        $("#send-order-receipt").trigger("reset");
                        var message = "<p style='color:#fff;font-weight:700;'> "+response.send_email+" </p>";
                        $(".error-form").html(message);
                    }else{
                        var message = "<p style='color:#fff;font-weight:700;'> "+response.send_email+" </p>";
                        $(".error-form").html(message);
                    }


                }
            });
        } else {
            $(".error-form").html("<p>Please fill out the required fields.</p>");
        }
    });

</script>
