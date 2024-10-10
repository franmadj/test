<?php
/*
  Template Name:FAQ
 */
get_header();
while (have_posts()) :the_post();
    ?>

    <div class="faq-landing c-page-header">
        <div class="faq-landing-content">

            

            <?php if (get_field('faq_title')): ?>
                <h1><?php the_field('faq_title'); ?></h1>
            <?php endif; ?>
                
                <?php if (get_field('faq_subtitle')): ?>
                <h2><?php the_field('faq_subtitle'); ?></h2>
            <?php endif; ?>

            <div class="faqs">
                <?php get_template_part('template-parts/all', 'faqs'); ?>
            </div>


        </div>
    </div>
<?php endwhile; ?>
<style>
    .faq-landing-content h2 {
        font-size: 20px;
        color: #000;
        line-height: 30px;
        font-weight: 300;
        letter-spacing: 1px;
        margin-bottom: 11px;
        margin-top: 20px;
        font-family: Oswald;
        text-transform: uppercase;
        text-align: center;
        display: block;
    }
    .faqs h3 {
        font-size: 20px;
        letter-spacing: 1px;
        line-height: 20px;
        margin-bottom: 15px;
        color: #000504;
        text-transform: uppercase;
        font-family: Oswald;
    }
</style>
<?php get_footer(); ?>
