<?php
/**
 * About with Slider for Visual Composer
 */

class WPBakeryShortCode_vc_s18_about_with_slider extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        ?>

        <?php
        	global $sk8er;
        	$main_title 		= $sk8er['sk8er_aws_main_title'];
        	$about_title 		= $sk8er['sk8er_aws_about_title'];
            if (isset($sk8er['sk8er_aws_about_text'])) {
                $about_text         = $sk8er['sk8er_aws_about_text'];
            }
        	$about_link 		= $sk8er['sk8er_aws_about_link'];
        	$slider 			= $sk8er['sk8er_aws_slider'];
        ?>

       <section class="style-18 about">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($main_title)): ?>
                    	<div class="title-bar">
                    	    <h3><?php echo esc_html($main_title); ?></h3>
                    	</div>
                    <?php endif ?>

                    <div class="row">
                    	<?php if (!empty($about_text[0])): ?>
                    		
	                    	<?php if (!empty($slider[0]['url'])): ?>
	                			<div class="col-md-6 text">
	                			<?php else: ?>
	                			<div class="col-md-6 col-md-offset-3 text">
	                		<?php endif ?>

	                        <?php if (!empty($about_title)): ?>
	                        	<h3><?php echo esc_html($about_title); ?></h3>
	                        <?php endif ?>
	                        
	                        <ul>
	                        	<?php if (!empty($about_text[0])): ?>
	                        		<?php foreach ($about_text as $single): ?>
	                        			<?php if (!empty($single)): ?>
	                        				<li><?php echo esc_html($single); ?></li>
	                        			<?php endif ?>
	                        		<?php endforeach ?>
	                        	<?php endif ?>
	                        </ul>
							
							<?php if (!empty($about_link)): ?>
								<div class="main-buttons">
								    <a href="<?php echo esc_url($about_link); ?>"><span><?php _e( 'Read More' , 'sk8er' ); ?></span></a>
								</div>
							<?php endif ?>

							</div>

						<?php endif ?>
                        

                        <?php if (!empty($slider[0]['url'])): ?>
                        	<?php if (!empty($about_text[0])): ?>
                        		<div class="col-md-6 slider-col col-same-height">
                        		<?php else: ?>
                        		<div class="col-md-6 col-md-offset-3 slider-col col-same-height">
                        	<?php endif ?>
                        	
                        	    <div class="slider">

                        	        <div class="slider-wrapper">
                        	            <div class="slider-controls">
                        	            	<?php foreach ($slider as $slide): ?>
                        	            		<a href="javascript:void(null);" class="ia">
                        	            		    <i class="fa <?php echo esc_attr($slide['url']); ?>"></i>
                        	            		</a>
                        	            	<?php endforeach ?>
                        	            </div>
                        	            <div class="slider-slides">

                        	            	<?php foreach ($slider as $slide): ?>
                        	            		<div class="slide" style="background-image: url(<?php echo esc_url($slide['image']); ?>)">
	                        	                    <div class="inside">
	                        	                        <h3><?php echo esc_html($slide['title']); ?></h3>
	                        	                        <p><?php echo esc_html($slide['description']); ?></p>
	                        	                    </div>
                        	                	</div>
                        	            	<?php endforeach ?>

                        	            </div>
                        	        </div>

                        	    </div>
                        	</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </section>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("About block with slider", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s18_about_with_slider",
    "class"     => "vc_s18_about_with_slider",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>About with Slider Section</b> and from there fill info.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);