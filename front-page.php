<?php
get_header();
if (have_posts()) :
    while (have_posts()) :the_post();
        if (has_post_thumbnail(get_the_ID())):
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
            $hero_image = $image[0];
        endif;
        $data = get_field('background_video');
        $value = array();
        $iframeClass = '';


        // DEV: What service is the user pasting in?
        if (preg_match('/youtube|youtu.be/', $data)) {
            $value['service'] = 'YouTube';
            $iframeClass = 'ytplayer';
        } elseif (preg_match('/vimeo/', $data)) {
            $value['service'] = 'Vimeo';
            $iframeClass = 'vmplayer';
        } else {
            $value['service'] = false;
        }

        // DEV: Find the identifier for this particular service.
        if ($value['service'] == 'YouTube') {
            preg_match('/\/watch\?v=(.*)/', $data, $matches);

            $value['identifier'] = $matches[1];
            $videoUrl = 'https://www.youtube.com/embed/' . $value['identifier'] . '?controls=1&t=31s&loop=1&showinfo=0&rel=0&enablejsapi=1&autoplay=1&playlist=' . $value['identifier'];
        } elseif ($value['service'] == 'Vimeo') {
            preg_match('/vimeo.com\/(.*)/', $data, $matches);

            $value['identifier'] = $matches[1];
            $videoUrl = 'https://player.vimeo.com/' . $value['identifier'] . '?background=1';
            ?>
            <script type="text/javascript" src="https://www.youtube.com/iframe_api"></script>
            <script type="text/javascript">
                function onYouTubeIframeAPIReady() {
                    document.querySelectorAll('.ytplayer').forEach((item) => {
                        new YT.Player(item, {
                            events: {
                                'onReady': (event) => {
                                    event.target.playVideo();
                                    event.target.mute();
                                }
                            }
                        })
                    })
                }
            </script>
            <?php
        } else {
            $iframeClass = 'ntplayer';
            $videoUrl = get_field('background_video');
        }
        ?>

        <div class="hero parallax <?php if (!isMobileDevice()) { ?> hero-parallax-desktop-loader <?php } ?>" <?php if (isMobileDevice()) { ?>style="background-image: url(<?php echo $hero_image; ?>);" <?php } ?>>
            <div class="c-video__wrapper">
                <div class="c-video__inner">
                    <video autoplay="" loop="" muted="" 
                           poster="<?php if (!isMobileDevice()) { echo 'https://texasdebrazil.com/wp-content/uploads/2024/09/tdb-bg.jpg'; }else{ echo $hero_image; } ?>" style="width:100%;">
			<source src="<?= get_template_directory_uri() ?>/assets/videos/tdb-hero.mp4?a=2" type="video/mp4">
