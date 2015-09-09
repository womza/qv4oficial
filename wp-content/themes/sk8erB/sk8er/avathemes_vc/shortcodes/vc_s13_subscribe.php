<?php
/**
 *  Member List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s13_subscribe extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'text'          => '',
            'cf7_id' => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
        ?>

        
        <section class="big-subscribe">
            <div class="inner">
                <div class="container">
                    <div class="title-bar">
                        <h3><?php echo esc_html($title); ?></h3>
                        <span><?php echo esc_html($subtitle); ?></span>
                    </div>
                    <p class="desc"><?php echo esc_html($text); ?></p>

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <?php if (!empty($cf7_id)): ?>
                                <?php echo do_shortcode("[contact-form-7 id='".$cf7_id."']"); ?>
                            <?php endif ?>
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
    "name"      => __("Subscribe Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s13_subscribe",
    "class"     => "vc_s13_subscribe",
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
            "type"        => "textfield",
            "heading"     => __("Contact Form 7 Form ID", 'js_composer'),
            "param_name"  => "cf7_id",
            "value"       => "",
            "description" => __("Paste here id of form.", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);