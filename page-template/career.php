<?php
/*
Template Name:Career
*/
get_header();
while ( have_posts() ) :the_post(); 
	if (has_post_thumbnail( $post->ID ) ): 
  	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  	$hero_image= $image[0]; 
  else:
  	$hero_image =home_url().'/assets/img/about/about-bg.png';
  endif;
  if(get_field('career_hero_image_mobile'))
  	$mobile_hero_image = get_field('career_hero_image_mobile');
  else
  	$mobile_hero_image = $hero_image;
	?>
  <?php if($hero_image):?>
  <div class="hero careers-hero" style="background-image: url(<?=$hero_image;?>);" data-ref="responsiveVisualElement" data-mobile="<?= $mobile_hero_image; ?>" data-desktop="<?=$hero_image;?>">
    <div class="careers-hero_content">
      <h1><?php the_field('banner_title');?></h1>
      <div class="white-hr"></div>
      <p><?php the_field('banner_subtitle');?></p>
    </div>
    <a href="#showCareers" class="hero__arrow" aria-label="Scroll down"></a>
  </div>
<?php endif;?>
  <div class="careers-wrapper">
    <div class="careers">

        <?php if(get_field('landing_section_title')):?>
            <h2 class="careers__page-title" id="showCareers"><?php the_field('landing_section_title');?></h2>
        <?php endif;?>

        <form class="careers-form">
            <div style="max-width: 90rem; margin: 0 auto; text-align: left;">
                <?php the_content();?>
                <?php echo get_field('enable_taleo');?>
                <?php if (get_field('enable_taleo')):?>
                    <div class="careers-iframe">
                        <iframe src="https://chm.tbe.taleo.net/chm03/ats/careers/jobSearch.jsp?act=redirectCws&cws=1&org=TXDBC"></iframe>
                    </div>
                <?php endif;?>
            </div>

             <!-- <div class="careers-form__buttons">
                <button class="careers-form__submit">Submit</button>
            </div>  -->
        </form>
    </div>
  </div>
<?php endwhile;?>
<?php get_footer();?>