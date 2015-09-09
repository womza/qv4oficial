<?php
/**
 *  Text Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_text_block extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => '',
            'subtitle' => '',
            'text_first' => '',
            'text_second' => '',
        ), $atts));

        ob_start();
        ?>
    
        <section class="style-misc text-block">
            <div class="inner">
                <div class="container">

                    <?php if (!empty($title)): ?>
                        <h3><?php echo esc_html($title); ?></h3>
                    <?php endif ?>

                    <?php if (!empty($subtitle)): ?>
                        <span><?php echo esc_html($subtitle); ?></span>
                    <?php endif ?>

                    <?php if (!empty($text_first)): ?>
                        <p><?php echo esc_html($text_first); ?></p>
                    <?php endif ?>

                    <?php if (!empty($text_second)): ?>
                        <span class="addinfo">
                            <?php echo esc_html($text_second); ?>
                        </span>
                    <?php endif ?>

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
    "name"      => __("Text Block", 'js_composer'),
    "description" => __('Insert Section with Text', 'js_composer'),
    "base"      => "vc_text_block",
    "class"     => "vc_text_block",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __('Title', 'js_composer'),
            "param_name"  => "title",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __('Subtitle', 'js_composer'),
            "param_name"  => "subtitle",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("[1] Text", 'js_composer'),
            "param_name"  => "text_first",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("[2] Text", 'js_composer'),
            "param_name"  => "text_second",
            "value"       => "",
            "description" => __("Instructions: Check out documentation.", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);