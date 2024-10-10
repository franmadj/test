<?php
/*
Template Name:Privacy Policy
*/
get_header();
while ( have_posts() ) :the_post();?>
<div class="privacy-policy c-page-header">
    <div class="privacy-policy-content">

        <h1><?php the_title();?></h1>

            <?php if(get_field('page_landing_text')):?>
                <div class="privacy-policy-landing-text"><?php the_field('page_landing_text');?></div>
            <?php endif;?>

            <?php if(get_field('page_content_title')):?>
                <h2><?php the_field('page_content_title');?></h2>
            <?php endif;?>
    <div class="privacy-policy-content-text"><?php the_content();?></div>
            

    </div>
</div>
<?php endwhile;?>
<?php get_footer();?>