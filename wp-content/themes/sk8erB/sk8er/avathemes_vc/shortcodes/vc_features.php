<?php
/**
 * Features for Visual Composer
 */

class WPBakeryShortCode_vc_features extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;

            if (isset($sk8er['sk8er_features_list'])) {
                $features = $sk8er['sk8er_features_list'];
            }
        ?>

        <section class="style-misc listed-features">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title)): ?>
                        <div class="row">
                            <div class="title-bar">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($features[0])): ?>
                        <div class="row list">
                            <?php foreach ($features as $feature): ?>

                                <div class="col-sm-6 col-md-4">
                                    <div class="box">
                                        <div class="image">
                                            <img src="<?php echo esc_url($feature['image']); ?>" alt="">
                                        </div>
                                        <div class="name"><span><?php echo esc_html($feature['title']); ?></span></div>
                                    </div>
                                </div>

                            <?php endforeach ?>
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
    "name"      => __("Features Section", 'js_composer'),
    "description" => __('Insert Section features', 'js_composer'),
    "base"      => "vc_features",
    "class"     => "vc_features",
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
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Features Section</b> and from there add features you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);