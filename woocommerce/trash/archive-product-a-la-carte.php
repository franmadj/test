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

global $current_category;
?>










<div class="shop-categories shop-categories-<?php echo $current_category->slug; ?>">
    <a href="/shop/" class="back-to-products">Back to shop</a>


    <div class="u-actions main-buttons">
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
    <a href = "/shop/butcher-shop/packages" class = "button button--small c-product__button cat-main-btn">Shop package-options</a>
    <h2><?php echo $current_category->slug; ?> options</h2>
    <?php
    if (woocommerce_product_loop()) {
        ?>



        <div class = "u-product-list">

            <?php
            $products = wc_get_products(array(
                'category' => array($current_category->slug),
            ));
            ?>
            <div class="product-items">
                <?php
                for ($i = 0; $i <= 7; $i++)
                    foreach ($products as $product) {
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->post->ID), 'single-post-thumbnail');
                        ?>


                        <div class="product-item" data-id="<?php echo $product->post->ID; ?>">

                            <a href = "<?php echo $product->get_permalink() ?>" >

                                <img  src = "<?php echo $image[0]; ?>" >

                            </a>
                            <div>
                                <h3><?php echo $product->get_title(); ?></h3><span>$<?php echo $product->get_price(); ?></span>
                            </div>

                            <a href = "<?php echo $product->get_permalink() ?>" class = "button button--small c-product__button">purchase</a>
                        </div>
                        <?php
                    }
                ?>
            </div>








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
