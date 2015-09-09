<?php
/**
 *  Latest News Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s10_mockup_slider extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'                             => '',
            'subtitle'                          => '',
            'text'                              => '',
            'slider_align'                      => '',
            'mockup_image'                      => '',
            'mockup_image_height'               => '',
            'mockup_slider_images'              => '',
            'mockup_slider_border'              => '',
            'mockup_image_slider_height'        => '',
            'mockup_image_slider_top'           => '',
            'mockup_image_slider_left'          => '',
            'mockup_image_slider_image_width'   => '',
            'mockup_small_stats'                => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
            $mockup_image = wp_get_attachment_image_src( $mockup_image, 'full' );
            $mockup_slider_images = explode(',', $mockup_slider_images);
            if ($mockup_slider_border=="enabled") {
                $border_red = "border: 1px solid red;";
                $border_blue = "border: 1px solid blue;";
            } else { $border_red = ""; $border_blue = ""; }

            $mish = $mockup_image_slider_height;
            $mist = $mockup_image_slider_top;
            $misl = $mockup_image_slider_left;
            $misiw = $mockup_image_slider_image_width+1;
        ?>

        <?php if ($slider_align=="yes"): ?>
                <section class="style-10 mockupslider imgright">
            <?php else: ?>
                <section class="style-10 mockupslider">
        <?php endif ?>

            <div class="inner">
                <div class="container">
                    <div class="col-md-8 image">
                        <div class="slider-wrapper">
                            <div class="mockup" style="height: <?php echo esc_attr($mockup_image_height)."px"; ?>;">
                                <img src="<?php echo esc_url($mockup_image[0]); ?>" alt="">
                            </div>
                            <div class="slides" style="height: <?php echo esc_attr($mish)."px"; ?>; top: <?php echo esc_attr($mist)."px"; ?>; left: <?php echo esc_attr($misl)."px"; ?>; <?php echo esc_attr($border_red); ?>">
                                <?php foreach ($mockup_slider_images as $image): ?>
                                    <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>

                                    <div class="slide" style="width: <?php echo esc_attr($misiw)."px"; ?>; <?php echo esc_attr($border_blue); ?>;">
                                        <img src="<?php echo esc_url($image_url[0]); ?>" alt="">
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 text">
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

                        <?php if (!empty($text)): ?>
                            <p><?php echo wp_kses($text, ''); ?></p>
                        <?php endif ?>

                        <?php if ($mockup_small_stats=="yes"): ?>
                            <div class="counter">
                                <?php foreach ($sk8er['sk8er_mockup_stats'] as $stats): ?>
                                    <?php if (!empty($stats['url'])): ?>
                                        <a href="<?php echo esc_url($stats['url']); ?>" target="_blank">
                                            <span class="inside">
                                                <span class="number"><?php echo esc_html($stats['description']); ?></span>
                                                <span class="text"><?php echo esc_html($stats['title']); ?></span>
                                            </span>
                                        </a>
                                    <?php endif ?>
                                <?php endforeach ?>
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
    "name"      => __("Mockup Slider", 'js_composer'),
    "description" => __('Insert Section with Mockup Slider', 'js_composer'),
    "base"      => "vc_s10_mockup_slider",
    "class"     => "vc_s10_mockup_slider",
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
            "type"        => "textfield",
            "heading"     => __("Subtitle", 'js_composer'),
            "param_name"  => "subtitle",
            "value"       => "",
            "description" => __("Add subtitle for your section", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("Text", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add text for your section", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Mockup Slider on right side?', 'js_composer' ),
            'param_name' => 'slider_align',
            'description' => __( 'If is not checked, slider will be on right side.', 'js_composer' ),
            'value' => array( __( 'Yes, please.', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Mockup Image", 'js_composer'),
            "param_name"  => "mockup_image",
            "value"       => "",
            "description" => __("Add Mockup Image with reasonable width", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Specify Mockup Image Height", 'js_composer'),
            "param_name"  => "mockup_image_height",
            "value"       => "",
            "description" => __("Type only number like: <b>480</b> (it's in px)", 'js_composer')
        ),
        array(
            "type"        => "attach_images",
            "heading"     => __("Mockup Slider Images", 'js_composer'),
            "param_name"  => "mockup_slider_images",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Easier Slider Positioning', 'js_composer' ),
            'param_name' => 'mockup_slider_border',
            'description' => __( 'Enable 1px Border around slider for easier positioning. (Disable this after positioning)', 'js_composer' ),
            'value' => array( __( 'Enable', 'js_composer' ) => 'enabled' ),
            'std' => ''
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Specify Mockup Slider Height", 'js_composer'),
            "param_name"  => "mockup_image_slider_height",
            "value"       => "",
            "description" => __("Type only number like: <b>480</b> (it's in px)", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Specify Mockup Slider Top Margin", 'js_composer'),
            "param_name"  => "mockup_image_slider_top",
            "value"       => "",
            "description" => __("Type only number like: <b>20</b> (it's in px)", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Specify Mockup Slider Left Margin", 'js_composer'),
            "param_name"  => "mockup_image_slider_left",
            "value"       => "",
            "description" => __("Type only number like: <b>20</b> (it's in px)", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Specify Mockup Slider Image WIdth", 'js_composer'),
            "param_name"  => "mockup_image_slider_image_width",
            "value"       => "",
            "description" => __("Type only number like: <b>150</b> (It should fit in Mockup image; it's in px)", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Show Small Stats?', 'js_composer' ),
            'param_name' => 'mockup_small_stats',
            'description' => __( 'Go to <b>Theme Options</b> -> <b>Mockup Slider</b> and from there, add stats you want.', 'js_composer' ),
            'value' => array( __( 'Yes, please.', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);