<?php
/**
 * Minimal Info Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s18_minimal_info extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
            $title      = $sk8er['sk8er_minimalinfo_title'];

            if (isset($sk8er['sk8er_minimalinfo_info_re'])) {
                $info       = $sk8er['sk8er_minimalinfo_info_re'];
            }
        ?>

        <?php if (!empty($info[0])): ?>
            <section class="style-18 contact-info">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title)): ?>
                            <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
                        </div>
                        <?php endif ?>
                        
                        <div class="row">
                            <?php foreach ($info as $single): ?>
                                <?php
                                    $single = explode("|",$single);
                                ?>
                                <div class="col-md-4">
                                    <div class="box">
                                        <?php if (!empty($single[0])): ?>
                                            <div class="icon">
                                            <i class="fa <?php echo esc_attr($single[0]); ?>"></i>
                                        </div>
                                        <?php endif ?>
                                        <div class="content">
                                            <p><?php echo esc_html($single[1]); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>

        

        

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Minimal Info Section", 'js_composer'),
    "description" => __('Insert Section with Info', 'js_composer'),
    "base"      => "vc_s18_minimal_info",
    "class"     => "vc_s18_minimal_info",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Minimal Info Section</b> and from there add links you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);