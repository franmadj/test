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
exit;
?>
<div class="shop-categories shop-categories-<?php echo $current_category->slug; ?>">
    
    <a href="/shop/" class="back-to-products">Back to shop</a>
    
    
   <!-- <div class="u-actions extra-buttons">
        
        <?php $balance = get_field('balance_page_link', 'option'); ?>
        <?php if ($balance): ?>
            <a href="https://texasdebrazil.myguestaccount.com/guest/nologin/account-balance" class="u-actions__item -balance" target="blank">
                <span class="u-actions__title">Check Balance</span>
            </a>
        <?php endif; ?>
        <a href="/recover/" class="u-actions__item -recover">
            <span class="u-actions__title">Recover Order</span>
        </a>
    </div> -->


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
     <div class="gift-black-buttons">
        <?php $balance = get_field('balance_page_link', 'option'); ?>
        <?php if ($balance): ?>
            <a href="https://texasdebrazil.myguestaccount.com/guest/nologin/account-balance" class="u-actions__item -balance" target="blank">
                <span class="u-actions__title">Check Balance</span>
            </a>
        <?php endif; ?>
        <a href="/recover/" class="u-actions__item -recover">
            <span class="u-actions__title">Recover Order</span>
        </a>
    </div> 
    
    

    <div class="o-container">
        <div class="u-product-list">

            <?php
            $products = wc_get_products(array(
                'category' => array($current_category->slug),
            ));
            



            foreach ($products as $product) {
                
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->post->ID), 'single-post-thumbnail');
                $teaser = get_field('product_teaser');
                ?>
             
                <li class="c-product">
                    <a href="<?php echo $product->get_permalink() ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link c-product">
                        <img width="283" height="180" 
                             data-cfsrc="<?php echo $image[0]; ?>" class="attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" 
                             alt="" loading="lazy" src="<?php echo $image[0]; ?>">
                        <span class="c-product__title"><?php echo $product->get_title(); ?></span></a>
                    <span class="c-product__teaser"><?php echo $teaser; ?></span>
                    <a href="<?php echo $product->get_permalink() ?>" class="button button--small c-product__button">Purchase</a>
                </li>

                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
