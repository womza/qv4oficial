<?php
/**
 * About With Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s10_about_with_image extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'subtitle'    => '',
            'text'    => '',
            'image'    => '',
        ), $atts));

        ob_start();
        ?>

        <section class="style-10 about-app">
            <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>
            <div class="inner">
                <div class="container">
                    <div class="col-md-6 image">
                        <img src="<?php echo esc_url($image_url[0]); ?>" alt="">
                    </div>
                    <div class="col-md-6 text">
                        <div class="title-bar">
                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                        </div>

                        <?php if (!empty($text)): ?>
                            <p>
                                <?php echo esc_html($text); ?>
                            </p>
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
    "name"      => __("About With Image", 'js_composer'),
    "description" => __('Insert Section with About text and image', 'js_composer'),
    "base"      => "vc_s10_about_with_image",
    "class"     => "vc_s10_about_with_image",
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
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);