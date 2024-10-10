<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package texaswp
 */

?>
 
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php texaswp_post_thumbnail(); ?>

	<div class="privacy-policy-landing-text">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'texaswp' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
