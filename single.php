<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package texaswp
 */

get_header();
?>
<?php
	while ( have_posts() ) :the_post();?>
		<a href="/news/" class="back-link">Back to all news</a>
		<article class="news-article">
	    <div class="news-article__inner">
				<h1 class="news-article__title"><?php the_title();?></h1>
				<div class="news-article__info">
		    <div class="news-article__date">
		        <div class="date-block">
		        	<?php $post_id=get_the_ID();?>
		        	<span class="date-block__year"><?php echo get_the_date( 'Y', $post_id );?></span>
		        	<span class="date-block__month"><?php echo get_the_date( 'M', $post_id );?></span>
		        	<span class="date-block__day"><?php echo get_the_date( 'd', $post_id );?></span>
		        </div>
		    </div>
		    <div class="news-article__share-links">
		        <div class="share-block"><h3 class="share-block__label">Share</h3>
		            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink();?>" target="_blank" class="share-block__link -facebook" aria-label="Facebook"></a>
		            <a href="https://twitter.com/home?status=<?php echo get_the_permalink();?>" target="_blank" class="share-block__link -twitter" aria-label="Twitter"></a>
                            <a href="https://www.instagram.com/texasdebrazil/" target="_blank" class="share-block__link -instagram" aria-label="Instagram"></a>
                            
		            <a href="https://pinterest.com/pin/create/button/?url=<?php echo get_the_permalink();?>" target="_blank" class="share-block__link -pinterest" aria-label="Pinterest"></a>
		        </div>
		    </div>
			</div>
	    <div class="news-article__body">
	      <?php the_content();?>
	    </div>
		</div>
	</article>
<?php
	endwhile; // End of the loop.
			?>
<?php
get_footer();
