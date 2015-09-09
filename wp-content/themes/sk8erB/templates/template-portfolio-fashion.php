<?php
/*
Template Name: Messy Portfolio Grid
*/
?>
<?php get_header(); ?>
<?php
	$main_title 	= get_post_meta($post->ID, 'sk8er_portfolio_messy_title', true);
	$subtitle 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_subtitle', true);
	$text_1_title 	= get_post_meta($post->ID, 'sk8er_portfolio_messy_text_1_title', true);
	$text_1_text 	= get_post_meta($post->ID, 'sk8er_portfolio_messy_text_1_text', true);
	$text_2_title 	= get_post_meta($post->ID, 'sk8er_portfolio_messy_text_2_title', true);
	$text_2_text 	= get_post_meta($post->ID, 'sk8er_portfolio_messy_text_2_text', true);
	$image_1 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_1', true);
	$image_2 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_2', true);
	$image_3 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_3', true);
	$image_4 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_4', true);
	$image_5 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_5', true);
	$image_6 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_6', true);
	$image_7 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_7', true);
	$image_8 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_image_8', true);
	$social 		= get_post_meta($post->ID, 'sk8er_portfolio_messy_social', true);
?>

	<section class="style-misc portfolio-fashion-single">
	    <div class="inner">
	        <div class="container">
	            <div class="title">
	                <div class="first">
	                    <?php echo wp_kses($main_title, 'span'); ?>
	                </div>
	                <div class="second">
	                    <?php echo wp_kses($subtitle, 'span'); ?>
	                </div>
	            </div>

	            <div class="row inner-content">
	                <div class="col-md-6">
	                    <div class="box-1">
	                        <?php if (!empty($image_1)): ?>
	                        	<div class="image">
	                        	    <div class="black-border" data-scalar-x="8" data-scalar-y="3">
	                        	        <img src="<?php echo esc_url($image_1); ?>" alt="">
	                        	        <div class="layer" data-depth="1.0"></div>
	                        	    </div>
	                        	</div>
	                        <?php endif ?>
	                        <?php if (!empty($text_1_title)): ?>
	                        	<div class="text">
	                        	    <h3><?php echo esc_html($text_1_title); ?></h3>
	                        	    <p><?php echo esc_html($text_1_text); ?></p>
	                        	</div>
	                        <?php endif ?>
	                    </div>

	                    <div class="box-2">
	                        <?php if (!empty($image_2)): ?>
	                        	<div class="image">
	                        	    <img src="<?php echo esc_url($image_2); ?>" alt="">
	                        	</div>
	                        <?php endif ?>
	                        <?php if (!empty($text_2_title)): ?>
	                        	<div class="text">
	                        	    <h3><?php echo esc_html($text_2_title); ?></h3>
	                        	    <p><?php echo esc_html($text_2_text); ?></p>
	                        	</div>
	                        <?php endif ?>
	                    </div>

	                    <div class="box-3">
	                        <?php if (!empty($image_3)): ?>
	                        	<div class="image">
	                        	    <div class="black-border" data-scalar-x="8" data-scalar-y="3">
	                        	        <img src="<?php echo esc_url($image_3); ?>" alt="">
	                        	        <div class="layer" data-depth="1.0"></div>
	                        	    </div>
	                        	</div>
	                        <?php endif ?>
	                    </div>
	                </div>
	                <div class="col-md-6">
	                    <div class="box-4">
	                        <?php if (!empty($image_4)): ?>
	                        	<div class="image">
	                        	    <div class="black-border" data-scalar-x="8" data-scalar-y="3">
	                        	        <img src="<?php echo esc_url($image_4); ?>" alt="">
	                        	        <div class="layer" data-depth="1.0"></div>
	                        	    </div>
	                        	</div>
	                        <?php endif ?>
	                    </div>

	                    <div class="box-5">
	                        <?php if (!empty($image_5)): ?>
	                        	<div class="image">
	                        	    <img src="<?php echo esc_url($image_5); ?>" alt="">
	                        	</div>
	                        <?php endif ?>

	                        <?php if (!empty($image_6)): ?>
	                        	<div class="image">
	                        	    <img src="<?php echo esc_url($image_6); ?>" alt="">
	                        	</div>
	                        <?php endif ?>

	                        <?php if (!empty($image_7)): ?>
	                        	<div class="image right">
	                        	    <div class="black-border" data-scalar-x="8" data-scalar-y="3">
	                        	        <img src="<?php echo esc_url($image_7); ?>" alt="">
	                        	        <div class="layer" data-depth="1.0"></div>
	                        	    </div>
	                        	</div>
	                        <?php endif ?>

	                        <?php if (!empty($image_8)): ?>
	                        	<div class="image">
	                        	    <img src="<?php echo esc_url($image_8); ?>" alt="">
	                        	</div>
	                        <?php endif ?>
	                    </div>
	                </div>
	            </div>

	            <?php if (!empty($social)): ?>

	            	<div class="social-links">

					<?php foreach ($social as $single): ?>
						<a href="<?php echo esc_url($single['url']); ?>" target="_blank"><?php echo esc_html($single['name']); ?></a>
					<?php endforeach ?>

					</div>

	            	<?php else: ?>

	            	<?php $sk8er_social = $sk8er['sk8er_social']; ?>

	            	<?php if (!empty($sk8er_social[0]['url'])): ?>
	            	    <div class="social-links">
	            	        <?php foreach ($sk8er_social as $social): ?>
	            	            <a href="<?php echo esc_url($social['url']); ?>" target="_blank"><?php echo esc_html($social['title']); ?></a>
	            	        <?php endforeach ?>
	            	    </div>
	            	<?php endif ?>
	            <?php endif ?>
	        </div>
	    </div>
	</section>

<?php get_footer(); ?>