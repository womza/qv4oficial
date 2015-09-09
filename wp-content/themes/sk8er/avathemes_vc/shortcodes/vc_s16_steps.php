<?php
/**
 * Steps Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s16_steps extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'background_image'  => '',
            'layout'        => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>
        <?php $image_url = wp_get_attachment_image_src( $background_image, 'full' ); ?>

            <section class="style-16 steps" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);">
                    <div class="inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="box">
                                       <?php if (!empty($title) || !empty($subtitle)): ?>
                                           <div class="title-bar">
                                               <?php if (!empty($title)): ?>
                                                   <h3><?php echo esc_html($title); ?></h3>
                                               <?php endif ?>
                                               <?php if (!empty($subtitle)): ?>
                                                   <span><?php echo esc_html($subtitle); ?></span>
                                               <?php endif ?>
                                           </div>
                                       <?php endif ?>

                                        <div class="content">
                                            <?php if (isset($sk8er['sk8er_stepsv2'])): ?>
                                                <?php foreach ($sk8er['sk8er_stepsv2'] as $step): ?>
                                                    <?php if (!empty($step)): ?>
                                                        <div class="single">
                                                            <p><?php echo esc_html($step); ?></p>
                                                        </div>
                                                    <?php endif ?>
                                                <?php endforeach; ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
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
    "name"      => __("Steps Block (v2)", 'js_composer'),
    "description" => __('Insert Section with Steps', 'js_composer'),
    "base"      => "vc_s16_steps",
    "class"     => "vc_s16_steps",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Steps (v2) Section</b> and from there add links you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
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
            "type"        => "attach_image",
            "heading"     => __("Background Image (Layout 1 only)", 'js_composer'),
            "param_name"  => "background_image",
            "value"       => "",
            "description" => __("Add image for your section", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);