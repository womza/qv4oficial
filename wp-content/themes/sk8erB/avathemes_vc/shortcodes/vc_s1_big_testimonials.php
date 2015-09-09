<?php
/**
 *  Portfolio Posts List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s1_big_testimonials extends  WPBakeryShortCode
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

        <?php global $sk8er; ?>


        <section class="style-1 testimonials-modern">
            <div class="inner">

                <div class="container">
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="title-bar">
                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($text)): ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <p class="desc">
                                    <?php echo esc_html($text); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>

                <?php if ($sk8er['sk8er_testimonials'][0]['description']): ?>
                    <?php if (empty($title) && empty($subtitle) && empty($text)): ?>
                            <div class="fake-container" style="margin-top: 0;">
                        <?php else: ?>
                            <div class="fake-container">
                    <?php endif ?>
                        
                        <?php $x=1; ?>
                        <?php foreach ($sk8er['sk8er_testimonials'] as $testimonial): ?>

                            <?php if ($x==1): ?>
                                <div class="container withtestimonial">
                                    <div class="row testimonial-1">
                                        <div class="col-md-4 image" style="background-image: url('<?php echo esc_url($testimonial['image']); ?>');">
                                            <a href="javascript:void(null);"></a>
                                        </div>
                                        <div class="col-md-4 actual-testimonial-wrapper">
                                            <div class="actual-testimonial">
                                                <div class="inside">
                                                    <p><?php echo esc_html($testimonial['description']); ?></p>
                                                    <span class="who">- <?php echo esc_html($testimonial['title']); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>

                            <?php if ($x==2): ?>
                                <div class="row testimonial-2">
                                    <div class="col-md-4 actual-testimonial-wrapper">
                                        <div class="actual-testimonial">
                                            <div class="inside">
                                                <p><?php echo esc_html($testimonial['description']); ?></p>
                                                <span class="who">- <?php echo esc_html($testimonial['title']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 image" style="background-image: url('<?php echo esc_url($testimonial['image']); ?>');">
                                        <a href="javascript:void(null);"></a>
                                    </div>
                                </div>

                                <?php $x=0; ?>
                            <?php endif ?>
                        <?php $x++; endforeach ?>

                    </div>
                <?php endif ?>

            </div>
        </section>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Big Testimonials", 'js_composer'),
    "description" => __('Insert Section with Testimonials', 'js_composer'),
    "base"      => "vc_s1_big_testimonials",
    "class"     => "vc_s1_big_testimonials",
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
            "type"        => "textarea",
            "heading"     => __("Text", 'js_composer'),
            "param_name"  => "text",
            "value"       => "",
            "description" => __("Add text for your section", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);