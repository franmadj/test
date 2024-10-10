<?php
$args = array(
		'post_type'      => 'faqs',
		'post_status'		 => 'publish',
		'posts_per_page' => -1,
		'order'          => 'ASC',
		'orderby'        => 'rand'
		);
		$faqs = new WP_Query( $args );
		
if ( $faqs->have_posts() ) : ?>
	<?php while ( $faqs->have_posts() ) : $faqs->the_post();?>
		<div class="faqs-entry">
      <h3><?php the_title();?></h3>
      <div class="answer"><?php the_content();?></div>
  </div>
	<?php endwhile;?>
<?php endif;wp_reset_postdata();?>