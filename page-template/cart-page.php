<?php
/*
Template Name:Cart Page
*/
get_header();
while ( have_posts() ) :the_post(); ?>
	<div class="container u-back-button">
    <a href="/shop/gift-cards" class="u-promo-back u-step-back u-actions__back u-cart-back">BACK TO GIFT CARD PRODUCTS</a>
	</div>
<?php
    
    if (isset($_COOKIE['butcher_shop_cart']) && $_COOKIE['butcher_shop_cart']>0) {
        $count=$_COOKIE['butcher_shop_cart'];
        $s = $count > 1 ? 's' : '';
        echo '<p class="cart-link">Can\'t find your cart products? You have ' . $count . ' product' . $s . ' in your Butcher Shop Cart - Click <a href="https://shop.texasdebrazil.com/cart/">HERE</a> to switch carts.</p>';
    }else{
        //echo '<p class="cart-link">YOUR GIFT CARD SHOP CART IS EMPTY</p>';
    }
    ?>
	
<?php the_content();?>
<?php endwhile;?>
<?php get_footer();?>