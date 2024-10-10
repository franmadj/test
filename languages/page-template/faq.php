<?php
/*
Template Name:FAQ
*/
get_header();
while ( have_posts() ) :the_post();?>

  <div class="faq-landing">
    <div class="faq-landing-content">

        <?php if(get_field('faq_subtitle')):?>
            <h3><?php the_field('faq_subtitle');?></h3>
       	<?php endif;?>

        <?php if(get_field('faq_title')):?>
            <h1><?php the_field('faq_title');?></h1>
        <?php endif;?>

        <div class="faqs">
        	<?php get_template_part( 'template-parts/all', 'faqs' );?>
        </div>


    </div>
</div>
<?php endwhile;?>
<?php get_footer();?>