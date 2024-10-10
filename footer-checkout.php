</main>
<?php get_template_part('_includes/checkout-first-modal'); ?>

<footer class="footer desktop-footer">
    <div class="footer__inner">
        <div class="left">
            <img src="/assets/img/logos/TDB-05.png" alt=" Texas de brazil churrascaria steakhouse logo" class="footer__logo">
            <div class="footer__fine-print">
                <div class="footer__menus">
                    <ul class="footer__list -fine desktop-menu">

                        <li class="footer__list-item">
                            <a href="/accessibility/" class="footer__link animsition-link">Accessibility</a>
                        </li>
                        <li class="footer__list-item"><a href="https://privacy.texasdebrazil.com/privacy-policy" class="footer__link animsition-link">Privacy Policy</a></li>
                        <li class="footer__list-item"><a href="/terms-of-use/" class="footer__link animsition-link">Terms of Use</a></li>
                        <li class="footer__list-item"><a href="/required-disclosures/" class="footer__link animsition-link">Disclosures</a></li>
                    </ul>

                    <ul class="footer__list -fine desktop-menu desktop-menu desktop-menu-ea-icon">

                        <li class="footer__list-item ea-icon">

                            <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                               class="footer__link animsition-link">
                                <img alt="Download the Level Access eA accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                                     src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                            </a>
                        </li>
                        <?php 
                        do_action('carolina_privacy_links');
                        
                        if (apply_filters('tx_check_ip_state', true, 'California')) { ?>
                            <li>
                                <a class="truevault_polaris_optout" href="https://privacy.texasdebrazil.com/opt-out" noreferrer noopener hidden>
                                    <img src="https://polaris.truevaultcdn.com/static/assets/icons/optout-icon-transparent.svg" 
                                         alt="California Consumer Privacy Act (CCPA) Opt-Out Icon" 
                                         style="vertical-align:middle" height="14px"
                                         />
                                    Your Privacy Choices
                                </a>
                            </li>

                            <li>
                                <a class="truevault-polaris-privacy-notice" data-ignore="1" href="https://privacy.texasdebrazil.com/privacy-policy#california-privacy-notice" noreferrer noopener hidden>California Privacy Notice</a>
                            </li>
                        <?php } ?>

                    </ul>

                    <!--                    <div class="accessibility-icon desktop-menu desktop-menu-ea-icon">
                    
                                            <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                                               class="footer__link animsition-link">
                                                <img alt="Download the Level Access eA accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                                                     src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                                            </a>
                    
                                        </div>-->
                </div>
            </div>
        </div>

        <div class="footer__links">
            <?php
            wp_nav_menu([
                'menu' => 'footer',
                'theme_location' => 'footer',
                'container' => 'footer__links',
                'container_id' => '',
                'container_class' => '',
                'menu_id' => false,
                'menu_class' => 'footer__list',
                'depth' => 1,
                'fallback_cb' => 'bs4navwalker::fallback',
                'walker' => new bs4navwalker()
            ]);
            ?>

            <ul class="footer__list -social">
                <li class="footer__list-item"><a href="<?php the_field('facebook_link', 'options'); ?>" target="_blank" class="footer__link -facebook">Facebook</a></li>
                <li class="footer__list-item"><a href="<?php the_field('twitter_link', 'options'); ?>" target="_blank" class="footer__link -twitter">Twitter</a></li>
                <li class="footer__list-item"><a href="<?php the_field('instagram_link', 'options'); ?>" target="_blank" class="footer__link -instagram">Instagram</a></li>
                <li class="footer__list-item"><a href="<?php the_field('pinterest', 'options'); ?>" target="_blank" class="footer__link -pinterest">Pinterest</a></li>
                <li class="footer__list-item footer__list-item--translator">
                    <div id="google_translate_element"></div>
                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                includedLanguages: 'ar,de,es,fr,it,ja,ko,nl,pt,ru,zh-CN,zh-TW',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                            }, 'google_translate_element');
                            jQuery('#goog-gt-tt .top').html('<h2 class="title gray">Original text</h2>');
                            jQuery('.goog-te-spinner-pos').remove();
                        }
                    </script>

                    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                </li>
                <li class="footer__list-item mobile-menu">
                    <a href="/accessibility/" class="footer__link animsition-link">Accessibility</a>
                </li>
                <li class="footer__list-item mobile-menu"><a href="https://privacy.texasdebrazil.com/privacy-policy" class="footer__link animsition-link">Privacy Policy</a></li>
                <li class="footer__list-item mobile-menu"><a href="/terms-of-use/" class="footer__link animsition-link">Terms of Use</a></li>
                <li class="footer__list-item mobile-menu"><a href="/required-disclosures/" class="footer__link animsition-link">Disclosures</a></li>
            </ul>
            <div class="accessibility-icon mobile-menu-ea-icon">

                <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                   class="footer__link animsition-link">
                    <img alt="This icon serves as a link to download the eSSENTIAL Accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                         src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                </a>
            </div>
            <?php if (apply_filters('tx_check_ip_state', true, 'California')) { ?>
                <ul class="california-policy">
                    <li>
                        <a class="truevault_polaris_optout" data-ignore="1"  href="https://privacy.texasdebrazil.com/opt-out" noreferrer noopener hidden>
                            <img src="https://polaris.truevaultcdn.com/static/assets/icons/optout-icon-transparent.svg" 
                                 alt="California Consumer Privacy Act (CCPA) Opt-Out Icon" 
                                 style="vertical-align:middle" height="14px"
                                 />
                            Your Privacy Choices
                        </a>
                    </li>

                    <li>
                        <a class="truevault-polaris-privacy-notice" data-ignore="1" 
                           href="https://privacy.texasdebrazil.com/privacy-policy#california-privacy-notice" noreferrer noopener hidden>California Privacy Notice</a>
                    </li>
                </ul>
            <?php } ?>
        </div>

    </div>
