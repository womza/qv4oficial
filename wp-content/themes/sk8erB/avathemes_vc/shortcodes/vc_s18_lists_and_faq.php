<?php
/**
 * List and Faq Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s18_lists_and_faq extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
            
            if (isset($sk8er['sk8er_laf_list_title'])) {
                $list_title     = $sk8er['sk8er_laf_list_title'];
            }
            if (isset($sk8er['sk8er_laf_list_items'])) {
                $list_items     = $sk8er['sk8er_laf_list_items'];
            }
            if (isset($sk8er['sk8er_laf_list_image'])) {
                $list_bg        = $sk8er['sk8er_laf_list_image'];
            }
            if (isset($sk8er['sk8er_laf_faq_title'])) {
                $faq_title      = $sk8er['sk8er_laf_faq_title'];
            }
            if (isset($sk8er['sk8er_laf_faq_items_text'])) {
                $faq_items      = $sk8er['sk8er_laf_faq_items_text'];
            }
        ?>

        <section class="style-18 listandfaq">
            <div class="inner">
                <div class="container">
                    <div class="row">
                        <?php if (!empty($list_items[0])): ?>

                            <?php if (!empty($faq_items[0])): ?>
                                <div class="col-md-6">
                                <?php else: ?>
                                <div class="col-md-6 col-md-offset-3">
                            <?php endif ?>
                            
                                <?php if (!empty($list_title)): ?>
                                    <div class="title-bar">
                                    <h3><?php echo esc_html($list_title); ?></h3>
                                </div>
                                <?php endif ?>

                                <div class="list" style="background-image: url(<?php echo esc_url($list_bg['url']); ?>);">
                                    <div class="actual-list">
                                        <?php if (!empty($list_items[0])): ?>
                                            <ul>
                                                <?php foreach ($list_items as $item): ?>
                                                    <?php if (!empty($item)): ?>
                                                        <li><?php echo esc_html($item); ?></li>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            </ul>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        

                        <?php if (!empty($list_items[0]) && !empty($faq_items[0])): ?>
                            <div class="sep"></div><!-- add if list and faq is enabled -->
                        <?php endif ?>
                        

                        <?php if (!empty($faq_items[0])): ?>
                            <?php if (!empty($list_items[0])): ?>
                                <div class="col-md-6">
                                <?php else: ?>
                                <div class="col-md-6 col-md-offset-3">
                            <?php endif ?>


                                <?php if (!empty($faq_title)): ?>
                                    <div class="title-bar">
                                    <h3><?php echo esc_html($faq_title); ?></h3>
                                </div>
                                <?php endif ?>

                                <div class="faq">

                                    <?php foreach ($faq_items as $item): ?>
                                        <?php
                                            $item = explode("|",$item);
                                        ?>
                                        <div class="single">
                                            <div class="title"><?php echo esc_html($item[0]); ?></div>
                                            <div class="content">
                                                <?php echo esc_html($item[1]); ?>
                                            </div>
                                        </div>
                                    <?php endforeach ?>

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
    "name"      => __("List and FAQ Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s18_lists_and_faq",
    "class"     => "vc_s18_lists_and_faq",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>List and FAQ Section</b> and from there add info you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);