<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */
defined('ABSPATH') || exit;
?>
<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */
defined('ABSPATH') || exit;
global $requiresShiping;
?>


<?php
if (true === WC()->cart->needs_shipping_address()) :

    $form_data = array_map(function($value) {
        //error_log('$value: '. print_r($value,true));
        if (is_array($value))
            return '';
        return stripcslashes($value);
    }, $_POST);
    ?>
    <div class="woocommerce-shipping-fields">
        <?php if (true === WC()->cart->needs_shipping_address()) : ?>
            <div class="shipping_address c-box">

                <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

                <div class="woocommerce-shipping-fields__field-wrapper" data-ref="shippingAddress">
                    <h2 class="t-heading-five t-white c-box__heading">Shipping Details</h2>
                    <div class="fields-group">

                        <div class="tx-form-group tx-form-group-full">
                            <label for="shipping_first_name">First Name</label>
                            <input type="text" id="shipping_first_name" name="shipping_first_name" placeholder="Enter First Name" class="c-box__input" required 
                                   value="<?php echo isset($form_data['shipping_first_name']) ? $form_data['shipping_first_name'] : ''; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>
                        <div class="tx-form-group tx-form-group-full">
                            <label for="shipping_last_name">Last Name</label>
                            <input type="text" id="shipping_last_name" name="shipping_last_name" placeholder="Enter Last Name" class="c-box__input" required 
                                   value="<?php echo isset($form_data['shipping_last_name']) ? $form_data['shipping_last_name'] : ''; ?>">
                            <span aria-hidden='true'>*</span>
                        </div>

                        <div class="tx-form-group tx-form-group-full">
                            <label for="shipping_address_1">Address Line 1</label>
                            <input type="text" id="shipping_address_1" name="shipping_address_1" placeholder="Street Address" class="c-box__input"  
                                   value="<?php echo isset($form_data['shipping_address_1']) ? $form_data['shipping_address_1'] : ''; ?>" data-name="Address Line 1" required>
                                   <?php if (isset($form_data['place_changed'])) { ?>
                                <input type="hidden" name="place_changed" value="1">
                            <?php } ?>
                            <span aria-hidden='true'>*</span>
                        </div>

                        <div class="tx-form-group tx-form-group-full">
                            <label for="shipping_address_2">Address Line 2</label>
                            <input type="text" name="shipping_address_2" placeholder="Apt Name, Suite" class="c-box__input" 
                                   value="<?php echo isset($form_data['shipping_address_2']) ? $form_data['shipping_address_2'] : ''; ?>">
                            
                        </div>
                        <div class="tx-form-group tx-form-group-full">
                            <label for="shipping_city">City</label>
                            <input type="text" id="shipping_city" name="shipping_city" placeholder="Town / City" class="c-box__input" 
                                   value="<?php echo isset($form_data['shipping_city']) ? $form_data['shipping_city'] : ''; ?>" data-name="City" required>
                            <span aria-hidden='true'>*</span>
                        </div>


                        <div class="tx-form-group tx-form-group-full">
                            <label for="shipping_country">Contry</label>
                       
                                <select id="shipping_country" name="shipping_country" data-name="Contry" required>
                                    <?php
                                    $countries = json_decode(file_get_contents(get_template_directory() . '/assets/countries.json'));
                                    $selectedCode = isset($form_data['shipping_country']) ? $form_data['shipping_country'] : 'US';
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
                            <label for="shipping_postcode">Postal Code / Zip</label>
                            <input type="text" id="shipping_postcode" name="shipping_postcode" placeholder="Postal Code / Zip" class="c-box__input" 
                                   value="<?php echo isset($form_data['shipping_postcode']) ? $form_data['shipping_postcode'] : ''; ?>" data-name="Zip Code" data-ref="updateAddress" required>
                            <span aria-hidden='true'>*</span>
                        </div>


                        <div class="tx-form-group tx-form-group-full select-billing-state">
                            <label for="shipping_state">State</label>

                            <select id="shipping_state" name="shipping_state" data-name="Shipping State" data-ref="shippingState" required="">
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
                            <label for="shipping_phone">Phone</label>
                            <input type="text" name="shipping_phone" maxlength="10" placeholder="Phone" class="c-box__input" 
                                   value="<?php echo isset($form_data['shipping_phone']) ? $form_data['shipping_phone'] : ''; ?>" data-ref="updateAddress" data-name="Phone" required>

                        </div>







                        <div class="tx-form-group tx-form-group-full">
                            <label for="order_comments">Message</label>
                            <div class="c-box__col u-message">
                                <textarea name="order_comments" class="c-box__textarea" id="order_comments" maxlength="100" placeholder="Your Message" rows="2" cols="5"></textarea>
                                <span class="u-chars u-chars-count">0/100</span>
                            </div>
                        </div>
                    </div>
                </div>

                <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>

            </div>



        <?php endif; ?>
    </div>

<?php endif; ?>


<div class="c-box pb-0">

    <div class="woocommerce-additional-fields">
        <?php do_action('woocommerce_before_order_notes', $checkout); ?>

        <?php if (apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) : ?>

            <?php if (!WC()->cart->needs_shipping() || wc_ship_to_billing_address_only()) : ?>

                <h3><?php esc_html_e('Additional information', 'woocommerce'); ?></h3>

            <?php endif; ?>

            <div class="woocommerce-additional-fields__field-wrapper">
                <?php foreach ($checkout->get_checkout_fields('order') as $key => $field) : ?>
                    <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

        <?php do_action('woocommerce_after_order_notes', $checkout); ?>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
<?php if (true === WC()->cart->needs_shipping_address()) : ?>
            let needs_shipping = true;
            $('#place_order').click(function () {
                if (!$('#ship-to-different-address-checkbox').is(':checked')) {
                    if ($('#billing_country').val() != 'US') {
                        alert('We do not ship the standard gift cards internationally. Please go add a digital e-gift card to your cart and checkout again.');
                        return false;
                    }
                } else {
                    if ($('#shipping_country').val() != 'US') {
                        alert('We do not ship the standard gift cards internationally. Please go add a digital e-gift card to your cart and checkout again.');
                        return false;
                    }
                }
            })
<?php else: ?>
            let needs_shipping = false;
<?php endif; ?>

        $('#billing_country').change(function () {
            console.log($('#ship-to-different-address-checkbox').is(':checked'));
            if ($(this).val() != 'US') {
                $('.select-billing-state').hide();
            } else {
                $('.select-billing-state').show();
            }
        });
        $('#shipping_country').change(function () {
            console.log($('#ship-to-different-address-checkbox').is(':checked'));
            if ($(this).val() != 'US') {
                $('.select-shipping-state').hide();
            } else {
                $('.select-shipping-state').show();
            }
        });




    });
</script>
