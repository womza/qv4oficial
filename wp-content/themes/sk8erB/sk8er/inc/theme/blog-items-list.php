<?php global $post; global $sk8er_sidebar; global $sk8er; ?>

<?php
	wp_enqueue_style('sk8er-slick');
	if ($sk8er['sk8er_post_likes']==1) {
		wp_enqueue_style( 'sk8er-postlikes');
	}
	wp_enqueue_style('sk8er-animate');
	wp_enqueue_script('sk8er-isotope');
?>

<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>

<?php if (is_page_template("templates/template-blog.php")): ?>
	<?php
		global $sk8er_sidebar;
		$sk8er_sidebar = get_post_meta($post->ID, 'sk8er_blog_sidebar', true);

		$layout = get_post_meta($post->ID, 'sk8er_blog_layout', true);
		global $sk8er_addlayout;

		if ($layout=="grid") {
			$sk8er_addlayout = "blog-items-grid";
		} else {
			$sk8er_addlayout = "blog-items ".$layout;
		}

		global $sk8er_cols;

		if ($layout!="grid") {
			$sk8er_cols = "cols col-3";
			$sk8er_big_columns = get_post_meta($post->ID, 'sk8er_blog_columns', true);

			if (!empty($sk8er_big_columns)) {
				$sk8er_cols = "cols col-".get_post_meta($post->ID, 'sk8er_blog_columns', true);
			}
		}
	?>
	<section class="style-misc <?php echo esc_attr($sk8er_addlayout); ?> <?php echo esc_attr($sk8er_cols); ?>">
<?php elseif(is_archive() || is_search()): ?>
	<?php $sk8er_sidebar="on"; $layout=""; ?>
	<section class="style-misc blog-items cols col-3">
<?php else: ?>
	<?php $sk8er_sidebar="on"; $layout=""; ?>
	<section class="style-misc blog-items cols col-1">
