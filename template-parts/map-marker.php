<?php
$map_location = get_field('location');?>
<?php $slide_images = get_field('photo');?>
<?php if($map_location):?>
<a href="<?php the_permalink();?>" class="c-locations__item" data-ref="location" data-index="1" data-type="domestic">
	<meta name="location[]" value='{"lat":"<?php echo $map_location['lat'];?>","lng":"<?php echo $map_location['lng'];?>","title":"<?php the_title();?>","address":"<?php echo $map_location['address'];?>","phone":"<?php the_field('phone_numbers');?>","distance":"105 mi. away","link":"<?php the_permalink();?>"}'>
	<?php $i=1;
	if($slide_images):?>
		<img src="<?php echo $slide_images[0]['sizes']['homeslider_button'];?>" class="c-locations__image" alt="<?php the_title();?>">
	<?php else:?>
		<img src="https://s3.amazonaws.com/texas-de-brazil-website/locations/International/Riyadh/_260x138_crop_center-center_50/KSA-Outside.jpg" class="c-locations__image" alt="<?php the_title();?>">
	<?php endif;?>
	<span class="c-locations__title"><?php the_title();?></span>
	<span class="c-locations__state"><?php the_field('state');?></span>
</a>
<?php endif;?>