<!--			<source src="<?= get_template_directory_uri() ?>/assets/videos/tdb-hero.ogg" type="video/ogg">
			<source src="<?= get_template_directory_uri() ?>/assets/videos/tdb-hero.webm" type="video/webm">-->
		</video>
                </div>
            </div>
            <div class="hero__inner">
                <?php if (get_field('home_page_logo')): ?>
                    <img src="<?php the_field('home_page_logo'); ?>" alt="Texas de brazil churrascaria steakhouse logo" class="hero__logo">
                <?php endif; ?>
                <?php get_template_part('_includes/table', 'finder'); ?>
            </div>
            <a href="#promo" class="hero__arrow" title="Scroll down"></a>
        </div>
        <h2 class="see-cooking display-mobile" >See what we have cooking...</h2>
        <div class="home-promo" id="promo">

            <div class="home-promo__photo display-desktop">
                <?php $featured_promotion = get_field('featured_promotion'); ?>
                <?php if (!empty($featured_promotion['image'])): ?>
                    <img src="<?= $featured_promotion['image'] ?>" alt="" class="home-promo__image" />
                    <img alt="" class="home-promo__frame" src="/assets/img/textured-frame.png" />
                <?php endif; ?>
            </div>

            <div class="home-promo__photo display-mobile">
                <?php $featured_promotion = get_field('featured_promotion'); ?>
                <?php if (!empty($featured_promotion['image_mobile'])): ?>
                    <img src="<?= $featured_promotion['image_mobile'] ?>" alt="" class="home-promo__image" />
                    <img alt="" class="home-promo__frame" src="/assets/img/textured-frame.png" />
                <?php endif; ?>
            </div>

            <div class="home-promo__content">
                <?php if (!empty($featured_promotion['eyebrow'])): ?>
                    <h2 class="home-promo__intro t-align-left display-desktop"><?= $featured_promotion['eyebrow']; ?></h2>
                <?php endif; ?>

                <?php if (!empty($featured_promotion['eyebrow_mobile'])): ?>
                    <h2 class="home-promo__intro t-align-left display-mobile"><?= $featured_promotion['eyebrow_mobile']; ?></h2>
                <?php endif; ?>


                <?php if (!empty($featured_promotion['heading'])): ?>
                    <h2 class="home-promo__title display-desktop"><?= $featured_promotion['heading']; ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($featured_promotion['heading_mobile'])): ?>
                    <h2 class="home-promo__title display-mobile"><?= $featured_promotion['heading_mobile']; ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($featured_promotion['description'])): ?>
                    <div class="home-promo__body display-desktop">
                        <?= $featured_promotion['description']; ?>
                    </div>
                <?php endif; ?>

                <div class="home-promo__body display-mobile">
                    <?= $featured_promotion['description_mobile']; ?>
                </div>

                <?php if (!empty($featured_promotion['link'])): ?>
                    <a href="<?= $featured_promotion['link']; ?>" class="home-promo__cta display-desktop custom-border-bottom" target="blank">
                        <?= $featured_promotion['link_text']; ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($featured_promotion['link_mobile'])): ?>
                    <a href="<?= $featured_promotion['link_mobile']; ?>" class="home-promo__cta display-mobile" target="blank">
                        <?= $featured_promotion['link_text_mobile']; ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
        <!-- promo section end- -->

        <?php
        $thumbnail_id = get_term_meta(CATEGORY_GIFT_CARDS, 'thumbnail_id', true);
        $gift_card_image = wp_get_attachment_url($thumbnail_id);

        $thumbnail_id = get_term_meta(CATEGORY_MERCHANDISE, 'thumbnail_id', true);
        $merchandise_image = wp_get_attachment_url($thumbnail_id);

        $thumbnail_id = get_term_meta(CATEGORY_PACKAGES, 'thumbnail_id', true);
        $packages_image = wp_get_attachment_url($thumbnail_id);
        ?>
        <section class="front-shop">

            <div class = "o-container">
                <h3 class="title">Give the gift of churrasco</h3>
                <div class = "u-product-list">


                    <li class = "c-product" data-ref='/shop/gift-cards'>

                        <a href = "/shop/gift-cards" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product" aria-label="Shop gift cards">
                            <h4 class="mb-2">gift cards</h2>

                                <img width = "283" height = "180" src = "<?php echo $gift_card_image; ?>" 
                                     class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt = "Texas de Brazil Red Dining Card" loading = "lazy">
                                <span class = "c-product__title">Standard and Digital Options</span>


                                <span class = "button button--small c-product__button custom-border-bottom">Shop</span>
                        </a>
                    </li>

                    <li class = "c-product" data-ref='<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop/'>
                        <a href = "<?php echo BUTCHER_SITE_URL; ?>/shop/butcher-shop/" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product" aria-label="Shop tdb butcher shop">
                            <h4 class="mb-2">tdb butcher shop</h2>


                                <img width = "283" height = "180" src = "<?php echo $packages_image; ?>" 
                                     class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" alt = "Texas de Brazil Red Dining Card" loading = "lazy">
                                <span class = "c-product__title">Packages & à la carte</span>


                                <span class = "button button--small c-product__button custom-border-bottom">Shop</span>
                        </a>
                    </li>

                    <li class = "c-product" data-ref='<?php echo BUTCHER_SITE_URL; ?>/shop/market/merchandise'>
                        <a href = "<?php echo BUTCHER_SITE_URL; ?>/shop/market/merchandise" class = "woocommerce-LoopProduct-link woocommerce-loop-product__link c-product" aria-label="Shop Merchandise">
                            <h4 class="mb-2">Market</h2>


                                <img width = "283" height = "180" src = "<?php echo $merchandise_image; ?>" class = "attachment-woocommerce_thumbnail_new size-woocommerce_thumbnail_new" 
                                     alt = "Texas de Brazil Red Dining Card" loading = "lazy" >
                                <span class = "c-product__title">from knives to golf balls</span>


                                <span class = "button button--small c-product__button custom-border-bottom">Shop</span>
                        </a>
                    </li>


                    <a href="/shop" class="button button--small c-product__button shop-now-btn custom-border-bottom">Shop Now</a>

                </div>
            </div>

        </section>



        <!-- Home page slider section start -->
        <?php get_template_part('template-parts/home', 'slider'); ?>
        <!-- Home slider section end -->
        <section class="menu-preview">
            <div class="menu-preview__intro fade-in-element">
                <div class="menu-preview__content">
                    <h1 class="menu-preview__title"><?php the_field('menu_heading'); ?></h1>
                    <p class="menu-preview__body">
                        <?php the_field('intro'); ?>
                    </p> 
                </div>
                <div class="menu-preview__deco"></div>
            </div>
            <?php
            $borderModifiers = array('red', 'orange', 'blue', 'brown');
            $menus = get_field('menu_page');
            $color = 0;
            foreach ($menus as $menu_id):
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($menu_id), 'full');
                ?>
                <div class="menu-thumbnail" style="-webkit-transform: translate3d(0,0,0);">
                    <a href="<?php echo get_the_permalink($menu_id); ?>" class="menu-thumbnail__inner fade-in-element ">
                        <div class="menu-thumbnail__background" style="background-image: url(<?php echo $image[0]; ?>)"></div>
                        <div class="menu-thumbnail__label">
                            <span class="menu-thumbnail__note"><?php echo get_field('tagline', $menu_id); ?></span>
                            <h2 class="menu-thumbnail__title"><?php echo get_the_title($menu_id); ?></h2>
                            <svg aria-hidden='true' class="menu-thumbnail__border -<?php echo!empty($borderModifiers[$color]) ? $borderModifiers[$color] : ''; ?> u-disable-ie" viewBox="0 0 302 8" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                            <title>menu thumbnail border <?php echo!empty($borderModifiers[$color]) ? $borderModifiers[$color] : ''; ?></title>
                            <path d="M0 4.856l10.51-3.5 9.42 2.183h32.857L111.742 0l24.61 3.61 69.805-.852 30.506 2.098H302V7.22H0" fill="#D29136" fill-rule="evenodd"/></svg>
                        </div>
                    </a>
                    <div class="menu-thumbnail__deco"></div>
                </div>
                <?php
                $color++;
            endforeach;
            ?>
            <a href="/menu" class="menu-preview__cta">
                <span class="menu-preview__cta-text">See full menu</span>
            </a>
        </section>
        <?php get_template_part('template-parts/homelocation', 'parallax'); ?>
        <?php
        $groupdining = get_field('desktop_image');
        $groupdining_mobile = get_field('responsive_image');
        if (!$groupdining) {
            $groupdining = "https://s3.amazonaws.com/texas-de-brazil-website/general/Homepage/_heroShort/Salad-Bar-HP-GD.jpg";
        }
        if (!$groupdining_mobile) {
            $groupdining_mobile = "https://s3.amazonaws.com/texas-de-brazil-website/general/Homepage/Mobile-Server-HP-GD.jpg";
        }
        ?>
        <section class="home-group-dining" style="background-image: url(<?php echo $groupdining; ?>)" data-ref="responsiveVisualElement" data-mobile="<?php echo $groupdining_mobile; ?>" data-desktop="<?php echo $groupdining; ?>">
            <div class="home-group-dining__inner">
                <h2 class="home-group-dining__title"><?php the_field('group_dining_heading'); ?></h2>
                <p class="home-group-dining__lead">
                    <?php the_field('lead'); ?>
                </p>
                <div class="home-group-dining__body">
                    <?php the_field('dining_description'); ?>
                </div>
                <a href="/group-dining/" class="home-group-dining__cta  custom-border-bottom">
                    <?php the_field('call_to_action'); ?>
                </a>
            </div>
        </section>
        <section class="home-more">
            <h2 class="home-more__title"><?php the_field('more_section_heading'); ?></h2>
            <p class="home-more__body">
                <?php the_field('more_section_text'); ?>
            </p>
            <div class="home-eclub" style="background-image: url(<?php the_field('eclub_background'); ?>);" data-ref="responsiveVisualElement" data-mobile="<?php the_field('eclub_background'); ?>" data-desktop="<?php the_field('eclub_background'); ?>">
                <h3 class="home-eclub__title"><?php the_field('join_section_heading'); ?></h3>
                <p class="home-eclub__intro">
                    <?php the_field('join_section_text'); ?>
                </p>
                <ul class="home-eclub__features">
                    <?php
                    if (have_rows('feature')):
                        while (have_rows('feature')):the_row();
                            ?>
                            <li class="home-eclub__feature -<?php the_sub_field('icon'); ?>"><?php the_sub_field('text'); ?></li>
                            <?php
                        endwhile;
                    endif;
                    ?>

                </ul><a href="/eclub/" class="home-eclub__cta custom-border-bottom">Join now</a>
            </div>
            <!--            <div class="home-gift-cards">
                            <h3 class="home-gift-cards__title"><?php the_field('gift_card_title'); ?></h3>
                            <p class="home-gift-cards__intro"><?php the_field('gift_card_subtitle'); ?></p>
            <?php if (get_field('gift_card_image')): ?>
                                                                            
                <?php
                $attr = array('class' => 'home-gift-cards__img');
                echo fly_get_attachment_image(get_field('gift_card_image'), array(208, 134), array('center', 'center'), $attr);
                ?>
            <?php endif; ?>
                            <a href="/shop/" class="home-gift-cards__cta">Buy now</a></div>
                        <div class="home-social">
                            <img class="home-social__img" src="<?php echo home_url(); ?>/assets/img/social-wedge.png" srcset="<?php echo home_url(); ?>/assets/img/social-wedge@2x.png 484w,<?php echo home_url(); ?>/assets/img/social-wedge.png 242w" sizes="242px" alt="Social Media">
                            <h3 class="home-social__title">Follow Us</h3>
                            <div class="home-social__links">
                                <a href="<?php the_field('facebook_link', 'options'); ?>" target="_blank" class="home-social__link -facebook" aria-label="Facebook"></a>
                                <a href="<?php the_field('twitter_link', 'options'); ?>" target="_blank" class="home-social__link -twitter" aria-label="Twitter"></a>
                                <a href="<?php the_field('instagram_link', 'options'); ?>" target="_blank" class="home-social__link -instagram" aria-label="Instagram"></a>
                                <a href="<?php the_field('pinterest', 'options'); ?>" target="_blank" class="home-social__link -pinterest" aria-label="Pinterest"></a>
                            </div>
                        </div>-->
        </section>


        <!-- Video in Model -->
        <div role="dialog" aria-modal="true" aria-labelledby="Modal experience video">
            <div class="c-modal -modal-disabled u-experience-modal">
                <div class="experience-video"></div>
                <!-- TODO: Should be in javascript routing, preferably in a plugin like Popup  -->
                <script type="text/javascript">
                    var tag = document.createElement('script'),
                            firstScriptTag = document.getElementsByTagName('script')[0],
                            player;
                    tag.src = "https://www.youtube.com/iframe_api";
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                    function onYouTubeIframeAPIReady() {
                        player = new YT.Player(document.querySelector('.experience-video'), {
                            videoId: '<?php the_field("video"); ?>',
                            width: '100%',
                            height: '100%',
                            playerVars: {
                                modestbranding: 1,
                                showinfo: 0,
                                rel: 0,
                                controls: 0
                            }
                        });
                        window.player = player;
                    }
                    //document.getElementById('#backgroundVideo').mute();
                </script>
            </div>
            <div class="c-modal-close -modal-disabled" data-ref="modalTwoClose" tabindex="0" role="button"></div>
            <div class="c-modal-overlay -modal-disabled" data-ref="modalTwoOverlay"></div>
        </div>

        <style>
            .hero-parallax-desktop-loader{
                position: relative;
            }
            .hero-parallax-desktop-loader:before{
                background-repeat: no-repeat !important;
                background-position: 0px -80px !important;
                background-color: #000 !important;
                background-size: cover !important;
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 1;
                /*background: url(https://texasdebrazil.com/wp-content/uploads/2024/08/tdb-bg-3.jpg);*/
                z-index: -1;
            }

        </style>




        <?php
    endwhile;
endif;
get_footer();
