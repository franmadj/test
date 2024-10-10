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
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="shop_table woocommerce-checkout-review-order-table">

    <?php
    do_action('woocommerce_review_order_before_cart_contents');

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        //var_dump($_product->id);

        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
            ?>
            <div class="c-mini-cart <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>"
                 <?php if (in_array($cart_item['product_id'], [HOLIDAY_STD_GIFT_CARD, HOLIDAY_E_GIFT_CARD])) { ?> style="border-bottom:none;" <?php } ?> >

                <div class="c-mini-cart__preview wc-preview-image">
                    <?php
                    //var_dump($_product);
                    if (!empty($cart_item['theme_id']) && $_product->id != 23574 && 'simple' != $_product->get_type()) :
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($cart_item['theme_id']), 'thumbnail');
                    else:
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($cart_item['product_id']), 'thumbnail');
                    endif;
                    ?>
                    <?php if ($image): ?>
                        <img src="<?php echo $image[0]; ?>" class="c-mini-cart__card" title="<?php echo get_the_title($cart_item['product_id']); ?>">
                    <?php else: ?>
                        <img src="/assets/img/gift-card.png" class="c-mini-cart__card" title="<?php echo get_the_title($cart_item['product_id']); ?>">
                    <?php endif; ?>

                    <span class="t-heading-six c-mini-cart__title"><?php echo get_the_title($cart_item['product_id']) . '&nbsp;'; ?>X&nbsp;<?php echo $cart_item['quantity']; ?></span>

                </div>

                <div class="t-style-one c-mini-cart__price">
                    <span class="t-style-one c-mini-cart__price"><?php echo $_product->get_price_html(); ?></span>
                </div>
            </div>

            <?php
            if (in_array($cart_item['product_id'], [HOLIDAY_STD_GIFT_CARD, HOLIDAY_E_GIFT_CARD])) {
                //var_dump($cart_item);
                $bonus25Qty = ($cart_item['line_total'] / $cart_item['quantity']) / 100;
                $left = $bonus25Qty - floor($bonus25Qty);
                $bonus10Qty = $left == 0.5 ? 1 : 0;



                if ($bonus25Qty >= 1) {
                    $bonus25Qty = floor($bonus25Qty) * $cart_item['quantity'];
                    ?>
                    <div class="c-mini-cart cart_item"
                         <?php if ($bonus10Qty) { ?> style="border-bottom:none;" <?php } ?> >
                        <div class="c-mini-cart__preview wc-preview-image">
                            <img src="/assets/img/updated_tdb_bonus_card.png" class="c-mini-cart__card" title="Bonus Card" />
                            <span class="t-heading-six c-mini-cart__title">Bonus Card X <?php echo floor($bonus25Qty); ?></span>
                        </div>
                        <div class="t-style-one c-mini-cart__price">
                            <span class="t-style-one c-mini-cart__price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>25.00</bdi></span></span>
                        </div>
                    </div>
                    <?php
                }
                if ($bonus10Qty) {
                    $bonus10Qty = $bonus10Qty * $cart_item['quantity'];
                    ?>

                    <div class="c-mini-cart cart_item">
                        <div class="c-mini-cart__preview wc-preview-image">
                            <img src="/assets/img/updated_tdb_bonus_card.png" class="c-mini-cart__card" title="Bonus Card" />
                            <span class="t-heading-six c-mini-cart__title">Bonus Card X <?php echo floor($bonus10Qty); ?></span>
                        </div>
                        <div class="t-style-one c-mini-cart__price">
                            <span class="t-style-one c-mini-cart__price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>10.00</bdi></span></span>
                        </div>
                    </div>


                    <?php
                }
            }
            ?>


            <?php if (in_array($cart_item['product_id'], [E_GIFT_CARD, HOLIDAY_E_GIFT_CARD, E_VIP_DINING_CARD]) && $cart_item['isGiftCard'] == "Yes"): ?>

                <div>
                    <div style="border-top:none;padding: 0 12px;">
                        <span class="t-heading-six c-mini-cart__title" style="margin-left: 0;">
                            Recipient
                        </span>
                    </div>
                </div>
                <div>
                    <div style="border-top:none;padding: 0 12px;margin-bottom: 26px;">
                        <span class="t-heading-six c-mini-cart__title" style="margin-left: 0;">
                            <?php echo $cart_item['firstname']; ?>
                            <?php echo $cart_item['lastname']; ?><br />
                            <?php echo $cart_item['user_email']; ?><br />
                            <?php echo $cart_item['message']; ?>
                        </span>
                    </div>
                </div>

            <?php endif; ?>

            <?php
            do_action('tx_after_checkout_order_review_item', $cart_item);
        }
    }

    do_action('woocommerce_review_order_after_cart_contents');
    ?>



    <div>

        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                <div><?php wc_cart_totals_coupon_label($coupon); ?></div>
                <div><?php wc_cart_totals_coupon_html($coupon); ?></div>
            </div>
        <?php endforeach; ?>

        <?php
        $product_array = array();
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
            $product_array[] = $cart_item['product_id'];
        endforeach;
        if (in_array(STD_GIFT_CARD, $product_array) || in_array(HOLIDAY_STD_GIFT_CARD, $product_array) || in_array(STD_VIP_DINING_CARD, $product_array)):
            //if (in_array(700, $product_array) || in_array(63786, $product_array)):
            ?>

            <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

                <?php do_action('woocommerce_review_order_before_shipping'); ?>

                <?php wc_cart_totals_shipping_html(); ?>

                <?php do_action('woocommerce_review_order_after_shipping'); ?>

            <?php endif; ?>

        <?php endif; ?>

        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
            <div class="fee">
                <div><?php echo esc_html($fee->name); ?></div>
                <td><?php wc_cart_totals_fee_html($fee); ?></div>
        </div>
    <?php endforeach; ?>

    <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
        <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
            <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
                <div class="tax-rate tax-rate-<?php echo sanitize_title($code); ?>">
                    <div><?php echo esc_html($tax->label); ?></div>
                    <div><?php echo wp_kses_post($tax->formatted_amount); ?></div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="tax-total">
                <div><?php echo esc_html(WC()->countries->tax_or_vat()); ?></div>
                <div><?php wc_cart_totals_taxes_total_html(); ?></div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php do_action('woocommerce_review_order_before_order_total'); ?>

    <div class="order-total <?php
    if (texaswp_cart_is_digital()) {
        echo 'no-border-top';
    }
    ?>">
        <div class="t-style-one c-adjustments__type">
            <?php _e('ORDER TOTAL', 'woocommerce'); ?></div>
        <div class="t-align-right t-style-one c-adjustments__amount"><?php wc_cart_totals_order_total_html(); ?></div>
    </div>

    <?php do_action('woocommerce_review_order_after_order_total'); ?>

</div>




</div>

<style>
    .c-mini-cart__preview .c-mini-cart__card{
        width: 63px;
        height: 45px;

    }
    .c-mini-cart.cart_item{
        display: flex;
        margin: 20px 0;
        border-bottom: 1px solid rgba(0,0,0,.1);
        min-height: 72px;
    }
    .c-mini-cart.cart_item div{
        display: flex;
        align-items: center;
    }
    .t-heading-five.shipping-title{
        display: block;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(0,0,0,.1);
        margin-bottom: 15px;
    }
    .order-total{
        display: flex;
        min-height: 46px;
        padding-top: 15px;
        border-top: 1px solid rgba(0,0,0,.1);
        margin: 15px 0;
    }
    .no-border-top{
        border-top: none;
    }
</style>
