<?php
/**
 * About Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s4_about extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-swipebox');
        ?>

        <?php
            global $sk8er;

            $title      = $sk8er['sk8er_about_title'];
            $subtitle   = $sk8er['sk8er_about_subtitle'];
            $text       = $sk8er['sk8er_about_text'];
            $bg_image   = $sk8er['sk8er_about_bg_image'];
            $image_1    = $sk8er['sk8er_about_image_1']['url'];
            $image_2    = $sk8er['sk8er_about_image_2']['url'];
            $image_3    = $sk8er['sk8er_about_image_3']['url'];
            $image_4    = $sk8er['sk8er_about_image_4']['url'];
        ?>
    
                       <section class="style-4 about">
                            <div class="container">
                                <?php if (!empty($bg_image['url'])): ?>
                                    <div class="about-image">
                                        <img src="<?php echo esc_url($bg_image['url']); ?>" alt="" style="bottom: -60px;">
                                    </div>
                                <?php endif ?>
                                <div class="col-md-7 col-md-offset-5">
                                    <div class="box">
                                        <div class="inside">
                                            <div class="row first-row">
                                                <div class="col-md-8 about-text">
                                                    <div class="inside">
                                                        <h3><?php echo esc_html($title); ?></h3>
                                                        <span><?php echo esc_html($subtitle); ?></span>
                                                        <p><?php echo wp_kses($text, 'br'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 about-img">
                                                    <div class="image" style="background-image: url(<?php echo esc_url($image_1); ?>);">
                                                        <div class="hover">
                                                            <div class="oh">
                                                              <span class="leftright-border"></span>
                                                              <span class="topbottom-border"></span>
                                                            </div>

                                                            <div class="links">
                                                                <a href="<?php echo esc_url($image_1); ?>" class="open-image swipebox" rel="gallery-about-1"><i class="fa fa-search-plus"></i></a>
                                                            </div>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row second-row">

                                                <div class="col-sm-4">
                                                    <div class="img col-same-height" style="background-image: url(<?php echo esc_url($image_2); ?>);">
                                                        <div class="hover col-same-height">
                                                              <div class="oh">
                                                                <span class="leftright-border"></span>
                                                                <span class="topbottom-border"></span>
                                                              </div>

                                                              <div class="links">
                                                                  <a href="<?php echo esc_url($image_2); ?>" class="open-image swipebox" rel="gallery-about-1"><i class="fa fa-search-plus"></i></a>
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="img col-same-height" style="background-image: url(<?php echo esc_url($image_3); ?>);">
                                                        <div class="hover col-same-height">
                                                          <div class="oh">
                                                            <span class="leftright-border"></span>
                                                            <span class="topbottom-border"></span>
                                                          </div>

                                                          <div class="links">
                                                              <a href="<?php echo esc_url($image_3); ?>" class="open-image swipebox" rel="gallery-about-1"><i class="fa fa-search-plus"></i></a>
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                        <div class="img col-same-height" style="background-image: url(<?php echo esc_url($image_4); ?>);">
                                                        <div class="hover col-same-height">
                                                              <div class="oh">
                                                                <span class="leftright-border"></span>
                                                                <span class="topbottom-border"></span>
                                                              </div>

                                                              <div class="links">
                                                                  <a href="<?php echo esc_url($image_4); ?>" class="open-image swipebox" rel="gallery-about-1"><i class="fa fa-search-plus"></i></a>
                                                              </div>
                                                         </div>
                                                </div>

                                                </div>
                                            </div>
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
    "name"      => __("About Block", 'js_composer'),
    "description" => __('Insert Section with About info', 'js_composer'),
    "base"      => "vc_s4_about",
    "class"     => "vc_s4_about",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>About Me</b> and from there add info.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);