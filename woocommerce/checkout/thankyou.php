<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="woocommerce-order u-confirmation" style="padding:6rem;">

    <?php if ($order) : ?>

        <?php if ($order->has_status('failed')) : ?>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php _e('Pay', 'woocommerce') ?></a>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php _e('My account', 'woocommerce'); ?></a>
                <?php endif; ?>
            </p>

        <?php else : ?>

            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received u-confirmation__heading">ORDER RECEIVED!</p>
            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received u-confirmation__heading">THANK YOU FOR YOUR BUSINESS</p>
            <span class="u-confirmation__text">You order is now undergoing a routine security review.</span>
            <span class="u-confirmation__text">Most orders are processed within 15 minutes, but can take up to 24 hours.</span>
            <span class="u-confirmation__text">You order email will be sent out as soon as possible.</span>

            <div class="u-confirmation__numbers">
                <span class="u-confirmation__text small">The order refeference number is not valid for in-store redemption.</span>
                <span class="t-light-gray">Order Reference Number</span>
                <span class="t-white"><?php echo $order->get_order_number(); ?></span>
            </div>
            <a href="/shop/" class="button button--small c-product__button">To Shop Page</a>


        <?php endif; ?>

        <?php //do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );  ?>
        <?php //do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
        <?php do_action('tx_thankyou_page', $order->get_id()); ?>

    <?php else : ?>

        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received u-confirmation__heading"><?php echo apply_filters('woocommerce_thankyou_order_received_text', __('ORDER SUCCESSFULLY PLACED', 'woocommerce'), null); ?></p> 

    <?php endif; ?>

</div>

<style>
    .u-confirmation__text{
        margin-bottom: 0px;

    }
    .u-confirmation__text.small{
        font-size: 12px;
        margin-top: 26px;
        text-transform: none;
        font-family: Futura PT,futura-pt,Helvetica,sans-serif;

    }
    .u-confirmation__numbers{
        padding-top: 0;
        margin-top: 30px;

    }
</style>
