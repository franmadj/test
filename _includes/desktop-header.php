<?php
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
global $post;
$post_id = !empty($post->ID) ? $post->ID : '';
$location_subpages = get_query_var('locations-togo') || get_query_var('locations-event');

$header_class = '';
if (is_shop()):
    $header_class .= get_field('header_class', get_option('woocommerce_shop_page_id'));
elseif ($location_subpages):
    $header_class .= 'location-white-logo';
else:
    $header_class .= get_field('header_class', $post_id);
    if (get_field('logo_color', $post_id) == 'white') {
        $header_class .= 'location-white-logo';
    }
endif;
?>

<header class="header header--no--fixed <?= $header_class ?>" data-ref="desktopHeader">
    <nav class="nav nav--has-modifier" role="navigation" aria-label="navigation top">

        <div class="menu-top">
            <?php include(get_template_directory() . '/_includes/social-link.php'); ?>
            <ul class="nav__list -sub">
                <li class="nav__list-item" style="width:5px;">

                </li>
                <li class="nav__list-item"><a href="/about/" class="nav__link animsition-link" aria-label="about us">About Us</a></li>
                <li class="nav__list-item"><a href="/eclub/" class="nav__link animsition-link">Receive deals</a></li>
                <li class="nav__list-item"><a href="/special/" class="nav__link animsition-link">Specials</a></li>
                <li class="nav__list-item"><a href="/articles/" class="nav__link animsition-link">Articles</a></li>
                <li class="nav__list-item"><a href="/cart/" class="nav__link -cart animsition-link" data-ref="cartLink" data-count="<?php echo WC()->cart->get_cart_contents_count(); ?>">Cart</a></li>
            </ul>
        </div>
        <ul class="nav__list -main">
            <li class="nav__list-item"><a aria-label="menu" href="/menu/" class="nav__link animsition-link <?php if ($uri_segments[1] == 'menu') echo '-active'; ?>" data-content="Menu"><span class="nav__link-text">Menu</span></a></li>
            <li class="nav__list-item"><a href="/locations/" class="nav__link animsition-link <?php if ($uri_segments[1] == 'locations') echo '-active'; ?><?php if ($uri_segments[1] == 'location') echo '-active'; ?>" data-content="Locations"><span class="nav__link-text">Locations</span></a></li>
            <?php if (!is_front_page()) { ?>
                <li class="nav__list-item" data-ref="headerLogo">
                    <a href="/" class="nav__link nav__link--logo animsition-link">
                        <?php
                        if (is_shop()): $id = get_option('woocommerce_shop_page_id');
                        else:
                            $id = $post_id;
                        endif;
                        ?>
                        <?php if ((get_field('logo_color', $id) == 'white' && !$is_menu_item) || $location_subpages): ?>
                            <?php if (get_field('header_white_logo', 'option')): ?>
                                <img src="<?php echo get_field('header_white_logo', 'option'); ?>" alt="Texas de brazil churrascaria steakhouse logo logo" class="nav__logo">
                            <?php endif; ?>
                        <?php elseif (is_archive() && $uri_segments[1] != 'shop'): ?>
                            <img src="<?php echo get_field('header_white_logo', 'option'); ?>" alt="Texas de brazil churrascaria steakhouse logo" class="nav__logo">
                        <?php elseif ($uri_segments[1] == 'shop'): ?>
                            <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de brazil churrascaria steakhouse logo" class="nav__logo">
                        <?php elseif (get_field('logo_color', $id) == 'black'): ?>
                            <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de brazil churrascaria steakhouse logo" class="nav__logo">
                        <?php else: ?>
                            <?php if (get_field('header_black_logo', 'option')): ?>
                                <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de brazil churrascaria steakhouse logo" class="nav__logo">
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </li>
            <?php } ?>

            <li class="nav__list-item g-dining-item has-dropdown has-submenu">
                <a href="/group-dining/" class="gd-nav__link nav__link animsition-link <?php if ($uri_segments[1] == 'group-dining') echo '-active'; ?>" data-content="Group Dining"><span class="nav__link-text">Group Dining</span>
                </a>

                <ul class="main-submenu ">
                    <li class="active">
                        <a data-ignore="1" href="/group-dining/" class="gd-subnav__link is-link-submenu">Group Dining</a>
                    </li>
                    <li>
                        <a data-ignore="1" href="/group-dining/#host-an-event" class="gd-subnav__link is-link-submenu">Host an Event</a>
                    </li>
                    <li><a data-ignore="1" href="http://catering.texasdebrazil.com" class="gd-subnav__link is-link-submenu">Catering</a></li>

                </ul>
            </li>
            <li class="nav__list-item shop-has-dropdown has-dropdown has-submenu">
                <a style="width:fit-content;" href="/shop/" class="sh-nav__link nav__link <?php if ($uri_segments[1] == 'shop') echo '-active'; ?>" data-content="Shop"><span class="nav__link-text">Shop</span></a>

                <ul class="main-submenu">
                    <li class="active">
                        <a class="is-link-submenu" href="/shop/gift-cards">GIFT CARDS</a>
                    </li>

                    <li><a class="is-link-submenu" href="<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop/">BUTCHER SHOP</a></li>
                    <li><a class="is-link-submenu" href="<?php echo BUTCHER_SITE_URL; ?>/shop/market">MARKET</a></li>
                </ul>


            </li>
        </ul>
    </nav>
    <a href="/reservations/" class="reserve-button" data-ref="reserveButton" aria-label="Reserve">Reserve</a>
    <a href="https://order.texasdebrazil.com" class="reserve-button eClub-button" data-ref="eClubButton" aria-label="ORDER PICKUP/DELIVERY">Order To-Go</a>
    <?php if ('page-template/menu-item.php' == get_page_template_slug()): ?>
        <h1 class="reserve-button eClub-button" ><?php the_title(); ?></h1>
    <?php endif; ?>
    <?php
    if (is_single() && 'locations' == get_post_type()) {
        ?>
        <a href="/locations/" class="reserve-button eClub-button back-locations-button" data-ref="eClubButton">Back</a>
        <?php
    }
    if (get_query_var('locations-togo') || get_query_var('locations-event')) {
        ?>
        <a href="/locations/<?= get_query_var('locations-togo') . get_query_var('locations-event') ?>" class="reserve-button eClub-button back-locations-button" data-ref="eClubButton">Location General Info</a>
        <?php
        if (get_query_var('locations-togo')) {
            ?>
            <h1 style="right: 0;left: inherit;top:120px;font:400 2rem/2em Oswald;min-width: 218px;" 
                class="reserve-button eClub-button back-locations-button togo-title" data-ref="eClubButton"><?= get_query_var('locations-togo') ?></h1>
            <?php
        }
    }
    ?>
