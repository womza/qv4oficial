<?php
/**
 * Standalone Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_standalone_image extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'     => '',
            'image'    => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            $image_url = wp_get_attachment_image_src( $image, 'full' );
        ?>

        <section class="style-misc image">
            <div class="inner">
                <?php if (!empty($title)): ?>
                    <div class="container">
                        <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
                        </div>
                    </div>
                <?php endif ?>

                <div class="row image-wrapper">
                    <div class="container">
                        <img src="<?php echo esc_url($image_url[0]); ?>" alt="">
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
    "name"      => __("Standalone Image", 'js_composer'),
    "description" => __('Insert Section with just image', 'js_composer'),
    "base"      => "vc_standalone_image",
    "class"     => "vc_standalone_image",
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