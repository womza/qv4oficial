<?php
/*
Template Name: Shop news
*/
?>
<?php get_header(); ?>

	<?php 
		$args = array( 'post_type' => 'shop_news', 'posts_per_page' => -1);
		$wp_query = new WP_Query( $args );

		wp_enqueue_script('sk8er-kinetic');
		wp_enqueue_script('sk8er-jquery-ui');
		wp_enqueue_script('sk8er-mousewheel');
		wp_enqueue_style('sk8er-smoothDivScroll');
		wp_enqueue_script('sk8er-smoothDivScroll');
	?>

	<?php if ($wp_query->have_posts()): ?>

	<section class="style-20 full-height-section">
	    <div class="items-wrapper">

	    	<?php while($wp_query->have_posts()): $wp_query->the_post(); ?>

	    	<?php
	    		if (has_post_thumbnail( $post->ID ) ) {
        			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
        			$thumbnail = $image[0]; 
        		} else {
					$thumbnail = "";
				}

	    		$smaller_title 		= get_post_meta($post->ID, 'sk8er_shop_news_title_smaller', true);
	    		$bigger_title 		= get_post_meta($post->ID, 'sk8er_shop_news_title_bigger', true);
	    	?>

	        <div class="item" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
	            <a href="<?php the_permalink(); ?>"></a>
	            <div class="valign">
	            	<?php if (!empty($smaller_title) || !empty($bigger_title)): ?>
	            		<span><?php echo esc_html($smaller_title); ?></span>
	            		<h3><?php echo esc_html($bigger_title); ?></h3>
	            	<?php else: ?>
	            		<span><?php the_title(); ?></span>
	            		<h3></h3>
	            	<?php endif ?>

	                <span class="read-more"><?php _e( 'Read More' , 'sk8er' ) ?></span>
	            </div>
	        </div>

	        <?php endwhile; ?>

	    </div>
	</section>

	<?php endif ?>

<?php get_footer(); ?>