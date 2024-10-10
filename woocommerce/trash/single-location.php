<?php
get_header();
?>
<?php
while (have_posts()) :the_post();
    ?>
    <div class="location-container">
        <?php $slide_images = get_field('photo'); ?>
        <div class="location-slider" data-ref="slideshow">
            <?php if ($slide_images): ?>
                <div class="location-slider__slides" data-ref="slides">

                    <?php
                    $i = 1;
                    foreach ($slide_images as $slide_image):
                        ?>
                        <div class="location-slider__slide parallax <?php if ($i > 1) { ?> -disabled <?php } ?>" style="background-image: url(<?php echo $slide_image['url']; ?>);" data-ref="slide"></div>
                        <?php
                        $i++;
                    endforeach;
                    ?>

                </div>
                <?php if (count($slide_images) > 1) : ?>
                    <div class="location-slider__buttons">
                        <?php
                        $j = 1;
                        $i = 0;
                        foreach ($slide_images as $slide_image):
                            ?>
                            <button aria-label="Slide <?= $j; ?>" class="location-slider__button<?php if ($i == 0) { ?> -active <?php } ?>" data-ref="slideButton" data-index="<?= $i; ?>">
                                <span class="location-slider__thumbnail" style="background-image: url(<?php echo $slide_image['sizes']['thumbnail']; ?>)"></span>
                            </button>
                            <?php
                            $i++;
                            $j++;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <a href="/locations" class="location-image__button">Back to map</a>

        </div>

        <div class="location-info" data-ref="preventOverScroll">
            <div class="location-info__main">
                <h1 class="location-info__title">
                    <?php the_title(); ?>
                    <span class="location-info__subtitle">
                        <?php if (get_field('location_subtitle')): ?>
                            <?php the_field('location_subtitle'); ?>
                        <?php else: ?>

                        <?php endif; ?>
                    </span>
                </h1>

                <div class="location-info__meta">
                    <div class="location-info__address">
                        <?php
                        if (get_field('shopping_plaza')):
                            the_field('shopping_plaza');
                        endif;
                        ?>

                        <?php
                        $map_location = get_field('location');
                        if ($map_location):
                            echo $map_location['address'];
                        endif;
                        ?>
                    </div>

                    <?php if (get_field('map_share_link')): ?>
                        <?php $url = get_field('map_share_link'); ?>
                    <?php else: ?>
                        <?php $url = 'https://www.google.com/maps/place/' . str_replace(" ", "+", $map_location['address']); ?>
                    <?php endif; ?>

                    <a href="<?php echo $url; ?>" target="_blank" class="location-info__link">Get Directions</a>
                    <?php if (have_rows('phone_numbers')): ?>
                        <div class="location-info__numbers">
                            <?php while (have_rows('phone_numbers')):the_row(); ?>
                                <div class="location-info__number">
                                    <span class="location-info__number-label">
                                        <?php the_sub_field('label'); ?>:
                                    </span>

                                    <?php the_sub_field('number'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (get_field('find_a_table_url_other')): ?>
                    <a href="<?php the_field('find_a_table_url_other'); ?>" target="_blank">
                        <div class="location-info__cta" >
                            Find a table
                        </div>
                    </a>
                <?php else: ?>

                    <div class="location-info__cta" data-ref="reserveButton" data-info="<?php echo get_the_title().'-'.get_field('restaurant_id');?>">
                        Find a table
                        <svg class="location-info__cta-border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"></path></svg>

                    </div>

                <?php endif; ?>

                <?php if (get_field('pdf_title') && get_field('pdf_file')): ?>
                    <div class="location-info__download-cta">

                        <a href="<?php the_field('pdf_file'); ?>" target="_blank" download class="location-info__link"><?php the_field('pdf_title'); ?></a>
                    </div>
                <?php endif; ?>


            </div>

            <div class="location-info__blocks">
                <?php
                while (the_flexible_field("pricing_&_hours")):
                    if (get_row_layout() == "pricing_and_hours"):
                        ?>
                        <div class="location-info__block">
                            <div class="info-block">
                                <?php
                                if (have_rows('heading')):
                                    while (have_rows('heading')):the_row();
                                        ?>
                                        <h2 class="info-block__heading">
                                            <?php the_sub_field('heading'); ?>
                                            <span class="info-block__price"><?php the_sub_field('price'); ?></span>
                                        </h2>
                                        <?php
                                    endwhile;
                                endif;
                                ?>
                                <?php
                                if (have_rows('subheading')):
                                    while (have_rows('subheading')):the_row();
                                        ?>
                                        <span class="info-block__subheading">
                                            <?php the_sub_field('subheading_label'); ?>
                                            <span class="info-block__price"><?php the_sub_field('subheading_price'); ?></span>

                                        </span>
                                        <?php
                                    endwhile;
                                endif;
                                ?>
                                <div class="info-block__schedule">
                                    <?php
                                    if (have_rows('schedule')):
                                        while (have_rows('schedule')):the_row();
                                            ?>
                                            <span class="info-block__time"><?php the_sub_field('days'); ?> : <?php the_sub_field('hours'); ?></span>

                                            <?php
                                        endwhile;
                                    endif;
                                    ?>    
                                </div>
                                <?php if (get_sub_field('dinner_menu_served')): ?>
                                    <span class="info-block__notice">*Dinner menu served.</span>
                                <?php endif; ?>
                                <div class="info-block__note">
                                    <?php
                                    if (have_rows('notes')):
                                        while (have_rows('notes')):the_row();
                                            ?>
                                            <?php the_sub_field('note'); ?>
                                            <?php
                                        endwhile;
                                    endif;
                                    ?>    
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (get_row_layout() == "general"): ?>
                        <div class="location-info__block">

                            <div class="info-block">

                                <h2 class="info-block__heading">
                                    <?php the_sub_field('heading'); ?>
                                </h2>
                                <?php
                                if (have_rows('items')):
                                    while (have_rows('items')):the_row();
                                        ?>
                                        <div class="info-block__note">
                                            <?php the_sub_field('note'); ?>
                                        </div>
                                        <?php
                                    endwhile;
                                endif;
                                ?>   


                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>

            </div>
        </div>

    </div>

    <script type="application/ld+json">
        {
        "@context": "http://schema.org",
        "@type": "LocalBusiness",
        "address": {
        "@type": "PostalAddress",
        "addressLocality": "{{ address.locality_short }}",
        "addressRegion": "{{ address.administrative_area_level_1 }}",
        "postalCode": "{{ address.postal_code }}",
        "streetAddress": "{{ address.street_number|default }} {{ address.route|default }}"
        },
        "description": "A superb collection of fine gifts and clothing to accent your stay in Mexico Beach.",
        "name": "Texas de Brazil",
        "telephone": "{{ entry.phoneNumbers[0] ? entry.phoneNumbers[0].number : '' }}",
        "image": "{{ entry.image.first.url }}",
        "priceRange": "$$$"
        }
    </script>
    <?php
    get_template_part('_includes/table', 'finderpopup');
//require get_template_directory() . '/_includes/table-finderpopup.php';
    ?>
<?php endwhile; ?>
<?php get_footer(); ?>

