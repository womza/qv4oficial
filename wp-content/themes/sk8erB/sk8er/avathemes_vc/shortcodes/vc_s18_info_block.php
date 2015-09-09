<?php
/**
 * Links Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s18_info_block extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
            $background             = $sk8er['sk8er_ib_background'];
            $first_title            = $sk8er['sk8er_ib_first_title'];
            $first_info             = $sk8er['sk8er_ib_first_info'];
            $second_title           = $sk8er['sk8er_ib_second_title'];
            $second_info            = $sk8er['sk8er_ib_second_info'];
            $third_title            = $sk8er['sk8er_ib_third_title'];
            $third_info             = $sk8er['sk8er_ib_third_info'];
            $fourth_title           = $sk8er['sk8er_ib_fourth_title'];
            $fourth_info            = $sk8er['sk8er_ib_fourth_info'];
            $fifth_title            = $sk8er['sk8er_ib_fifth_title'];
            $fifth_info             = $sk8er['sk8er_ib_fifth_info'];
            $contact_link           = $sk8er['sk8er_ib_contact_link'];
        ?>

        <section class="style-18 big-contact-info" style="background-image: url(<?php echo esc_url($background['url']); ?>);">
            <div class="inner">
                <div class="container">

                    <div class="row">
                        <?php if (!empty($first_title) || !empty($first_info)): ?>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="title"><?php echo esc_html($first_title); ?></div>
                                    <div class="content">
                                        <p class="number"><?php echo esc_html($first_info); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($second_title) || !empty($second_info)): ?>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="title"><?php echo esc_html($second_title); ?></div>
                                    <div class="content">
                                        <p class="number"><?php echo esc_html($second_info); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($third_title) || !empty($third_info)): ?>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="title"><?php echo esc_html($third_title); ?></div>
                                    <div class="content">
                                        <p class="number"><?php echo esc_html($third_info); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                    <div class="row">
                        <?php if (!empty($fourth_title) || !empty($fourth_info)): ?>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="title"><?php echo esc_html($fourth_title); ?></div>
                                    <div class="content">
                                        <p class="text"><?php echo esc_html($fourth_info); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($fifth_title) || !empty($fifth_info)): ?>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="title"><?php echo esc_html($fifth_title); ?></div>
                                    <div class="content">
                                        <p class="text"><?php echo esc_html($fifth_info); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($contact_link)): ?>
                            <div class="col-md-4">
                                <div class="box">
                                    <div class="content">
                                        <a href="<?php echo esc_url($contact_link); ?>" class="contact-button"><span><?php _e( 'Contact Us' , 'sk8er' ); ?> <i class="fa fa-long-arrow-right"></i></span></a>
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
    "name"      => __("Info Block", 'js_composer'),
    "description" => __('Insert Section with Info', 'js_composer'),
    "base"      => "vc_s18_info_block",
    "class"     => "vc_s18_info_block",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Info Block</b> and from there add links you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);