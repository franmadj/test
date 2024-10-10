<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined('ABSPATH') || exit;

get_header('shop');

?>










<div class="shop-categories">
    <a href="/shop/" class="back-to-products">Back to shop</a>

    
    <div class="u-actions">
        <a href="<?php echo wc_get_cart_url(); ?>" class="u-actions__item -cart">
            <span class="u-actions__title">Cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
        </a>

        <a href="/shop/gift-cards" class="u-actions__item -cards -shop-cats">
            <span class="u-actions__title">Gift<br>Cards</span>
        </a>
        <a href="/shop/butcher-shop/packages" class="u-actions__item -butcher -shop-cats">
            <span class="u-actions__title">butcher<br>shop</span>
        </a>
        <a href="/shop/merchandise/" class="u-actions__item -merch -shop-cats">
            <span class="u-actions__title">merch</span>
        </a>
    </div>
    <div class="woocommerce-products-header one">
        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        echo $current_category->description;
        ?>
    </div>
    <a href = "https://tdbdev.wpengine.com/shop/cards/standard-gift-card/" class = "button button--small c-product__button">Shop</a>
    <?php
    if (woocommerce_product_loop()) {
        ?>


        <div class = "woocommerce-notices-wrapper"></div>
        <div class = "o-container">
            <div class = "u-product-list">

                <li class = "c-product">
                    <h2>gift cards</h2>
                    <a href = "/shop/gift-cards" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product">
                        
                        <img width = "283" height = "180" src = "https://tdbdev.wpengine.com/wp-content/uploads/2019/05/570x260_Red-Dining-Cards.png" class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt = "Texas de Brazil Red Dining Card" loading = "lazy" srcset = "https://tdbdev.wpengine.com/wp-content/uploads/2019/05/570x260_Red-Dining-Cards.png 570w, https://tdbdev.wpengine.com/wp-content/uploads/2019/05/570x260_Red-Dining-Cards-450x284.png 450w" sizes = "(max-width: 283px) 100vw, 283px">
                        <span class = "c-product__title">Standard and eGift Cards options available</span>
                    </a>
                   
                    <a href = "https://tdbdev.wpengine.com/shop/cards/standard-gift-card/" class = "button button--small c-product__button">Shop</a>
                </li>
                
                <li class = "c-product">
                    <h2>butcher shop</h2>
                    <a href = "/shop/butcher-shop/packages" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product">
                        
                        <img width = "283" height = "180" src = "https://tdbdev.wpengine.com/wp-content/uploads/2021/01/butcher.png" 
                             class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt = "Texas de Brazil Red Dining Card" loading = "lazy">
                        <span class = "c-product__title">packages options and individual steaks available</span>
                    </a>
                   
                    <a href = "https://tdbdev.wpengine.com/shop/cards/standard-gift-card/" class = "button button--small c-product__button">Shop</a>
                </li>
                
                <li class = "c-product">
                    <h2>Merchandise</h2>
                    <a href = "/shop/merchandise" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product">
                        
                        <img width = "283" height = "180" src = "https://tdbdev.wpengine.com/wp-content/uploads/2021/01/merchandise.png" class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" 
                             alt = "Texas de Brazil Red Dining Card" loading = "lazy" >
                        <span class = "c-product__title">From T-Shirts to Grill Tongs available</span>
                    </a>
                   
                    <a href = "https://tdbdev.wpengine.com/shop/cards/standard-gift-card/" class = "button button--small c-product__button">Shop</a>
                </li>
               
            </div>
        </div>
        <img src = "/assets/img/horizontal-decorator.svg" class = "c-decorator">

        <div class = "u-good-to-know">
            <span class = "u-good-to-know__heading">Good To know</span>
            <p><strong>Gift Card Usage:<br>
                </strong>All gift cards purchased online (excluding VIP dining cards) are valid for food and beverage purchases at Texas de Brazil restaurants. Additionally, Texas de Brazil gift cards never expire, are redeemable only in the US &amp;
                Aruba* locations, are not valid for cash back, and cannot be applied towards gratuity. Please note that gift cards purchased online may not be redeemed at Texas de Brazil locations in Mexico, Panama, Puerto Rico, Qatar, Saudi Arabia, South Korea, Trinidad &amp;
                Tobago, or the United Arab Emirates.</p>
            <p>*Please note that <strong>happy dining gift cards</strong> and <strong>dine together gift card</strong>s are not valid for redemption outside the United States.</p>
            <p><strong>Payment:</strong><br>
                Our online shop only accepts Visa, Master Card, and American Express as payment methods – we do not accept Discover or any other payment methods.</p>
            <p><strong>Shipping:&nbsp;
                </strong><br>
                We ship our standard gift cards via FedEx. FedEx provides all package tracking information and is responsible for shipping.&nbsp;
                A physical address is required;
                P.O. boxes are not accepted.&nbsp;
                Please note that orders placed after 2:00 PM CST, that require shipping, will not be processed until the next business day and that our shipping methods only involve business days (Monday through Friday).</p>
        </div>

        <div class = "u-card-support">
            <span class = "t-heading-two u-card-support__heading">Gift Card Support</span>
            <span class = "button button--alternate u-card-support__call">Call +1 (214) 615-2184</span>
            <span class = "u-card-support__or">or</span>
            <a href = "/contact/" class = "button u-card-support__email">Contact a Gift Card Specialist</a>
        </div>

        <?php
    } else {
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action('woocommerce_no_products_found');
    }
    ?>
</div>
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
//do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
