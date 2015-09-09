<?php
/**
 * About With Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s10_text_with_link extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'subtitle'    => '',
            'text'    => '',
            'image'    => '',
            'learn_more'    => '',
            'image_left' => '',
        ), $atts));

        ob_start();
        ?>

        <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>

        
        <?php if ($image_left=='yes'): ?>
                <section class="style-10 features">
            <?php else: ?>
                <section class="style-10 features imgright">
        <?php endif ?>
            <div class="inner">
                <div class="container">
                    <div class="col-md-8 image">
                        <?php if (!empty($image)): ?>
                            <img src="<?php echo esc_url($image_url[0]); ?>" alt="">
                        <?php endif ?>
                    </div>
                    <div class="col-md-4 text">
                        <?php if (!empty($title) || !empty($subtitle)): ?>
                            <div class="title-bar">
                                <?php if (!empty($title)): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif ?>
                                <?php if (!empty($subtitle)): ?>
                                    <span><?php echo esc_html($subtitle); ?></span>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($text)): ?>
                            <p>
                                <?php echo esc_html($text); ?>
                            </p>
                        <?php endif ?>

                        <?php if (!empty($learn_more)): ?>
                            <div class="buttons">
                                <a href="<?php echo esc_url($learn_more); ?>"><span><?php _e( 'Learn More' , 'sk8er' ); ?></span></a>
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
    "name"      => __("Text with image and link", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s10_text_with_link",
    "class"     => "vc_s10_text_with_link",
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
            "type"        => "textfield",
            "heading"     => __("Learn More link (to some page or external)", 'js_composer'),
            "param_name"  => "learn_more",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Image on left?', 'js_composer' ),
            'param_name' => 'image_left',
            'description' => __( 'If is not checked, image will be on right side.', 'js_composer' ),
            'value' => array( __( 'Yes, please.', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);