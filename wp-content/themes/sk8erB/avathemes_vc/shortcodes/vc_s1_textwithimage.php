<?php
/**
 * Text With Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_textwithimage extends  WPBakeryShortCode
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

        <?php if (isset($title)): ?>
            <section class="style-1 image-bottom">
                <div class="inner">

                    <div class="container">
                        <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                        </div>

                        <?php if (!empty($text)): ?>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <p class="desc">
                                        <?php echo esc_html($text); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                </div>

                <?php if (!empty($image)): ?>
                    <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>
                    <div class="spec-image">
                        <img src="<?php echo esc_url($image_url[0]); ?>" alt="">
                    </div>
                <?php endif ?>
            </section>
        <?php endif ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Text and Image Section", 'js_composer'),
    "description" => __('Insert Section with Text and Image', 'js_composer'),
    "base"      => "vc_textwithimage",
    "class"     => "vc_textwithimage",
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