</footer>
<?php wp_footer(); ?>
<script>(function (r, e, b, o, u, n, d) {
                            if (r.Rebound)
                                return;
                            d = function () {
                                o = "script";
                                u = e.createElement(o);
                                u.type = "text/javascript";
                                u.src = b;
                                u.async = true;
                                n = e.getElementsByTagName(o)[0];
                                n.parentNode.insertBefore(u, n)
                            };
                            if (r.attachEvent) {
                                r.attachEvent("onload", d)
                            } else {
                                r.addEventListener("load", d, false)
                            }
                        })(window, document, "https://rebound.postmarkapp.com/widget/1.0");</script>
<script type="text/javascript">
    jQuery(document).ready(function () {

        jQuery("#billing_postcode,#shipping_postcode").focusout(function () {

            jQuery('body').trigger('update_checkout');

        })
    });

</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHMjwxuI9Eur-p2-qS90VHByW4dem8v0o&callback=initAutocomplete&libraries=places&v=weekly"
    defer
></script>
<script>
// This sample uses the Places Autocomplete widget to:
// 1. Help the user select a place
// 2. Retrieve the address components associated with that place
// 3. Populate the form fields with those address components.
// This sample requires the Places library, Maps JavaScript API.
// Include the libraries=places parameter when you first load the API.
// For example: <script
// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    let autocompleteField;
    let address1Field;
    let shipping_address2Field;
    let shipping_postalField;
    let stateField;

    let shipping_autocompleteField;
    let shipping_address1Field;
    let address2Field;
    let postalField;
    let shipping_stateField;

    function initAutocomplete() {
        //BILLING FORM
        address1Field = document.querySelector("#billing_address_1");
        address2Field = document.querySelector("#billing_address_2");
        postalField = document.querySelector("#billing_postcode");
        stateField = document.querySelector("#billing_state");
        // Create the autocomplete object, restricting the search predictions to
        // addresses in the US and Canada.
        autocompleteField = new google.maps.places.Autocomplete(address1Field, {
            componentRestrictions: {country: ["us", "ca"]},
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        //address1Field.focus();
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        autocompleteField.addListener("place_changed", fillInAddress);
//    setTimeout(function(){
//        jQuery("#billing_address_1, #billing_postcode, #billing_city, #billing_state").attr('autocomplete','nope')
//    },1500)



        //SHIPPING FORM
        shipping_address1Field = document.querySelector("#shipping_address_1");
        shipping_address2Field = document.querySelector("#shipping_address_2");
        shipping_postalField = document.querySelector("#shipping_postcode");
        shipping_stateField = document.querySelector("#shipping_state");
        // Create the autocomplete object, restricting the search predictions to
        // addresses in the US and Canada.
        shipping_autocompleteField = new google.maps.places.Autocomplete(shipping_address1Field, {
            componentRestrictions: {country: ["us", "ca"]},
            fields: ["address_components", "geometry"],
            types: ["address"],
        });
        //shipping_address1Field.focus();
        // When the user selects an address from the drop-down, populate the
        // address fields in the form.
        shipping_autocompleteField.addListener("place_changed", shipping_fillInAddress);
//    setTimeout(function(){
//        jQuery("#shipping_address_1, #shipping_postcode, #shipping_city, #shipping_state").attr('autocomplete','nope')
//    },1500)
    }

    function fillInAddress() {
        jQuery("#billing_address_1").after('<input type="hidden" name="place_changed" value="1">')
        // Get the place details from the autocomplete object.
        const place = autocompleteField.getPlace();
        let address1 = "";
        let postcode = "";

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        // place.address_components are google.maps.GeocoderAddressComponent objects
        // which are documented at http://goo.gle/3l5i5Mr
        for (const component of place.address_components) {
            // @ts-ignore remove once typings fixed
            const componentType = component.types[0];
            switch (componentType) {
                case "street_number":
                {
                    address1 = `${component.long_name} ${address1}`;
                    break;
                }

                case "route":
                {
                    address1 += component.short_name;
                    break;
                }

                case "postal_code":
                {
                    postcode = `${component.long_name}`;
                    break;
                }

//            case "postal_code_suffix":
//            {
//                postcode = `${postcode}`;
//                break;
//            }
                case "locality":
                    document.querySelector("#billing_city").value = component.long_name;
                    break;
                case "administrative_area_level_1":
                {
                    console.log('stateField: ' + component.long_name);
                    stateField.value = component.long_name;
                    stateField.blur();
                    break;
                }

            }
        }

        console.log('postcode: ' + postcode);
        console.log('address1: ' + address1);

        address1Field.value = address1;
        postalField.value = postcode;
        postalField.focus();
        postalField.blur();
        // After filling the form with address components from the Autocomplete
        // prediction, set cursor focus on the second address line to encourage
        // entry of subpremise information such as apartment, unit, or floor number.
        address2Field.focus();
    }

    function shipping_fillInAddress() {
        jQuery("#shipping_address_1").after('<input type="hidden" name="shipping_place_changed" value="1">')
        // Get the place details from the autocomplete object.
        const place = shipping_autocompleteField.getPlace();
        let address1 = "";
        let postcode = "";

        // Get each component of the address from the place details,
        // and then fill-in the corresponding field on the form.
        // place.address_components are google.maps.GeocoderAddressComponent objects
        // which are documented at http://goo.gle/3l5i5Mr
        for (const component of place.address_components) {
            // @ts-ignore remove once typings fixed
            const componentType = component.types[0];
            switch (componentType) {
                case "street_number":
                {
                    address1 = `${component.long_name} ${address1}`;
                    break;
                }

                case "route":
                {
                    address1 += component.short_name;
                    break;
                }

                case "postal_code":
                {
                    postcode = `${component.long_name}`;
                    break;
                }

//            case "postal_code_suffix":
//            {
//                postcode = `${postcode}`;
//                break;
//            }
                case "locality":
                    document.querySelector("#shipping_city").value = component.long_name;
                    break;
                case "administrative_area_level_1":
                {
                    console.log('stateField: ' + component.long_name);
                    shipping_stateField.value = component.long_name;
                    shipping_stateField.blur();
                    break;
                }

            }
        }

        console.log('postcode: ' + postcode);
        console.log('address1: ' + address1);

        shipping_address1Field.value = address1;
        shipping_postalField.value = postcode;
        shipping_postalField.focus();
        shipping_postalField.blur();
        // After filling the form with address components from the Autocomplete
        // prediction, set cursor focus on the second address line to encourage
        // entry of subpremise information such as apartment, unit, or floor number.
        shipping_address2Field.focus();
    }

    window.initAutocomplete = initAutocomplete;</script>
<style>
    .unstyled select, .choices__item{
        color:white;
    }
    textarea::placeholder{
        color:white;

    }
</style>
</body>

</html>
