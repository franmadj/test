<div class="home-slider" data-ref="slideshow">
    <div class="home-slider__slides show-only-desktop" data-ref="slides">
        <?php
        // check if the repeater field has rows of data
        if (have_rows('slider')):
            $i = 1;
            // loop through the rows of data
            while (have_rows('slider')) : the_row();
                ?>
                <div class="home-slider__slide parallax <?php
                if ($i != 1) {
                    echo '-disabled';
                }
                ?>" style="background-image: url(<?php echo wp_get_attachment_url(get_sub_field('slider_image')); ?>);" data-ref="slide"></div>
                     <?php
                     $i++;
                 endwhile;
             endif;
             ?>
    </div>
    <!--    <div class="home-slider__buttons show-only-desktop">
    <?php
    if (have_rows('slider')):
        $i = 1;
        $j = 0;
        while (have_rows('slider')) : the_row();
            ?>
                                                                            <button aria-label="Slide <?= $i; ?>" class="home-slider__button <?php if ($i == 1) echo '-active'; ?> " data-ref="slideButton" data-index="<?= $j; ?>">
            <?php $desktop_button = wp_get_attachment_image_src(get_sub_field('slider_image'), 'homeslider_button'); ?>
                                                                            <span class="home-slider__thumbnail" style="background-image: url(<?php echo $desktop_button[0]; ?>)"></span>
                                                                            </button>
            <?php
            $i++;
            $j++;
        endwhile;
    endif;
    ?>
        </div>-->
    <div class="home-slider__slides show-only-mobile" data-ref="slidesMobile">
        <?php
        // check if the repeater field has rows of data
        if (have_rows('slider_mobile')):
            $i = 1;
            // loop through the rows of data
            while (have_rows('slider_mobile')) : the_row();
                ?>
                <div class="home-slider__slide parallax <?php if ($i != 1) echo '-disabled'; ?>" style="background-image: url(<?php echo wp_get_attachment_url(get_sub_field('slider_mobile_image')); ?>);" data-ref="slide"></div>
                <?php
                $i++;
            endwhile;
        endif;
        ?>
    </div>
    <div class="home-slider__buttons show-only-mobile">
        <?php
        if (have_rows('slider')):
            $i = 1;
            while (have_rows('slider')) : the_row();
                ?>
                <button aria-label="Slide <?= $i; ?>" class="home-slider__button <?php if ($i == 1) echo '-active'; ?>" data-ref="slideButtonMobile" data-index="<?= $i; ?>">
                    <?php $mobile_button = wp_get_attachment_image_src(get_sub_field('slider_mobile_image'), 'homeslider_button'); ?>
                    <span class="home-slider__thumbnail" <?php if (!empty($mobile_button[0])) { ?>style="background-image: url(<?= $mobile_button[0]; ?>)"<?php } ?>></span>
                </button>
                <?php
                $i++;
            endwhile;
        endif;
        ?>
    </div>
    <div class="home-slider__inner">
        <div class="home-slider__intro">
            <h2 class="home-slider__title"><?= get_field('section_title'); ?><span class="home-slider__reg">&reg;</span></h2>

            <img src="/wp-content/themes/texaswp/assets/img/promo-decorator.png" class="home-slider__intro-border u-disable-ie">
        </div>
        <?php if (get_field('video')): ?>
            <button class="home-slider__cta" data-ref="experienceModal">
                <img src="/assets/img/slider-button.svg" alt="About the Experience" class="home-slider__icon"> Learn more <span class="home-slider__text">about the experience</span>
            </button>
        <?php else: ?>
            <a href="/about/#experience" class="button home-slider__cta home-slider__cta--no-icon">
                Learn more <span class="home-slider__text">about the experience</span>
            </a>
        <?php endif; ?>
    </div>
</div>