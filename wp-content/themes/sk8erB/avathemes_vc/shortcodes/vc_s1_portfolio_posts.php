<?php
/**
 *  Portfolio Posts List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s1_portfolio_posts extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'text'          => '',
            'title_style'   => '',
        ), $atts));

        ob_start();

        wp_enqueue_script('sk8er-kinetic');
        wp_enqueue_script('sk8er-jquery-ui');
        wp_enqueue_script('sk8er-mousewheel');
        wp_enqueue_style('sk8er-swipebox');
        wp_enqueue_style('sk8er-smoothDivScroll');
        wp_enqueue_script('sk8er-smoothDivScroll');
        ?>

        <?php
            $args = array( 'post_type' => 'portfolio');
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ($title_style=="style_1"): ?>
                <section class="style-1 portfolio">
            <?php elseif($title_style=="style_3"): ?>
                <section class="style-3 portfolio">
            <?php else: ?>
                <section class="style-13 portfolio">
        <?php endif ?>

        
            <?php if (empty($title) && empty($subtitle)): ?>
                    <div class="inner" style="padding-top:0;">
                <?php else: ?>
                    <div class="inner">
            <?php endif ?>

                <?php if (!empty($title) || !empty($subtitle)): ?>
                	<div class="container">
                	    <div class="title-bar">
                	        <?php if (!empty($title)): ?>
                	        	<?php if ($title_style=="style_1"): ?>
                                        <h3><?php echo esc_html($title); ?></h3>
                                    <?php elseif($title_style=="style_3"): ?>
                                        <h3><?php echo esc_html($title); ?></h3>
                                    <?php else: ?>
                                        <h3><span><?php echo esc_html($title); ?></span></h3>
                                <?php endif ?>
                	        <?php endif ?>
                	        <?php if (!empty($subtitle)): ?>
                	        	<span><?php echo esc_html($subtitle); ?></span>
                	        <?php endif ?>
                	    </div>

                        <?php if (!empty($text)): ?>
                            <div class="row" style="margin-bottom: 60px;">
                                <div class="col-md-10 col-md-offset-1">
                                    <p class="desc">
                                        <?php echo esc_html($text); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>
                	</div>
                <?php endif ?>

                <?php if ($wp_query->have_posts() && taxonomy_exists('portfolio-categories')): ?>
                	<?php global $sk8er_total; global $post; ?>

	                <div class="row portfolio-gallery-wrapper">
	                    <div class="portfolio-gallery">
							<?php while($wp_query->have_posts() ): $wp_query->the_post() ?>
								<?php $sk8er_total++; ?>
							<?php endwhile; ?>


							<?php $x = 1; $y = 1; while($wp_query->have_posts() ): $wp_query->the_post() ?>
								<?php if (has_post_thumbnail( $post->ID ) ): ?>
								    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
								    <?php $thumbnail = $image[0]; ?>
								<?php else: ?>
								    <?php $thumbnail = "http://placehold.it/800x480"; ?>
								<?php endif; ?>

								<?php if ($x==1): ?>
									<!-- one column -->
									    <div class="col-xs-6 col-sm-3">
								<?php endif ?>

		                                <div class="image col-same-height" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
		                                    <div class="hover">
		                                        <span class="leftright-border"></span>
		                                        <span class="topbottom-border"></span>

		                                        <div class="inside">
		                                            <div class="name"><?php the_title(); ?></div>
		                                            <hr>
		                                            <div class="links">
		                                                <a href="<?php echo esc_url($thumbnail); ?>" class="open-image swipebox" rel="gallery-portfolio"><i class="fa fa-search-plus"></i></a>
		                                                <a href="<?php the_permalink(); ?>" class="open-external"><i class="fa fa-external-link"></i></a>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>

		                        <?php if ($x==2 || $y == $sk8er_total): ?>
		                        	    </div>
		                        	<!-- end of one column -->
		                        	<?php $x=0; ?>
		                        <?php endif; ?>
	                        <?php $x++; $y++; endwhile; ?>

                            

	                    </div>
	                </div>

                <?php endif ?>

            </div>
        </section>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Portfolio Posts", 'js_composer'),
    "description" => __('Insert Section with Latest Portfolio Posts', 'js_composer'),
    "base"      => "vc_s1_portfolio_posts",
    "class"     => "vc_s1_portfolio_posts",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Title", 'js_composer'),
            "param_name"  => "title",
            "value"       => "",
            "description" => __("Add title for your section", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Subtitle", 'js_composer'),
            "param_name"  => "subtitle",
            "value"       => "",
            "description" => __("Add subtitle for your section", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("Text", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add text for your section", 'js_composer')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Title Style (Layout 1)', 'js_composer' ),
            'param_name' => 'title_style',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Style 1', 'js_composer' ) => 'style_1', __( 'Style 2', 'js_composer' ) => 'style_2', __( 'Style 3', 'js_composer' ) => 'style_3'),
            'std' => 'style_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);