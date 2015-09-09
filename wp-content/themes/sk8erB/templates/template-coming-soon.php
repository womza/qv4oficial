<?php
/*
Template Name: Coming Soon Page
*/
?>
<?php get_header(); ?>
	<?php
		$title 	= get_post_meta($post->ID, 'sk8er_coming_soon_title', true);
		$description 	= get_post_meta($post->ID, 'sk8er_coming_soon_description', true);
		$background = get_post_meta($post->ID, 'sk8er_coming_soon_background', true);
		$counter 	= get_post_meta($post->ID, 'sk8er_coming_soon_counter', true);
		$counter = explode("/",$counter);
		if (isset($counter[1])) {
			$c_day = $counter[1];
		} else { $c_day = 0; }
		if (isset($counter[0])) {
			$c_month = $counter[0];
		} else {$c_month = 0; }
		if (isset($counter[2])) {
			$c_year = $counter[2];
		} else { $c_year = 0; }		
	?>

	<div class="coming-soon-header" style="background-image: url(<?php echo esc_url($background); ?>);">
	    <div class="logo">
	        <a href="<?php echo home_url(); ?>">
	            <?php if (!empty($sk8er['sk8er_logo']['url'])): ?>
	                    <img src="<?php echo esc_url($sk8er['sk8er_logo']['url']); ?>" alt="<?php echo bloginfo('title'); ?>">
	                <?php else: ?>
	                    <span class="txt-logo"><?php echo bloginfo('title'); ?></span>
	            <?php endif ?>
	            <span class="cut"></span>
	        </a>
	    </div>

	    <a href="javascript:void(null);" class="go-to-contact scrollto" data-scroll="big-contact"><i class="fa fa-envelope"></i></a>

	    <div class="container">
	        <?php if (!empty($title)): ?>
	        	<h3><?php echo esc_html($title); ?></h3>
	        <?php endif ?>

	        <div class="count-down-timer"></div>

	        <?php if (!empty($description)): ?>
	        	<div class="row">
	        	    <div class="col-md-8 col-md-offset-2">
	        	        <p class="text">
	        	            <?php echo esc_html($description); ?>
	        	        </p>
	        	    </div>
	        	</div>
	        <?php endif ?>
	    </div>
	</div>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>

	<script>
	    (function($){
	    	$(document).ready(function() {
    			if ($(".big-contact").length > 0) {$(".go-to-contact").show();}else{$(".go-to-contact").hide();}

    		    $(document).ready(function() {
    		        // 0 is january / 1-1 (1 is from wp, -1 is static)
    		        var newDate = new Date(<?php echo esc_attr($c_year); ?>, <?php echo esc_attr($c_month); ?>-1, <?php echo esc_attr($c_day); ?>);
    		        $('.count-down-timer').countdown({until: newDate});
    		    });
	    	});
	    })(jQuery); 
	</script>

<?php get_footer(); ?>