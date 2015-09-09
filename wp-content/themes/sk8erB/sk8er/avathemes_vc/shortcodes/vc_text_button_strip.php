<?php
/**
 *  Text with button Strip  Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_text_button_strip extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'text'          => '',
            'button_text'   => '',
            'button_link'   => '',
            'background_color' => '',
            'layout'        => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
        ?>
        
        <?php if ($layout=="layout_1"): ?>
            <section class="buy-theme">
                <div class="container">
                    <?php if (!empty($text)): ?>
                        <div class="text">
                            <?php echo esc_html($text); ?>
                        </div>
                    <?php endif ?>

                    <div class="button">
                        <a href="<?php echo esc_url($button_link); ?>" class="ia" target="_blank" style="background-color: <?php echo esc_attr($background_color); ?>;">
                        <?php echo esc_html($button_text); ?>
                        </a>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_2"): ?>
            <section class="buy-theme-2">
                <div class="container">
                    <div class="text">
                        <?php if (!empty($title)): ?>
                            <h3><?php echo esc_html($title); ?></h3>
                        <?php endif ?>
                        <?php if (!empty($text)): ?>
                            <span><?php echo esc_html($text); ?></span>
                        <?php endif ?>
                    </div>

                    <div class="button">
                        <a href="<?php echo esc_url($button_link); ?>" target="_blank" class="ia" style="background-color: <?php echo esc_attr($background_color); ?>;">
                            <?php echo esc_html($button_text); ?>
                            <i class="fa fa-angle-down"></i>
                        </a>
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
    "name"      => __("Text with Button Strip", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_text_button_strip",
    "class"     => "vc_text_button_strip",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Title (Layout 2)", 'js_composer'),
            "param_name"  => "title",
            "value"       => "",
            "description" => __("Add text for your section", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Text/Subtitle", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add text/subtitle for your section", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Button Text", 'js_composer'),
            "param_name"  => "button_text",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Button Link", 'js_composer'),
            "param_name"  => "button_link",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "colorpicker",
            "heading"     => __("Button Background Color", 'js_composer'),
            "param_name"  => "background_color",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'js_composer' ),
            'param_name' => 'layout',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Layout 1', 'js_composer' ) => 'layout_1', __( 'Layout 2', 'js_composer' ) => 'layout_2', ),
            'std' => 'layout_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);