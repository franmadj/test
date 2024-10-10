<?php
/*
  Template Name:Cart Link
 */
$count = WC()->cart->get_cart_contents_count();
setcookie('gift_card_cart', $count,0,'/','texasdebrazil.com');
if ($count) {
    $s = $count > 1 ? 's' : '';

    echo '<p class="cart-link">You have ' . $count . ' product' . $s . ' in your Gift Card - Click <a href="' . WC()->cart->get_cart_url() . '">HERE</a> to switch carts.</p>';
} else {
    //echo var_dump($_COOKIE);
}
?>
<style>
    .cart-link{
        font-family: Futura PT,futura-pt,Helvetica,sans-serif;
        font-size: 1rem;
        letter-spacing: 1.5px;
        line-height: 1.9rem;
        color: #000;
    }
    .cart-link a{
        font-weight: bold;
        text-decoration: none;
        color: #000;
    }

</style>