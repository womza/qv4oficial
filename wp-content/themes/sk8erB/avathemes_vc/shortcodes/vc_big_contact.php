<?php
/**
 *  Big COntact List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_big_contact extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'background_color' => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>


            <section class="style-4 big-contact" style="background-color: <?php echo esc_attr($background_color); ?>;">
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

                        <?php

                            if (isset($sk8er['sk8er_contact_shortcode'])) {
                               $contact_shortcode = $sk8er['sk8er_contact_shortcode'];
                            }
                            if (isset($sk8er['sk8er_contact_info_1_title'])) {
                                $contact_info_1_title = $sk8er['sk8er_contact_info_1_title'];
                            }
                            if (isset($sk8er['sk8er_contact_info_1'][0])) {
                                $contact_info_1 = $sk8er['sk8er_contact_info_1'];
                            }
                            if (isset($sk8er['sk8er_contact_info_2_title'])) {
                               $contact_info_2_title = $sk8er['sk8er_contact_info_2_title'];
                            }
                            if (isset($sk8er['sk8er_contact_info_2'][0])) {
                                $contact_info_2 = $sk8er['sk8er_contact_info_2'];
                            }
                            if (isset($sk8er['sk8er_contact_info_3_title'])) {
                                $contact_info_3_title = $sk8er['sk8er_contact_info_3_title'];
                            }
                            if (isset($sk8er['sk8er_contact_info_3'][0])) {
                                $contact_info_3 = $sk8er['sk8er_contact_info_3'];
                            }
                            if (isset($sk8er['sk8er_contact_info_4_title'])) {
                                $contact_info_4_title = $sk8er['sk8er_contact_info_4_title'];
                            }
                            if (isset($sk8er['sk8er_contact_info_4'][0])) {
                                $contact_info_4 = $sk8er['sk8er_contact_info_4'];
                            }
                        ?>

                        <div class="row contact-info">
                            <?php if (!empty($contact_shortcode)): ?>
                                <?php if (!empty($contact_info_1) || !empty($contact_info_2) || !empty($contact_info_3) || !empty($contact_info_4)): ?>
                                        <div class="col-md-6">
                                    <?php else: ?>
                                        <div class="col-md-8 col-md-offset-2" style="border-right: none;padding-left:0;padding-right:0;">
                                <?php endif; ?>

                                    <?php echo do_shortcode($contact_shortcode); ?>
                                </div>
                            <?php endif ?>

                            <?php if (!empty($contact_shortcode)): ?>
                                    <div class="col-md-6">
                                <?php else: ?>
                                    <div class="col-md-8 col-md-offset-2" style="border-right: none;padding-right:0;">
                            <?php endif ?>
                                <?php if (!empty($contact_info_1) || !empty($contact_info_2) || !empty($contact_info_3) || !empty($contact_info_4)): ?>
                                <div class="row contact-more-info">

                                    <?php if (isset($sk8er['sk8er_contact_info_1'][1])): ?>
                                        <div class="col-sm-6">
                                            <div class="box">
                                                <?php if (!empty($contact_info_1_title)): ?>
                                                    <div class="name"><?php echo esc_html($contact_info_1_title); ?></div>
                                                <?php endif ?>

                                                <div class="list">
                                                    <?php foreach ($contact_info_1 as $info): ?>
                                                        <?php if (!empty($info)): ?>
                                                            <?php
                                                                $info = explode("|", $info);
                                                                $info_icon = $info[0];
                                                                $info_text = $info[1];
                                                            ?>
                                                            <p>
                                                                <span class="icon">
                                                                    <i class="fa <?php echo esc_attr($info_icon); ?>"></i>
                                                                </span>
                                                                <?php echo wp_kses($info_text, 'a'); ?>
                                                            </p>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <?php if (isset($sk8er['sk8er_contact_info_2'][1])): ?>
                                        <div class="col-sm-6">
                                            <div class="box">
                                                <?php if (!empty($contact_info_2_title)): ?>
                                                    <div class="name"><?php echo esc_html($contact_info_2_title); ?></div>
                                                <?php endif ?>

                                                <div class="list">
                                                    <?php foreach ($contact_info_2 as $info): ?>
                                                        <?php if (!empty($info)): ?>
                                                            <?php
                                                                $info = explode("|", $info);
                                                                $info_icon = $info[0];
                                                                $info_text = $info[1];
                                                            ?>
                                                            <p>
                                                                <span class="icon">
                                                                    <i class="fa <?php echo esc_attr($info_icon); ?>"></i>
                                                                </span>
                                                                <?php echo wp_kses($info_text, 'a'); ?>
                                                            </p>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <?php if (isset($sk8er['sk8er_contact_info_3'][1])): ?>
                                        <div class="col-sm-6">
                                            <div class="box">
                                                <?php if (!empty($contact_info_3_title)): ?>
                                                    <div class="name"><?php echo esc_html($contact_info_3_title); ?></div>
                                                <?php endif ?>

                                                <div class="list">
                                                    <?php foreach ($contact_info_3 as $info): ?>
                                                        <?php if (!empty($info)): ?>
                                                            <?php
                                                                $info = explode("|", $info);
                                                                $info_icon = $info[0];
                                                                $info_text = $info[1];
                                                            ?>
                                                            <p>
                                                                <span class="icon">
                                                                    <i class="fa <?php echo esc_attr($info_icon); ?>"></i>
                                                                </span>
                                                                <?php echo wp_kses($info_text, 'a'); ?>
                                                            </p>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                    <?php if (isset($sk8er['sk8er_contact_info_4'][1])): ?>
                                        <div class="col-sm-6">
                                            <div class="box">
                                                <?php if (!empty($contact_info_4_title)): ?>
                                                    <div class="name"><?php echo esc_html($contact_info_4_title); ?></div>
                                                <?php endif ?>

                                                <div class="list">
                                                    <?php foreach ($contact_info_4 as $info): ?>
                                                        <?php if (!empty($info)): ?>
                                                            <?php
                                                                $info = explode("|", $info);
                                                                $info_icon = $info[0];
                                                                $info_text = $info[1];
                                                            ?>
                                                            <p>
                                                                <span class="icon">
                                                                    <i class="fa <?php echo esc_attr($info_icon); ?>"></i>
                                                                </span>
                                                                <?php echo wp_kses($info_text, 'a'); ?>
                                                            </p>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif ?>

                                </div>
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
    "name"      => __("Big Contact", 'js_composer'),
    "description" => __('Insert Section with Contact', 'js_composer'),
    "base"      => "vc_big_contact",
    "class"     => "vc_big_contact",
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
            "type"        => "colorpicker",
            "heading"     => __("Background Color", 'js_composer'),
            "param_name"  => "background_color",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);