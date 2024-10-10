<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout form-with-labels" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <?php if ($checkout->get_checkout_fields()) : ?>

        <?php
        do_action('woocommerce_checkout_before_customer_details');
        $form_data = array_map(function($value) {
            //error_log('$value: '. print_r($value,true));
            if (is_array($value))
                return '';
            return stripcslashes($value);
        }, $_POST);
        ?>

        <div class="col2-set u-checkout__grid" id="customer_details">
            <div class="col-1 u-checkout__col">
                <div class="c-box" data-ref="billingAddress">
                    <span class="t-heading-five t-white c-box__heading">Billing Details</span>

                    <div class="fields-group">

                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_first_name">First Name</label>
                            <input type="text" id="billing_first_name" name="billing_first_name" placeholder="Enter First Name" class="c-box__input" required 
                                   value="<?php echo isset($form_data['billing_first_name']) ? $form_data['billing_first_name'] : ''; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>
                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_last_name">Last Name</label>
                            <input type="text" id="billing_last_name" name="billing_last_name" placeholder="Enter Last Name" class="c-box__input" required 
                                   value="<?php echo isset($form_data['billing_last_name']) ? $form_data['billing_last_name'] : ''; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>

                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_email">Email</label>
                            <input type="email" id="billing_email" name="billing_email" placeholder="Enter Your Email" class="c-box__input" required data-name="Email" data-ref="updateEmail"
                                   value="<?php echo isset($form_data['billing_email']) ? $form_data['billing_email'] : ''; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>
                        <div class="tx-form-group tx-form-group-full">
                            <label for="repeat_billing_email">Confirm Email</label>
                            <input type="email" id="repeat_billing_email" name="repeat_billing_email" placeholder="Confirm Email" class="c-box__input" required data-name="Email" data-ref="updateEmail"
                                   value="<?php echo isset($form_data['repeat_billing_email']) ? $form_data['repeat_billing_email'] : ''; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>



                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_address_1">Address Line 1</label>
                            <input type="text" id="billing_address_1" name="billing_address_1" placeholder="Street Address" class="c-box__input"  
                                   value="<?php echo isset($form_data['billing_address_1']) ? $form_data['billing_address_1'] : ''; ?>" data-name="Address Line 1" required>
                                   <?php if (isset($form_data['place_changed'])) { ?>
                                <input type="hidden" name="place_changed" value="1">
                            <?php } ?>
                            <span aria-hidden='true'>*</span>
                        </div>

                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_address_2">Address Line 2</label>
                            <input type="text" name="billing_address_2" placeholder="Apt Name, Suite" class="c-box__input" 
                                   value="<?php echo isset($form_data['billing_address_2']) ? $form_data['billing_address_2'] : ''; ?>">

                        </div>

                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_city">City</label>
                            <input type="text" id="billing_city" name="billing_city" placeholder="Town / City" class="c-box__input" 
                                   value="<?php echo isset($form_data['billing_city']) ? $form_data['billing_city'] : ''; ?>" data-name="City" required>
                            <span aria-hidden='true'>*</span>
                        </div>



                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_country">Contry</label>

                            <select id="billing_country" name="billing_country" data-name="Contry" required>
                                <?php
                                $countries = json_decode(file_get_contents(get_template_directory() . '/assets/countries.json'));
                                $selectedCode = isset($form_data['billing_country']) ? $form_data['billing_country'] : 'US';
                                foreach ($countries as $contry) {
                                    $selected = '';
                                    if ($contry->code == $selectedCode)
                                        $selected = 'selected="selected"';
                                    echo '<option value="' . $contry->code . '" ' . $selected . '>' . $contry->name . '</option>';
                                }
                                ?>
                            </select>

                            <span aria-hidden='true'>*</span>


                        </div>

                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_postcode">Postal Code / Zip</label>
                            <input type="text" id="billing_postcode" name="billing_postcode" placeholder="Postal Code / Zip" class="c-box__input" 
                                   value="<?php echo isset($form_data['billing_postcode']) ? $form_data['billing_postcode'] : ''; ?>" data-name="Zip Code" data-ref="updateAddress" required>
                            <span aria-hidden='true'>*</span>
                        </div>


                        <div class="tx-form-group tx-form-group-full select-billing-state">
                            <label for="billing_state">State</label>

                            <select id="billing_state" name="billing_state" data-name="Billing State" data-ref="billingState" required="">
                                <option>State</option>
                                <option value="Alabama">Alabama</option>
                                <option value="Alaska">Alaska</option>
                                <option value="Arizona">Arizona</option>
                                <option value="Arkansas">Arkansas</option>
                                <option value="California">California</option>
                                <option value="Colorado">Colorado</option>
                                <option value="Connecticut">Connecticut</option>
                                <option value="Delaware">Delaware</option>
                                <option value="District of Columbia">District of Columbia</option>
                                <option value="Florida">Florida</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Idaho">Idaho</option>
                                <option value="Illinois">Illinois</option>
                                <option value="Indiana">Indiana</option>
                                <option value="Iowa">Iowa</option>
                                <option value="Kansas">Kansas</option>
                                <option value="Kentucky">Kentucky</option>
                                <option value="Louisiana">Louisiana</option>
                                <option value="Maine">Maine</option>
                                <option value="Maryland">Maryland</option>
                                <option value="Massachusetts">Massachusetts</option>
                                <option value="Michigan">Michigan</option>
                                <option value="Minnesota">Minnesota</option>
                                <option value="Mississippi">Mississippi</option>
                                <option value="Missouri">Missouri</option>
                                <option value="Montana">Montana</option>
                                <option value="Nebraska">Nebraska</option>
                                <option value="Nevada">Nevada</option>
                                <option value="New Hampshire">New Hampshire</option>
                                <option value="New Jersey">New Jersey</option>
                                <option value="New Mexico">New Mexico</option>
                                <option value="New York">New York</option>
                                <option value="North Carolina">North Carolina</option>
                                <option value="North Dakota">North Dakota</option>
                                <option value="Ohio">Ohio</option>
                                <option value="Oklahoma">Oklahoma</option>
                                <option value="Oregon">Oregon</option>
                                <option value="Pennsylvania">Pennsylvania</option>
                                <option value="Rhode Island">Rhode Island</option>
                                <option value="South Carolina">South Carolina</option>
                                <option value="South Dakota">South Dakota</option>
                                <option value="Tennessee">Tennessee</option>
                                <option value="Texas">Texas</option>
                                <option value="Utah">Utah</option>
                                <option value="Vermont">Vermont</option>
                                <option value="Virginia">Virginia</option>
                                <option value="Washington">Washington</option>
                                <option value="West Virginia">West Virginia</option>
                                <option value="Wisconsin">Wisconsin</option>
                                <option value="Wyoming">Wyoming</option>
                            </select>

                            <span aria-hidden='true'>*</span>


                        </div>
                        <div class="tx-form-group tx-form-group-full">
                            <label for="billing_phone">Phone</label>
                            <input type="text" name="billing_phone" maxlength="10" placeholder="Phone" class="c-box__input" 
                                   value="<?php echo isset($form_data['billing_phone']) ? $form_data['billing_phone'] : ''; ?>" data-ref="updateAddress" data-name="Phone" required>

                        </div>


                        <?php if (true === WC()->cart->needs_shipping_address()) : ?>

                            <div class="tx-form-group tx-form-group-full">
                                <label for="set-signature">Signature Option</label>
                                <select id="set-signature" name="signature" class="c-box__input" data-name="Signature Option" required="">
                                    <option value="" disabled selected>Signature Option</option>
                                    <option value="Signature Required">Signature Required (Aditional cost)</option>
                                    <option value="No Signature Required">No Signature</option>
                                </select>
                                <span aria-hidden='true'>*</span>
                            </div>

                        <?php endif; ?>



                    </div>


                    <?php if (true === WC()->cart->needs_shipping_address()) :  global $requiresShiping; $requiresShiping=true; ?>



                        <div class="u-form-check u-billing-address-input">
                            <span id="ship-to-different-address">
                                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                    <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" 
                                    <?php
                                    $checked = empty($_POST) || (isset($_POST['ship_to_different_address']) && $_POST['ship_to_different_address'] == 0);
                                    checked($checked, 1, true);
                                    ?> 
                                           type="checkbox" name="ship_to_different_address" value="1" /> 
                                    <span role="button" class="u-form-check__label u-conditions-text"><?php esc_html_e('Click to ship as a gift or to a different address', 'woocommerce'); ?></span>
                                </label>
                            </span>
                        </div>
                        <script>
                            jQuery(document).ready(function ($) {



                                $("#set-signature").on("change", function () {
                                    jQuery.ajax({
                                        type: "post",
                                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                        data: "action=set_additional_charge_fee&signature=" + $(this).val() + "&nonce=<?php echo wp_create_nonce('set_charge-nonce'); ?>",
                                        success: function (result) {
                                            jQuery('body').trigger('init_checkout');
                                        }
                                    });
                                });

        <?php if (!empty($form_data['signature'])) { ?>
                                    setTimeout(function () {
                                        //$('[data-value="<?php echo $form_data['signature']; ?>"]').click()
                                        $("#set-signature")
                                                .html('<option value="<?php echo $form_data['signature']; ?>" selected=""><?php echo $form_data['signature']; ?></option>')
                                                .val('<?php echo $form_data['signature']; ?>')
                                                .next().html('<div class="choices__item choices__item--selectable" data-item="" data-id="6" data-value="<?php echo $form_data['signature']; ?>" aria-selected="true"><?php echo $form_data['signature']; ?></div>')
                                        console.log($("#set-signature").val());
                                        $("#set-signature").change();
                                    }, 1000)


        <?php } ?>
                            });
                        </script>

                    <?php endif; ?>

                </div>

                <script>
                    jQuery(document).ready(function ($) {
                        <?php if (!empty($form_data['billing_state'])) { ?>
                            $('#billing_state').val('<?php echo $form_data['billing_state']; ?>');
                        <?php } ?>

                    });
                </script>


                <div class="shipping-form" data-ref="shippingAddress">
                    <?php //if ($requiresShiping) { ?>
                    <?php do_action('woocommerce_checkout_shipping'); ?>
                    <?php //}    ?>
                    <p class="disclaimer">By providing your information, you agree to be contacted about this order as needed.</p>

                </div>
                <script>
                    jQuery(document).ready(function ($) {

    <?php if (!empty($form_data['shipping_state'])) { ?>

                            $('#shipping_state').val('<?php echo $form_data['shipping_state']; ?>');


    <?php } ?>


                    });
                </script>


            </div>

            <div class="col-2 u-checkout__col">
                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
                <?php do_action('woocommerce_review_order_before_submit'); ?>
                <div class="u-form-check mt-0 mb-2">
                    <input type="checkbox" name="optMarketing" id="optMarketing" class="u-form-check__input" data-ref="optDealsMarketing" value="1" checked="">
                    <label for="optMarketing" class="t-heading-five u-conditions-text u-form-check__label">Opt-In to Receive Exclusive Deals, News, and Offers Via Email</label>

                </div>
                <div class="opt-message">
                    <p>We respect your privacy and will never rent or sell your information. Must be 13 years or older to join/participate. By providing your email address you are opting-in to receive email from our company, and you may ask to stop receiving emails from us at any time.</p>
                </div>
                <?php $order_button_text = "Place order"; ?>
                <?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // @codingStandardsIgnoreLine      ?>

                <?php do_action('woocommerce_review_order_after_submit'); ?>

                <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>

            </div>
        </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

    <?php endif; ?>





</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
<style>
    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first{
        padding: 0;
        margin-bottom: 0;

    }
    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first .input-text{
        padding: 10px;
        letter-spacing: -1px;
        color:rgb(67, 69, 75);
    }
    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first .input-text:placeholder,
    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first .input-text::-webkit-input-placeholder,
    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first .input-text::-moz-placeholder,
    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first .input-text:-ms-input-placeholder,
    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first .input-text:-moz-placeholder {
        color: #000;
        font-weight: 800;
    }

    .woocommerce-checkout #payment div.payment_box #wc-cybersource-credit-card-credit-card-form .form-row-first .input-text{
        font-family:Arial;
        font-size: 24px;
        padding: 11px 8.832px !important;
    }

    .shipping-form .disclaimer{
        color: #000;
        font-size: 12px;
        line-height: 1.5;
    }
    #wc-cybersource-credit-card-credit-card-form {
        border: none;
    }
</style>
