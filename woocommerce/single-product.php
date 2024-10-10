<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');
?>

<?php

/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>

<?php while (have_posts()) : the_post(); ?>
    <?php

//    if ($_GET['fran']) {
//        $category = get_queried_object();
//        var_dump($category);exit;
//    }

    if (get_post_field('post_name', get_the_ID()) == 'standard-gift-card') :
        wc_get_template_part('content', 'standard-card');
    elseif (get_post_field('post_name', get_the_ID()) == 'e-gift-card'):
        wc_get_template_part('content', 'single-product');
    elseif (get_post_field('post_name', get_the_ID()) == 'holiday-e-gift-card') :
        wc_get_template_part('content', 'bonus-product');
    elseif (get_post_field('post_name', get_the_ID()) == 'e-vip-dining-card'):
        wc_get_template_part('content', 'simple-e-dining-card');
    elseif (get_post_field('post_name', get_the_ID()) == 'standard-vip-dining-card'):
        wc_get_template_part('content', 'simple-std-dining-card');
    else:
        //wc_get_template_part( 'content', 'bonus-standard-card' );
        wc_get_template_part('content', 'bonus-product');
    endif;
    ?>

<?php endwhile; // end of the loop. ?>

<?php

/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php

/**
 * woocommerce_sidebar hook.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );
?>

<?php

get_footer('shopp');
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
