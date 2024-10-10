<?php
/*
Template Name:Press Releases
*/
get_header();
while ( have_posts() ) :the_post();?>
	<section class="news-list">
    <h2 class="news-list__title">
        <?php the_title();?>
    </h2>
    <div class="news-list__items">
      <?php get_template_part( 'template-parts/latest', 'news' );?>
    </div>
    
  </section>
<?php endwhile;?>
<?php get_footer();?>