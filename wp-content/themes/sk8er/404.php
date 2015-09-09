<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Sk8er
 */
global $sk8er;
$bg_404 = $sk8er['sk8er_404_bg'];
get_header(); ?>

	<section class="fourofour" style="background-image: url(<?php echo esc_url($bg_404['url']); ?>);">
	    <div class="inner">
	        <div class="container">
	            <div class="box">
	                <div class="inside">
	                    <div class="icon">
	                        <img src="<?php echo get_template_directory_uri(); ?>/img/fourofour-rocket.png" style="width: 30px;" alt="">
	                    </div>

	                    <h3>404</h3>
	                    <span><?php _e( 'Oops! That page can&rsquo;t be found.', 'sk8er' ); ?></span>

	                    <a href="javascript:history.back()" class="go-back">Go Back</a>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>

<?php get_footer(); ?>
