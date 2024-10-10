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
<a href="/shop/merchandise/" class="u-promo-back u-step-back backto-all">Back to Merchandise Products</a>

<form class="variations_form cart variations_form-categories" action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo get_the_ID(); ?>" >
    <div class="c-page-header">
        <a href="/shop/merchandise/" class="back-to-products-all">Back to Merchandise Products</a>
        <h1 class="c-page-header__heading" data-ref="tabTitle"><?php the_title(); ?></h1>
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



                <button id="standard-card" class="button c-card-form__submit u-product-detail__confirm1 u-cart single_add_to_cart_button button alt wc-variation-selection-needed">Add to Cart</button>
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




                <?php
                $attributes = $product->get_available_variations();

                $sizes = [];
                $colors = [];
                $styles = [];
                if ($attributes) {


                    $variations = [];
                    foreach ($attributes as $att):
                        $sizes[$att['attributes']['attribute_size']] = $att['attributes']['attribute_size'];
                        $colors[$att['attributes']['attribute_color']] = $att['attributes']['attribute_color'];
                        $styles[$att['attributes']['attribute_style']] = $att['attributes']['attribute_style'];
                        $variations[] = '"' . $att['attributes']['attribute_size'] . $att['attributes']['attribute_color'] . $att['attributes']['attribute_style'] . '":'
                                . '{"variation_id":' . $att['variation_id'] . ','
                                . '"price":"' . addslashes(wc_price($att['display_price'])) . '",'
                                . '"stock":"' . addslashes(wc_price($att['is_in_stock'])) . '",'
                                . '"active":"' . $att['variation_is_active'] . '"}';

                    endforeach;
                    $variations = implode(',', $variations);

                    $defaults = $product->get_default_attributes();
                }
                ?>
                

                    <div class="c-option">
                        <span class="c-option__heading">Size</span>
                        <select name="attribute_size" id="attribute_size">
                            <?php
                            foreach ($sizes as $size):
                                $checked = '';
                                if ($defaults['size'] == $size)
                                    $checked = 'selected="selected"';
                                ?>
                                <option <?php echo $checked; ?> value="<?php echo $size; ?>"><?php echo $size; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="c-option">
                        <span class="c-option__heading">Color</span>
                        <select name="attribute_color">
                            <?php
                            foreach ($colors as $color):
                                $checked = '';
                                if ($defaults['color'] == $color)
                                    $checked = 'selected="selected"';
                                ?>
                                <option <?php echo $checked; ?> value="<?php echo $color; ?>"><?php echo $color; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="c-option c-option-style">
                        <span class="c-option__heading">Style</span>
                        <select name="attribute_style">
                            <?php
                            foreach ($styles as $style):
                                $checked = '';
                                if ($defaults['style'] == $style)
                                    $checked = 'selected="selected"';
                                ?>
                                <option <?php echo $checked; ?> value="<?php echo $style; ?>"><?php echo $style; ?></option>
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
            <input type="hidden" name="variation_id" class="variation_id" value="">

        </div>
    </div>

    <?php $tabTitle = (get_post_field('post_name', get_the_ID()) == 'standard-card') ? 'Tell Us Where to Send This Card' : 'Almost Done — We Need More Details'; ?>



</form>
<script>
    var $ = jQuery.noConflict();
<?php echo 'variations={' . $variations . '};'; ?>

    console.log(variations);
    $('.merch-attributes select').change(function () {
        var atts = '';
        $('.merch-attributes select').each(function () {
            console.log($(this).val());
            atts += $(this).val();
        });
        console.log(atts);
        console.log(variations[atts]);
        if (typeof variations[atts] != 'undefined' && "1" == variations[atts].active) {
            $('.variation_id').val(variations[atts].variation_id);
            $('#product-amount').html(variations[atts].price);
        }
    });
    $('#attribute_size').change();
    
    $('.tab-link').on('click', function (e) {
            e.preventDefault();
            $('.tab-content,.tab-link').removeClass('active');
            $(this).addClass('active');
            $($(this).data('href')).removeClass('hide-content');
            $($(this).data('href')).addClass('active');
            console.log($(this).attr('href'));
        });



</script>    
