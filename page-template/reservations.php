<?php
/*
Template Name:Reservation

*/
get_header();

?>
<?php
while ( have_posts() ) :the_post(); 
	if (has_post_thumbnail( $post->ID ) ): 
  	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
  	$hero_image= $image[0]; 
  else:
  	$hero_image =home_url().'/assets/img/about/about-bg.png';
  endif;
 ?>
<div class="reservations arrow-bg" style="background-image: url(<?php echo $hero_image;?>)">
  <div class="reservations__inner" >
      <div class="reservations__heading">
          <h2 class="reservations__subtitle"><?php the_field('reservation_subtitle');?></h2>
          <h1 class="reservations__title"><?php the_title();?></h1>
      </div>

      <div class="reservations__form">
          <?php get_template_part('_includes/table','finder');?>
          <h2 class="reservations__title" style="text-align: center; margin-bottom: 0px; margin-top: 20px;"><?php the_field('group_dining_heading');?></h2>
          <p style="text-align: center; color: white;"><?php the_field('group_dining_subheading');?></p>
          <p style="text-align: center;"><a class="table-finder__submit hover-none" href="<?php echo home_url();?>/group-dining/?modal=host-event">Host an Event</a></p>
      </div>

      <div class="reservations__contact">
          Need help?
          <a href="/contact" class="reservations__link">Contact us</a>
      </div>

  </div>
  <a href="#locationbody" class="hero__arrow hide-on-mobile" title="Scroll down"></a>
</div>
<div id="locationbody" class="c-locations__body" style="margin-top:0;">
	<div class="faq-landing-content locations-content-updated">
		<?php the_content();?>
	</div>
</div>
<?php endwhile;?>
<?php 
get_footer();?>