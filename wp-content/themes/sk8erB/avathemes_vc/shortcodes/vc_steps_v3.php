<?php
/**
 * Steps Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_steps_v3 extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'text'      => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
            $steps = $sk8er['sk8er_stepsv3'];
        ?>

            <section class="style-misc steps">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title)): ?>
                            <div class="title-bar">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($text)): ?>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <p class="desc">
                                        <?php echo esc_html($text); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="row steps-list">
                            <?php foreach ($steps as $step): ?>
                                
                                <?php if (!empty($step)): ?>
                                    <div class="col-md-4">
                                        <div class="box">
                                            <span class="count"></span>
                                            <p><?php echo esc_html($step); ?></p>
                                        </div>
                                    </div>
                                <?php endif ?>

                            <?php endforeach ?>
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
    "name"      => __("Steps Block (v3)", 'js_composer'),
    "description" => __('Insert Section with Steps', 'js_composer'),
    "base"      => "vc_steps_v3",
    "class"     => "vc_steps_v3",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Steps (v3) Section</b> and from there add links you want.", 'js_composer'),
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