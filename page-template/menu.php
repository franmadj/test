<?php
/*
  Template Name:Menu
 */
get_header();
?>
<?php while (have_posts()) :the_post(); ?>
    <?php
    if (have_rows('content')):
        // loop through the rows of data
        while (have_rows('content')) : the_row();
            ?>
            <div class="o-grid o-grid--gutters s-promotions tx-menu-hero">
                <div class="o-col">
                    <div class="c-promo c-promo--feature menu-feature hero" data-ref="responsiveVisualElement" style="background-image: url(<?php echo get_sub_field('desktop_image'); ?>);" data-mobile="<?php echo get_sub_field('mobile_image'); ?>" data-desktop="<?php echo get_sub_field('desktop_image'); ?>">
                        <div class="c-promo__content">
                            <h1 class="c-promo__title" style="color: #FFF;"><?php the_sub_field('page_title'); ?></h1><span class="c-promo__teaser"><?php the_sub_field('teaser'); ?></span></div>
                    </div>
                </div>
                <a href="#meats" class="hero__arrow" aria-label="Scroll down" data-focus="meats"></a>
            </div>
            <?php
        endwhile;
    endif;
    ?>
    <?php get_template_part('template-parts/menupage', 'scroll'); ?>
    <div class="s-group-dining">
        <?php
        if (have_rows('menu_content_block')):
            // loop through the rows of data
            while (have_rows('menu_content_block')) : the_row();
                ?>
                <div class="o-grid o-grid--gutters promo" id="<?php the_sub_field('scroll_section_id'); ?>">
                    <div class="o-col">
                        <section class="menu-directory" style="background-image: url(<?php the_sub_field('menu_image'); ?>)" data-ref="responsiveVisualElement" data-mobile="<?php the_sub_field('menu_mobile_image'); ?>" data-desktop="<?php the_sub_field('menu_image'); ?>">
                            <div class="menu-directory__inner">
                                <h2 class="menu-directory__title"><?php the_sub_field('menu_heading'); ?></h2>
                                <div class="menu-directoty__bb"></div>
                                <p class="menu-directory__lead">
                                    <?php the_sub_field('menu_lead_text'); ?>
                                </p>
                                <?php $menu_link = get_sub_field('menu_page_link'); ?>
                                <?php if (isset($menu_link[0]) && $menu_link[0] == 1239): ?>
                                    <div class="px-5">
                                        <?php echo get_post_field('post_content', $menu_link[0]); ?>

                                    </div>
                                <?php endif; ?>

                                <?php if (isset($menu_link[0]) && have_rows('menu_items', $menu_link[0])): ?>
                                    <ul class="menu-directory__list">
                                        <?php
                                        // loop through rows (sub repeater)
                                        while (have_rows('menu_items', $menu_link[0])): the_row();
                                            ?>

                                            <li><?php the_sub_field('menu_item'); ?></li>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </ul>

                                <?php if (isset($menu_link[0]) && $menu_link[0] == ''): ?>
                                    <div class="menu-directory__col mt-3">
                                        <a href="<?php the_field('takeout_menu', 'option'); ?>" target="_blank" class="button menu-directory__cta mr-5 display-desktop">View Takeout Menu</a>
                                        <a href="<?php the_field('takeout_menu', 'option'); ?>" target="_blank" class="button menu-directory__cta mr-5 display-mobile">View Takeout Menu</a>
                                        <a href="<?php the_field('catering_menu', 'option'); ?>" target="_blank" class="button menu-directory__cta custom-border-bottom">View Catering Menu</a>
                                    </div>
                                <?php elseif (isset($menu_link[0])): ?>
                                    <div class="menu-directory__col mt-3" data-id="<?php echo isset($menu_link[0]) ? $menu_link[0] : ''; ?>"> 
                                        <a href="<?php the_sub_field('scroll_section_id'); ?>" class="button menu-directory__cta custom-border-bottom"><?php the_sub_field('button_label'); ?></a>
                                    </div>
                                <?php else: ?>
                                    <?php
                                    $buttonLinkl2 = get_sub_field('2nd_button_link');
                                    if ($buttonLinkl2) {
                                        $buttonLabel2 = get_sub_field('2nd_button_label');
                                        ?>
                                        <div class="menu-directory__col mt-3"> 
                                            <a target="blank" href="<?php echo $buttonLinkl2; ?>" class="button menu-directory__cta custom-border-bottom"><?php echo $buttonLabel2; ?></a>
                                        </div>
                                    <?php } ?>
                                    <div class="menu-directory__col mt-3"> 
                                        <a target="blank" href="<?php the_sub_field('downloadable'); ?>" class="button menu-directory__cta custom-border-bottom"><?php the_sub_field('button_label'); ?></a>
                                    </div>
                                <?php endif; ?>
                                <div class="menu-directory__col menu-directory__claim">
                                    <small><?php the_field('bottom_message'); ?></small>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>