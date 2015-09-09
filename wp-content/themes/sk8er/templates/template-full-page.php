<?php
/*
Template Name: Full Page Posts
*/
?>
<?php get_header(); ?>

	<?php 
		wp_enqueue_style('sk8er-slick');
		wp_enqueue_style('sk8er-swipebox');
		$args = array( 'post_type' => 'post', 'posts_per_page' => 6);
		$wp_query = new WP_Query( $args );
	?>

	<div class="fullscreen-holder">

		<?php if ( $wp_query->have_posts() ) : ?>

			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
				<?php 
					$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
					$images = get_post_meta( $post->ID, 'sk8er_slider_images', 1 );
					
					if (isset(get_post_meta( $post->ID, 'sk8er_video_vimeo_id')[0])) {
						$video_vimeo = get_post_meta( $post->ID, 'sk8er_video_vimeo_id')[0];
					}

					if (isset(get_post_meta( $post->ID, 'sk8er_video_youtube_id')[0])) {
						$video_youtube = get_post_meta( $post->ID, 'sk8er_video_youtube_id')[0];
					}
					
					
					if (!empty($video_vimeo)) {
						$video = "http://vimeo.com/".$video_vimeo;
					} else if(!empty($video_youtube)) {
						$video = "https://www.youtube.com/watch?v=".$video_youtube;
					} else {
						$video = "";
					}

					if (empty($thumb_url)) {
						$class = "full";
					} else { $class = ""; }
				?>

				<?php if ('video' == get_post_format()): ?>

					<div class="fullscreen-section" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
					    <div class="valign">
					        <div class="post-wrapper video">
					            <div class="content">
					                <span class="post-icon"><i class="fa fa-video-camera"></i></span>

					                <a href="<?php the_permalink(); ?>" class="post-title ia"><?php the_title(); ?></a>
					                <span class="date"><?php the_time('M n, Y'); ?></span>

					                <div class="post-text">
					                    <?php echo sk8er_excerpt(50); ?>
					                </div>

					                <div class="buttons">
					                    <a href="<?php the_permalink(); ?>"><span><?php _e( 'Read More' , 'sk8er' ) ?></span></a>
					                </div>
					            </div>
					            <div class="image">
					            	<?php if (has_post_thumbnail()): ?>
					            			<div class="actual-image">
					            		<?php else: ?>
					            			<div class="actual-image" style="background-color: #222;">
					            	<?php endif ?>
					                
					                    <a href="<?php echo esc_url($video); ?>" class="play-video swipebox"><i class="fa fa-play"></i></a>
					                    <img src="<?php echo esc_url($thumb_url[0]); ?>" alt="">
					                </div>
					            </div>
					        </div>
					    </div>
					</div>

					<?php elseif ('quote' == get_post_format()): ?>

					<div class="fullscreen-section" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
					    <div class="valign">
					        <div class="post-wrapper quote">
					            <div class="content">
					                <span class="post-icon"><i class="fa fa-quote-right"></i></span>
					                <a href="<?php the_permalink(); ?>" class="post-title ia"><?php the_title(); ?></a>
					                <span class="date"><?php the_time('M n, Y'); ?></span>

					                <div class="post-text">
					                    <?php echo wp_strip_all_tags( get_the_content() ); ?>
					                </div>

					                <div class="buttons">
					                    <a href="<?php the_permalink(); ?>"><span><?php _e( 'Read More' , 'sk8er' ); ?></span></a>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>

				<?php elseif ('link' == get_post_format()): ?>
					<?php $link = get_post_meta( $post->ID, 'sk8er_link_url')[0]; ?>

					<div class="fullscreen-section" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
					    <div class="valign">
					        <div class="post-wrapper quote">
					            <div class="content">
					                <span class="post-icon"><i class="fa fa-chain"></i></span>
					                <a href="<?php echo esc_url($link); ?>" class="post-title"><?php the_title(); ?></a>
					                <span class="date"><?php the_time('M n, Y'); ?></span>

					                <div class="post-text">
					                    <?php echo wp_strip_all_tags( get_the_content() ); ?>
					                </div>

					                <div class="buttons">
					                    <a href="<?php echo esc_url($link); ?>"><span><?php _e( 'Vist Link' , 'sk8er' ); ?></span></a>
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
					

					<?php else: ?>

						<div class="fullscreen-section" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
						    <div class="valign">
						        <div class="post-wrapper normal <?php echo esc_attr($class); ?>">
						            <div class="content">
						            	<?php if (has_post_thumbnail()): ?>
						            		<span class="post-icon"><i class="fa fa-pencil"></i></span>
						            	<?php else: ?>
						            		<span class="post-icon" style="background-color: #fff !important;"><i class="fa fa-pencil"></i></span>
						            	<?php endif ?>
						                
						                <a href="<?php the_permalink(); ?>" class="post-title ia"><?php the_title(); ?></a>

						                <div class="post-text">
						                    <?php echo sk8er_excerpt(50); ?>
						                </div>
						            </div>

						            <?php if (!empty($images) || !empty($thumb_url)): ?>
						            	<div class="image">
						            	    <div class="actual-image">
						            	    	<?php if (!empty($images)): ?>
						            	    		<div class="post-images-slick">
						            	    			<?php foreach ($images as $image): ?>
						            	    				<div>
						            	    				    <img src="<?php echo esc_url($image); ?>" alt="">
						            	    				</div>
						            	    			<?php endforeach ?>
						            	    		</div>
						            	    	<?php else: ?>
						            	    		<a href="javascript:void(null);" class="full"></a>
						            	    		<img src="<?php echo esc_url($thumb_url[0]); ?>" alt="">
						            	    	<?php endif ?>
						            	    </div>
						            	</div>
						            <?php endif ?>
						            
						        </div>
						    </div>
						</div>

				<?php endif ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</div>

<?php get_footer(); ?>