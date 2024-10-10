<?php
/*
  Template Name:Checkout
 */
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

if ($uri_segments[2] == 'order-received'):
    get_header('single');
else:
    get_header('checkout');
endif;


while (have_posts()) :the_post();
    ?>
    <h1 class="t-heading-three">Order Checkout</h1>
    <div class="u-checkout__grid" >
    <?php the_content(); ?>
    </div>
<?php endwhile; ?>
<?php
if ($uri_segments[2] == 'order-received'):
    get_footer();
else:
    get_footer('checkout');
endif;