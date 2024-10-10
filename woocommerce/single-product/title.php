<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="c-page-header">
  <span class="c-page-header__heading" data-ref="tabTitle"><?php the_field('product_lead_test');?></span>
  <span class="c-page-header__text" data-ref="tabSteps" data-template="Step {currentStep} of {totalSteps}">Step 1 of 2</span>
</div>