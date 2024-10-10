<div class="event-modal -disabled" data-ref="eventModal"  data-type="accounts" id="na_accounts" role="dialog" aria-modal="true" aria-labelledby="National Accounts">
    <div class="event-modal__inner">
        <button class="event-modal__exit" aria-label="Exit" data-ref="eventModalExitButton"></button>
        <h2 class="event-modal__title">
            National Accounts
        </h2>
        <form method="POST" id="accounts_submit" class="event-form form-with-labels">
            <div class="event-form__fieldset s-accounts-fields">
                <h3 class="event-form__legend">Your contact details</h3>
                <div class="fields-group">

                    <div class="tx-form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" aria-label="Enter First Name" class="c-box__input" required >
                        <span aria-hidden='true'>*</span>

                    </div>
                    <div class="tx-form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" aria-label="Enter Last Name" class="c-box__input" required >
                        <span aria-hidden='true'>*</span>
                    </div>

                    <div class="tx-form-group">
                        <label for="email-address">Email</label>
                        <input type="email" id="email-address" name="email" placeholder="Enter Your Email" aria-label="Email" class="c-box__input" required>
                        <span aria-hidden='true'>*</span>
                    </div>
                    <div class="tx-form-group">
                        <label for="phone-number">Mobile Phone</label>
                        <input type="text" name="phone" id="phone-number" placeholder="Phone Number 999-999-9999" aria-label="Phone" class="c-box__input"  aria-describedby="error-phone">
                    </div>
                    
                    <div class="tx-form-group tx-form-group-full">
                        <label for="company">Company / Organization</label>
                        <input type="text" id="company" name="company" aria-label="Company / Organization" class="c-box__input" placeholder="Company / Organization" required="">
                        <span aria-hidden='true'>*</span>
                    </div>
                    
                    <div class="tx-form-group tx-form-group-full">
                        <label for="inquiry">Inquiry</label>
                        <textarea name="inquiry" id="inquiry" class="c-box__input" placeholder="Inquiry" required=""></textarea>
                        <span aria-hidden='true'>*</span>
                    </div>


                </div>
            </div>
            <div class="c-box__col mb-3">
                <div id="recap3">

                </div>
                <div style="top: 20px;position: absolute;z-index: -1;" >
                    <input tabindex="-1" aria-label="Captcha validation" type="checkbox" aria-describedby="cont-error-captcha" class="cont-error-captcha">
                </div>
            </div>

            <div class="c-box__col">
                <div class="c-form-error error-form error-form-account mb-0"></div>
            </div>
            <div class="event-form__buttons">
                <button class="event-form__submit accounts_submit" type="button">Submit</button>
                <div class="last-element" style="color:black;width: 0;overflow: hidden;" tabindex="0">l</div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    function doSumbitAccounts() {
        var $ = jQuery;

        //e.preventDefault(); // avoid to execute the actual submit of the form.
        jQuery(".accounts_submit").attr("disabled", true);

        var form = jQuery("#accounts_submit");
        var firstname = form.find('input[name="firstName"]');
        var lastName = form.find('input[name="lastName"]');
        var email = form.find('input[name="email"]');
        var phone = form.find('input[name="phone"]');
        var company = form.find('input[name="company"]');

        var inquiry = jQuery("#inquiry");
        if (firstname.val() != "" && lastName.val() != "" && email.val() != "" && phone.val() != "" && inquiry.val() != "") {
            jQuery(".error-form-account").html("");


            jQuery.ajax({

                type: "POST",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {action: 'na_event_form', first_name: firstname.val(), lastName: lastName.val(), na_email: email.val(), na_phone: phone.val(), na_company: company.val(), inquiry: inquiry.val()}, // serializes the form's elements.
                success: function (data)
                {
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
            jQuery(".accounts_submit").removeAttr("disabled");

            if (firstname.val() == "") {
                jQuery(".error-form-account").html("<p id='error-firstname' class='errors'>Please Enter First name.</p>");
                firstname.attr('aria-describedby', "error-firstname").attr('aria-invalid', "true").focus()
                return false;
            }
            if (lastName.val() == "") {
                jQuery(".error-form-account").html("<p id='error-lastName' class='errors'>Please Enter Last name.</p>");
                lastName.attr('aria-describedby', "error-lastName").attr('aria-invalid', "true").focus()
                return false;
            }
            if (email.val() == "") {
                jQuery(".error-form-account").html("<p id='error-email' class='errors'>Please Enter Email.</p>");
                email.attr('aria-describedby', "error-email").attr('aria-invalid', "true").focus()
                return false;
            }
            if (phone.val() == "") {
                jQuery(".error-form-account").html("<p id='error-phone' class='errors'>Please Enter Phone number.</p>");
                phone.attr('aria-describedby', "error-phone").attr('aria-invalid', "true").focus()
                return false;
            }
            if (company.val() == "") {
                jQuery(".error-form-account").html("<p id='error-company' class='errors'>Please Enter company name.</p>");
                phone.attr('aria-describedby', "error-company").attr('aria-invalid', "true").focus()
                return false;
            }

            if (inquiry.val() == "") {
                jQuery(".error-form-account").html("<p id='error-inquiry' class='errors'>Please Enter Inquiry.</p>");
                inquiry.attr('aria-describedby', "error-inquiry").attr('aria-invalid', "true").focus()
                return false;
            }


        }

    }
    ;
</script>
