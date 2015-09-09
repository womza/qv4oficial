<?php
/**
 * Image Bottom Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_image_bottom extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'description' => '',
            'image'    => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            $image_url = wp_get_attachment_image_src( $image, 'full' );
        ?>

        <section class="style-misc image-bottom">
            <div class="inner">

                <div class="container">
                    <?php if (!empty($title)): ?>
                        <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($description)): ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p class="desc">
                                    <?php echo esc_html($description); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>

            </div>

            <?php if (!empty($image)): ?>
                <div class="spec-image">
                    <img src="<?php echo esc_url($image_url[0]); ?>" alt="">
                </div>
            <?php endif ?>
        </section>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Title and Image", 'js_composer'),
    "description" => __('Insert Section with image and title', 'js_composer'),
    "base"      => "vc_image_bottom",
    "class"     => "vc_image_bottom",
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
            "type"        => "textarea",
            "heading"     => __("Description", 'js_composer'),
            "param_name"  => "description",
            "value"       => "",
            "description" => __("Add description for your section", 'js_composer')
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