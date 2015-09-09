<?php
/*
Template Name: Posts Page
*/
?>
<?php get_header(); ?>

	<?php 
		wp_enqueue_style('sk8er-swipebox');
		$args = array( 'post_type' => 'post', 'posts_per_page' => 8);
		$wp_query = new WP_Query( $args );
	?>

	<?php if ($wp_query->have_posts()): ?>
		<?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
			<?php if (has_post_thumbnail( $post->ID ) ): ?>
    			<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
    			<?php $thumbnail = $image[0]; ?>
    		<?php else: ?>
    			<?php $thumbnail = ""; ?>
			<?php endif; ?>

			<?php if ('video' == get_post_format()): ?>

				<?php
					$video_vimeo = get_post_meta( $post->ID, 'sk8er_video_vimeo_id');
					$video_youtube = get_post_meta( $post->ID, 'sk8er_video_youtube_id');
					$video_mp4 = get_post_meta( $post->ID, 'sk8er_video_mp4');

					if (!empty($video_vimeo)) {
						$video_url = "http://vimeo.com/".$video_vimeo[0];
					} else if(!empty($video_youtube)) {
						$video_url = "http://youtube.com/watch?v=".$video_youtube[0];
					} else if (!empty($video_mp4)) {
						$video_url = $video_mp4[0];
					} else {
						$video_url = "";
					}
				?>

				<section class="style-19 full-post format-video overlay-1 half-image">
				    <div class="row">
				        <div class="col-md-6">

				            <div class="post-wrapper">
				                <div class="inner">
				                    <div class="post-info">
				                        <div class="icon"><i class="fa fa-video-camera"></i></div>
				                        <div class="date"><?php the_time('F n, Y'); ?></div>

				                        <div class="actual-post">
				                            <a href="<?php the_permalink(); ?>" class="title ia"><?php the_title(); ?></a>
				                            <p><?php echo sk8er_excerpt(30); ?></p>
				                            <div class="main-buttons white">
				                                <a href="<?php the_permalink(); ?>"><span><?php _e( 'Read More' , 'sk8er' ) ?></span></a>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="cut"></div>
				            </div>
				        </div>
				        <div class="col-md-6">
				        	<?php if (!empty($video_url)): ?>
				        		<div class="video-wrapper overlay-1" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
				        		    <a href="<?php echo esc_url($video_url); ?>" class="play swipebox"><i class="fa fa-play"></i></a>
				        		</div>
				        	<?php endif ?>
				            
				        </div>
				    </div>
				</section>

			<?php elseif ('quote' == get_post_format()): ?>
				
					<section class="style-19 full-post format-quote" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
				    <div class="inner">
				        <div class="container">
				            <div class="row">
				                <div class="col-md-8 col-md-offset-2">

				                    <div class="post-wrapper">
				                        <div class="post-info">
				                            <div class="icon"><i class="fa fa-quote-right"></i></div>
				                            <div class="date"><?php the_time('F n, Y'); ?></div>

				                            <div class="actual-post">
				                                <a href="<?php the_permalink(); ?>" class="title">"<?php echo wp_strip_all_tags( get_the_content() ); ?>"</a>
				                                <p>-<?php the_title(); ?></p>
				                                <div class="main-buttons white">
				                                    <a href="<?php the_permalink(); ?>"><span><?php _e( 'Read More' , 'sk8er' ) ?></span></a>
				                                </div>
				                            </div>
				                        </div>
				                    </div>

				                </div>
				            </div>
				        </div>
				    </div>
				</section>

			<?php elseif ('link' == get_post_format()): ?>
				<?php $link = get_post_meta( $post->ID, 'sk8er_link_url')[0]; ?>

				<section class="style-19 full-post format-link">
				    <div class="inner">
				        <div class="container">
				            <div class="row">
				                <div class="col-md-8 col-md-offset-2">

				                    <div class="post-wrapper">
				                        <div class="post-info">
				                            <div class="icon"><i class="fa fa-chain"></i></div>

				                            <div class="actual-post">
				                                <a href="<?php echo esc_url($link); ?>" class="title ia" target="_blank"><?php echo esc_html($link); ?></a>
				                                <p><?php the_content(); ?></p>
				                                <div class="main-buttons white">
				                                    <a href="<?php echo esc_url($link); ?>" target="_blank"><span><?php _e( 'Visit Link' , 'sk8er' ) ?></span></a>
				                                </div>
				                            </div>
				                        </div>
				                    </div>

				                </div>
				            </div>
				        </div>
				    </div>
				</section>


			<?php elseif ('audio' == get_post_format()): ?>

				<?php $audio_id = get_post_meta( $post->ID, 'sk8er_audio_id'); ?>
				
				<?php if (has_post_thumbnail()): ?>
					<section class="style-19 full-post format-audio overlay-1" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
					<?php else: ?>
					<section class="style-19 full-post format-audio">	
				<?php endif ?>
				
				    <div class="inner">
				        <div class="container">
				            <div class="row">
				                <div class="col-md-8 col-md-offset-2">

				                    <div class="post-wrapper">
				                        <div class="post-info">
				                            <div class="icon"><i class="fa fa-pencil"></i></div>
				                            <div class="date"><?php the_time('F n, Y'); ?></div>

				                            <div class="actual-post">
				                                <div class="sc-wrapper">
				                                	<?php if (!empty($audio_id)): ?>
				                                    	<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https://api.soundcloud.com/tracks/<?php echo esc_attr($audio_id[0]); ?>&amp;color=ffdb00"></iframe>
				                                	<?php else: ?>
														<?php _e('Please enter SoundCloud song id.','sk8er'); ?>
				                                	<?php endif ?>
				                                </div>
				                            </div>
				                        </div>
				                    </div>

				                </div>
				            </div>
				        </div>
				    </div>
				</section>

			<?php else: ?>

				<?php if (has_post_thumbnail()): ?>
						<section class="style-19 full-post format-standard overlay-1" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
					<?php else: ?>
						<section class="style-19 full-post format-standard no-thumb">
				<?php endif ?>
			
				
				    <div class="inner">
				        <div class="container">
				            <div class="row">
				                <div class="col-md-8 col-md-offset-2">

				                    <div class="post-wrapper">
				                        <div class="post-info">
				                            <div class="icon"><i class="fa fa-pencil"></i></div>
				                            <div class="date"><?php the_time('F n, Y'); ?></div>

				                            <div class="actual-post">
				                                <a href="<?php the_permalink(); ?>" class="title ia"><?php the_title(); ?></a>
				                                <p><?php echo sk8er_excerpt(30); ?></p>
				                                <div class="main-buttons white">
				                                    <a href="<?php the_permalink(); ?>"><span><?php _e( 'Read More' , 'sk8er' ) ?></span></a>
				                                </div>
				                            </div>
				                        </div>
				                    </div>

				                </div>
				            </div>
				        </div>
				    </div>
				</section>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif ?>

<?php get_footer(); ?>