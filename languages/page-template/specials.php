<?php 
/*
Template Name:Specials
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
  if(get_field('promotion_mobile_image'))
  	$promotion_mobile_image = get_field('promotion_mobile_image');
  else
  	$promotion_mobile_image = $hero_image;
?>
<div class="o-grid o-grid--gutters s-promotions">
    <div class="o-col">
        <div class="c-promo c-promo--feature" data-ref="responsiveVisualElement" style="background-image: url(<?php echo $hero_image;?>);" data-mobile="<?php echo $promotion_mobile_image;?>" data-desktop="<?php echo $hero_image;?>">
            <div class="c-promo__content">
                <h1 class="c-promo__title" style="color: #FFF;"><?php the_field('promotion_heading');?></h1><span class="c-promo__teaser"><?php the_field('teaser');?></span></div>
        </div>
    </div>
</div>
<?php
while(the_flexible_field("block_body")):
	/* Banner Section  */
	if(get_row_layout() == "one_up"): ?>
		<?php $posts_id = get_sub_field('promotion');?>
		<?php foreach ($posts_id as $value): 
			$one_up_image = wp_get_attachment_image_src( get_post_thumbnail_id( $value ), 'full' );
		?>
		
		<div class="o-grid o-grid--gutters s-promotions">
	    <div class="o-col">
	        <div class="c-promo c-promo--highlight" data-ref="responsiveVisualElement" style="background-image: url(<?php echo $one_up_image[0];?>);" data-mobile="<?php echo $one_up_image[0];?>" data-desktop="<?php echo $one_up_image[0];?>">
	            <div class="c-promo__content">
	                <h2 class="c-promo__title" style="color: white;"><?php echo get_the_title($value);?></h2><span class="c-promo__teaser">Reserve your experience for Sunday, May 12th</span><a href="<?php echo get_the_permalink($value);?>" class="c-promo__button">
	                Learn More
	            </a></div>
	        </div>
	    </div>
		</div>
	<?php endforeach;?>
	<?php 
	endif;
	if(get_row_layout() == "two_up"): ?>
		<div class="o-grid o-grid--gutters">
		<?php $two_up_post = get_sub_field('promotion');?>
		<?php foreach ($two_up_post as $value): 
			$two_up_image = wp_get_attachment_image_src( get_post_thumbnail_id( $value ), 'full' );
		?>
	    <div class="o-col">
	        <div class="c-promo" data-ref="responsiveVisualElement" style="background-image: url(<?php echo $two_up_image[0];?>);" data-mobile="<?php echo $two_up_image[0];?>" data-desktop="<?php echo $two_up_image[0];?>">
	            <div class="c-promo__content">
	                <h2 class="c-promo__title" style="color: white;"><?php echo get_the_title($value);?></h2><span class="c-promo__teaser"><?php echo get_field('teaser', $value);?></span><a href="<?php echo get_the_permalink($value);?>" class="c-promo__button">
	                Learn More
	            </a></div>
	        </div>
	    </div>
    <?php endforeach;?>
		</div>
	<?php 
	endif;
endwhile
	?>
<?php endwhile;?>
<?php 
get_footer();
?>