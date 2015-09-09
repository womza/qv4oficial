<?php
/**
 * Links Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s9_benefits extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>

        <section class="style-9 benefits">
            <div class="inner">
                <div class="container">

                    <?php foreach ($sk8er['sk8er_benefits_section'] as $benefit): ?>
                        <div class="single">
                            <div class="icon">
                                <i class="fa <?php echo esc_attr($benefit['url']); ?>"></i>
                            </div>
                            <div class="text">
                                <span class="name"><?php echo esc_html($benefit['title']); ?></span>
                                <span class="desc"><?php echo esc_html($benefit['description']); ?></span>
                            </div>
                        </div>
                    <?php endforeach ?>


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
    "name"      => __("Benefits Block", 'js_composer'),
    "description" => __('Insert Section with Benefits', 'js_composer'),
    "base"      => "vc_s9_benefits",
    "class"     => "vc_s9_benefits",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Benefits Section</b> and from there add links you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);