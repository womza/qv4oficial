<?php
/**
 * Info and Location Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s16_info_and_location extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        ?>

        <?php
            global $sk8er;
            $ial = $sk8er['sk8er_ial_info'];
            $ial_loc = $sk8er['sk8er_ial_location'];
        ?>
    
        
        <section class="style-16 quote-team-location">
            <div class="inner">
                <div class="container">
                    <div class="row">
                        <?php if (!empty($ial_loc)): ?>
                            <div class="col-md-6">
                            <?php else: ?>
                            <div class="col-md-10">
                        <?php endif ?>

                            <div class="quote-slick">

                                <?php foreach ($ial as $info): ?>
                                    <div class="quote" style="background-image: url(<?php echo esc_url($info['image']); ?>);">
                                        <div class="actual-quote">
                                            <div class="text">
                                                <p class="quote-text">
                                                    " <?php echo esc_html($info['description']); ?> "
                                                </p>
                                                <p class="who">- <?php echo esc_html($info['title']); ?></p>
                                            </div>
                                        </div>
                                    </div> 
                                <?php endforeach ?>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="quote-slick-navigation">
                                <?php foreach ($ial as $info): ?>
                                    <a href="javascript:void(null);" style="background-image: url(<?php echo esc_url($info['image']); ?>);"></a>
                                <?php endforeach ?>
                            </div>
                        </div>

                        <?php if (!empty($ial_loc)): ?>
                            <div class="col-md-4">
                                <div class="map">
                                    <div class="title">Our Location</div>
                                    <div class="actual-map">
                                        <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/?q=<?php echo esc_attr($ial_loc); ?>&z=12&output=embed"></iframe>
                                    </div>
                                </div>
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
    "name"      => __("Info and Location Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s16_info_and_location",
    "class"     => "vc_s16_info_and_location",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Info and Location Section</b> and from there configure this section..", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);