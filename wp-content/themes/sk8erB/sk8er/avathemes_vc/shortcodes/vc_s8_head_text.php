<?php
/**
 *  Head Text Section List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s8_head_text extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'text'          => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            $args = array( 'post_type' => 'portfolio');
            $wp_query = new WP_Query( $args );
        ?>

        <section class="style-8 head-title">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="title-bar">
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($text)): ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p class="desc"><?php echo esc_html($text); ?></p>
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
    "name"      => __("Head (pure) Text Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s8_head_text",
    "class"     => "vc_s8_head_text",
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
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);