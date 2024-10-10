<?php
/*
  Template Name:Send BonusCard
 */
get_header();
while (have_posts()) :the_post();
    ?>
    <div class="o-container privacy-policy-content">
        <div class="o-grid">
            <div class="o-col">
                <h1><?php the_title();?></h1>
                <form id="send-bonuscard" method="POST" class="mt-4">


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
                
                
                <h1 style="margin-top: 30px">With No Validation</h1>
                 <form id="send-bonuscard-no-val" method="POST" class="mt-4">


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
                            <input type="text" name="email" placeholder="Email *" aria-label="Name" class="c-box__input" required autocomplete="off">
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
       
   })
</script>
<script type="text/javascript">
    jQuery(".u-contact-submit").click(function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        response = grecaptcha.getResponse();
           if (response.length === 0) {
               jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
               return false;
           } else {
               jQuery('.recaptcha-error').text('');
           }
        var cardnumber = jQuery('#send-bonuscard').find('input[name="cardnumber"]').val();
        var regcode = jQuery('#send-bonuscard').find('input[name="regcode"]').val();
        var amount = jQuery('#send-bonuscard').find('input[name="amount"]').val();
        var order_id = jQuery('#send-bonuscard').find('input[name="order_id"]').val();
        var input_data = jQuery('#send-bonuscard').serialize();
        if (cardnumber != "" && regcode != "" && amount != "" && order_id !="") {
            $(".error-form").html("");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {action: 'send_bonuscard_manually', cardnumber: cardnumber, regcode: regcode, amount: amount, order_id: order_id},
                success: function (data)
                {
                    $(".error-form").html("");
                    var response = JSON.parse(data);
                    console.log(response);
                    if (response.message == "ok") {
                        var message = "<p style='color:#fff;font-weight:700;'>Send Successfully to Email ID "+response.send_email+"</p>";
                        $(".error-form").html(message);
                    }else{
                        var message = "<p style='color:#fff;font-weight:700;'>Error "+response.send_email+"</p>";
                        $(".error-form").html(message);
                    }


                }
            });
        } else {
            $(".error-form").html("<p>Please fill out the required fields.</p>");
        }
    });
    
    var form=jQuery('#send-bonuscard-no-val');
    
    
    form.find(".u-contact-submit").click(function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        
        
       
        var cardnumber = form.find('input[name="cardnumber"]').val();
        var regcode = form.find('input[name="regcode"]').val();
        var amount = form.find('input[name="amount"]').val();
        var email = form.find('input[name="email"]').val();

        if (cardnumber != "" && regcode != "" && amount != "" && email !="") {
            form.find(".error-form").html("");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {action: 'send_bonuscard_manually', cardnumber: cardnumber, regcode: regcode, amount: amount, email: email},
                success: function (data)
                {
                    form.find(".error-form").html("");
                    var response = JSON.parse(data);
                    console.log(response);
                    if (response.message == "ok") {
                        var message = "<p style='color:#fff;font-weight:700;'>Send Successfully to Email ID "+response.send_email+"</p>";
                        form.find(".error-form").html(message);
                    }else{
                        var message = "<p style='color:#fff;font-weight:700;'>Error "+response.send_email+"</p>";
                        form.find(".error-form").html(message);
                    }


                }
            });
        } else {
            form.find(".error-form").html("<p>Please fill out the required fields.</p>");
        }
    });

</script>
