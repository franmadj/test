<?php 
/*
Template Name:Thank You
*/
get_header('404');
?>
<?php
while ( have_posts() ) :the_post(); ?>
	<div style="text-align: center;">
		<?php if($_GET['from'] == 'eclub'):?>
			<?php the_field('eclub_message');?>
		<?php else:
			the_content();
		endif;?>
	</div>
<?php endwhile;?>
<?php get_footer();?>