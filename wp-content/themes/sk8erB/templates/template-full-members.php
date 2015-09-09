<?php
/*
Template Name: Members Page
*/
?>
<?php get_header(); ?>

	<?php
	    global $post;
	    global $sk8er;
	    $args = array( 'post_type' => 'members', 'posts_per_page' => -1);
	    $wp_query = new WP_Query( $args );
	?>

	<?php if ($wp_query->have_posts()): ?>
		<?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
			<?php 
				$position = get_post_meta($post->ID, 'sk8er_member_position', true);
				$transparent_image = get_post_meta($post->ID, 'sk8er_member_transparent_image', true);
				$name = explode(' ',get_the_title());
				$background = get_post_meta($post->ID, 'sk8er_member_background_color', true);
			?>

			<section class="style-misc team-member" style="background-color: <?php echo esc_url($background); ?>;">
			    <div class="cut"></div>
			    <div class="container">
			        <div class="row">
			            <div class="col-md-5 text">
			                <div class="box">
			                    <span class="name" data-name="<?php the_title(); ?>">
			                    	<?php $x=1; foreach ($name as $word): ?>

			                    		<?php if ($x % 2 == 1): ?>
			                    			<b><?php echo esc_html($word); ?></b>
			                    		<?php else: ?>
			                    			<?php echo esc_html($word); ?>
			                    		<?php endif ?>

			                    	<?php $x++; endforeach ?>
			                    </span>
			                    <span class="desc" style="display: none;">One Morning, When Gregor <b>Samsa Woke From Troubled</b></span>
			                    <span class="position"><?php echo esc_html($position); ?></span>
			                    <p><?php echo wp_strip_all_tags(get_the_content()); ?></p>
			                </div>
			            </div>

			            <div class="col-md-5 image">
			                <div class="valign-wrapper">
			                    <div class="valign">
			                        <img src="<?php echo esc_url($transparent_image); ?>" alt="">
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</section>

		<?php endwhile; ?>
	<?php endif ?>
	 <?php wp_reset_query(); ?> 

	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>