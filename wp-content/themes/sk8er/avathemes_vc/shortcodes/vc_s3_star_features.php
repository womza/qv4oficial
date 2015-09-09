<?php
/**
 *  Star Features Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s3_star_features extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>
    
        <section class="style-3 specdeals">
            <div class="inner">
                <div class="container">
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

                    <?php if (!empty($sk8er['sk8er_star_features'][0]['title'])): ?>
                        <div class="row list">
                            <?php foreach ($sk8er['sk8er_star_features'] as $feature): ?>
                                <div class="col-md-4">
                                    <div class="box">
                                        <div class="box-head">
                                            <div class="icon">
                                                <i></i>
                                            </div>
                                            <div class="name">
                                                <?php echo esc_html($feature['title']); ?>
                                            </div>
                                            <?php if (!empty($feature['url'])): ?>
                                                <p><?php echo esc_html($feature['url']); ?></p>
                                            <?php endif ?>
                                        </div>
                                        <div class="box-content">
                                            <?php if (!empty($feature['description'])): ?>
                                                <?php echo wp_kses($feature['description'], 'p'); ?>
                                            <?php endif ?>

                                            <?php if (!empty($feature['image'])): ?>
                                                <p class="image">
                                                    <img src="<?php echo esc_url($feature['image']); ?>" alt="">
                                                </p>
                                            <?php endif ?>
                                        </div>
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
    "name"      => __("Star Features", 'js_composer'),
    "description" => __('Insert Section with Star Features', 'js_composer'),
    "base"      => "vc_s3_star_features",
    "class"     => "vc_s3_star_features",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Star Features</b> and from there add features you want.", 'js_composer'),
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
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);