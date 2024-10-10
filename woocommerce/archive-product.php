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


/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
//do_action('woocommerce_before_main_content');
?>










<div class="shop-categories">

    <div class="woocommerce-products-header one">
        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action('woocommerce_archive_description');
        ?>
    </div>

    <div class="u-actions main-buttons">
        <a href="<?php echo wc_get_cart_url(); ?>" class="u-actions__item -cart">
            <span class="u-actions__title">Cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
        </a>

        <a href="/shop/gift-cards" class="u-actions__item -cards -shop-cats">
            <span class="u-actions__title">Gift<br>Cards</span>
        </a>
        <a href="<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop" class="u-actions__item -butcher -shop-cats">
            <span class="u-actions__title">butcher<br>shop</span>
        </a>
        <a href="<?php echo BUTCHER_SITE_URL; ?>/shop/market" class="u-actions__item -merch -shop-cats">
            <span class="u-actions__title">Market</span>
        </a>
    </div>
    <?php
    if (woocommerce_product_loop()) {
        $thumbnail_id = get_term_meta(CATEGORY_GIFT_CARDS, 'thumbnail_id', true);
        $gift_card_image = wp_get_attachment_url($thumbnail_id);

        $thumbnail_id = get_term_meta(CATEGORY_MERCHANDISE, 'thumbnail_id', true);
        $merchandise_image = wp_get_attachment_url($thumbnail_id);

        $thumbnail_id = get_term_meta(CATEGORY_PACKAGES, 'thumbnail_id', true);
        $packages_image = wp_get_attachment_url($thumbnail_id);
        ?>


        <div class = "woocommerce-notices-wrapper"></div>
        <div class = "o-container">
            <div class = "u-product-list">

                <li class = "c-product">

                    <a href = "/shop/gift-cards" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product" aria-label="Shop Standard and Digital Options">
                        <h2 class="mb-2">gift cards</h2>
                        <img width = "283" height = "180" src = "<?php echo $gift_card_image; ?>" 
                             class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt = "Texas de Brazil Red Dining Card" loading = "lazy">
                        <span class = "c-product__title">Standard and Digital Options</span>


                        <span class = "button button--small c-product__button custom-border-bottom" >Shop</span>
                    </a>
                </li>

                <li class = "c-product">

                    <a href = "<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product" aria-label="Shop Packages & à la carte">
                        <h2 class="mb-2">tdb butcher shop</h2>
                        <img width = "283" height = "180" src = "<?php echo $packages_image; ?>" 
                             class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt = "Texas de Brazil Butcher Shop Package" loading = "lazy">
                        <span class = "c-product__title">Packages & à la carte</span>


                        <span class = "button button--small c-product__button custom-border-bottom">Shop</span>
                    </a>
                </li>

                <li class = "c-product">

                    <a href = "<?php echo BUTCHER_SITE_URL; ?>/shop/market" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product" aria-label="Shop from knives to golf balls">
                        <h2 class="mb-2">Market</h2>
                        <img width = "283" height = "180" src = "<?php echo $merchandise_image; ?>" class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" 
                             alt = "Texas de Brazil Merchandise" loading = "lazy" >
                        <span class = "c-product__title">from knives to golf balls</span>


                        <span class = "button button--small c-product__button custom-border-bottom">Shop</a>
                    </a>
                </li>

                <li class = "c-product">

                    <a href = "https://daouvineyards.com/texas-de-brazil" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product" target="blank" aria-label="Shop Collaboration with Texas de Brazil">
                        <h2 class="mb-2">DAOU WINES</h2>
                        <img width = "283" height = "180" src = "/wp-content/uploads/2021/09/DAOU.png" 
                             class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" 
                             alt = "Texas de Brazil Butcher Knife" loading = "lazy" >
                        <span class = "c-product__title">Collaboration with Texas de Brazil</span>


                        <span class = "button button--small c-product__button custom-border-bottom">Shop</span>
                    </a>
                </li>

            </div>
        </div>
        <img src = "/assets/img/horizontal-decorator.svg" class = "c-decorator" alt="">





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
<div class = "u-good-to-know">
    <?php echo get_field('good_to_know_text', 515); ?>
</div>
<style>

    .u-actions.main-buttons a.-shop-cats{
        display: flex;
        align-items: center;
        justify-content: center;

    }
    @media(max-width:999px){


        .u-actions.main-buttons {
            margin-top: 0px !important;
        }

        .main--interior{
            padding-top: 17rem;
        }
    }
</style>
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
