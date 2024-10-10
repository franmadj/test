<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="shop_table woocommerce-checkout-review-order-table">
	
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="c-mini-cart <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						
						<td class="c-mini-cart__preview">
							
		                <img src="https://s3.amazonaws.com/texas-de-brazil-website/products/570x260_Red-Dining-Cards.png" class="c-mini-cart__card" alt="Standard Gift Card">
		                <span class="t-heading-six c-mini-cart__title"><?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';?>X<?php echo $cart_item['quantity'];?></span>
		           
		          </td>
		         
		          <td class="t-style-one c-mini-cart__price">
		          	<span class="t-style-one c-mini-cart__price"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span>
		          </td>
		            
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>
	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<td class="t-style-one c-adjustments__type">
				<?php _e( 'ORDER TOTAL', 'woocommerce' ); ?></td>
			<td class="t-align-right t-style-one c-adjustments__amount"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
