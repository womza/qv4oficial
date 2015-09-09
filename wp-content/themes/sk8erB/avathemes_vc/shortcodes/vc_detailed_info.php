<?php
/**
 *  Detailed Info Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_detailed_info extends  WPBakeryShortCode
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
            global $sk8er;

            $first_icon_image       = $sk8er['sk8er_detailed_first_icon_image'];
            $first_icon_fa          = $sk8er['sk8er_detailed_first_icon_fa'];
            $first_main_title       = $sk8er['sk8er_detailed_first_main_title'];
            $first_sub_title        = $sk8er['sk8er_detailed_first_sub_title'];
            $first_text             = $sk8er['sk8er_detailed_first_text'];
            $first_detail_title     = $sk8er['sk8er_detailed_first_info_title'];
            $first_detail           = $sk8er['sk8er_detailed_first_info'];

            $second_icon_image       = $sk8er['sk8er_detailed_second_icon_image'];
            $second_icon_fa          = $sk8er['sk8er_detailed_second_icon_fa'];
            $second_main_title       = $sk8er['sk8er_detailed_second_main_title'];
            $second_sub_title        = $sk8er['sk8er_detailed_second_sub_title'];
            $second_text             = $sk8er['sk8er_detailed_second_text'];
            $second_detail_title     = $sk8er['sk8er_detailed_second_info_title'];
            $second_detail           = $sk8er['sk8er_detailed_second_info'];
        ?>

        <section class="style-misc icon-text-blocks">
            <div class="inner">
                <div class="container">
                    <div class="row">

                        <?php if (!empty($first_main_title)): ?>

                            <div class="col-md-6">
                                <div class="box">
                                    <div class="content">
                                        <div class="title">
                                            <div class="icon">
                                                <?php if (!empty($first_icon_image['url'])): ?>
                                                    <!-- Opcija za popup margin top -->
                                                    <img src="<?php echo esc_url($first_icon_image['url']); ?>" alt="" style="margin-top: -15px;">
                                                <?php elseif(!empty($first_icon_fa)): ?>
                                                    <i class="fa <?php echo esc_html($first_icon_fa); ?>"></i>
                                                <?php endif ?>
                                                
                                            </div>
                                            <div class="name">
                                                <?php if (!empty($first_main_title)): ?>
                                                    <h3><?php echo esc_html($first_main_title); ?></h3>
                                                <?php endif ?>
                                                <?php if (!empty($first_sub_title)): ?>
                                                    <span><?php echo esc_html($first_sub_title); ?></span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($first_text)): ?>
                                            <div class="text">
                                                <p><?php echo esc_html($first_text); ?></p>
                                            </div>
                                        <?php endif ?>

                                        <div class="more-info">
                                            <?php if (!empty($first_detail_title)): ?>
                                                <h3><?php echo esc_html($first_detail_title); ?></h3>
                                            <?php endif ?>

                                            <?php $total=0; ?>

                                            <?php foreach ($first_detail as $detail): ?>
                                                <?php $total++; ?>
                                            <?php endforeach ?>

                                            <?php $x=1; $y=0; foreach ($first_detail as $detail): ?>
                                                <?php $y++; ?>

                                                <?php if ($x==1): ?>
                                                    <ul>
                                                <?php endif ?>

                                                    <li>
                                                        <i class="fa <?php echo esc_html($detail['description']); ?>"></i>
                                                        <span><?php echo wp_kses($detail['title'], 'a'); ?></span>
                                                    </li>

                                                <?php if ($x==3 || $y==$total): ?>
                                                    </ul>
                                                    <?php $x=0; ?>
                                                <?php endif ?>


                                            <?php $x++; endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endif ?>

                        <?php if (!empty($second_main_title)): ?>

                            <div class="col-md-6">
                                <div class="box">
                                    <div class="content">
                                        <div class="title">
                                            <div class="icon">
                                                <?php if (!empty($second_icon_image['url'])): ?>
                                                    <!-- Opcija za popup margin top -->
                                                    <img src="<?php echo esc_url($second_icon_image['url']); ?>" alt="" style="margin-top: -15px;">
                                                <?php elseif(!empty($second_icon_fa)): ?>
                                                    <i class="fa <?php echo esc_html($second_icon_fa); ?>"></i>
                                                <?php endif ?>
                                                
                                            </div>
                                            <div class="name">
                                                <?php if (!empty($second_main_title)): ?>
                                                    <h3><?php echo esc_html($second_main_title); ?></h3>
                                                <?php endif ?>
                                                <?php if (!empty($second_sub_title)): ?>
                                                    <span><?php echo esc_html($second_sub_title); ?></span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($second_text)): ?>
                                            <div class="text">
                                                <p><?php echo esc_html($second_text); ?></p>
                                            </div>
                                        <?php endif ?>

                                        <div class="more-info">
                                            <?php if (!empty($second_detail_title)): ?>
                                                <h3><?php echo esc_html($second_detail_title); ?></h3>
                                            <?php endif ?>

                                            <?php $total=0; ?>

                                            <?php foreach ($second_detail as $detail): ?>
                                                <?php $total++; ?>
                                            <?php endforeach ?>

                                            <?php $x=1; $y=0; foreach ($second_detail as $detail): ?>
                                                <?php $y++; ?>

                                                <?php if ($x==1): ?>
                                                    <ul>
                                                <?php endif ?>

                                                    <li>
                                                        <i class="fa <?php echo esc_html($detail['description']); ?>"></i>
                                                        <span><?php echo wp_kses($detail['title'], 'a'); ?></span>
                                                    </li>

                                                <?php if ($x==3 || $y==$total): ?>
                                                    </ul>
                                                    <?php $x=0; ?>
                                                <?php endif ?>


                                            <?php $x++; endforeach ?>
                                        </div>
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
    "name"      => __("Detailed Info Block", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_detailed_info",
    "class"     => "vc_detailed_info",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Detailed Info Block</b> and from there add info you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);