<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package texaswp
 */

get_header();
?>
<style>
main#main-content {
	display: block !important;
	margin-top: 160px !important;
}
.c-promo__content {
	bottom: -56px !important;
}
.page-hero__inner:before {
	width: 600px !important;
}
.news-item__date {
	left: 0;
	position: relative;
	float: left;
	margin-bottom: 200px;
	margin-right: 35px;
	margin-top: 6px;
}
.news-list__items {
	padding: 25px;
}
.news-list__items a:hover {
	text-decoration:none;
}
</style>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		var images = document.querySelectorAll('img');
		images.forEach(function(img) {
			if (img.src === 'https://texasdebrazil.com/wp-content/uploads/2019/05/TDB-05.png' && img.classList.contains('nav__logo')) {
				img.src = 'https://texasdebrazil.com/wp-content/uploads/2019/05/TDB-01.png';
			}
		});
	});
</script>
<?php 
if ( have_posts() ) :
	the_post();
	if ( has_post_thumbnail( $post->ID ) ) :
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$hero_image = $image[0];
	else :
		$hero_image = home_url().'/assets/img/about/about-bg.png';
	endif;

	if ( get_field('mobile_hero_image') ) :
		$mobile_hero_image = get_field('mobile_hero_image');
	else :
		$mobile_hero_image = $hero_image;
	endif;
	?>
	<?php if ( $hero_image ): ?>
		<div class="page-hero" style="max-height: 100px !important;background-image: url(<?php echo $hero_image; ?>);" data-ref="responsiveVisualElement" data-mobile="<?php echo $mobile_hero_image; ?>" data-desktop="<?php echo $hero_image; ?>">
			<div class="page-hero__inner">
				<div class="c-promo__content">
					<h1 class="c-promo__title" style="color: #FFF;">
						Category: <?php
						if ( is_category() ) {
							$category_title = single_cat_title('', false);
							if (substr($category_title, -2) === 'es') {
								$category_title = substr($category_title, 0, -2) . 'e';
							}
							echo $category_title;
						}
						?> Posts
						
					</h1>
					<span class="c-promo__teaser">
						Learn about Brazilian food, recipes, history and more in our <?php
						if ( is_category() ) {
							echo strtolower(single_cat_title('', false));
						}
						?>
						content section!
					</span>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php rewind_posts(); ?>
<?php endif; ?>

<div class="news-wrapper">
	<section class="news-list">
		<h2 class="news-list__title">
			<?php the_field('landing_section_title'); ?>
			<p style="text-align:center; font-size: 16px; font-weight: 400; text-transform: none; color: #595959; letter-spacing: 1px;">
				Join our <a href="/eclub">e-club</a> to stay updated with all the latest exclusive deals and news. Sign Up today and receive $20 off!
			</p>
		</h2>
		<div class="news-list__items">
			<?php
			$category_id = get_queried_object_id();
			
			$latest_posts_query = new WP_Query([
				'post_type' => 'post',
				'posts_per_page' => 99,
				'cat' => $category_id
			]);
			if ($latest_posts_query->have_posts()) :
				while ($latest_posts_query->have_posts()) : $latest_posts_query->the_post();
					?>
					<div class="news-list__item">
						<a href="<?php the_permalink(); ?>" class="news-item">
							<h3 class="news-item__title">
								<span class="news-item__link"><?php the_title(); ?></span>
							</h3>
							<div class="news-item__date">
								<div class="date-block">
									<span class="date-block__year"><?php echo get_the_date('Y'); ?></span>
									<span class="date-block__month"><?php echo get_the_date('M'); ?></span>
									<span class="date-block__day"><?php echo get_the_date('d'); ?></span>
								</div>
							</div>
							<div class="news-item__teaser">
								<?php the_excerpt(); ?>
							</div>
							<span class="news-item__link" aria-label="Learn more about <?php echo esc_attr(get_the_title()); ?>">Learn more</span>
						</a>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
				<?php
			endif;
			?>
		</div>
		
		
	</section>
</div>

<?php get_footer(); ?>