<?php
/**
 * Text With Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_text_with_image_v3 extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'	=> '',
            'subtitle' => '',
            'text' => '',
            'image' => '',
            'image_align' => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
        ?>

        <?php if ($image_align=='yes'): ?>
        	<section class="style-misc half-half image-left">
        <?php else: ?>
        	<section class="style-misc half-half">
        <?php endif ?>

            <div class="row">
                <div class="col-md-6 text">
                    <div class="box">
                        <div class="inside">
                            <?php if (!empty($title) || !empty($subtitle)): ?>
                            	<div class="title">
                            	    <?php if (!empty($title)): ?>
                            	    	<h3><?php echo esc_html($title); ?></h3>
                            	    <?php endif ?>
                            	    <?php if (!empty($subtitle)): ?>
                            	    	<span><?php echo esc_html($subtitle); ?></span>
                            	    <?php endif ?>
                            	</div>
                            <?php endif ?>

                            <?php if (!empty($text)): ?>
                            	<p><?php echo esc_html($text); ?></p>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 image">
                    <div class="box">
                        <div class="inside">
                        	<?php $image = wp_get_attachment_image_src( $image, 'full' ); ?>
                            <img src="<?php echo esc_url($image[0]); ?>" alt="">
                        </div>
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
    "name"      => __("Text and Image Section (v3)", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_text_with_image_v3",
    "class"     => "vc_text_with_image_v3",
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
            "type"        => "attach_image",
            "heading"     => __("Image", 'js_composer'),
            "param_name"  => "image",
            "value"       => "",
            "description" => __("Add image for your section", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Image on the left side?', 'js_composer' ),
            'param_name' => 'image_align',
            'description' => __( 'If is not checked, slider will be on right side.', 'js_composer' ),
            'value' => array( __( 'Yes, please.', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);