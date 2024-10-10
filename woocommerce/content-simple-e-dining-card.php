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
    .the-page-title{
        font-size: 23px;
        margin-bottom: 8px;
    }
    .option-price{
        font-size: 20px;
    }
    .nav__list{
        background: none;
    }
    @media (min-width: 999px){
        .nav__list-item .nav__link {
            color: #000504;
        }
    }
    .back-to-1{
        padding-top: 18px;
    }
</style>
<?php do_action('woocommerce_before_cart'); ?>
<?php do_action('woocommerce_shop_page_link'); ?>
<div class="back-to-1">
    <a href="#" class="u-promo-back u-step-back u-step-back--hidden stepBack" data-ref="stepBack">Back to Step 1</a>
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

    <div class="u-tab" data-ref="tab" data-title="<?php  echo $title; ?>" data-step="1">

        <div class="u-desktop-row" data-ref="desktopRow">


            <div class="c-card-options">
                <div class="c-option">
                    <span class="c-option__heading">Amount</span>
                    <div class="option-price">$ <?php echo $product->get_price(); ?></div>

                </div>

                <div class="c-option">
                    <span class="c-option__heading">Quantity</span>
                    <select name="quantity">
                        <?php foreach (range(1, 10) as $number): ?>
                            <option value="<?php echo $number; ?>"><?php echo $number; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="c-option">
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

                <?php if (get_post_field('post_name', get_the_ID()) != 'vip-dinning-card' && false) { ?>
                    <div class="c-option c-theme">
                        <span class="c-option__heading">Theme</span>
                        <?php wc_get_template_part('card', 'theme'); ?>
                    </div>
                <?php } ?>


            </div>




            <div class="u-card-body">
                <h2 class="the-page-title"><?php the_title(); ?></h2>
                <p class="u-product-content__lead-text"><?php the_field('product_teaser'); ?></p>
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



            <div class="u-desktop-preview">
                <?php
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                ?>
                <div class="c-current-card" style="background-image: url('<?php echo $image[0]; ?>');" data-ref="currentCard"></div>
                <span class="button u-confirm-options hidden" data-ref="moveTabs" data-direction="forward" data-el="confirmButtonn">Confirm</span>
                <button id="e-gift-card-1"  class="button c-card-form__submit u-cart single_add_to_cart_button button alt wc-variation-selection-needed u-confirm-options custom-border-bottom">Add to Cart</button>
            </div>



            <input id="theme-id" type="hidden" name="theme_id" value="690" data-ref="themeInput">
        </div>
    </div>

    <?php $tabTitle = (get_post_field('post_name', get_the_ID()) == 'standard-card') ? 'Tell Us Where to Send This Card' : 'Almost Done — We Need More Details'; ?>
    <div class="u-tab u-tab--disabled" data-ref="tab" data-title="<?php echo $tabTitle; ?>" data-step="2">
        <?php
        ?>
        <div class="c-card-form">
            <div class="c-card-form__header">

                <span class="c-card-form__title"><?php the_title(); ?> - <span class="t-light-gray">Recipient Details</span></span>
            </div>
            <?php
            ?>
            <div class="c-card-form__col">
                <input id="firstName" type="text" name="firstName" class="c-card-form__input" placeholder="First Name" data-name="First Name">
                <input id="lastName" type="text" name="lastName" class="c-card-form__input" placeholder="Last Name" data-name="Last Name">
            </div>

            <div class="c-card-form__col">
                <input id="email" type="email" name="email" class="c-card-form__input" data-ref="ecardEmail" placeholder="Email" data-name="Email Address">
                <input id="conf-email" type="email" name="conf-email" class="c-card-form__input" data-ref="ecardConfEmail" placeholder="Confirm Email" data-name="Confirm Email">
            </div>

            <div class="c-card-form__col u-message">
                <textarea id="message" name="message" class="c-card-form__textarea" rows="8" data-name="Message" placeholder="YOUR MESSAGE" data-ref="message" maxlength="140"></textarea>
                <span class="u-chars" data-ref="charCount">0/140</span>
            </div>
        </div>
        <input type="hidden" name="add-to-cart" value="<?php echo get_the_ID(); ?>">
        <input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>">
        <button id="e-gift-card"  class="button c-card-form__submit u-cart single_add_to_cart_button button alt wc-variation-selection-needed custom-border-bottom">Add to Cart</button>
    </div>
</form>
<script>
    var $ = jQuery.noConflict();
    $(document).ready(function () {


        $('#e-gift-card').click(function () {
            $('.conf-form-error').remove();
            if ($('#conf-email').val().toLowerCase() != $('#email').val().toLowerCase()) {
                $('.u-message').after('<div class="c-form-error conf-form-error" data-ref="formError">The Confimation Email must match with the Email field.</div>');
                return false;
            }
            return true;

        });

        $('#giftcard').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            if (this.value == 'No') {
                $('.u-confirm-options').addClass('hidden');
                $('#e-gift-card-1').css('display','block');
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

    });
</script>
