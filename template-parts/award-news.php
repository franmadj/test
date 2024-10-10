<?php
$args = array(
		'post_type'      => 'awards',
		'post_status'		 => 'publish',
		'posts_per_page' => 3,
		'order'          => 'DESC'
		
		);
		$awards = new WP_Query( $args );
		
if ( $awards->have_posts() ) : ?>
<?php while ( $awards->have_posts() ) : $awards->the_post();?>

	<div class="awards__award">
		<div class="award">
		<span class="award__name"><?php the_title();?></span>
		<span class="award__category"><?php the_field('award_category');?></span>
		<span class="award__year">— <?php the_field('award_year');?></span>
		<?php $image_68 = fly_get_attachment_image_src( get_field('award_image'), 'award_68'); 
		$image_136 = fly_get_attachment_image_src( get_field('award_image'), 'award_136'); 
			
		 ?>
                <img src="<?php echo $image_68['src'];?>" srcset="<?php echo $image_136['src'];?>  330w, <?php echo $image_68['src'];?> 165w" sizes="165px" alt="<?php esc_attr(the_title());?> <?php the_field('award_category');?>" class="award__image">
		</div>
	</div>
<?php endwhile;?>
<?php endif;wp_reset_postdata();?>