<?php
/**
 * Social Networks Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s9_social_networks extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'layout' => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>

        <?php if ($layout=="layout_1"): ?>
            <section class="social-footer">
                <div class="inner">
                    <div class="container">
                        <?php foreach ($sk8er['sk8er_social'] as $social): ?>
                            <a href="<?php echo esc_url($social['url']); ?>" target="_blank" class="ia"><i class="fa <?php echo esc_attr($social['description']); ?>"></i></a>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_2"): ?>
            <section class="social-links-bar">
                <div class="container">
                    <div class="links">
                        <?php foreach ($sk8er['sk8er_social'] as $social): ?>
                            <a href="<?php echo esc_url($social['url']); ?>" target="_blank" class="ia"><i class="fa <?php echo esc_attr($social['description']); ?>"></i></a>
                        <?php endforeach ?>
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
    "name"      => __("Social Network links Block", 'js_composer'),
    "description" => __('Insert Section with Social Network links', 'js_composer'),
    "base"      => "vc_s9_social_networks",
    "class"     => "vc_s9_social_networks",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>General</b> -> <b>Social Network Links</b> and from there add links you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'js_composer' ),
            'param_name' => 'layout',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Layout 1', 'js_composer' ) => 'layout_1', __( 'Layout 2', 'js_composer' ) => 'layout_2' ),
            'std' => 'layout_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);