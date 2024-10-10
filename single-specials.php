<?php
get_header();
while (have_posts()) :the_post();
    $fullWidth = 'Yes' == get_field('full_width') ? true : false;
    ?>
    <a href="/specials/" class="u-promo-back">Back to All Promotions</a>
    <div class="o-content u-promo-wrapper o-content-specials">
        <div class="o-grid--desktop">
            <div class="o-col--desktop">
                <div class="u-promo-content-wrapper">
                    <h1 class="u-promo-title"><?php the_title(); ?></h1>
                    <?php if ($fullWidth) { ?>
                        <span class="t-lead-text u-promo-lead-text"><?php the_field('lead_text'); ?></span>
                        <div class="single-detail_photo"><?php echo fly_get_attachment_image(get_field('detail_photo'), array(550, 367), true); ?></div>
                    <?php } ?>
                    <div class="u-promo-content">
                        <?php the_content(); ?>
                    </div>

                    <?php if ($fullWidth) { ?>
                        <a href="<?php the_field('interior_button_url'); ?>" class="button u-promo-button"<?php if (get_field('trigger_modal') == 'yes'): ?> data-ref="reserveButton"<?php endif; ?>><?php the_field('exterior_button_text'); ?></a>
                    <?php } ?>

                </div>
            </div>
            <?php if (!$fullWidth) { ?>
                <div class="o-col--desktop single-specials-image">

                    <?php if (get_field('detail_photo')): ?>
                    <span class="t-lead-text u-promo-lead-text"><?php the_field('lead_text'); ?></span>
                    <div class="single-detail_photo"><?php echo fly_get_attachment_image(get_field('detail_photo'), array(550, 367), true); ?></div>
                        <a href="<?php the_field('interior_button_url'); ?>" class="button u-promo-button"<?php if (get_field('trigger_modal') == 'yes'): ?> data-ref="reserveButton"<?php endif; ?>><?php the_field('exterior_button_text'); ?></a>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endwhile;
?>
<?php get_footer(); ?>