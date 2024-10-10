<?php
/*
  Template Name:About Us
 */
get_header();
while (have_posts()) :the_post();
    if (has_post_thumbnail($post->ID)):
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
        $hero_image = $image[0];
    else:
        $hero_image = home_url() . '/assets/img/about/about-bg.png';
    endif;
    if (get_field('mobile_hero_image'))
        $mobile_hero_image = get_field('mobile_hero_image');
    else
        $mobile_hero_image = $hero_image;
    ?>
    <div id="about-us">
        <div class="hero about-us-hero" style="background-image: url(<?php echo $hero_image; ?>);" data-ref="responsiveVisualElement" data-mobile="<?php echo $mobile_hero_image; ?>" data-desktop="<?php echo $hero_image; ?>">
            <div class="about-us-hero_content">
                <h1><?php the_field('hero_title'); ?></h1>
                <div class="white-hr"></div>
                <p><?php the_field('hero_subtitle'); ?></p>
            </div>
            <a href="#showHistory" class="hero__arrow" aria-label="Scroll down"></a>
        </div>
        <?php if (get_field('story_section_title')): ?>
            <section class="about-history" id="showHistory">
                <div class="about-history_content">
                    <h2 class="about-title"><?php the_field('story_section_title'); ?></h2>
                    <div class="ahc-block">
                        <p><?php the_field('story_left_content'); ?></p>
                    </div>
                    <div class="ahc-block">
                        <p><?php the_field('story_right_content'); ?></p>
                    </div>
                    <div class="red-hr"></div>
                </div>
            </section>
        <?php endif; ?>
        <?php if (get_field('experience_title')): ?>
            <section class="about-chef" id="experience">
                <div class="about-chef__content" style="margin-bottom: 0;">
                    <div class="about-chef__col"><img src="https://texasdebrazil.com/wp-content/uploads/2019/05/About-Us-Experience-Dining.jpg" class="about-chef__img" alt="About the Chef"></div>
                    <!-- ac-col -->
                    <div class="about-chef__col">
                        <div class="about-chef__intro">
                            <h4 class="about-chef__subtitle"><?php the_field('experience_top_title'); ?></h4>
                            <h2 class="about-chef__title"><?php the_field('experience_title'); ?></h2>
                            <div class="about-chef__txt">
                                <?php the_field('experience_description'); ?>
                            </div>
                        </div>
                        <div class="about-chef-purchase">
                            <?php if (get_field('about_chef_purchase_thumbnail')): ?>
                                <div class="about-chef-purchase-thumb">
                                    <img src="<?php the_field('about_chef_purchase_thumbnail'); ?>">
                                </div>
                            <?php endif; ?>
                            <?php if (get_field('about_chef_purchase_description')): ?>
                                <div class="about-chef-purchase-content">
                                    <p><?php the_field('about_chef_purchase_description'); ?></p>
                                    <a href="<?php the_field('about_chef_purchase_button'); ?>" target="_blank" class="btn-red-arrow">Purchase</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- about-chef-purchase -->
                    </div>
                    <!-- ac-col -->
                </div>
                <!-- about-chefs-content -->
                <div class="about-quote__frame">
                    <?php
                    if (have_rows('about_chef_testimonials')):
                        // loop through the rows of data
                        while (have_rows('about_chef_testimonials')) : the_row();
                            ?>
                            <div class="about-quote">
                                <div class="about-quote__content">
                                    <p class="about-quote__txt"><?php the_sub_field('testimonial'); ?></p>
                                    <div class="about-quote__by">— <?php the_sub_field('testimonial_by'); ?></div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                    endif;
                    ?>
                </div>
                <!-- about-quote-frame -->
            </section>
        <?php endif; ?>
        <?php if (get_field('about_charity_hero_image')): ?>
            <?php
            $charity_image = get_field('about_charity_hero_image');
            if (get_field('about_charity_hero_image_mobile'))
                $charity_mobile_image = get_field('about_charity_hero_image_mobile');
            else
                $charity_mobile_image = get_field('about_charity_hero_image');;
            ?>
            <div class="hero about-charity" style="background-image: url(<?php echo $charity_image; ?>);" data-ref="responsiveVisualElement" data-mobile="<?php echo $charity_mobile_image; ?>" data-desktop="<?php echo $charity_image; ?>">
                <div class="about-charity-content">
                    <div class="black-overlay">
                        <h2><?php the_field('about_charity_title'); ?></h2>
                        <p><?php the_field('about_charity_description'); ?></p>
                        <a href="#donation" class="btn-red-arrow custom-border-bottom" data-ref="openDonationModal" data-ignore="true" role="button">Request Donation</a></div>
                </div>
                <a href="#showcommunity" class="hero__arrow" aria-label="Show Community"></a>
            </div>
        <?php endif; ?>
    <?php if (get_field('about_community_title')): ?>
            <section class="about-community" id="showcommunity">
                <div class="about-community-content">
                    <h2 class="about-title"><?php the_field('about_community_title'); ?></h2>
                    <?php
                    if (have_rows('items')):
                        while (have_rows('items')):the_row();
                            ?>
                            <div class="acc-block">
                                <h3><?php the_sub_field('item_heading'); ?></h3>
                                <p><?php the_sub_field('item_text'); ?></p>
                            </div>
            <?php endwhile; ?>
            <?php endif; ?>
                </div>
            </section>
    <?php endif; ?>
    </div>
    <?php
endwhile;
get_footer();
?>
<?php get_template_part('_includes/donation-modal'); ?>

