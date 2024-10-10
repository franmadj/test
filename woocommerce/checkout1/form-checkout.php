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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<form name="checkout" method="post" class="checkout woocommerce-checkout " action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set u-checkout__grid" id="customer_details">
			<div class="col-1 u-checkout__col">
				<div class="c-box" data-ref="billingAddress">
          <span class="t-heading-five t-white c-box__heading">Billing Details</span>
          <div class="c-box__col">
            <input type="text" name="billing_first_name" placeholder="First Name" aria-label="firstName" class="c-box__input" data-ref="name" data-reference="cardFirst" value="" data-name="First Name" required>
            <input type="text" name="billing_last_name" placeholder="Last Name" aria-label="lastName" class="c-box__input" data-ref="name" data-reference="cardLast" value="" data-name="Last Name" required>
          </div>
          <div class="c-box__col">
            <input type="email" name="billing_email" placeholder="Email" aria-label="Email" class="c-box__input" value="" data-name="Email" data-ref="updateEmail" required>
          </div>
          <div class="c-box__col">
            <input type="text" name="billing_company" placeholder="Company" aria-label="Company" class="c-box__input" value="">
          </div>
          <div class="c-box__col c-box__col--shortened">
            <input type="text" name="billing_address_1" aria-label="address1" placeholder="Street Address" class="c-box__input" value="" data-name="Address Line 1" required>
            <input type="text" name="billing_address_2" aria-label="address2" placeholder="Apt Name, Suite" class="c-box__input" value="">
          </div>
          <div class="c-box__col">
            <input type="text" name="billing_city" aria-label="City" placeholder="Town / City" class="c-box__input" value="" data-name="City" required>
            <input type="hidden" name="billing_country" aria-label="City" placeholder="Town / City" class="c-box__input" value="US" data-name="City" required>
          </div>
          <div class="c-box__col c-box__col--shortened">
            <div class="unstyled c-box__input">
          		<select name="billing_state" aria-label="State" data-name="Billing State" data-ref="billingState" data-ignore="true" required="">
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
            <input type="text" name="billing_postcode" placeholder="Postal Code / Zip" aria-label="Zip Code" class="c-box__input" autocomplete="user-postalZip" value="" data-name="Zip Code" data-ref="updateAddress" required>
          </div>
          <div class="c-box__col">
            <input type="text" name="billing_phone" maxlength="10" placeholder="Phone" aria-label="Phone" class="c-box__input" value="" data-ref="updateAddress" data-name="Phone" required>
            <select name="fields[signatureOption]" class="c-box__input" data-name="Signature Option" {% if shippingRequired %}required{% endif %}>
                <option value="" disabled selected>Signature Option</option>
                <option value="Signature Required">Signature Required</option>
                <option value="No Signature Required">No Signature</option>
            </select>
        	</div>
        	<div class="u-form-check u-billing-address-input">
            <span id="ship-to-different-address">
							<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
								<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span class="u-form-check__label u-conditions-text"><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
							</label>
						</span>
          </div>
			</div>
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			<?php 
			$productincart =array();
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$productincart[] = $cart_item['product_id'];
					} ?>
			
			<?php if(in_array(700,$productincart)):?>
			
			<div class="c-box">
				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

				<?php endif; ?>
			</div>
		<?php endif;?>
		<?php wc_get_template( 'checkout/payment.php' ); ?>
		</div>
			<div class="col-2 u-checkout__col">
				
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>
				<?php do_action( 'woocommerce_review_order_before_submit' ); ?>
				<?php $order_button_text ="Place Order";?>
				<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

				<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

				<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