<?php endif ?>

	    <div class="container">
	        <div class="row">
	        <?php if (is_page_template("templates/template-blog.php") && $sk8er_sidebar!="on"): ?>
	        	<div class="col-md-12">
	        <?php else: ?>
	        	<div class="col-md-9">
	        <?php endif ?>

	       			<?php if (!is_home()): ?>

	                <ul class="portfolio-filter">
	                    <li class="left"><ul>
	                    	<?php
		                    	global $post;
		                    	$categories = get_categories();
		                    	if (is_category()) {
		                    		$category = get_category( get_query_var( 'cat' ) );
		                    		$cat_id = $category->cat_ID;
		                    	} else {
		                    		$cat_id = -1;
		                    	}


		                    	foreach ($categories as $category) { ?>
		                    		<?php if ($category->cat_ID == $cat_id): ?>
		                    			<li class="active"><a href="<?php echo get_category_link($category->cat_ID);  ?>" class="filter"><?php echo esc_html($category->name); ?></a></li>
		                    		<?php else: ?>
		                    			<li><a href="<?php echo get_category_link($category->cat_ID);  ?>" class="filter"><?php echo esc_html($category->name); ?></a></li>
		                    		<?php endif ?>
		                    	<?php }
	                    	?>
	                    	</ul>
	                    </li>
	                </ul>

	                <?php else: ?>

	                	<div style="padding-top:30px"></div>

	                <?php endif ?>

	                <?php if ($layout=="grid"): ?>
	                	<?php $sticky_posts = get_option('sticky_posts'); ?>
	                	<?php if (!empty($sticky_posts)): ?>
	                		<?php
	                		$args = array(
	                		   'post__in' => get_option('sticky_posts'),
	                		   'posts_per_page'			=> 1,
	                		   'ignore_sticky-posts'	=> 1,
	                		);
	                		$my_query = new WP_Query($args) ; ?>
	                		<?php if ($my_query->have_posts() ) : while ($my_query->have_posts()) : $my_query->the_post(); ?>

	                			<?php if (has_post_thumbnail( $post->ID ) ): ?>
		                			<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
		                			<?php $thumbnail = $image[0]; ?>
		                		<?php else: ?>
		                			<?php $thumbnail = ""; ?>
	                			<?php endif; ?>
	                		<div class="row">
	                			<div class="col-md-12 full-item">
	                				<div class="item animate-el fadeIn" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
	                					<div class="hover">
	                						<a href="<?php the_permalink(); ?>">
	                							<span class="icon"><i class="fa fa-thumb-tack"></i></span>
	                							<span class="align">
	                							    <span class="title"><?php the_title(); ?></span>
	                							    <span class="date"><?php the_time('F n, Y'); ?></span>
	                							    <span class="text"><?php echo sk8er_excerpt(30); ?></span>
	                							</span>
	                						</a>
	                					</div>
	                				</div>
	                			</div>
	                		</div>

	                		<?php endwhile; endif; ?>
	                		<?php endif ?>
	                <?php endif ?>
	                <?php wp_reset_postdata(); //VERY VERY IMPORTANT?>

					<?php
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$ppp = get_option( 'posts_per_page' );

						if ($layout=="grid") {
							$ppp = 9; // x + 1
							$args = array( 'post_type' => 'post', 'paged' => $paged, 'posts_per_page' => $ppp, 'post__not_in' => get_option('sticky_posts'));
						} else {
							$args = array( 'post_type' => 'post', 'paged' => $paged, 'posts_per_page' => $ppp);
						}
						$wp_query = new WP_Query( $args );
					?>

	                <?php if ( $wp_query->have_posts() ) : ?>

	                	<?php if ($layout=="grid"): ?>

			                		<?php $x = 1; $total = 1; ?>
			                		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
			                			<?php if (has_post_thumbnail( $post->ID ) ): ?>
				                			<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
				                			<?php $thumbnail = $image[0]; ?>
				                		<?php else: ?>
				                			<?php $thumbnail = ""; ?>
			                			<?php endif; ?>

			                			<?php if ($x == 1): ?>
			                				<!-- start of row -->
			                				<div class="row">
			                			<?php endif ?>

			                			<?php if($x <4 && $x != 0): ?>
			                				<?php if ($x==1): ?>
			                					<div class="col-md-8 one-item">
					                                <div <?php post_class("item animate-el fadeIn"); ?> style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
					                                    <div class="hover">
					                                        <a href="<?php the_permalink(); ?>">
					                                            <span class="icon">
					                                            <?php if ('video' == get_post_format()): ?>
					                                            	<i class="fa fa-video-camera"></i>
					                                            <?php elseif('audio' == get_post_format()): ?>
					                                            	<i class="fa fa-music"></i>
					                                            <?php else: ?>
					                                            	<i class="fa fa-pencil"></i>
					                                            <?php endif ?>
					                                            </span>
					                                            <span class="align">
					                                                <span class="title"><?php the_title(); ?></span>
					                                                <span class="date"><?php the_time('F n, Y'); ?></span>
					                                                <span class="text"><?php echo sk8er_excerpt(30); ?></span>
					                                            </span>
					                                        </a>
					                                    </div>
					                                </div>
					                            </div>
					                            <div class="col-md-4 two-items">
			                				<?php else: ?>
			                					<div <?php post_class("item animate-el fadeIn"); ?> style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
			                                        <div class="hover">
			                                            <a href="<?php the_permalink(); ?>">
			                                                <span class="icon">
				                                            <?php if ('video' == get_post_format()): ?>
				                                            	<i class="fa fa-video-camera"></i>
				                                            <?php elseif('audio' == get_post_format()): ?>
				                                            	<i class="fa fa-music"></i>
				                                            <?php else: ?>
				                                            	<i class="fa fa-pencil"></i>
				                                            <?php endif ?>
				                                            </span>
			                                                <span class="align">
			                                                    <span class="title"><?php the_title(); ?></span>
			                                                    <span class="date"><?php the_time('F n, Y'); ?></span>
			                                                </span>
			                                            </a>
			                                        </div>
			                                    </div>
			                				<?php endif ?>
										<?php endif; ?>

			                			<?php if ($x == 3 || $wp_query->current_post == $wp_query->post_count - 1): ?>
			                					</div><!-- end of two-items -->
			                				</div><!-- end of row -->
			                				<?php $x=0; ?>
			                			<?php endif ?>

			                		<?php $x++; $total++; endwhile; ?>

	                			<?php else: ?>

		                			<div class="blog-items-wrapper">

		                			<?php if ($wp_query->have_posts()): ?>
		                				<?php else: ?>
		                					<p style="text-align: center;"><?php _e( 'Sorry, nothing found.', 'sk8er' ); ?></p>
		                			<?php endif ?>

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
				                	</div>

	                	<?php endif ?>

					<?php sk8er_pagination(); ?>

	                <?php else : ?>

	                <?php endif; ?>

	            </div>

				<?php if ($sk8er_sidebar=="on"): ?>
					<div class="col-md-3">
					    <div class="sidebar">

					        <?php get_sidebar(); ?>

					    </div>
					</div>
				<?php endif ?>
	        </div>
	    </div><!-- end container -->
</section>