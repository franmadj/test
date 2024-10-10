<?php
$number_post = (is_page('news')) ? 8 : 12;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $number_post,
    'paged' => $paged,
    'cat' => 38, // Use the category ID to pull posts from the "News" category
    'order' => 'DESC',
);

// Debug statement to verify query arguments
error_log(print_r($args, true));

$latest_post = new WP_Query($args);

// Debug statement to check if posts are found
if (!$latest_post->have_posts()) {
    error_log('No posts found');
} else {
    error_log('Posts found');
}

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
    <div class="pagination">
        <?php
            $big = 999999999; // need an unlikely integer
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $latest_post->max_num_pages,
                'before_page_number' => 'Go to page '
            ));
        ?>
    </div>
    <?php
    wp_reset_postdata();
endif;
?>
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
</style>
