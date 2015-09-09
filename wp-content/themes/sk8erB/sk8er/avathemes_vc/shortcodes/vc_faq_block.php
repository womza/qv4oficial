<?php
/**
 * FAQ Block Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_faq_block extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => '',
            'faq_list' => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        ?>

        <?php
            global $sk8er;
            global $sk8er_faq_items;
        ?>

        <?php if ($faq_list=='faq_1'): ?>
            <?php
                $sk8er_faq_items = $sk8er['sk8er_laf_faq_items_text'];
                if (isset($sk8er['sk8er_laf_faq_items_text'])) {
                    $sk8er_faq_items = $sk8er['sk8er_laf_faq_items_text'];
                }
            ?>
        <?php endif ?>

        <?php if ($faq_list=='faq_2'): ?>
            <?php
                if (isset($sk8er['sk8er_faq_secton_items'])) {
                    $sk8er_faq_items = $sk8er['sk8er_faq_secton_items'];
                }
            ?>
        <?php endif ?>

        <section class="style-misc services faq">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title)): ?>
                        <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
                        </div>
                    <?php endif ?>

                    <div class="service-list">
                    <?php $total=0; ?>

                    <?php foreach ($sk8er_faq_items as $item): ?><?php $total++; ?><?php endforeach; ?>

                    <?php $x=1; $y=0; foreach ($sk8er_faq_items as $item): ?>
                        <?php $y++; ?>

                        <?php
                            $item = explode("|",$item);

                            $real_title = "";

                            $title = explode(" ",$item[0]);
                            $count=0;
                            $z=0;
                            foreach ($title as $one) {$count++;}
                            $half = round($count/2);

                            foreach ($title as $one) {
                                $z++;

                                if ($z==1) {
                                    $real_title .= '<b>';
                                }

                                if ($z<$half) {
                                    $real_title .= $one.' ';
                                } else {
                                    $real_title .= $one.' ';
                                }

                                if ($z==$half) {
                                    $real_title .= '</b>';
                                }
                            }
                        ?>

                        <?php if ($x==1): ?>
                            <div class="one">
                        <?php endif ?>

                        <div class="col-md-6">
                            <div class="box">
                                <div class="title">
                                    <span class="count">
                                    </span>
                                    <span class="name">
                                        <span class="inside">
                                            <?php echo wp_kses($real_title, ''); ?>
                                        </span>
                                    </span>
                                </div>
                                <div class="content">
                                    <p>
                                    <?php if (isset($item[1])): ?>
                                        <?php echo esc_html($item[1]); ?>
                                    <?php endif ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php if ($x==4 || $y==$total && $total > 4): ?>
                            </div><!-- end of one -->
                            <?php $x=0; ?>
                        <?php endif ?>

                    <?php $x++; endforeach ?>

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
    "name"      => __("FAQ Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_faq_block",
    "class"     => "vc_faq_block",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>List and FAQ Section</b>/<b>FAQ Section</b> and from there add info you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __('Title', 'js_composer'),
            "param_name"  => "title",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Use what FAQ?', 'js_composer' ),
            'param_name' => 'faq_list',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Use FAQ that are in Theme Options -> List and FAQ Section', 'js_composer' ) => 'faq_1', __( 'Use FAQ that are in Theme Options -> FAQ Section', 'js_composer' ) => 'faq_2'),
            'std' => 'faq_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);