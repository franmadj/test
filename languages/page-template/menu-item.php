<?php
/*
Template Name:Menu Item
*/
get_header();
?>
<?php
while ( have_posts() ) :the_post(); 
$hotspot_post = get_field('hotspot_post');
if($hotspot_post):
    $hotspot = get_post_meta($hotspot_post[0],'hotspot_content',true);
else:
    $hotspot = 0;
endif;   
    ?>
<div class="viewport" data-ref="viewport">
    <div class="viewport-instructions">
        <div class="viewport-instructions__mobile">Swipe to see more <?php echo get_the_ID();?></div>
        <div class="viewport-instructions__desktop">Click and drag to see more</div>
    </div>
    <?php if($hotspot):?>
    <div class="image-maps">
        <div class="image-maps__map -active" data-ref="imageMap" data-category="<?php echo  get_post_field( 'post_name', get_the_ID() );?>" data-index="0">
            <div class="image-maps__map-inner" data-ref="swipeable" style="transform: translateX(0px);">

                <img alt="" class="image-map" src="<?php echo $hotspot['maps_images'];?>">

                <div class="image-hotspots">
                <?php foreach ($hotspot['data_points'] as $key => $value):?>
                   
               
                    <div class="image-hotspot" style="top:<?php echo $value['top'];?>%;left:<?php echo $value['left'];?>%;" data-ref="hotSpot">
                        <img src="/assets/img/hotspot-icon.svg" class="image-hotspot__plus" alt="Menu Item">

                        <div class="image-hotspot__big -disabled" data-ref="hotSpotContent">
                            <span class="image-hotspot__content"><?php echo $value['content'];?></span>
                        </div>
                    </div>
                <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
    <button class="viewport-button" data-ref="panLeft" aria-label="Left"></button>
    <button class="viewport-button -right" data-ref="panRight" aria-label="Right"></button>
</div>
<?php $post_id = get_the_ID();?>
<div class="menu-categories" data-ref="categories">
    <div class="menu-categories__inner" data-ref="swipeable">
        <div class="menu-categories__group">
            <?php
            $args = array(
                'post_type'      => 'page',
                'posts_per_page' => -1,
                'post_parent'    => 255,
                'order'          => 'ASC',
                'orderby'        => 'menu_order'
            );
            $parent = new WP_Query( $args );
            $i=0;
            if ( $parent->have_posts() ) : ?>
            <?php while ( $parent->have_posts() ) : $parent->the_post(); ?>
            <a href="<?php echo get_the_permalink();?>" class="menu-categories__button <?php if(get_the_ID() == $post_id){ ?>-active <?php }?>" data-ref="categoryButton" data-category="<?php echo get_post_field( 'post_name', get_the_ID() ); ?>" data-index="<?= $i;?>">
                <span class="menu-categories__button-label"><?php echo get_the_title();?></span>
            </a>
            <?php $i++; endwhile; ?>
            <?php endif; wp_reset_postdata(); ?>
            
        </div>
        <div class="menu-categories__group">
            <a href="<?php the_field('catering_menu','options');?>" target="_blank" class="menu-categories__link">Catering Menu</a>
            <a href="<?php the_field('takeout_menu','options');?>" target="_blank" class="menu-categories__link">Takeout Menu</a>
            
        </div>
    </div>
</div>
<div class="side-panels">
    <button class="panel-button -list side-panel__button" data-ref="panelButton">
    <span class="panel-button__label -open">Show List</span>
    <span class="panel-button__label -close">Close</span>
    </button>
    <div class="side-panel -list -disabled" data-ref="panel listPanel">
        <div class="menu-items" data-ref="list" data-category="<?php echo get_post_field( 'post_name', get_the_ID() );?>">
            <h2 class="menu-items__heading"><?php the_title();?></h2>
            
            <?php
            if( have_rows('menu_items') ): ?>
            <ul class="menu-items__list">
                <?php
                // loop through rows (sub repeater)
                while( have_rows('menu_items') ): the_row();?>
                
                <li class="menu-items__item"><?php the_sub_field('menu_item');?></li>
                <?php endwhile;?>
                <?php endif;?>
            </ul>
        </div>
        
    </div>
    <button class="panel-button -info side-panel__button" data-ref="panelButton">
    <span class="panel-button__label -open">More Info</span>
    <span class="panel-button__label -close">Close</span>
    </button>
    <div class="side-panel -info -disabled" data-ref="panel infoPanel">
        
        <div class="menu-category-info" data-ref="info" data-category="<?php echo get_post_field( 'post_name', get_the_ID() );?>">
            <h2 class="menu-category-info__heading"><?php the_title();?></h2>
            <div class="menu-category-info__content">
                <?php the_content();?>
            </div>
        </div>
        
    </div>
</div>
<?php endwhile;?>
<?php get_footer('page');?>
<script type="text/javascript">
    jQuery( document ).ready(function() {
     jQuery( "button.-list" ).click(function() {
        
        if(jQuery( "div.-list" ).hasClass('-disabled')){
            jQuery( "div.-list" ).removeClass('-disabled');
        }else{
            jQuery( "div.-list" ).addClass('-disabled');
        }
    });
    jQuery( "button.-info" ).click(function() {
        
        if(jQuery( "div.-info" ).hasClass('-disabled')){
            jQuery( "div.-info" ).removeClass('-disabled');
        }else{
            jQuery( "div.-info" ).addClass('-disabled');
        }
    });
});
</script>