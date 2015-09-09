<?php
/**
 *  Image with details Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s2_image_details extends  WPBakeryShortCode
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

            <section class="style-2 image-details">
                <?php if (!empty($title) || !empty($subtitle)): ?>
                    <div class="inner">
                        <div class="container">
                            <div class="title-bar">
                                <?php if (!empty($subtitle)): ?>
                                    <span><?php echo esc_html($subtitle); ?></span>
                                <?php endif ?>
                                <?php if (!empty($title)): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <?php if (!empty($sk8er['sk8er_iwd_image']['url'])): ?>

                    <div class="image-holder">

                        <img src="<?php echo esc_url($sk8er['sk8er_iwd_image']['url']); ?>" class="actual-image" alt="">

                        <?php foreach ($sk8er['sk8er_iwd_details'] as $detail): ?>
                            <div class="detail" style="<?php echo esc_attr($detail['url']); ?>">
                                <div class="plus"><i class="fa fa-plus"></i></div>
                                <div class="info">
                                    <img src="<?php echo esc_url($detail['image']); ?>" alt="">
                                    <div class="inner_info">
                                        <div class="name"><?php echo esc_html($detail['title']); ?></div>
                                        <div class="price"><?php echo esc_html($detail['description']); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>

                <?php endif ?>

            </section>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Image with details", 'js_composer'),
    "description" => __('Insert Section with details on image', 'js_composer'),
    "base"      => "vc_s2_image_details",
    "class"     => "vc_s2_image_details",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Image with details</b> and from there add image and fill other options. <i>This section is limited to only one per site.</i>", 'js_composer'),
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