</header>



<header class="header header--fixed <?php echo get_field('header_class', $id); ?>" data-ref="desktopHeader">
    <nav class="nav nav--has-modifier" role="navigation" aria-label="navigation fixed">
        <div class="menu-top">
<?php include(get_template_directory() . '/_includes/social-link.php'); ?>
            <ul class="nav__list -sub">
                <li class="nav__list-item" style="width:5px;">

                </li>
                <li class="nav__list-item"><a href="/about/" class="nav__link animsition-link" aria-label="about us">About Us</a></li>
                <li class="nav__list-item"><a href="/eclub/" class="nav__link animsition-link">Receive deals</a></li>
                <li class="nav__list-item"><a href="/special/" class="nav__link animsition-link">Specials</a></li>
                <li class="nav__list-item"><a href="/articles/" class="nav__link animsition-link">Articles</a></li>
                <li class="nav__list-item"><a href="/cart/" class="nav__link -cart animsition-link" data-ref="cartLink" data-count="<?php echo WC()->cart->get_cart_contents_count(); ?>">Cart</a></li>
            </ul>
        </div>
        <ul class="nav__list -main">
            <li class="nav__list-item"><a href="/menu/" class="nav__link animsition-link" data-content="Menu" aria-label="menu"><span class="nav__link-text">Menu</span></a></li>
            <li class="nav__list-item"><a href="/locations/" class="nav__link animsition-link" data-content="Locations"><span class="nav__link-text">Locations</span></a></li>
            <li class="nav__list-item" data-ref="headerLogo">
                <a href="/" class="nav__link nav__link--logo animsition-link">
<?php if (get_field('sticky_logo_color', $id) == 'white' && !$is_menu_item): ?>
    <?php if (get_field('header_white_logo', 'option')): ?>
                            <img src="<?php echo get_field('header_white_logo', 'option'); ?>" alt="Texas de brazil churrascaria steakhouse logo" class="nav__logo">
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if (get_field('header_black_logo', 'option')): ?>
                            <img src="<?php echo get_field('header_black_logo', 'option'); ?>" alt="Texas de brazil churrascaria steakhouse logo" class="nav__logo">
                        <?php endif; ?>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav__list-item g-dining-item has-dropdown has-submenu">
                <a href="/group-dining/" class="gd-nav__link nav__link animsition-link" data-content="Group Dining"><span class="nav__link-text">Group Dining</span>
                </a>

                <ul class="main-submenu ">
                    <li class="active">
                        <a data-ignore="1" href="/group-dining/" class="gd-subnav__link is-link-submenu">Group Dining</a>
                    </li>
                    <li>
                        <a data-ignore="1" href="/group-dining/#host-an-event" class="gd-subnav__link is-link-submenu">Host an Event</a>
                    </li>
                    <li><a data-ignore="1" href="http://catering.texasdebrazil.com" class="gd-subnav__link is-link-submenu">Catering</a></li>

                </ul>



                <!--                <ul class="g-dining-submenu">
                                    <li class="active">
                                        <a href="#">Host an Event</a>
                                    </li>
                                    <li><a href="#">Churrascaria Catering</a></li>
                                    <li><a href="#">'Pickup & Delivery</a></li>
                                    <li><a href="#">National Accounts</a></li>
                                </ul>-->
            </li>
            <li class="nav__list-item shop-has-dropdown has-dropdown has-submenu">
                <a style="width:fit-content;" href="/shop/" class="sh-nav__link nav__link animsition-link" data-content="Shop"><span class="nav__link-text">Shop</span></a>


                <ul class="main-submenu">
                    <li class="active">
                        <a class="is-link-submenu" href="/shop/gift-cards">GIFT CARDS</a>
                    </li>

                    <li><a class="is-link-submenu" href="<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop/">BUTCHER SHOP</a></li>
                    <li><a class="is-link-submenu" href="<?php echo BUTCHER_SITE_URL; ?>/shop/market">KITCHEN</a></li>
                </ul>


            </li>
        </ul>
        <a href="https://texasdebrazil.order.online/" class="reserve-button eClub-button" data-ref="eClubButton">ORDER PICKUP/DELIVERY</a>
        <a href="/reservations/" class="reserve-button" data-ref="reserveButton">Reserve</a></nav>
</header>


