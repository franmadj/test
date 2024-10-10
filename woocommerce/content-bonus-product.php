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
        background:#86090f;

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
    .back-to-1{
        padding-top: 18px;
    }
</style>
<?php do_action('woocommerce_before_cart'); ?>
<?php do_action('woocommerce_shop_page_link'); ?>
<div class="back-to-1">
    <a href="#" class="u-promo-back u-step-back u-step-back--hidden stepBack mt-4" data-ref="stepBack">Back to Step 1</a>
</div>
<form class="variations_form cart single-product" action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo get_the_ID(); ?>" data-ref="productForm">
    <div class="c-page-header">
        <h1 class="c-page-header__heading" data-ref="tabTitle">
            <?php
            $title = get_field('product_lead_test');
            if (!$title) {
                $title = 'Customize your E-Gift Card';
            }
            echo $title;
            ?></h1>
        <!-- <span class="c-page-header__text" data-ref="tabSteps" data-template="Step {currentStep} of {totalSteps}">Step 1 of 2</span> -->
    </div>

    <div class="u-tab" <?php if (get_field('digital_product') == true): ?> data-ref="tab" data-title="<?php echo $title; ?>" data-step="1" <?php endif; ?>>

        <div class="u-desktop-row" data-ref="desktopRow">





            <div class="c-card-options">
                <div class="c-option">
                    <span class="c-option__heading">Amount</span>
                    <select name="attribute_denominations" data-attribute_name="attribute_denominations">
                        <?php
                        //var_dump($attributes);exit;





                        if (have_rows('denominations')):
                            while (have_rows('denominations')):the_row();
                                ?>
                                <option value="<?php the_sub_field('value'); ?>" <?php
                                if (get_sub_field('value') == 100): echo 'selected';
                                endif;
                                ?>>$<?php the_sub_field('value'); ?></option>
                                        <?php
                                    endwhile;
                                endif;
                                ?>
                    </select>
                </div>
                <div class="c-option">
                    <span class="c-option__heading">Quantity</span>
                    <select name="quantity">
                        <?php foreach (range(1, 10) as $number): ?>
                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if (get_field('digital_product') == true): ?>
                    <div class="c-option c-option_digital">
                        <span class="c-option__heading">
                            <?php
                            if (get_field('send_this_card_as_a_gift', 'options')):
                                the_field('send_this_card_as_a_gift', 'options');
                            else:
                                ?>
                                Send this card as a gift?
                            <?php endif; ?>
                        </span>
                        <select id="giftcard" name="isGiftCard" class="giftcard">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>
                <?php endif; ?>
