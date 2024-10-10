<?php 
/*
Template Name:Menu
*/
get_header();
?>
<?php
while ( have_posts() ) :the_post(); ?>
	<?php 
	if( have_rows('content') ):
		// loop through the rows of data
    while ( have_rows('content') ) : the_row();?>
			<div class="o-grid o-grid--gutters s-promotions">
			    <div class="o-col">
			        <div class="c-promo c-promo--feature" data-ref="responsiveVisualElement" style="background-image: url(<?php echo get_sub_field('desktop_image');?>);" data-mobile="<?php echo get_sub_field('mobile_image');?>" data-desktop="<?php echo get_sub_field('desktop_image');?>">
			            <div class="c-promo__content">
			                <h1 class="c-promo__title" style="color: #FFF;"><?php the_sub_field('page_title');?></h1><span class="c-promo__teaser"><?php the_sub_field('teaser');?></span></div>
			        </div>
			    </div>
			</div>
		<?php endwhile;
	endif;?>
	<div class="s-group-dining mt-3">
		<?php 
		if( have_rows('menu_content_block') ):
			// loop through the rows of data
	    while ( have_rows('menu_content_block') ) : the_row();?>
	    	<div class="o-grid o-grid--gutters promo">
				    <div class="o-col">
				        <section class="menu-directory" style="background-image: url(<?php the_sub_field('menu_image');?>)" data-ref="responsiveVisualElement" data-mobile="<?php the_sub_field('menu_mobile_image');?>" data-desktop="<?php the_sub_field('menu_image');?>">
				            <div class="menu-directory__inner">
				                <h2 class="menu-directory__title"><?php the_sub_field('menu_heading');?></h2>
				                <p class="menu-directory__lead">
				                    <?php the_sub_field('menu_lead_text');?>
				                </p>
				                <?php $menu_link = get_sub_field('menu_page_link');?>
				                <?php 
				                if( have_rows('menu_items',$menu_link[0]) ): ?>
													<ul class="menu-directory__list">
													<?php
														// loop through rows (sub repeater)
														while( have_rows('menu_items',$menu_link[0]) ): the_row();?>
				                
				                    <li><?php the_sub_field('menu_item');?></li>
				                    <?php endwhile;?>
				                  <?php endif;?>
				                </ul>
				                
				                <div class="menu-directory__col mt-3"><a href="<?php echo get_permalink($menu_link[0]);?>" class="button menu-directory__cta"><?php the_sub_field('button_label');?></a></div>
				            </div>
				        </section>
				    </div>
				</div>
	    <?php endwhile;?>
	  <?php endif;?>
	</div>
<?php endwhile; ?>
<?php get_footer();?>