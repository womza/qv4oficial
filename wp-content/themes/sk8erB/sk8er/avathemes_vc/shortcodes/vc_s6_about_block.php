<?php
/**
 * About Block (Layout 2) Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s6_about_block extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'main_title'                => '',
            'title'                     => '',
            'subtitle'                  => '',
            'text'                      => '',
            'image'                     => '',
            'testimonial'               => '',
            'testimonial_oneword'       => '',
            'testimonial_name'          => '',
            'testimonial_testimonial'   => '',
            'testimonial_image'         => '',

        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
        ?>


        <section class="style-6 about">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($main_title)): ?>
                        <div class="title-bar">
                            <h3><span><?php echo esc_html($main_title); ?></span></h3>
                        </div>
                    <?php endif ?>

                    <div class="row">
                        <?php if (!empty($image)): ?>
                            <div class="col-md-4 img">
                                <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>
                                    <img src="<?php echo esc_url($image_url[0]); ?>" alt="" />
                            </div>
                        <?php endif ?>

                        <?php if (!empty($image)): ?>
                            <div class="col-md-8 text">
                                <?php else: ?>
                            <div class="col-md-10 col-md-offset-1 text">
                        <?php endif ?>

                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                            <?php if (!empty($subtitle)): ?>
                                <h5><?php echo esc_html($subtitle); ?></h5>
                            <?php endif ?>

                            <div class="content">
                                <p>
                                    <?php echo wp_kses($text, 'p, br'); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php if ($testimonial=="yes"): ?>
                        <div class="row single-testimonial">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="testimonial">
                                    <?php if (!empty($testimonial_image)): ?>
                                        <div class="image-holder">
                                            <?php $image_url = wp_get_attachment_image_src( $testimonial_image, 'full' ); ?>
                                            <div class="image" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);">
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <div class="actual-testimonial">
                                        <div class="inside">
                                            <?php if (!empty($testimonial_oneword)): ?>
                                                <h3>"<?php echo esc_html($testimonial_oneword); ?>"</h3>
                                            <?php endif ?>
                                            <?php if (!empty($testimonial_testimonial)): ?>
                                                <p><?php echo esc_html($testimonial_testimonial); ?></p>
                                            <?php endif ?>
                                            <?php if (!empty($testimonial_name)): ?>
                                                <span>- <?php echo esc_html($testimonial_name); ?></span>
                                            <?php endif ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
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
    "name"      => __("About Block (Layout 2)", 'js_composer'),
    "description" => __('Insert Section with About info', 'js_composer'),
    "base"      => "vc_s6_about_block",
    "class"     => "vc_s6_about_block",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Main Title", 'js_composer'),
            "param_name"  => "main_title",
            "value"       => "",
            "description" => __("Add title for your section", 'js_composer')
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
            "type"        => "textarea",
            "heading"     => __("Text", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add About text for your section", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Image", 'js_composer'),
            "param_name"  => "image",
            "value"       => "",
            "description" => __("Add image for your section", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'Show Testimonial', 'js_composer' ),
            'param_name' => 'testimonial',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("One-word impression", 'js_composer'),
            "param_name"  => "testimonial_oneword",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Name", 'js_composer'),
            "param_name"  => "testimonial_name",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("Testimonial", 'js_composer'),
            "param_name"  => "testimonial_testimonial",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Testimonial Image", 'js_composer'),
            "param_name"  => "testimonial_image",
            "value"       => "",
            "description" => __("Add image for testimonial.", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);