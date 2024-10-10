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

defined( 'ABSPATH' ) || exit;
?>
<div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
	<div class="shipping_address ">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper c-box" data-ref="shippingAddress">
				<span class="t-heading-five t-white c-box__heading">Shipping Details</span>
				<div class="c-box__col">
          <input type="text" name="shipping_first_name" placeholder="First Name" class="c-box__input" data-name="First Name" value="" required="">
          <input type="text" name="shipping_last_name" placeholder="Last Name" class="c-box__input" data-name="Last Name" value="" required="">
        </div>
        <div class="c-box__col">
           <input type="email" name="shipping_email" placeholder="Email" class="c-box__input" value="customerrelations@texasdebrazil.com">
        </div>
        <div class="c-box__col c-box__col--shortened">
          <input type="text" name="shipping_address_1" placeholder="Street Address" class="c-box__input" data-name="Address Line 1" value="" required="">
          <input type="text" name="shipping_address_2" placeholder="Apt Name, Suite" class="c-box__input" value="">
        </div>
        <div class="c-box__col">
          <input type="text" name="shipping_city" placeholder="Town / City" class="c-box__input" data-name="City" value="" required="">
        </div>
        <div class="c-box__col c-box__col--shortened">
          <div class="unstyled c-box__input">
            <select name="shiping_state" aria-label="State" data-name="Billing State" data-ref="billingState" data-ignore="true" required="">
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
          </div>
          <input type="text" name="shipping_postcode" placeholder="Postal Code / Zip" class="c-box__input" data-name="Zip Code" value="" data-ref="updateAddress" required>
        </div>
        <div class="c-box__col">
          <input type="text" name="shipping_phone" maxlength="10" placeholder="Phone" class="c-box__input" value="" data-ref="updateAddress">
        </div>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>

