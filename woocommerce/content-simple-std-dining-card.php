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
<?php do_action('woocommerce_before_cart'); ?>
<div class="o-container single-product std-dining-card">
    
    <?php do_action('woocommerce_shop_page_link'); ?>
    <form class="variations_form cart" action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo get_the_ID(); ?>">
        <div class="c-page-header">
            <h1>
                <span class="c-page-header__heading" data-ref="tabTitle">
                    <?php
                    if (get_field('product_lead_test')) {
                        the_field('product_lead_test');
                    } else {
                        echo 'eGift Card';
                    }
                    ?></span>
            </h1>
            <span class="c-page-header__text" data-ref="tabSteps" data-template="Step {currentStep} of {totalSteps}">&nbsp;</span>
        </div>

        <div class="u-product-detail">
            <h1 class="u-product-content__title tx-mobile-view"><?php the_title(); ?></h1>
            <div class="u-product-detail__gallery">
                <div class="u-product-detail__gallery-wrapper">
                    <?php
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                    ?>

                    <img src="<?php echo $image[0]; ?>" class="u-product-detail__current-image" data-ref="currentCard" alt="<?php echo esc_attr(get_the_title()); ?>">
                </div>


                <div class="c-customizers tx-desktop-view">
                    <div class="c-customizers__item c-customizers__item--amount">
                        <span class="c-customizers__heading">Amount</span>
                        <div class="option-price">$ <?php echo $product->get_price(); ?></div>
                    </div>
                    <div class="c-customizers__item c-customizers__item--qty">
                        <span class="c-customizers__heading">Quantity</span>
                        <select name="quantity">
                            <?php foreach (range(1, 10) as $number): ?>
                                <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

    


                </div>


            </div>

            <div class="u-product-detail__confirm-wrapper tx-mobile-view">
                <button id="standard-card" class="button u-product-detail__confirm u-cart single_add_to_cart_button button alt wc-variation-selection-needed tx-mobile-view custom-border-bottom">Add to Cart</button>
            </div>

            <div class="c-customizers tx-mobile-view">
                <div class="c-customizers__item c-customizers__item--amount">
                    <span class="c-customizers__heading">Amount</span>
                    <div class="option-price">$ <?php echo $product->get_price(); ?></div>
                </div>
                <div class="c-customizers__item c-customizers__item--qty">
                    <span class="c-customizers__heading">Quantity</span>
                    <select name="quantity">
                        <?php foreach (range(1, 10) as $number): ?>
                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

          


            </div>

            <div class="u-product-detail__content u-product-content">
                <h1 class="u-product-content__title tx-desktop-view"><?php the_title(); ?></h1>
                <p class="u-product-content__lead-text"><?php the_field('product_teaser'); ?></p>
                <div class="u-product-content__text">
                    <div class="u-card-body">
                        <div class="tab-links" role="tablist" aria-label="info-use">
                            <a href="javascript:void(0);" class="info-tab tab-link custom-border-bottom active" data-href="#info-tab" id="info-tab-" type="button" role="tab" aria-selected="true" aria-controls="info-tab">Product Info</a>
                            <a href="javascript:void(0);" class="rule-tab tab-link custom-border-bottom" data-href="#rule-tab" id="rule-tab-" type="button" role="tab" aria-selected="false" aria-controls="rule-tab" tabindex="-1">Rules of use</a>
                        </div>


                        <div id="info-tab" class="active tab-content" role="tabpanel" aria-labelledby="info-tab-" tabindex="0">
                            <div class="element-desktop-view">
                                <?php the_content(); ?>
                            </div>
                            <div class="element-mobile-view">
                                <?php the_field('product_info_mobile'); ?>
                            </div>
                        </div>
                        <div id="rule-tab" class="hide-content tab-content" role="tabpanel" aria-labelledby="rule-tab-" tabindex="0">
                            <div class="element-desktop-view">
                                <?php the_field('rule_of_use'); ?>
                            </div>
                            <div class="element-mobile-view">
                                <?php the_field('rule_of_use_mobile'); ?>
                            </div>
                        </div>

                    </div>

                </div>


            </div>
            <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID(); ?>">
            <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">

            <div class="u-product-detail__confirm-wrapper tx-desktop-view">
                <?php tx_get_product_button_single($product); ?>
            </div>
        </div>
    </form>
</div>
<script>
    var $ = jQuery.noConflict();
    var variations = {};
    $(document).ready(function () {
        
        

        
        
        $("#standard_theme").val($('#select_theme').val());
        $('#select_theme').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            $("#standard_theme").val(valueSelected);
        });



</script> 

<style>
    .std-dining-card .c-page-header{
        margin-bottom: 20px;
        
    }
</style>

<script>
        var $ = jQuery.noConflict();
    $(document).ready(function () {
        $('.tab-link').on('click', function (e) {
            e.preventDefault();
            $('.tab-content,.tab-link').removeClass('active');
            $(this).addClass('active');
            $($(this).data('href')).removeClass('hide-content');
            $($(this).data('href')).addClass('active');

        });

    });
</script>