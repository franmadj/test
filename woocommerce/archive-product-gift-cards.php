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
$current_category = get_queried_object();
?>

<div class="shop-categories shop-categories-<?php echo $current_category->slug; ?>">

    <a href="/shop/" class="back-to-products">Back to shop</a>


    <!--    <div class="u-actions extra-buttons">
    
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

    <?php if (empty($_GET['test_boxes'])) { ?>
        <ul class="u-actions main-buttons">
            <li>
                <a href="<?php echo wc_get_cart_url(); ?>" class="u-actions__item -cart">
                    <span class="u-actions__title">Cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
                </a>
            </li>
            <li>
                <a href="/shop/gift-cards" class="u-actions__item -cards -shop-cats">
                    <span class="u-actions__title">Gift<br>Cards</span>
                </a>
            </li>
            <li>
                <a href="<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop/" class="u-actions__item -butcher -shop-cats">
                    <span class="u-actions__title">butcher<br>shop</span>
                </a>
            </li>
            <li>
                <a href="<?php echo BUTCHER_SITE_URL; ?>/shop/market" class="u-actions__item -merch -shop-cats">
                    <span class="u-actions__title">Market</span>
                </a>
            </li>
        </ul>

    <?php } else { ?>
        <div class="u-actions main-buttons">
            <a href="<?php echo wc_get_cart_url(); ?>" class="u-actions__item -cart">
                <span class="u-actions__title">Cart (<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
            </a>
            <a href="/shop/gift-cards" class="u-actions__item -cards -shop-cats">
                <span class="u-actions__title">Gift<br>Cards</span>
            </a>
            <a href="<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop/" class="u-actions__item -butcher -shop-cats">
                <span class="u-actions__title">butcher<br>shop</span>
            </a>
            <a href="<?php echo BUTCHER_SITE_URL; ?>/shop/market" class="u-actions__item -merch -shop-cats">
                <span class="u-actions__title">Market</span>
            </a>
        </div>

    <?php } ?>



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
            <a href="/balance" class="u-actions__item -balance" target="blank">
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
//            $products = wc_get_products(array(
//                'category' => array($current_category->slug),
//            ));

            $products = wc_get_products([
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'post__not_in' => array(394018,394019),
            ]);




            foreach ($products as $product) {

//                if($_GET['testingit'])
//                error_log('$product->post->post_status '.$product->post->post_status.' - current_user_can - '. print_r(!(bool)current_user_can('administrator'),true));

                if ($product->post->post_status != 'publish' && !(bool) current_user_can('administrator'))
                    continue;

                $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->post->ID), 'single-post-thumbnail');
                $teaser = get_field('product_teaser', $product->post->ID);
                ?>

                <li class="c-product" data-id="<?php echo $product->post->ID; ?>">
                    <?php
                    $out_of_stock = $product->get_stock_quantity() < 1 && $product->get_manage_stock();
                    if (!$out_of_stock) {
                        ?>
                        <a href="<?php echo $product->get_permalink() ?>" class="c-product" aria-label="Purchase <?php echo esc_attr($product->get_title()); ?>">
                            <img width="283" height="180" 
                                 data-cfsrc="<?php echo $image[0]; ?>" class="attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" 
                                 alt="<?php echo esc_attr($product->get_title()); ?>" loading="lazy" src="<?php echo $image[0]; ?>">
                            <span class="c-product__title"><?php echo $product->get_title(); ?></span>
                            <span class="c-product__teaser"><?php echo $teaser; ?></span>
                            <span class="button button--small c-product__button custom-border-bottom">Purchase</span>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo $product->get_permalink() ?>" class="c-product" aria-label="Out Of stock">
                            <img width="283" height="180" 
                                 data-cfsrc="<?php echo $image[0]; ?>" class="attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" 
                                 alt="<?php echo esc_attr($product->get_title()); ?>" loading="lazy" src="<?php echo $image[0]; ?>">
                            <span class="c-product__title"><?php echo $product->get_title(); ?></span>
                            <span class="c-product__teaser"><?php echo $teaser; ?></span>
                            <span class="button button--small c-product__button out-of-stock-button custom-border-bottom">Out Of stock</span>

                        </a>


                    <?php } ?>
                </li>

                <?php
            }
            ?>
        </div>
    </div>
</div>
<style>
    .out-of-stock-button{
        background: black;
        pointer-events: none;

    }
    .out-of-stock-button:after{
        content:'';
    }

    .gift-black-buttons{
        text-align: center;
        margin-top: -55px;
        margin-bottom: 65px;
    }
    .u-actions.main-buttons {

        padding-top: 255px;
        margin-top: -58px;
        margin-bottom: 50px;
    }
    .u-actions.main-buttons a {
        height: 68px;


    }
    .u-actions.main-buttons a.-shop-cats{
        display: flex;
        align-items: center;
        justify-content: center;

    }
    .gift-black-buttons a.u-actions__item{
        padding: 25px 63px;
        margin: 0 5px;
    } 
    .gift-black-buttons a.u-actions__item span{
        font-size: 20px;

    }

    @media(max-width:635px){
        .gift-black-buttons a.u-actions__item{
            display:block;
            margin: 5px auto;
        }
    }
    @media(max-width:600px){
        .gift-black-buttons a.u-actions__item{padding: 20px;}
    }
</style>
<?php
/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
