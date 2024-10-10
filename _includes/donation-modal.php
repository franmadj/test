<div class="event-modal -disabled" data-ref="eventModal" data-type="donation" id="donation_modal" role="dialog" aria-modal="true" aria-labelledby="Donation Request">
    <div class="event-modal__inner">
        <button class="event-modal__exit" aria-label="Exit" data-ref="eventModalExitButton"></button>
        <h2 class="event-modal__title">
            Donation Request
        </h2>
        <p>
            In order to request a donation, please attach a formal request document to this form on company letterhead that includes the following information:
            <br> 1. Name of organization
            <br> 2. Contact person
            <br> 3. Mailing address
            <br> 4. Telephone number
            <br> 5. Email address
            <br> 6. Charity/Organization's Mission
            <br> 7. Explanation of how the donation will be used (i.e. silent auction, raffle, etc...)
            <br> 8. Date of the event
        </p>
        <form method="POST" class="event-form" enctype="multipart/form-data" accept-charset="UTF-8" data-ref="donationForm">
            <input type="hidden" name="action" value="texas/saveSubmission">
            <input type="hidden" name="sectionId" value="26">
            <input type="hidden" name="redirect" value="thanks">

            <div class="event-form__fieldset">
                <h3 class="event-form__legend">Your request details</h3>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="title" placeholder="First Name*" type="text" class="event-form__input" id="first_name" required="">
                    </div>
                </div>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="fields[lastName]" placeholder="Last Name*" type="text" class="event-form__input" id="last_name" required="">
                    </div>
                </div>
                <div class="event-form__field -full">
                    <div class="event-form__input-wrapper">
                        <input name="fields[email]" placeholder="Email Address*" type="text" class="event-form__input" id="email" required="">
                    </div>
                </div>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="fields[phone]" placeholder="Phone Number*" type="text" class="event-form__input" id="phone" required="">
                    </div>
                </div>
                <div class="event-form__field">
                    <div class="event-form__input-wrapper">
                        <input name="fields[company]" placeholder="Company / Organization*" type="text" class="event-form__input" id="company" required="">
                    </div>
                </div>
                <div class="event-form__field -full">
                    <label for="sortpicture" class="event-form__label -textarea u-file-label">Attach Formal Request Document (PDF Only)</label>
                    <input type="file" id="sortpicture" name="upload_attachment" class="u-file-input" accept="application/pdf">
                </div>
                <div class="event-form__field -full">
                    <textarea name="fields[inquiry]" id="inquiry" class="event-form__textarea" placeholder="Additional Comments"></textarea>
                </div>
                <div class="c-box__col">
                    <div class="g-recaptcha mt-3" data-sitekey="6LcEJ3UUAAAAAKmz6x3Olh5w1_-4rof4GJYj70Rr"></div>
                    <div class="c-form-error recaptcha-error mb-0"></div>
                </div>
                <div class="c-box__col">
                    <div class="c-form-error error-form mb-0"></div>
                </div>
            </div>
            <div class="event-form__buttons">
                <button class="event-form__submit" type="button">Submit</button>
                <div class="last-element" style="color:black;width: 0;overflow: hidden;" tabindex="0">l</div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">
    jQuery('.event-form__submit').click(function () {
        response = grecaptcha.getResponse();
        if (response.length === 0) {
            jQuery('.recaptcha-error').text("reCAPTCHA is mandatory");
            return false;
        } else {
            jQuery('.recaptcha-error').text('');
        }
    });
    jQuery(document).ready(function ($) {
        jQuery.noConflict();
        jQuery(document).on('click', '.event-form__submit', function (e) {
            e.preventDefault();
            $(".event-form__submit").attr("disabled", true);




            var fd = new FormData();
            //var file = jQuery(document).find('input[type="file"]');
            var file = jQuery('#sortpicture').prop('files')[0];


            var form = jQuery("#donation_modal");
            var firstname = form.find('#first_name');
            var lastName = form.find('#lastname');
            var email = form.find('#email');
            var phone = form.find('#first_name');
            var company = form.find('#company');

            if (typeof file == 'undefined' || 'application/pdf' != file.type) {
                form.find(".error-form").html("<p>Please select a valid PDF file.</p>");
                $(".event-form__submit").removeAttr("disabled", false);
                return false;

            }

            if (firstname.val() != "" && lastName.val() != "" && email.val() != "" && phone.val() != "" && company.val() != "") {
                fd.append("file", file);
                fd.append('first_name', jQuery("#first_name").val());
                fd.append('last_name', jQuery("#last_name").val());
                fd.append('contact_email', jQuery("#email").val());
                fd.append('contact_phone', jQuery("#phone").val());
                fd.append('content', jQuery("#inquiry").val());
                fd.append('company', jQuery("#company").val());
                fd.append('action', 'donaction_submission');

                jQuery.ajax({
                    type: 'POST',
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        var response = JSON.parse(response);

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
                form.find(".error-form").html("<p>Please fill out the required fields.</p>");
                $(".event-form__submit").removeAttr("disabled", false);

            }




        });
    });
</script>
