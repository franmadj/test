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
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>







<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>





    <div class="c-table c-table-mobile" aria-describedby="caption" role="grid" aria-label="Cart">




        <span class="c-cart__heading">Your Cart <span class="t-light-gray"><?php
                if (WC()->cart->get_cart_contents_count()) {
                    echo '(' . WC()->cart->get_cart_contents_count() . ')';
                }
                ?>
            </span>
        </span>
        <div role="rowgroup">
            <div class="c-table__row c-table__row--header" role="row">

                <div class="c-table__item " role="columnheader"><?php esc_html_e('Item', 'woocommerce'); ?></div>

                <div class="c-table__item c-table__item--half t-align-center" role="columnheader"><?php esc_html_e('Amount', 'woocommerce'); ?></div>
                <div class="c-table__item c-table__item--half t-align-center" role="columnheader"><?php esc_html_e('Qty', 'woocommerce'); ?></div>
                <div class="c-table__item" role="columnheader"><?php esc_html_e('Recipient', 'woocommerce'); ?></div>
                <div class="c-table__item c-table__item--half t-align-right" role="columnheader">REMOVE</div>
            </div>
        </div>
        <?php do_action('woocommerce_before_cart_contents'); ?>
        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <div role="rowgroup">
                    <div class="c-table__row" role="row">
                        <div class="c-table__item c-table__item--image-container" role="cell" data-type="<?php echo $_product->get_type(); ?>">


                            <?php if ($product_id == E_VIP_DINING_CARD || 'simple' == $_product->get_type()) { ?>
                                <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'thumbnail')[0]; ?>" 
                                     class="u-item-image thumbnail-cart" title="<?php echo get_the_title($cart_item['product_id']); ?>">

                            <?php } else { ?>
                                <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($cart_item['theme_id']), 'full'); ?>

                                <?php if ($image): ?>
                                    <img src="<?php echo $image[0]; ?>" class="u-item-image" title="<?php echo get_the_title($cart_item['product_id']); ?>">
                                <?php else: ?>
                                    <img src="/assets/img/gift-card.png" class="u-item-image" title="<?php echo get_the_title($cart_item['product_id']); ?>">
                                <?php endif; ?>
                            <?php } ?>
                            <span class="u-item-title"><?php echo get_the_title($cart_item['product_id']); ?></span>
                        </div>
                        <div class="c-table__item c-table__item--half u-item-amount t-align-center" role="cell" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </div>


                        <div class="c-table__item c-table__item--half u-item-qty t-align-center" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">

                            <?php if ($product_id != EVENT_DEPOSIT): ?>
                                X<input type="number" maxlength="2" name="cart[<?php echo $cart_item_key; ?>]" class="update-cart-qty" 
                                        style="padding: 0px 4px;
                                        margin-left: 5px;
                                        width: 47px;
                                        font-size: 20px;
                                        border-radius: 4px;
                                        background: #0c0a09;
                                        color: white;"
                                        value="<?php echo $cart_item['quantity']; ?>" data-value="<?php echo $cart_item['quantity']; ?>">
                                    <?php else: ?>
                                X 1
                            <?php endif; ?>
                        </div>

                        <div role="cell" class="c-table__item c-table__item--half t-align-right">
                            <?php
                            // @codingStandardsIgnoreLine
                            echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                            '<a href="%s" role="button" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>', esc_url(wc_get_cart_remove_url($cart_item_key)), __('Remove this item', 'woocommerce'), esc_attr($product_id), esc_attr($_product->get_sku())
                                    ), $cart_item_key);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                if (in_array($product_id, [HOLIDAY_STD_GIFT_CARD, HOLIDAY_E_GIFT_CARD])) {
                    //var_dump($cart_item);
                    $bonus25Qty = ($cart_item['line_total'] / $cart_item['quantity']) / 100;
                    $left = $bonus25Qty - floor($bonus25Qty);
                    $bonus10Qty = $left == 0.5 ? 1 : 0;
                    if ($bonus25Qty >= 1) {
                        $bonus25Qty = floor($bonus25Qty) * $cart_item['quantity'];
                        ?>
                        <div role="rowgroup">
                            <div class="c-table__row" role="row" style="border-top: none;">
                                <div class="c-table__item c-table__item--image-container" role="cell" data-type="<?php echo $_product->get_type(); ?>">
                                    <img src="/assets/img/updated_tdb_bonus_card.png" class="u-item-image" title="Bonus Card" />
                                    <span class="u-item-title">Bonus Card</span>
                                </div>
                                <div class="c-table__item c-table__item--half u-item-amount t-align-center" role="cell" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>25.00</bdi></span>
                                </div>
                                <div class="c-table__item c-table__item--half u-item-qty t-align-center" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">X</span><?php echo floor($bonus25Qty); ?></bdi></span>
                                </div>
                                <div role="cell" class="c-table__item c-table__item--half t-align-right">
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    if ($bonus10Qty) {
                        $bonus10Qty = $bonus10Qty * $cart_item['quantity'];
                        ?>

                        <div role="rowgroup">
                            <div class="c-table__row" role="row" style="border-top: none;">
                                <div class="c-table__item c-table__item--image-container" role="cell" data-type="<?php echo $_product->get_type(); ?>">
                                    <img src="/assets/img/updated_tdb_bonus_card.png" class="u-item-image" title="Bonus Card" />
                                    <span class="u-item-title">Bonus Card</span>
                                </div>
                                <div class="c-table__item c-table__item--half u-item-amount t-align-center" role="cell" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>10.00</bdi></span>
                                </div>
                                <div class="c-table__item c-table__item--half u-item-qty t-align-center" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">X</span><?php echo floor($bonus10Qty); ?></bdi></span>
                                </div>
                                <div role="cell" class="c-table__item c-table__item--half t-align-right">
                                </div>
                            </div>
                        </div>


                        <?php
                    }
                }
            }
        }
        ?>
    </div>


    <div class="c-table c-table-desktop">
        <table>
            <caption>
                <span class="c-cart__heading">Your Cart <span class="t-light-gray"><?php
                        if (WC()->cart->get_cart_contents_count()) {
                            echo '(' . WC()->cart->get_cart_contents_count() . ')';
                        }
                        ?>
                    </span>
                </span>
            </caption>
            <thead>
                <tr>
                    <th scope="col"><?php esc_html_e('Item', 'woocommerce'); ?></th>
                    <th scope="col" class="amount"><?php esc_html_e('Amount', 'woocommerce'); ?></th>
                    <th scope="col" class="quantity"><?php esc_html_e('Qty', 'woocommerce'); ?></th>
                    <th scope="col" class="recipient"><?php esc_html_e('Recipient', 'woocommerce'); ?></th>
                    <th scope="col" class="action">REMOVE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                        ?>
                        <tr>
                            <td scope="row" class="item-name">


                                <?php if ($product_id == E_VIP_DINING_CARD || 'simple' == $_product->get_type()) { ?>
                                    <img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'thumbnail')[0]; ?>" class="u-item-image" title="<?php echo get_the_title($cart_item['product_id']); ?>">

                                <?php } else { ?>
                                    <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($cart_item['theme_id']), 'full'); ?>

                                    <?php if ($image): ?>
                                        <img src="<?php echo $image[0]; ?>" class="u-item-image" title="<?php echo get_the_title($cart_item['product_id']); ?>">
                                    <?php else: ?>
                                        <img src="/assets/img/gift-card.png" class="u-item-image" title="<?php echo get_the_title($cart_item['product_id']); ?>">
                                    <?php endif; ?>
                                <?php } ?>
                                <span class="u-item-title"><?php echo get_the_title($cart_item['product_id']); ?></span>
                            </td>



                            <td scope="row">
                                <?php
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                ?>
                            </td>


                            <td scope="row">


                                <?php if ($product_id != EVENT_DEPOSIT): ?>
                                    <span aria-hidden="true">X</span> <input type="number" maxlength="2" name="cart[<?php echo $cart_item_key; ?>]" class="update-cart-qty" 
                                                                             style="padding: 0px 4px;
                                                                             margin-left: 5px;
                                                                             width: 47px;
                                                                             font-size: 20px;
                                                                             border-radius: 4px;
                                                                             background: #0c0a09;
                                                                             color: white;"
                                                                             value="<?php echo $cart_item['quantity']; ?>" data-value="<?php echo $cart_item['quantity']; ?>">
                                                                         <?php else: ?>
                                    <span style="display: block;padding-right: 44px;">X <span style="font-size: 20px;">1</span></span>
                                <?php endif; ?>

                            </td>
                            <td scope="row">
                                <?php
                                //63786,700
                                if (!in_array($product_id, [HOLIDAY_STD_GIFT_CARD, STD_GIFT_CARD, STD_VIP_DINING_CARD]))
                                    if ($product_id == E_GIFT_CARD || $product_id == HOLIDAY_E_GIFT_CARD || $product_id == E_VIP_DINING_CARD) {
                                        if ($cart_item['isGiftCard'] == 'No') {
                                            echo "Send to billing email address";
                                        } else {
                                            echo $cart_item['user_email'];
                                        }
                                    } else {
                                        echo "Send to billing address";
                                    }
                                ?> 
                            </td>
                            <td scope="row">
                                <?php
                                // @codingStandardsIgnoreLine
                                echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                                '<a href="%s" role="button" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>', esc_url(wc_get_cart_remove_url($cart_item_key)), __('Remove this item', 'woocommerce'), esc_attr($product_id), esc_attr($_product->get_sku())
                                        ), $cart_item_key);
                                ?>
                            </td>
                        </tr>

                        <?php
                        if (in_array($product_id, [HOLIDAY_STD_GIFT_CARD, HOLIDAY_E_GIFT_CARD])) {
                            //var_dump($cart_item);
                            $bonus25Qty = ($cart_item['line_total'] / $cart_item['quantity']) / 100;
                            $left = $bonus25Qty - floor($bonus25Qty);
                            $bonus10Qty = $left == 0.5 ? 1 : 0;
                            if ($bonus25Qty >= 1) {
                                $bonus25Qty = floor($bonus25Qty) * $cart_item['quantity'];
                                ?>
                                <tr>
                                    <td scope="row" class="item-name">
                                        <img src="/assets/img/updated_tdb_bonus_card.png" class="u-item-image" title="Bonus Card" />
                                        <span class="u-item-title">Bonus Card</span>
                                    </td>
                                    <td scope="row">

                                        <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>25.00</bdi></span>

                                    </td>
                                    <td scope="row">

                                        <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">X</span><?php echo floor($bonus25Qty); ?></bdi></span>
                                    </td>
                                    <td scope="row"></td>
                                    <td scope="row"></td>
                                </tr>
                                <?php
                            }
                            if ($bonus10Qty) {
                                $bonus10Qty = $bonus10Qty * $cart_item['quantity'];
                                ?>
                                <tr>
                                    <td scope="row" class="item-name">
                                        <img src="/assets/img/updated_tdb_bonus_card.png" class="u-item-image" title="Bonus Card" />
                                        <span class="u-item-title">Bonus Card</span>
                                    </td>
                                    <td scope="row">
                                        <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>10.00</bdi></span>
                                    </td>
                                    <td scope="row">
                                        <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">X</span><?php echo floor($bonus10Qty); ?></bdi></span>
                                    </td>
                                    <td scope="row"></td>
                                    <td scope="row"></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
            </tbody>





        </table>
    </div>








    <?php do_action('woocommerce_cart_contents'); ?>

    <div class="u-cart-postmatter">
        <div class="u-promotion" >

            <?php if (wc_coupons_enabled()) { ?>
                <div class="coupon u-coupon-form">
                    <label class="t-heading-five u-order-heading" for="coupon_code"><?php esc_html_e('PROMOTION CODE:', 'woocommerce'); ?></label> <input type="text" name="coupon_code" class="input-text u-force-height" id="coupon_code" value="" placeholder="<?php esc_attr_e('Code...', 'woocommerce'); ?>" /> <button type="submit" class="u-coupon-button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Redeem', 'woocommerce'); ?></button>
                    <?php do_action('woocommerce_cart_coupon'); ?>
                </div>
            <?php } ?>



            <?php do_action('woocommerce_cart_actions'); ?>

            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </div>
    </div>

    <?php do_action('woocommerce_after_cart_contents'); ?>

    <?php do_action('woocommerce_after_cart_table'); ?>
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
        do_action('woocommerce_cart_collaterals');
        ?>
    </div>
</div>
<?php do_action('woocommerce_after_cart'); ?>
