<?php
$butcher_shop_cart = 0;
if (isset($_COOKIE['butcher_shop_cart'])) {
    $butcher_shop_cart = $_COOKIE['butcher_shop_cart'];
}
$is_menu_item = is_page_template('page-template/menu-item.php');
global $post;
$post_id = !empty($post->ID) ? $post->ID : '';
?>
<header class="header <?php echo get_field('header_class', $post_id); ?> mobile-header" data-ref="mobileHeader">
    <button class="header__button" data-ref="navButton" aria-expanded="false">
        <span class="menu-icon" data-ref="navButtonIcon">
            <span class="menu-icon__top"></span>
            <span class="menu-icon__middle"></span>
            <span class="menu-icon__bottom"></span>

        </span> Navigation
    </button>
    <a href="https://order.texasdebrazil.com" class="header__button -reserve border-right animsition-link">PICKUP/DELIVERY</a>
    <a href="/reservations/" class="header__button -reserve">Reserve</a>
    <div role="dialog" aria-modal="true" aria-labelledby="nav-modal_title" id="nav-modal">
        <span id="nav-modal_title" style="position:absolute;opacity:0;">Mobile Menu</span>

        <nav class="nav -disabled" role="navigation" data-ref="navMenu">
            <ul class="nav__list -sub -sub-one">
                <li class="nav__list-item"><a href="/" class="nav__link first-element">Home</a></li>
                <li class="nav__list-item"><a href="/menu" class="nav__link">Menu</a></li>
                <li class="nav__list-item"><a href="/locations/" class="nav__link">Locations</a></li>
                <li class="nav__list-item"><a href="/group-dining/" class="nav__link">Group Dining</a></li>

                <li class="nav__list-item"><a href="/group-dining/#host-an-event" class="nav__link" data-ignore="1">host an event</a></li>
                <li class="nav__list-item"><a href="https://catering.texasdebrazil.com" target="blank" class="nav__link" data-ignore="1">catering</a></li>
                <li class="nav__list-item"><a href="/special/" class="nav__link">Specials</a></li>

                <li class="nav__list-item"><a href="/eclub" class="nav__link" onclick="window.location = '/eclub'">RECEIVE DEALS</a></li>


<!--            <li class="nav__list-item"><a href="/cart/" class="nav__link -cart" data-ref="cartLink" data-count="<?php echo WC()->cart->get_cart_contents_count(); ?>">Cart</a></li>-->

            </ul>
            <ul class="nav__list -sub -sub-two">
                <li class="nav__list-item shop-link"><a href="/shop/" class="nav__link">Shop</a></li>
                <li class="nav__list-item shop-link"><a class="nav__link" href="/shop/gift-cards">GIFT CARDS</a></li>

                <li class="nav__list-item shop-link"><a class="nav__link" href="<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop/">BUTCHER SHOP</a></li>
                <li class="nav__list-item shop-link"><a class="nav__link" href="<?php echo BUTCHER_SITE_URL; ?>/shop/market">MARKET</a></li>

            </ul>
            <ul class="nav__list nav__list-cart">
                <li class="nav__list-item"><a href="/cart/" class="nav__link -cart" data-ref="cartLink" data-count="<?php echo WC()->cart->get_cart_contents_count(); ?>">Gift Card Cart</a></li>
                <li class="nav__list-item"><a href="<?php echo BUTCHER_SITE_URL; ?>/cart/" class="nav__link -cart" data-ref="cartLink" data-count="<?php echo $butcher_shop_cart; ?>">Butcher Shop Cart</a></li>


            </ul>
            <ul class="nav__list -sub -sub-three">
                <li class="nav__list-item"><a href="/contact/" class="nav__link">Contact Us</a></li>
                <li class="nav__list-item"><a href="/eclub/" class="nav__link">join eclub</a></li>
                <li class="nav__list-item"><a href="https://www.nutritionix.com/texas-de-brazil/portal" class="nav__link" target="blank">Nutrition & Allergies</a></li>
                <li class="nav__list-item"><a href="/faq/" class="nav__link">FAQ</a></li>
                <li class="nav__list-item"><a href="/careers/" class="nav__link">Careers</a></li>

                <li class="nav__list-item"><a href="/about/" class="nav__link">About Us</a></li>
                <li class="nav__list-item"><a href="/leasing-expansion/" class="nav__link">Leasing &amp; Expansion</a></li>
                <li class="nav__list-item"><a href="/news/" class="nav__link">News</a></li>
                <li class="nav__list-item"><a href="/articles/" class="nav__link">Articles</a></li>







            </ul>
            <?php include(get_template_directory() . '/_includes/social-link.php'); ?>
            <ul class="nav__list -sub -legal">
                <li class="nav__list-item"><a href="https://privacy.texasdebrazil.com/privacy-policy" class="nav__link animsition-link">Privacy Policy</a></li>
                <li class="nav__list-item"><a href="/terms-of-use/" class="nav__link animsition-link">Terms of Use</a></li>
                <li class="nav__list-item"><a href="/accessibility/" class="nav__link animsition-link">Accessibility</a></li>
                <li class="nav__list-item"><a href="/required-disclosures/" class="nav__link animsition-link">Disclosures</a></li>
                <li class="nav__list-item ea-icon" style="width:100%;">
                    <a href="https://www.essentialaccessibility.com/texas-de-brazil?utm_source=texasdebrazilhomepage&utm_medium=iconlarge&utm_term=eachannelpage&utm_content=header&utm_campaign=texasdebrazil" 
                       class="nav__link animsition-link">
                        <img alt="This icon serves as a link to download the eSSENTIAL Accessibility assistive technology app for individuals with physical disabilities. It is featured as part of our commitment to diversity and inclusion" 
                             src="<?php echo get_template_directory_uri(); ?>/assets/img/eA_Icon.svg">
                    </a>
                    
                </li>
                <?php do_action('carolina_privacy_links'); ?>


            </ul>
            <div id="google_translate_element_mobile" class="translate-mobile"></div>
        </nav>
    </div>
