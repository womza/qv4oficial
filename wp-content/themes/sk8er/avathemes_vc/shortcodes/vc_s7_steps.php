<?php
/**
 * Steps Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s7_steps extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'background_image'  => '',
            'layout'        => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>
        <?php $image_url = wp_get_attachment_image_src( $background_image, 'full' ); ?>

        <?php if ($layout=="layout_1"): ?>
            <section class="style-7 steps" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);">
                <div class="inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="inside">
                                        <?php if (!empty($title)): ?>
                                            <h3><?php echo esc_html($title); ?></h3>
                                        <?php endif ?>

                                        <?php foreach ($sk8er['sk8er_steps'] as $step): ?>
                                            <div class="col-md-4">
                                                <div class="single">
                                                    <div class="icon">
                                                        <?php if (!empty($step['image'])): ?>
                                                            <img src="<?php echo esc_url($step['image']); ?>" alt="">
                                                                <?php else: ?>
                                                            <i class="fa <?php echo esc_attr($step['description']); ?>"></i>
                                                        <?php endif ?>
                                                    </div>
                                                    <div class="name">
                                                        <h3><?php echo esc_attr($step['title']); ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_2"): ?>
            <section class="style-8 style-element steps">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title)): ?>
                            <h3 class="box-title"><?php echo esc_html($title); ?></h3>
                        <?php endif ?>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="inside">
                                        <?php foreach ($sk8er['sk8er_steps'] as $step): ?>
                                            <div class="col-md-4">
                                                <div class="single">
                                                    <div class="icon">
                                                         <?php if (!empty($step['image'])): ?>
                                                            <img src="<?php echo esc_url($step['image']); ?>" alt="">
                                                                <?php else: ?>
                                                            <i class="fa <?php echo esc_attr($step['description']); ?>"></i>
                                                        <?php endif ?>
                                                    </div>
                                                    <div class="name">
                                                        <h3><?php echo esc_html($step['title']); ?></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>

                                    </div>
                                </div>
                            </div>
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
    "name"      => __("Steps Block", 'js_composer'),
    "description" => __('Insert Section with Steps', 'js_composer'),
    "base"      => "vc_s7_steps",
    "class"     => "vc_s7_steps",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Steps Section</b> and from there add links you want.", 'js_composer'),
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
            "type"        => "attach_image",
            "heading"     => __("Background Image (Layout 1 only)", 'js_composer'),
            "param_name"  => "background_image",
            "value"       => "",
            "description" => __("Add image for your section", 'js_composer')
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