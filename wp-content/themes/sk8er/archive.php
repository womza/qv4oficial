<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sk8er
 */

get_header(); ?>

	<?php
		global $sk8er;

		wp_enqueue_style('sk8er-slick');
		if ($sk8er['sk8er_post_likes']==1) {
			wp_enqueue_style( 'sk8er-postlikes');
		}
		wp_enqueue_style('sk8er-animate');
		wp_enqueue_script('sk8er-isotope');
	?>


	<section class="style-misc blog-items cols col-3">
		<div class="container">
			<div class="row">
				<div class="col-md-9">

					<?php wp_reset_query(); ?>

					<div class="blog-items-wrapper" style="padding-top: 30px;">
						<?php if ($wp_query->have_posts()): ?>
							<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

			        				<div <?php post_class("item animate-el fadeInUp"); ?>>
			        					<?php
			        						$images = get_post_meta($post->ID, "sk8er_slider_images", true);
			        					?>
			        					<?php if (!empty($images)): ?>
			        						<div class="image-slider">
			        						<?php foreach ($images as $image) { ?>
			        							<div class="one" style="background-image: url(<?php echo esc_url($image); ?>);">
			        							</div>
			        						<?php } ?>
			        						</div>
			        						<div class="text">

			        					<?php else: ?>
			        						<?php if (has_post_thumbnail()): ?>
			        							<?php
			        							$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			        							?>
			        							<div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
			        						    	<a href="<?php the_permalink(); ?>"></a>
			        							</div>
			        							<div class="text">
			        						<?php else: ?>
			        							<div class="text full-width">
			        						<?php endif ?>
			        					<?php endif ?>
			                                <span class="info">
			                                    <span><i class="fa fa-user"></i>  <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a></span>
			                                    <span><i class="fa fa-clock-o"></i> <?php the_time('M n, Y'); ?></span>
			                                    <span>
			                                    	<?php if (function_exists( 'getPostLikeLink' )): ?>
                                                        <?php if ($sk8er['sk8er_post_likes']==1): ?>
                                                            <?php echo getPostLikeLink( get_the_ID() ); ?>
                                                        <?php endif ?>
                                                    <?php endif ?>
			                                    </span>
			                                </span>

			                                <div class="post-content">
			                                    <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>

			                                    <p><?php echo sk8er_excerpt(25); ?></p>

			                                    <a href="<?php the_permalink(); ?>" class="read-more ia"><?php _e('Read More', 'sk8er') ?> <i class="fa fa-angle-right"></i></a>
			                                </div>
			                            </div>
			                        </div>

							<?php endwhile; ?>
						<?php endif; ?>
					</div>

					<?php sk8er_pagination(); ?>

				</div>
				<div class="col-md-3">
					<div class="sidebar">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php get_footer(); ?>