</header>

<?php
$isEclubPage = 140 == get_the_ID();
$isTTJPage = 56981 == get_the_ID();

if (!is_front_page() && !is_cart() && !$isEclubPage && !$isTTJPage):
    ?>
    <div class="header__mobile-logo-content" >
        <div class="header__mobile-logo" >
            <a href="/" title="Go the Homepage">

                <?php
                if (is_shop()):
                    $id = get_option('woocommerce_shop_page_id');
                else:
                    $id = $post_id;
                endif;
                global $specials_page_id;

                if (!empty($specials_page_id)) {
                    $id = $specials_page_id;
                }
                ?>
                <?php if (get_field('logo_color', $id) == 'white' && !$is_menu_item): ?>
                    <?php if (get_field('header_white_logo', 'option')): ?>
                        <img src="<?php echo get_field('header_white_logo', 'option'); ?>" alt="Texas de Brazil" class="nav__logo">
                    <?php endif; ?>
                <?php elseif (get_field('logo_color', $id) == 'black'): ?>
                    <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de Brazil" class="nav__logo">
                <?php else: ?>
                    <?php if (get_field('header_black_logo', 'option')): ?>
                        <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de Brazil" class="nav__logo">
                    <?php endif; ?>
                <?php endif; ?>
            </a>

        </div>
    </div>
<?php endif; ?>

<?php if (is_cart() || $isEclubPage || $isTTJPage): ?>
    <div class="header__mobile-logo-wrapper only-mobile-view">
        <div class="header__mobile-logo">
            <a href="/" title="Go the Homepage">

                <?php
                if (is_shop()):
                    $id = get_option('woocommerce_shop_page_id');
                else:
                    $id = $post_id;
                endif;
                global $specials_page_id;

                if (!empty($specials_page_id)) {
                    $id = $specials_page_id;
                }
                ?>
                <?php if (get_field('logo_color', $id) == 'white'): ?>
                    <?php if (get_field('header_white_logo', 'option')): ?>
                        <img src="<?php echo get_field('header_white_logo', 'option'); ?>" alt="Texas de Brazil" class="nav__logo">
                    <?php endif; ?>
                <?php elseif (get_field('logo_color', $id) == 'black'): ?>
                    <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de Brazil" class="nav__logo">
                <?php else: ?>
                    <?php if (get_field('header_black_logo', 'option')): ?>
                        <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de Brazil" class="nav__logo">
                    <?php endif; ?>
                <?php endif; ?>
            </a>

        </div>
    </div>
<?php endif; ?>
