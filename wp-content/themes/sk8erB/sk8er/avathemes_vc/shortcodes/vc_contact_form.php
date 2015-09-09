<?php
/**
 *  Contact Form Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_contact_form extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'subtitle'    => '',
            'form_id'    => '',
        ), $atts));

        ob_start();
        ?>

        <section class="style-misc contact-form">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="title">
                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <div class="form">
                        <?php if (!empty($form_id)): ?>
                            <?php echo do_shortcode('[contact-form-7 id="'.$form_id.'"]'); ?>
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
    "name"      => __("Contact Form", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_contact_form",
    "class"     => "vc_contact_form",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Title", 'js_composer'),
            "param_name"  => "title",
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Subtitle", 'js_composer'),
            "param_name"  => "subtitle",
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Contact Form Shortcode", 'js_composer'),
            "param_name"  => "form_id",
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);