<?php
/*
Template Name: Articles
*/
get_header();?>
<style>
  a.news-item {
      display: block;
  }
  a.news-item:hover {
      text-decoration: none;
  }
  a.news-item:hover .news-item__title {
      text-decoration: underline;
  }
  body {
    padding-bottom:0px !important;
  }
  .footer {
    position: relative !important;
  }
  .page-hero {background-size: cover; background-position: center center;}
  .page-hero__inner:before {width:800px !important;}
</style>
<?php 
while ( have_posts() ) : the_post();
  if (has_post_thumbnail( $post->ID )) :
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
      $hero_image = $image[0];
    else :
      $hero_image = home_url() . '/assets/img/about/about-bg.png';
    endif;

    if(get_field('mobile_hero_image')) :
      $mobile_hero_image = get_field('mobile_hero_image');
    else :
      $mobile_hero_image = $hero_image;
    endif;
  ?>
  <?php if($hero_image) : ?>
    <div class="page-hero" style="background-image: url(<?= $hero_image; ?>);" data-ref="responsiveVisualElement" data-mobile="<?= $mobile_hero_image; ?>" data-desktop="<?= $hero_image; ?>">
      <div class="page-hero__inner">
        <h1 class="page-hero__title">Helpful Articles</h1>
        <div class="white-hr"></div>
        <span class="page-hero__subtitle">Curious about our latest adventures? Dive into our blog for updates on Texas de Brazil's special offers, authentic recipes, the rich history of Brazilian cuisine, and expert tips!</span>
      </div>
    </div>
  <?php endif; ?>
  
  
  
  

  <section class="news-list">
    <h2 class="news-list__title">
      Latest Posts
    </h2>
    <div class="news-list__items">
      <?php
      
      $category_name = 'blog';
      
      $args = array(
          'post_type' => 'post',
          'post_status' => 'publish',
          'posts_per_page' => '12',
          'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
          'order' => 'DESC',
          'category_name' => $category_name
      );
      $latest_post = new WP_Query($args);
      if ($latest_post->have_posts()) :
      ?>
      <?php while ($latest_post->have_posts()) : $latest_post->the_post(); ?>
        <div class="news-list__item">
          <a href="<?php the_permalink(); ?>" class="news-item">
            <h3 class="news-item__title">
              <span class="news-item__link"><?php the_title(); ?></span>
            </h3>
            <div class="news-item__date">
              <div class="date-block">
                <?php $post_id = get_the_ID(); ?>
                <span class="date-block__year"><?php echo get_the_date('Y', $post_id); ?></span>
                <span class="date-block__month"><?php echo get_the_date('M', $post_id); ?></span>
                <span class="date-block__day"><?php echo get_the_date('d', $post_id); ?></span>
              </div>
            </div>
            <div class="news-item__teaser">
              <?php the_excerpt(); ?>
            </div>
            <span class="news-item__link" aria-label="Learn more about <?php echo esc_attr(get_the_title()); ?>">Learn more</span>
          </a>
        </div>
      <?php endwhile; ?>
      </div>
      <?php
      $category_id = get_cat_ID($category_name);
      $category_link = get_category_link($category_id);
      ?>
      <a href="<?php echo esc_url($category_link); ?>" class="news-list__link" aria-label="Show more news">Show more</a>
      <?php endif; wp_reset_postdata(); ?>
    </div>
  </section>
  
  
  <section class="news-list">
    <h2 class="news-list__title">
      Recipes
    </h2>
    <div class="news-list__items">
      <?php
      
      $category_name = 'recipes';
      
      $args = array(
          'post_type' => 'post',
          'post_status' => 'publish',
          'posts_per_page' => '12',
          'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
          'order' => 'DESC',
          'category_name' => $category_name
      );
      $latest_post = new WP_Query($args);
      if ($latest_post->have_posts()) :
      ?>
      <?php while ($latest_post->have_posts()) : $latest_post->the_post(); ?>
        <div class="news-list__item">
          <a href="<?php the_permalink(); ?>" class="news-item">
            <h3 class="news-item__title">
              <span class="news-item__link"><?php the_title(); ?></span>
            </h3>
            <div class="news-item__date">
              <div class="date-block">
                <?php $post_id = get_the_ID(); ?>
                <span class="date-block__year"><?php echo get_the_date('Y', $post_id); ?></span>
                <span class="date-block__month"><?php echo get_the_date('M', $post_id); ?></span>
                <span class="date-block__day"><?php echo get_the_date('d', $post_id); ?></span>
              </div>
            </div>
            <div class="news-item__teaser">
              <?php the_excerpt(); ?>
            </div>
            <span class="news-item__link" aria-label="Learn more about <?php echo esc_attr(get_the_title()); ?>">Learn more</span>
          </a>
        </div>
      <?php endwhile; ?>
      </div>
      <?php
      $category_id = get_cat_ID($category_name);
      $category_link = get_category_link($category_id);
      ?>
      <a href="<?php echo esc_url($category_link); ?>" class="news-list__link" aria-label="Show more news">Show more</a>
      <?php endif; wp_reset_postdata(); ?>
    </div>
  </section>
  

  <section class="news-list">
    <h2 class="news-list__title">
      News
    </h2>
    <div class="news-list__items">
      <?php
      
      $category_name = 'news';
      
      $args = array(
          'post_type' => 'post',
          'post_status' => 'publish',
          'posts_per_page' => '12',
          'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
          'order' => 'DESC',
          'category_name' => $category_name
      );
      $latest_post = new WP_Query($args);
      if ($latest_post->have_posts()) :
      ?>
      <?php while ($latest_post->have_posts()) : $latest_post->the_post(); ?>
        <div class="news-list__item">
          <a href="<?php the_permalink(); ?>" class="news-item">
            <h3 class="news-item__title">
              <span class="news-item__link"><?php the_title(); ?></span>
            </h3>
            <div class="news-item__date">
              <div class="date-block">
                <?php $post_id = get_the_ID(); ?>
                <span class="date-block__year"><?php echo get_the_date('Y', $post_id); ?></span>
                <span class="date-block__month"><?php echo get_the_date('M', $post_id); ?></span>
                <span class="date-block__day"><?php echo get_the_date('d', $post_id); ?></span>
              </div>
            </div>
            <div class="news-item__teaser">
              <?php the_excerpt(); ?>
            </div>
            <span class="news-item__link" aria-label="Learn more about <?php echo esc_attr(get_the_title()); ?>">Learn more</span>
          </a>
        </div>
      <?php endwhile; ?>
      </div>
      <?php
      $category_id = get_cat_ID($category_name);
      $category_link = get_category_link($category_id);
      ?>
      <a href="<?php echo esc_url($category_link); ?>" class="news-list__link" aria-label="Show more news">Show more</a>
      <?php endif; wp_reset_postdata(); ?>
    </div>
  </section>
  
  
  

<?php endwhile; ?>

<?php get_footer(); ?>
