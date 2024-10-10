<?php
if (!get_query_var('locations-togo'))
    exit('invalid request');
$the_query = new WP_Query(['name' => get_query_var('locations-togo'), 'post_type' => 'locations']);

if (empty($the_query->post->ID))
    exit('invalid request');

$disable = get_field('disable_togo_event_pages', $the_query->post->ID);
if (is_array($disable) && !empty($disable[0]) && 'yes' == $disable[0])
    wp_redirect('/');

add_filter('wpseo_title', function()use($the_query) {
    return get_field('page_title_togo', $the_query->post->ID);
});
add_filter('wpseo_metadesc', function()use($the_query) {
    return get_field('page_description_togo', $the_query->post->ID);
});
get_header();
?>
<script>
    let title = '<?= $the_query->post->post_title ?>';
    let subtitle = '<?= get_field('location_subtitle', $the_query->post->ID) ?>';
</script>
<?php
if ($the_query->have_posts()) :
    $alternative_find_table = get_field('find_table_alternative_content_toggle');
    $alternative_find_table = !empty($alternative_find_table[0]) && 'yes' == $alternative_find_table[0];
    while ($the_query->have_posts()) : $the_query->the_post();
        ?>
        <div class="location-container location-togo-container">
            <?php
            if (isMobileDevice()) {
                $slide_images = get_field('togo_gallery_mobile', 'option');
            } else {
                $slide_images = get_field('togo_gallery', 'option');
            }
            ?>
            <div class="location-slider" data-ref="slideshow">
                <?php
                if ($slide_images):
//                if (!isMobileDevice()) {
//                    $newSlide=[];
//                    $newSlide[0]=$slide_images[0];
//                    $slide_images=$newSlide;
//                }
                    ?>
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
                    <?php if (!isMobileDevice() && count($slide_images) > 1) : ?>
                        <div class="location-slider__buttons location-slider_events__buttons">
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
                <!--            <a href="/locations" class="location-image__button">Back to map</a>-->

            </div>

            <div class="location-info togo" data-ref="preventOverScroll">
                <div class="location-info__main">

                    <h1 class="location-info__title">
                        <?= $the_query->post->post_title ?> <span class="location-info__subtitle">
                            <?= get_field('location_subtitle', $the_query->post->ID) ?> </span>
                    </h1>

                    <h2>To-Go</h2>
                    <p class="location-info__tagline">
                        <?php if (get_field('togo_tagline')): ?>
                            <?php the_field('togo_tagline'); ?>
                        <?php endif; ?>
                    </p>
                    <?php
                    if (isMobileDevice()) {
                        $image = get_field('togo_image_mobile');
                    } else {
                        $image = get_field('togo_image');
                    }
                    
                    

                    if ($image && !empty($image["url"])):
                        ?>
                        <img width="420" height="202" class="attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt="<?= $image['alt'] ?>" loading="lazy" 
                             src="<?= $image["url"] ?>"/>
                         <?php endif; ?>
                         <?php if (get_field('togo_text_button')): ?>
                        <a href="<?php the_field('togo_link_button'); ?>" class="location-info__cta reserve-with-location" tabindex="0" data-valor="Addison-39355" data-title="Addison, TEXAS">
                            <?php the_field('togo_text_button'); ?>
                            <svg style="width:100%;" class="location-info__cta-border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" tabindex="-1" title="Image"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd" tabindex="-1"></path></svg>
                        </a>
                    <?php endif; ?>
                    <p class="location-info__text">
                        <?php if (get_field('togo_text')): ?>
                            <?php the_field('togo_text'); ?>
                        <?php endif; ?>
                    </p>

                    <?php if (get_field('togo_text_footer')): ?>
                        <p class="location-info__text-bottom">
                            <?php the_field('togo_text_footer'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="location-info catering" data-ref="preventOverScroll">
                <div class="location-info__main">







                    <h2>Catering</h2>
                    <p class="location-info__tagline">
                        <?php if (get_field('catering_tagline')): ?>
                            <?php the_field('catering_tagline'); ?>
                        <?php endif; ?>
                    </p>
                    <?php
                    if (isMobileDevice()) {
                        $image = get_field('catering_image_mobile');
                    } else {
                        $image = get_field('catering_image');
                    }


                    if ($image && !empty($image["url"])):
                        ?>
                        <img width="420" height="202" class="attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt="<?= $image['alt'] ?>" loading="lazy" 
                             src="<?= $image["url"] ?>"/>
                         <?php endif; ?>
                         <?php if (get_field('catering_text_button')): ?>
                        <a href="<?php the_field('catering_link_button'); ?>" class="location-info__cta reserve-with-location" tabindex="0" data-valor="Addison-39355" data-title="Addison, TEXAS">
                            <?php the_field('catering_text_button'); ?>
                            <svg style="width:100%;" class="location-info__cta-border u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" tabindex="-1" title="Image"><path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd" tabindex="-1"></path></svg>
                        </a>
                    <?php endif; ?>
                    <p class="location-info__text">
                        <?php if (get_field('catering_text')): ?>
                            <?php the_field('catering_text'); ?>
                        <?php endif; ?>
                    </p>

                    <?php if (get_field('catering_text_footer')): ?>
                        <p class="location-info__text-bottom">
                            <?php the_field('catering_text_footer'); ?>
                        </p>
                    <?php endif; ?>
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
        //get_template_part('_includes/table', 'finderpopup');
//require get_template_directory() . '/_includes/table-finderpopup.php';
        ?>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
<?php
if ($alternative_find_table)
    get_template_part('_includes/find-table-alternative-content');
?>
<script>
    jQuery(document).ready(function ($) {
        $('.find-table-alt').click(function () {
            $('.find_table_text').removeClass('-disabled');
            $('body').addClass('modal-enabled');
        });
        $('.find_table_text_exit').click(function () {
            $('.find_table_text').addClass('-disabled');
            $('body').removeClass('modal-enabled');
        });


        $('.togo-title').html(`${title}<span style="font-size:1rem;margin-left:3px">${subtitle}</span>`);

    });
</script>
<style>
    .location-info__title{
        text-align: center;
        width: 100%;
        font-size: 4rem;
    }

    .location-info__title .location-info__subtitle{

        font-size: 2.5rem;
    }



    .location-info.catering{
        right: auto;
        left: 0;
    }

    .location-info__main h2{
        color:white;
        text-transform: capitalize;
        text-align: center;
    }
    .togo .location-info__main_head{
        display:none;
    }
    @media (min-width:999px) {
        .location-info__title{
            display: none;
        }
        .location-info__main_head{
            display:flex;justify-content: end;
        }

        .togo .location-info__main_head{
            display:flex;justify-content: start;
        }
        .location-togo-container .location-info{
            padding-top: 19rem;
        } 
    }
    @media (max-width:999px) {
        .location-info.catering{
            padding-top: 3rem;

        }
        .location-info.togo{
            padding-bottom: 3rem;
            border-bottom: solid thin #cccccc5c;

        }
        .location-info.togo .location-info__main{
            margin-bottom: 0;

        }

    }
    .location-info__main img{
        width: 100%;
        height: auto;
    }
    .location-info__main img{
        display: block;
        margin: 35px auto 30px auto;
        border-radius: 5px;
    }
    .location-info__main .location-info__text-bottom{
        opacity: .7;
        font-size: 12px;
    }
    .location-info__main .location-info__tagline{
        text-align: center;
        margin-top: 10px;
        margin-bottom: 15px;
        opacity: .7;

    }
    .location-info__main .location-info__cta{
        float: none;
        display: block;
        margin: 35px auto;

    }

</style>

