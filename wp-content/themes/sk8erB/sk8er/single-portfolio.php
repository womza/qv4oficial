<?php get_header(); ?>
	<?php
		wp_enqueue_style('sk8er-slick');
		wp_enqueue_style('sk8er-swipebox');
	?>
	<?php global $post; $curr_id=$post->ID; ?>
	<?php 
		$sk8er_client_name = get_post_meta($post->ID, 'sk8er_portfolio_client_name', true);
		$sk8er_client_url = get_post_meta($post->ID, 'sk8er_portfolio_client_url', true);
		if ($sk8er_client_url=="") { $sk8er_client_url="javascript:void(null);"; }
		$sk8er_client_tasks = get_post_meta($post->ID, 'sk8er_portfolio_tasks', true);
		$sk8er_portfolio_images = get_post_meta($post->ID, 'sk8er_portfolio_images', true);
		$sk8er_portfolio_images_layout = get_post_meta($post->ID, 'sk8er_portfolio_images_layout', true);
		$sk8er_portfolio_slider = get_post_meta($post->ID, 'sk8er_portfolio_images_slider', true);
	?>

	<?php if ($sk8er_portfolio_images_layout == 'grid' && $sk8er_portfolio_slider != 'on'): ?>
		<section class="style-misc portfolio-single-gallery">
		    <div class="inner">
		        <div class="container">
		            <div class="row">
		            	<?php if (!empty($sk8er_portfolio_images)): ?>
		            		<?php foreach ($sk8er_portfolio_images as $image): ?>
		            			<div class="col-md-4">
		            			    <div class="image" style="background-image: url(<?php echo esc_url($image); ?>);">
		            			        <a href="<?php echo esc_url($image); ?>" class="swipebox" rel="gallery-post"></a>
		            			    </div>
		            			</div>
		            		<?php endforeach ?>
		            	<?php endif ?>
		            </div>
		        </div>
		    </div>
		</section>
	<?php endif ?>

	<?php if ($sk8er_portfolio_images_layout == 'fullwidth' && $sk8er_portfolio_slider != 'on'): ?>
		<section class="style-misc portfolio-single-gallery-big">
		    <div class="inner">
		        <div class="container">
		            <div class="row">
		                <?php if (!empty($sk8er_portfolio_images)): ?>
		                	<?php foreach ($sk8er_portfolio_images as $image): ?>
		                		<div class="col-xs-12">
		                		    <div class="image" style="background-image: url(<?php echo esc_url($image); ?>);">
		                		        <a href="<?php echo esc_url($image); ?>" class="swipebox" rel="gallery-post"></a>
		                		    </div>
		                		</div>
		                	<?php endforeach ?>
		                <?php endif ?>
		            </div>
		        </div>
		    </div>
		</section>
	<?php endif ?>

	<?php if ($sk8er_portfolio_images_layout == 'grid2' && $sk8er_portfolio_slider != 'on'): ?>
		<section class="style-misc portfolio-single-gallery-big-divided">
		    <div class="inner">
		        <div class="container">
		        	<?php $x=1; $y=0; $total=0; ?>
		        	<?php foreach ($sk8er_portfolio_images as $images): ?>
		        		<?php $total++; ?>
		        	<?php endforeach ?>

		        	<?php foreach ($sk8er_portfolio_images as $image): ?>
		        		<?php $y++; ?>
		        		<?php if ($x==1): ?>
		        			<div class="row">
		        		<?php endif ?>
							
							<?php if ($x==1): ?>
								<div class="col-md-6">
									<div class="image" style="background-image: url(<?php echo esc_url($image); ?>);">
				                        <a href="<?php echo esc_url($image); ?>" class="swipebox" rel="gallery-post"></a>
				                    </div>
								</div>
							<?php endif ?>

							<?php if ($x==2): ?>
								<div class="col-md-6">
							<?php endif ?>

							<?php if($x!=1 && $x<5): ?>
								<div class="image" style="background-image: url(<?php echo esc_url($image); ?>);">
			                        <a href="<?php echo esc_url($image); ?>" class="swipebox" rel="gallery-post"></a>
			                    </div>
							<?php endif; ?>

							<?php if ($x==5 || $y==$total): ?>
								</div>
							<?php endif ?>

		        		<?php if ($x==5 || $y==$total): ?>
		        			</div><!-- end row-->
		        			<?php $x=0; ?>
		        		<?php endif ?>
		        	<?php $x++; endforeach; ?>

		        </div>
		    </div>
		</section>
	<?php endif ?>

	<?php if ($sk8er_portfolio_slider == 'on'): ?>
		<section class="style-misc portfolio-single-gallery-big-slider">
		    <div class="inner">
		        <div class="container">
		            <div class="actual-slider">
		            	<?php if (!empty($sk8er_portfolio_images)): ?>
		            		 	<?php foreach ($sk8er_portfolio_images as $image): ?>
		            		 		<div class="image" style="background-image: url(<?php echo esc_url($image); ?>);">
		            		 		    <a href="<?php echo esc_url($image); ?>" class="swipebox" rel="gallery-post"></a>
		            		 		</div>
		            				<?php endforeach; ?>
		            	<?php endif ?>
		            </div>
		        </div>
		    </div>
		</section>
	<?php endif ?>

	<section class="style-misc portfolio-single-content">
        <div class="inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 text">
                    	<?php if ($sk8er_portfolio_images_layout == 'normal' && $sk8er_portfolio_slider != 'on'): ?>
                    		<?php if (!empty($sk8er_portfolio_images)): ?>
                    			<?php foreach ($sk8er_portfolio_images as $image): ?>
                    				<div class="image" style="background-image: url(<?php echo esc_url($image); ?>);">
                    				    <a href="<?php echo esc_url($image); ?>" class="swipebox" rel="gallery-post"></a>
                    				</div>
                    			<?php endforeach ?>
                    		<?php endif ?>
                    	<?php endif ?>

                    	<br>

                        <?php the_content(); ?>
                    </div>

                    <div class="col-md-3 col-md-offset-1 sidebar">
                    	<?php if (!empty($sk8er_client_name)): ?>
                    		<div class="box">
                    		    <div class="name"><i class="fa fa-globe"></i><?php _e('Client:', 'sk8er') ?></div>
                    		    <div class="content">
                    		        <a href="<?php echo esc_url($sk8er_client_url); ?>" target="_blank"><?php echo esc_html($sk8er_client_name); ?></a>
                    		    </div>
                    		</div>
                    	<?php endif ?>

                        <div class="box">
                            <div class="name"><i class="fa fa-clock-o"></i><?php _e('Date:', 'sk8er') ?></div>
                            <div class="content">
                                <?php the_time('F j, Y'); ?>
                            </div>
                        </div>

                        <?php if (!empty($sk8er_client_url) && $sk8er_client_url!='javascript:void(null);'): ?>
                        	<div class="box">
	                            <div class="name"><i class="fa fa-chain"></i><?php _e('Links:', 'sk8er') ?></div>
	                            <div class="content">
	                                <a href="<?php echo esc_url($sk8er_client_url); ?>" target="_blank"><?php echo esc_url($sk8er_client_url); ?></a>
	                            </div>
                        	</div>
                        <?php endif ?>

                        <?php if (!empty($sk8er_client_tasks)): ?>
                        	<div class="box">
                        	    <div class="name"><i class="fa fa-tasks"></i><?php _e('Task(s):', 'sk8er') ?></div>
                        	    <div class="content">
                        	        <?php echo esc_html($sk8er_client_tasks); ?>
                        	    </div>
                        	</div>
                        <?php endif ?>

                       <?php $additional_info = get_post_meta($post->ID, 'sk8er_portfolio_additional_info') ?>
                       <?php if (!empty($additional_info[0])): ?>
                       		<?php foreach ($additional_info as $info): ?>
                       			<div class="box">
                       				<div class="name"><i class="fa <?php echo esc_attr($info[0]['icon']); ?>"></i><?php echo esc_html($info[0]['title']); ?></div>
                       				<div class="content">
                       					<?php echo esc_html($info[0]['text']); ?>
                       				</div>
                       			</div>
                       		<?php endforeach ?>
                       <?php endif ?>

                        <div class="box">
                            <div class="name"><i class="fa fa-heart-o"></i><?php _e('Share the love:', 'sk8er') ?></div>
                            <div class="content">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="social-link" target="_blank"><i class="fa fa-facebook"></i></a>
                                <a href="https://twitter.com/home?status=<?php the_permalink(); ?>" class="social-link" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=&description=" class="social-link" target="_blank"><i class="fa fa-pinterest"></i></a>
                                <a href="http://www.tumblr.com/share/link?url=<?php the_permalink(); ?>&amp;name=<?php the_title(); ?>&amp;description=" class="social-link" target="_blank" style="display: none;"><i class="fa fa-tumblr"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<section class="style-misc portfolio-single-related cols col-4">
	    <div class="inner">
	        <div class="container">
	            <div class="small-title-bar">
	                <h3><?php _e('Related Posts', 'sk8er') ?>:</h3>
	            </div>

	            <div class="portfolio-items-wrapper boxes">

	            	<?php
	            		$tags = wp_get_post_tags($post->ID);  
	            		if ($tags) {

	            		    $tag_ids = array();  
	            		    foreach($tags as $individual_tag) { $tag_ids[] = $individual_tag->term_id; }

	            		} else { $tag_ids = "";}
	            	    $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 4, 'tag__in' => $tag_ids, 'ignore_sticky_posts'=>1);
	            	    $wp_query = new WP_Query( $args );
	            	?>

	            	<?php if ($wp_query->have_posts() ): while($wp_query->have_posts() ): $wp_query->the_post() ?>
	            		<?php $current_category = wp_get_object_terms( $post->ID, 'portfolio-categories', array('orderby'=>'term_order')); ?>
						<?php if ($post->ID != $curr_id): ?>
							
							<?php if (has_post_thumbnail( $post->ID ) ): ?>
							    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
							    <?php $thumbnail = $image[0]; ?>
							<?php else: ?>
							    <?php $thumbnail = "http://placehold.it/800x480&text=Portfolio+Image"; ?>
							<?php endif; ?>
							
							<div <?php post_class("item"); ?>>
							    <div class="image">
							        <div class="actual-image" style="background-image: url(<?php echo esc_url($thumbnail); ?>);"></div>
							        <div class="hover">
							            <div class="actions">
							                <a href="<?php the_permalink(); ?>"><i class="fa fa-chain"></i></a>
							                    <span class="sep"></span>
							                <a href="<?php echo esc_url($thumbnail); ?>" class="swipebox"><i class="fa fa-search"></i></a>
							            </div>
							        </div>
							    </div>
							    <div class="info">
							        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							        <span><?php echo esc_html($current_category[0]->name); ?></span>
							        <?php the_excerpt(); ?>
							    </div>
							</div>

						<?php endif ?>

	            	<?php endwhile; endif; ?>

	            </div>
	        </div>
	    </div>
	</section>

<?php get_footer(); ?>