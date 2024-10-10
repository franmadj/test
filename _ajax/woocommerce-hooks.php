<?php
function woocommerce_product_archive_description() { 
    // Don't display the description on search results page 
    if ( is_search() ) { 
        return; 
    } 
 
    if ( is_post_type_archive( 'product' ) && 0 === absint( get_query_var( 'paged' ) ) ) { 
        $shop_page = get_post( wc_get_page_id( 'shop' ) ); 
        if ( $shop_page ) { 
            $description = wc_format_content( $shop_page->post_content ); 
            if ( $description ) { 
                echo '<div class="page-description c-page-header">' . $description . '</div>'; 
            } 
        } 
    } 
} 
// To remove Breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
// To remove Sorting
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
// Result Count 
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );


if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<span class="c-product__title">' . get_the_title() . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'woocommerce_template_loop_product_link_open' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function woocommerce_template_loop_product_link_open() {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link c-product">';

	}
}

if ( ! function_exists( 'woocommerce_template_loop_price' ) ) {

	/**
	 * Get the product price for the loop.
	 */
	function woocommerce_template_loop_price() {
		//wc_get_template( 'loop/price.php' );
	}
}

if ( ! function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {

	/**
	 * Get the add to cart template for the loop.
	 *
	 * @param array $args Arguments.
	 */
	function woocommerce_template_loop_add_to_cart( $args = array() ) {
		global $product;
		
		if ( $product ) {
			$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
			echo '<span class="c-product__teaser">'.get_field('product_teaser',get_the_ID()).'</span>';
			echo '<a href="' . esc_url( $link ) . '" class="button button--small c-product__button">Purchase</a>';
		}
	}
}

if( ! function_exists('woocommerce_below_shop_page_content_callback')){

	function woocommerce_below_shop_page_content_callback(){
		
		$shop_page_id = wc_get_page_id( 'shop' );?>
		<img src="/assets/img/horizontal-decorator.svg" class="c-decorator">

    <div class="u-good-to-know">
        <span class="u-good-to-know__heading"><?php the_field('good_to_know_heading',$shop_page_id);?></span>
        <?php the_field('good_to_know_text',$shop_page_id);?>
    </div>

    <div class="u-card-support">
        <span class="t-heading-two u-card-support__heading">Gift Card Support</span>
        <span class="button button--alternate u-card-support__call">Call  <?php the_field('customer_service_phone','options');?></span>
        <span class="u-card-support__or">or</span>
        <a href="/contact/" class="button u-card-support__email">Contact a Gift Card Specialist</a>
    </div>
    <?php 
	}
}
add_action('woocommerce_below_shop_page_content','woocommerce_below_shop_page_content_callback');

if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @param string $size (default: 'woocommerce_thumbnail').
	 * @param int    $deprecated1 Deprecated since WooCommerce 2.0 (default: 0).
	 * @param int    $deprecated2 Deprecated since WooCommerce 2.0 (default: 0).
	 * @return string
	 */
	function woocommerce_get_product_thumbnail( $size = 'woocommerce_thumbnail_new', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $product;

		$image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

		return $product ? $product->get_image( $image_size ) : '';
	}
}

// Remove Related product from single product page
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action('woocommerce_shop_page_link','woocommerce_shop_page_link_callback');

function woocommerce_shop_page_link_callback(){
	$shop_page_id = wc_get_page_id( 'shop' );
	echo '<a href="'.get_the_permalink($shop_page_id).'" class="u-promo-back u-step-back">Back to All Products</a>';
}
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );
add_filter( 'woocommerce_shipping_package_name', 'custom_shipping_package_name' );
function custom_shipping_package_name( $name ) {
  return '<span class="t-heading-five t-white c-box__heading">Shipping Options</span>';
}

add_action( 'woocommerce_after_checkout_validation', 'misha_validate_fname_lname', 20, 2);
 
function misha_validate_fname_lname( $fields, $errors ){
 		require get_template_directory() . '/inc/us-zipcode.php';
    if($fields[ 'billing_postcode' ] != ""){
    	if(! in_array($fields[ 'billing_postcode' ], $validFedExZipCodes))
    		$errors->add( 'validation', 'Wrong zip code' );
    }else{
    	$errors->add( 'validation', 'ZIP code is not valide' );
    }
}