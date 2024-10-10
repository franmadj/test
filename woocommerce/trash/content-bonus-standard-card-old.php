<div class="o-container">
    <?php do_action( 'woocommerce_before_cart' );?>
<?php do_action('woocommerce_shop_page_link');?>
<form class="variations_form cart" action="<?php the_permalink();?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo get_the_ID();?>">
            <div class="c-page-header c-page-header--disabled">
                <h1><span class="c-page-header__heading" data-ref="tabTitle">
                    <?php if(get_field('product_lead_test')){ the_field('product_lead_test');}else{echo 'eGift Card';}?></span></h1>
                <span class="c-page-header__text" data-ref="tabSteps" data-template="Step {currentStep} of {totalSteps}">&nbsp;</span>
            </div>

            <div class="u-product-detail">
                <div class="u-product-detail__gallery">
                    <div class="u-product-detail__gallery-wrapper">
                        <?php
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail' );
                        ?>

                        <img src="<?php echo $image[0];?>" class="u-product-detail__current-image" data-ref="currentCard">
                    </div>
                </div>
                <div class="u-product-detail__content u-product-content">
                    <h1 class="u-product-content__title"><?php the_title();?></h1>
                    <p class="u-product-content__lead-text"><?php the_field('product_lead_test');?></p>
                    <div class="u-product-content__text">
                        <?php the_content();?>
                        <?php the_excerpt();?>

                    </div>

                    <div class="c-customizers">
                        <div class="c-customizers__item c-customizers__item--amount">
                            <span class="c-customizers__heading">Amount</span>
                            <select name="attribute_denominations" data-attribute_name="attribute_denominations">
                                <?php if(have_rows('denominations')):
                                while(have_rows('denominations')):the_row(); ?>
                                    <option value="<?php the_sub_field('value');?>" <?php if (get_sub_field('value') == 100 ): echo 'selected';endif;?>>$<?php the_sub_field('value');?></option>
                                <?php
                                endwhile;
                              endif;?>
                            </select>
                        </div>
                        <div class="c-customizers__item c-customizers__item--qty">
                            <span class="c-customizers__heading">Quantity</span>
                            <select name="quantity">
                                <?php
                                foreach (range(1, 5) as $number): ?>
                                    <option value="<?php echo $number;?>"><?php echo $number;?></option>
                            <?php endforeach;?>
                            </select>
                        </div>


                        <input type="hidden" id="standard_theme" name="theme_id" value="692" />


                    </div>
                </div>
                <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID();?>">
                <input type="hidden" name="product_id" value="<?php echo get_the_ID();?>">
                <div class="u-product-detail__confirm-wrapper">
                    <button id="standard-card" class="button u-product-detail__confirm u-cart single_add_to_cart_button button alt wc-variation-selection-needed">Add to Cart</button>
                </div>
            </div>
        </form>
        </div>
<script>
var $ = jQuery.noConflict();
$( document ).ready(function() {
$("#standard_theme").val($('#select_theme').val());
$('#select_theme').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    $("#standard_theme").val(valueSelected);
});
});
</script>
