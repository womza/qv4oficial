<?php
/**
 *  Latest Work Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_pure_text extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'text'         => '',
        ), $atts));

        ob_start();
        ?>

        <?php if (!empty($text)): ?>
            <section class="style-2 pure-text">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <p>
                               <?php echo wp_kses($text, array('br' => '')); ?>
                            </p>
                        </div>
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
    "name"      => __("Pure Text Section", 'js_composer'),
    "description" => __('Insert Section with just text', 'js_composer'),
    "base"      => "vc_pure_text",
    "class"     => "vc_pure_text",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textarea",
            "heading"     => __("Text", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add text for your section", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);