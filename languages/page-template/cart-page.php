<?php
/*
Template Name:Cart Page
*/
get_header();
while ( have_posts() ) :the_post(); ?>
	<div class="container u-back-button">
    <a href="/shop/" class="u-promo-back u-step-back u-actions__back u-cart-back">Back to All Products</a>
	</div>
	
<?php the_content();?>
<?php endwhile;?>
<?php get_footer();?>