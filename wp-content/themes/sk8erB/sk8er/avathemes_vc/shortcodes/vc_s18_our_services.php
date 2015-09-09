<?php
/**
 * Our Services for Visual Composer
 */

class WPBakeryShortCode_vc_s18_our_services extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'services', 'posts_per_page' => -1);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ($wp_query->have_posts()): ?>
    		<section class="style-18 services">
    		    <div class="inner">
    		        <div class="container">
    		            <div class="row list">

    		            	<?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
    		            		<?php $icon = get_post_meta($post->ID, 'sk8er_services_icon', true); ?>

    		                	<div class="col-md-3">
	    		                    <div class="box">
	    		                    	<?php if (!empty($icon)): ?>
	    		                    		<div class="icon">
	    		                    		    <i class="fa <?php echo esc_attr($icon); ?>"></i>
                                                <a href="javascript:void(null);" class="full"></a>
	    		                    		</div>
	    		                    	<?php endif ?>
	    		                        
	    		                        <div class="content">
	    		                            <span class="name"><?php the_title(); ?></span>
	    		                            <p><?php echo sk8er_excerpt(18); ?></p>

	    		                            <div class="buttons">
	    		                                <a href="<?php the_permalink(); ?>" class="ia"><span><?php _e( 'Learn more' , 'sk8er' ) ?> <i class="fa fa-long-arrow-right"></i></span></a>
	    		                            </div>
	    		                        </div>
	    		                    </div>
	    		                </div>

    		                <?php endwhile; ?>
                        </div>
    		        </div>
    		    </div>
    		</section>
        <?php endif ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Services List", 'js_composer'),
    "description" => __('Insert Services (Posts) Section', 'js_composer'),
    "base"      => "vc_s18_our_services",
    "class"     => "vc_s18_our_services",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("From the left side menu, choose Services and then from there add services.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);