<!-- <span class="c-card-options__reset" data-ref="resetForm">Reset</span> -->
            </div>




            <div class="u-card-body">
                <div class="tab-links" role="tablist" aria-label="info-use">
                    <a href="javascript:void(0);" class="info-tab tab-link custom-border-bottom active" data-href="#info-tab" id="info-tab-" type="button" role="tab" aria-selected="true" aria-controls="info-tab">Product Info</a>
                    <a href="javascript:void(0);" class="rule-tab tab-link custom-border-bottom" data-href="#rule-tab" id="rule-tab-" type="button" role="tab" aria-selected="false" aria-controls="rule-tab" tabindex="-1">Restrictions</a>
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



            <div class="u-desktop-preview">
                <?php
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                ?>
                <div class="c-current-card" style="background-image: url('<?php echo $image[0]; ?>');" data-ref="currentCard"></div>



                <?php if (get_field('digital_product') != false): ?>
                    <button id="e-gift-card-1"  class="button c-card-form__submit u-cart single_add_to_cart_button button alt wc-variation-selection-needed u-confirm-options custom-border-bottom">Add to Cart</button>
                    <span class="button u-confirm-options hidden" data-ref="moveTabs" data-direction="forward">Add to Cart</span>
                <?php else: ?>
                    <button id="standard-card" class="button c-card-form__submit u-product-detail__confirm1 u-cart single_add_to_cart_button button alt wc-variation-selection-needed tx-mobile-view custom-border-bottom">Add to Cart</button>
                <?php endif; ?>
            </div>


            <input id="theme-id" type="hidden" name="theme_id" value="690" data-ref="themeInput">
        </div>
    </div>

    <?php $tabTitle = (get_post_field('post_name', get_the_ID()) == 'standard-card') ? 'Tell Us Where to Send This Card' : 'Almost Done — We Need More Details'; ?>
    <?php if (get_field('digital_product') == true): ?>
        <div class="u-tab u-tab--disabled" data-ref="tab" data-title="<?php echo $tabTitle; ?>" data-step="2">

            <div class="c-card-form">
                <div class="c-card-form__header">
                    <img src="<?php echo $image[0]; ?>" class="c-card-form__card-preview" data-ref="cardThumbnail" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <span class="c-card-form__title"><?php the_title(); ?> - <span class="t-light-gray">Recipient Details</span></span>
                </div>

                <div class="c-card-form__col">
                    <input id="firstName" type="text" name="firstName" class="c-card-form__input" placeholder="First Name" data-name="First Name">
                    <input id="lastName" type="text" name="lastName" class="c-card-form__input" placeholder="Last Name" data-name="Last Name">
                </div>


                <div class="c-card-form__col">
                    <input id="email" type="email" name="email" class="c-card-form__input" data-ref="ecardEmail" placeholder="Email" data-name="Email Address">
                    <input id="conf-email" type="email" name="conf-email" class="c-card-form__input" data-ref="ecardConfEmail" placeholder="Confrim Email" data-name="Confirm Email" autocomplete="nope">
                </div>

                <div class="c-card-form__col u-message">
                    <textarea id="message" name="message" class="c-card-form__textarea" rows="8" data-name="Message" placeholder="YOUR MESSAGE" data-ref="message" maxlength="140"></textarea>
                    <span class="u-chars" data-ref="charCount">0/140</span>
                </div>
                <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID(); ?>">
                <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
                <br /><br />
                <button id="e-gift-card"  class="button c-card-form__submit c-card-form__submit u-cart single_add_to_cart_button button alt wc-variation-selection-needed custom-border-bottom">Add to Cart</button>
            </div>

        </div>
    <?php endif; ?>
    <?php if (get_the_ID() == HOLIDAY_STD_GIFT_CARD): ?>

        <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID(); ?>">
        <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
        <input type="hidden" name="giftcard" class="giftcard" value="no">
        <input id="theme-id" type="hidden" name="theme_id" value="692" data-ref="themeInput">



        <input type="hidden" name="gtm4wp_id" value="<?php echo get_the_ID(); ?>">
        <input type="hidden" name="gtm4wp_name" value="Holiday Standard Gift Card">
        <input type="hidden" name="gtm4wp_sku" value="<?php echo get_the_ID(); ?>">
        <input type="hidden" name="gtm4wp_category" value="Bonus Card">
        <input type="hidden" name="gtm4wp_price" value="50">
        <input type="hidden" name="gtm4wp_stocklevel" value="">
        <input type="hidden" name="variation_id" class="variation_id" value="63788">






        <button id="standard-card" class="button c-card-form__submit u-product-detail__confirm1 u-cart single_add_to_cart_button button alt wc-variation-selection-needed tx-desktop-view custom-border-bottom">Add to Cart</button>
    <?php else: ?>
        <input type="hidden" name="variation_id" class="variation_id" value="63780">
    <?php endif; ?>

</form>
<script>
    var $ = jQuery.noConflict();
    var variations = {};

    $(document).ready(function () {
        
        $('#e-gift-card').click(function () {
            $('.conf-form-error').remove();
            if ($('#conf-email').val().toLowerCase() != $('#email').val().toLowerCase()) {
                $('.u-message').after('<div class="c-form-error conf-form-error" data-ref="formError">The Confimation Email must match with the Email field.</div>');
                return false;
            }
            return true;

        });

<?php
if (!empty($_GET['typeis'])) {
    var_dump($product->get_type());
    exit;
}
$attributes = false;
if ('variable' == $product->get_type())
    $attributes = $product->get_available_variations();
if ($attributes) {
    $variations = [];
    foreach ($attributes as $att):
        $variations[] = '"' . $att['attributes']['attribute_denominations'] . '":"' . $att['variation_id'] . '"';

    endforeach;
    $variations = implode(',', $variations);

    echo 'variations={' . $variations . '};';
}
?>


        $('#giftcard').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            if (this.value == 'No') {
                $('.u-confirm-options').addClass('hidden');
                $('#e-gift-card-1').css('display', 'block');
            } else {
                $('.u-confirm-options').removeClass('hidden');

                $('#e-gift-card-1').hide();
            }
        });
        $('.tab-link').on('click', function (e) {
            e.preventDefault();
            $('.tab-content,.tab-link').removeClass('active');
            $(this).addClass('active');
            $($(this).data('href')).removeClass('hide-content');
            $($(this).data('href')).addClass('active');
            console.log($(this).attr('href'));
        });
        console.log(variations);
        $('select[name="attribute_denominations"]').change(function () {
            console.log(variations[$(this).val()]);
            $('.variation_id').val(variations[$(this).val()]);
        });
    });
</script>
