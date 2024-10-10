<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
//do_action( 'woocommerce_before_single_product' );

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<style>
    .tab-content{
        display: none;
    }
    .tab-content.active{
        display: block;
        margin-top: 25px;
    }

    .tab-link.active{
        background:#6e181e;

    }
    .holiday-standard-gift-cardbody--standard-card .c-current-card{
        margin-bottom: 0;
    }
    .holiday-standard-gift-cardbody--standard-card .c-card-options .c-option{
        height: 68px;
    }
    .c-option_digital{
        width: 98.5%;
    }
</style>
<?php do_action('woocommerce_before_cart'); ?>
<a href="/shop/butcher-shop/a-la-carte/" class="u-promo-back u-step-back backto-all">Back to a-la-carte Products</a>

<form class="variations_form cart variations_form-categories" action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo get_the_ID(); ?>" >
    <div class="c-page-header">
        <a href="/shop/butcher-shop/a-la-carte/" class="back-to-products-all">Back to a-la-carte Products</a>
        <h1 class="c-page-header__heading" data-ref="tabTitle">
            <?php the_title(); ?></h1>
        <!-- <span class="c-page-header__text" data-ref="tabSteps" data-template="Step {currentStep} of {totalSteps}">Step 1 of 2</span> -->
    </div>

    <div class="u-tab" <?php if (get_field('digital_product') == true): ?> data-ref="tab" data-title="Customize Your E-Gift Card" data-step="1" <?php endif; ?>>

        <div class="u-desktop-row" data-ref="desktopRow">
            <div class="u-desktop-preview">
                <?php
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                ?>
                <div class="c-current-card" style="background-image: url('<?php echo $image[0]; ?>');" data-ref="currentCard"></div>
                <div class="butcher-gallery-images">
                    <?php
                    $attachment_ids = $product->get_gallery_image_ids();

                    foreach ($attachment_ids as $attachment_id) {
                        // Display the image URL
                        //echo $Original_image_url = wp_get_attachment_url($attachment_id);
                        // Display Image instead of URL
                        echo wp_get_attachment_image($attachment_id, 'thumbnail', false, ['data-full' => wp_get_attachment_url($attachment_id)]);
                    }
                    ?>

                </div>



                <button type="submit" id="standard-card" class="button u-product-detail__confirm u-cart single_add_to_cart_button button ">Add to Cart</button>
            </div>
            <div class="c-card-options">
                <div class="c-option">
                    <span class="c-option__heading">Amount</span>
                    <div><?php echo wc_price($product->get_price()); ?></div>
                </div>
                <div class="c-option">
                    <span class="c-option__heading">Quantity</span>
                    <select name="quantity">
                        <?php foreach (range(1, 10) as $number): ?>
                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="u-card-body">
                <a href="javascript:void(0);" class="info-tab tab-link active" data-href="#info-tab">Product Info</a>
                <a href="javascript:void(0);" class="rule-tab tab-link" data-href="#rule-tab">Additional Info</a>

                <div id="info-tab" class="active tab-content">
                    <?php the_content(); ?>
                </div>
                <div id="rule-tab" class="hide-content tab-content">
                    <?php the_field('rule_of_use'); ?>
                </div>

            </div>
            
            <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID(); ?>">
            <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
            
        </div>
    </div>

    <?php $tabTitle = (get_post_field('post_name', get_the_ID()) == 'standard-card') ? 'Tell Us Where to Send This Card' : 'Almost Done — We Need More Details'; ?>

    

</form>
<script>
    var $ = jQuery.noConflict();
    var variations = {};

    $(document).ready(function () {





        $('.tab-link').on('click', function (e) {
            e.preventDefault();
            $('.tab-content,.tab-link').removeClass('active');
            $(this).addClass('active');
            $($(this).data('href')).removeClass('hide-content');
            $($(this).data('href')).addClass('active');
            console.log($(this).attr('href'));
        });

    });
</script>
