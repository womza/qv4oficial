<?php
/**
 * Image Links Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_image_links extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'first_image' => '',
            'first_link' => '',
            'second_image' => '',
            'second_link' => '',
            'third_image' => '',
            'third_link' => '',
            'grey_bg' => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            $first_image = wp_get_attachment_image_src( $first_image, 'full' );
            $second_image = wp_get_attachment_image_src( $second_image, 'full' );
            $third_image = wp_get_attachment_image_src( $third_image, 'full' );
            if ($grey_bg=='yes') {
                $add_class="grey_bg";
            } else { $add_class=""; }
        ?>

        <section class="style-2 image-links <?php echo esc_attr($add_class); ?>">
            <div class="container">
                <div class="row">

                    <div class="col-xs-12">
                        <?php if (!empty($first_image[0])): ?>
                            <div class="one-link-wrapper">
                                <a class="one-link" href="<?php esc_url($first_link); ?>" style="background-image: url(<?php echo esc_url($first_image[0]); ?>);">
                                </a>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($second_image[0])): ?>
                            <div class="one-link-wrapper">
                                <a class="one-link" href="<?php esc_url($second_link); ?>" style="background-image: url(<?php echo esc_url($second_image[0]); ?>);">
                                </a>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($third_image[0])): ?>
                            <div class="one-link-wrapper">
                                <a class="one-link" href="<?php esc_url($third_link); ?>" style="background-image: url(<?php echo esc_url($third_image[0]); ?>);">
                                </a>
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
    "name"      => __("Image Links Block", 'js_composer'),
    "description" => __('Insert Section with Image Links', 'js_composer'),
    "base"      => "vc_image_links",
    "class"     => "vc_image_links",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "attach_image",
            "heading"     => __("[1] Image", 'js_composer'),
            "param_name"  => "first_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[1] Link", 'js_composer'),
            "param_name"  => "first_link",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("[2] Image", 'js_composer'),
            "param_name"  => "second_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[2] Link", 'js_composer'),
            "param_name"  => "second_link",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("[3] Image", 'js_composer'),
            "param_name"  => "third_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[3] Link", 'js_composer'),
            "param_name"  => "third_link",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Grey Background?', 'js_composer' ),
            'param_name' => 'grey_bg',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Yes.', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);