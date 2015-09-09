<?php
/**
 * Single Wine Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s9_single_wine extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'wine_year'                 => '',
            'text'                      => '',
            'wine_price'                => '',
            'wine_desc'                 => '',
            'wine_bg_image'             => '',
            'wine_bottle_image'         => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>
        <?php
            $bg_image = wp_get_attachment_image_src( $wine_bg_image, 'full' );
            $bottle_image = wp_get_attachment_image_src( $wine_bottle_image, 'full' );
        ?>

        <section class="style-9 textwithimage">
            <div class="inner">
                <div class="container">
                    <div class="col-md-6 text">
                        <?php if (!empty($wine_year)): ?>
                            <div class="head-title">
                                <div class="actual-title">
                                    <span class="pre">
                                        Since
                                    </span>
                                    <h3>
                                        <?php echo esc_html($wine_year); ?>
                                    </h3>
                                    <span class="endhr"></span>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="actual-text">
                            <p><?php echo esc_html($text); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 image">
                        <div class="topimg">
                            <img src="<?php echo esc_url($bg_image[0]); ?>" alt="">
                        </div>
                        <div class="actualimg">
                            <img src="<?php echo esc_url($bottle_image[0]); ?>" alt="">
                        </div>
                        <?php if (!empty($wine_price)): ?>
                            <div class="price">
                                <?php echo esc_html($wine_price); ?>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($wine_desc)): ?>
                            <div class="minitext">
                                <span><?php echo esc_html($wine_desc); ?></span>
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
    "name"      => __("Single Wine Block", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s9_single_wine",
    "class"     => "vc_s9_single_wine",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Wine Year", 'js_composer'),
            "param_name"  => "wine_year",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("Text", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add text for your section", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Price in Buble", 'js_composer'),
            "param_name"  => "wine_price",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("Buble Text", 'js_composer'),
            "param_name"  => "wine_desc",
            "value"       => "",
            "description" => __("Add text in buble", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Top Image", 'js_composer'),
            "param_name"  => "wine_bg_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Bottom (Bottle) Image", 'js_composer'),
            "param_name"  => "wine_bottle_Image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);