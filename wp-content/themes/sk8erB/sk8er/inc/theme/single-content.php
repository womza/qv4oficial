<?php
	wp_enqueue_style('sk8er-slick');
	wp_enqueue_style('sk8er-video-js');
	wp_enqueue_script('sk8er-video');
	wp_enqueue_script('sk8er-video-youtube');
	wp_enqueue_script('sk8er-video-vimeo');
?>

<section class="style-misc blog-single">
	<div class="inner">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<div class="post-content">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php if ('video' == get_post_format()): ?>
								<?php
									$images = get_post_meta( $post->ID, 'sk8er_slider_images', 1 );
									$video_vimeo = get_post_meta( $post->ID, 'sk8er_video_vimeo_id');
									$video_youtube = get_post_meta( $post->ID, 'sk8er_video_youtube_id');
									$video_mp4 = get_post_meta( $post->ID, 'sk8er_video_mp4');
									$video_hosted = get_post_meta( $post->ID, 'sk8er_video_hosted');
								?>

								<?php if (!empty($video_vimeo[0]) || !empty($video_youtube[0]) || !empty($video_hosted[0]) || !empty($video_mp4[0])): ?>
									<?php if (!empty($video_vimeo[0])): ?>
										<video id="actual-video" class="video-js vjs-default-skin vjs-big-play-centered"
										  controls preload="auto" width="auto" height="auto"
										  data-setup='{ "techOrder": ["vimeo"], "src": "https://vimeo.com/<?php echo esc_attr($video_vimeo[0]); ?>", "loop": true, "autoplay": false }'>
										 <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
										</video>
									<?php elseif (!empty($video_youtube[0])): ?>
										<div class="video-wrapper">
										    <video id="actual-video" class="video-js vjs-default-skin vjs-big-play-centered"
										      controls preload="auto" width="auto" height="auto"
										      data-setup='{ "techOrder": ["youtube"], "src": "http://www.youtube.com/watch?v=<?php echo esc_attr($video_youtube[0]); ?>" }'>
										     <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
										    </video>
										</div>
									<?php elseif (!empty($video_mp4[0])): ?>
										<div class="video-wrapper">
										    <video id="actual-video" class="video-js vjs-default-skin vjs-big-play-centered"
										      controls preload="auto" width="auto" height="auto"
										      data-setup='{"example_option":true}'>
										     <source src="<?php echo esc_url($video_mp4[0]); ?>" type='video/mp4' />
										     <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
										    </video>
										</div>
									<?php elseif (!empty($video_hosted[0])): ?>
										<div class="video-wrapper">
										    <video id="actual-video" class="video-js vjs-default-skin vjs-big-play-centered"
										      controls preload="auto" width="auto" height="auto"
										      data-setup='{"example_option":true}'>
										     <source src="<?php echo esc_url($video_hosted[0]); ?>" type='video/mp4' />
										     <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
										    </video>
										</div>
									<?php endif ?>
								<?php endif ?>

							<?php else: ?>
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

								<?php else: ?>
									<?php if (has_post_thumbnail()): ?>
										<?php
										$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
										?>
										<?php if ('wines' == get_post_type() ): ?>
												<div class="image" style="text-align: center; background: #f5f5f5; padding: 30px;">
												    <?php the_post_thumbnail('full'); ?>
												</div>
											<?php else: ?>
												<div class="image">
												    <?php the_post_thumbnail('full'); ?>
												</div>
										<?php endif ?>
									<?php endif ?>
								<?php endif ?>
							<?php endif ?>

							<div class="text">
								<span class="info">
								    <span><i class="fa fa-user"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a></span>
								    <span><i class="fa fa-clock-o"></i> <?php the_time('M n, Y'); ?></span>
								    <span><i class="fa fa-inbox"></i> <?php echo get_the_term_list( $post->ID, 'category', '', ', ', '' ); ?></span>
								    <?php if (get_the_tags()!=''): ?>
								    	<span><i class="fa fa-tags"></i> <?php the_tags( ' ', ', ', '' ); ?></span>
								    <?php endif ?>
								</span>

								<div class="post-text">
									<?php if ('shop_news' == get_post_type()): ?>
										<?php
											$smaller_title 		= get_post_meta($post->ID, 'sk8er_shop_news_title_smaller', true);
											$bigger_title 		= get_post_meta($post->ID, 'sk8er_shop_news_title_bigger', true);
										?>

										<?php if (get_the_title()): ?>
												<a href="javascript:void(null);" class="title"><?php the_title(); ?></a>
											<?php else: ?>
												<a href="javascript:void(null);" class="title"><?php echo esc_html($smaller_title).' '.esc_html($bigger_title); ?></a>
										<?php endif ?>
									<?php endif ?>
									
									<?php if ('quote' == get_post_format()): ?>
											<?php the_content(); ?>
										<?php elseif('audio' == get_post_format()): ?>
											<?php if (isset(get_post_meta( $post->ID, 'sk8er_audio_id')[0])): ?>
												<?php $audio_id = get_post_meta( $post->ID, 'sk8er_audio_id')[0]; ?>

												<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/<?php echo esc_attr($audio_id); ?>&amp;color=ffdb00"></iframe>

												<br><br>
											<?php endif ?>

											<?php the_content(); ?>

										<?php elseif('link'	== get_post_format()): ?>
											<?php $link = get_post_meta( $post->ID, 'sk8er_link_url')[0]; ?>
											<a href="<?php echo esc_url($link); ?>" target="_blank"><b><?php _e( 'Visit Link!' , 'sk8er' ) ?></b></a>

											<br><br>

											<?php the_content(); ?>
										<?php else: ?>
											<?php the_content(); ?>
									<?php endif; ?>
									
								</div>
							</div>

							<?php if (wp_link_pages()): ?>
								<div class="page-nav" style="DISPLAY:NONE;">
									<?php wp_link_pages(); ?>
								</div>
							<?php endif ?>

							<?php sk8er_post_nav(); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>

						<?php endwhile; // end of the loop. ?>
					</div>
				</div>

				<div class="col-md-3">
					<div class="sidebar" style="padding-top: 0;">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>