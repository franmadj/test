<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

//do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="c-table">
	<span class="c-cart__heading">Your Cart <span class="t-light-gray"><?php if(WC()->cart->get_cart_contents_count()){ echo '('.WC()->cart->get_cart_contents_count().')';} ?></span></span>
	<div class="c-table__row c-table__row--header">
				
				<div class="c-table__item "><?php esc_html_e( 'Item', 'woocommerce' ); ?></div>
				
				<div class="c-table__item c-table__item--half t-align-center"><?php esc_html_e( 'Amount', 'woocommerce' ); ?></div>
				<div class="c-table__item c-table__item--half t-align-center"><?php esc_html_e( 'Qty', 'woocommerce' ); ?></div>
				<div class="c-table__item"><?php esc_html_e( 'Recipient', 'woocommerce' ); ?></div>
				<div class="c-table__item c-table__item--half t-align-right">REMOVE</div>
			</div>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>
			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<div class="c-table__row">
						<div class="c-table__item c-table__item--image-container">
						<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id($cart_item['theme_id']), 'full' );?>
						
						<?php if($image):?>
						<img src="<?php echo $image[0];?>" class="u-item-image" title="<?php echo get_the_title($cart_item['product_id']);?>">
						<?php else:?>
							<img src="/assets/img/gift-card.png" class="u-item-image" title="<?php echo get_the_title($cart_item['product_id']);?>">
						<?php endif;?>
						<span class="u-item-title"><?php echo get_the_title($cart_item['product_id']);?></span>
						</div>

						

						<div class="c-table__item c-table__item--half u-item-amount t-align-center" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</div>

						<div class="c-table__item c-table__item--half u-item-qty t-align-center" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
							X<?php echo $cart_item['quantity'];?>
						</div>
						<div class="c-table__item u-item-address t-align-center">
							<?php 
							if($product_id == 653 || $product_id == 63778){
							if($cart_item['isGiftCard'] == 'No'){
								echo "Send to billing email address";
							}else{
								echo $cart_item['user_email'];
							}
							}else{
								echo "Send to billing address";
							}
							?> 
						</div>
						<div class="c-table__item c-table__item--half t-align-right">
							<?php
								// @codingStandardsIgnoreLine
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</div>
					</div>
					<?php
				}
			}
			?>
</div>
			<?php do_action( 'woocommerce_cart_contents' ); ?>

		<div class="u-cart-postmatter">
				<div class="u-promotion">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon u-coupon-form">
							<label class="t-heading-five u-order-heading" for="coupon_code"><?php esc_html_e( 'PROMOTION CODE:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text u-force-height" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Code...', 'woocommerce' ); ?>" /> <button type="submit" class="u-coupon-button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Redeem', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</div>
			</div>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>
<div class="u-cart-postmatter">
<div class="c-adjustments u-padding-bottom">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
