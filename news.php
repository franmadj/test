<?php
/*
Template Name:News
*/
get_header();
while ( have_posts() ) :the_post();
	if (has_post_thumbnail( $post->ID ) ):
  	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  	$hero_image= $image[0];
  else:
  	$hero_image =home_url().'/assets/img/about/about-bg.png';
  endif;
  if(get_field('mobile_hero_image')):
  	$mobile_hero_image = get_field('mobile_hero_image');
  else:
  	$mobile_hero_image = $hero_image;
  endif;
	?>
  <?php if($hero_image):?>
    <div class="page-hero" style="background-image: url(<?=$hero_image;?>);" data-ref="responsiveVisualElement" data-mobile="<?= $mobile_hero_image; ?>" data-desktop="<?=$hero_image;?>">
      <div class="page-hero__inner">
        <h1 class="page-hero__title"><?php the_field('banner_title');?></h1>
        <div class="white-hr"></div>
        <span class="page-hero__subtitle"><?php the_field('banner_subtitle');?></span>
      </div>
    </div>
  <?php endif;?>
    <div class="news-wrapper">
      <div class="awards">
        <?php get_template_part( 'template-parts/award', 'news' );?>
      </div>

    <section class="news-list">
    <h2 class="news-list__title">
        News and Press Releases
        <p style="text-align:center; font-size: 16px; font-weight: 400; text-transform: none; color: #595959; letter-spacing: 1px;">Join our <a href="/eclub">e-club</a> to stay updated with all the latest exclusive deals and news. Sign Up today and receive $20 off!</p>
    </h2>

    <div class="news-list__items">
      <?php get_template_part( 'template-parts/latest', 'news' );?>
    </div>
    <a href="<?php echo home_url();?>/news/" class="news-list__link" aria-label="Show more news">Show more</a>
  </section>
  </div>
<?php endwhile;?>

<?php get_footer();?>
