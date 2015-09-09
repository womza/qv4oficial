<?php
/**
 * Text With Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_text_with_image extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(

        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;

            $image = $sk8er['sk8er_twis_image']['url'];
            $pop = $sk8er['sk8er_twis_image_pop'];
            $text = $sk8er['sk8er_twis_text'];
        ?>

        <section class="style-misc imagewithtext">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text">
                        <div class="inner">
                            <div class="box">

                                <?php foreach ($text as $single): ?>
                                    <?php
                                        $real_title = "";

                                        $title = explode(" ", $single['title']);
                                        $count=0;
                                        $x=0;
                                        foreach ($title as $one) {$count++;}
                                        $half = round($count/2);

                                        foreach ($title as $one) {
                                            $x++;

                                            if ($x==1) {
                                                $real_title .= '<b>';
                                            }

                                            if ($x<$half) {
                                                $real_title .= $one.' ';
                                            } else {
                                                $real_title .= $one.' ';
                                            }

                                            if ($x==$half) {
                                                $real_title .= '</b>';
                                            }
                                        }

                                    ?>

                                    <div class="single">
                                        <div class="title">
                                            <?php if (!empty($single['url'])): ?>
                                                <span class="count">
                                                    <span><i class="fa <?php echo esc_attr($single['url']); ?>"></i></span>
                                                </span>
                                            <?php endif ?>

                                            <?php if (!empty($real_title)): ?>
                                                <span class="name">
                                                    <span class="inside">
                                                        <?php echo wp_kses($real_title, ''); ?>
                                                    </span>
                                                </span>
                                            <?php endif ?>
                                        </div>
                                        <?php if (!empty($single['description'])): ?>
                                            <div class="content">
                                                <p>
                                                    <?php echo esc_html($single['description']); ?>
                                                </p>
                                            </div>
                                        <?php endif ?>
                                    </div>

                                <?php endforeach ?>

                            </div>
                        </div>
                    </div>

                    <?php if ($pop=="no"): ?>
                        <div class="col-md-6 image">
                    <?php elseif($pop=="up"): ?>
                        <div class="col-md-6 image popup">
                    <?php elseif($pop=="down"): ?>
                        <div class="col-md-6 image popdown">
                    <?php endif ?>

                        <div class="inside">
                            <div class="valign">
                                <img src="<?php echo esc_url($image); ?>" alt="">
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
    "name"      => __("Text and Image Section (v2)", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_text_with_image",
    "class"     => "vc_text_with_image",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Text With Image Section</b> and from there add links you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);