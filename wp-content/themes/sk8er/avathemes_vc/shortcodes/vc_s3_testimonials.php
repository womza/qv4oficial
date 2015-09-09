<?php
/**
 *  Testimonials Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s3_testimonials extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'layout'        => '',
        ), $atts));

        ob_start();
        
        wp_enqueue_style('sk8er-slick');
        ?>

        <?php global $sk8er; ?>

        <?php if ($layout=='layout_1'): ?>
            <section class="style-3 testimonials">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($subtitle) || !empty($subtitle)): ?>
                        <div class="title-bar">
                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if ($sk8er['sk8er_testimonials'][0]['description']): ?>
                        <div class="testimonials-slick">
                            <?php
                                $x=1;
                                $y=1;
                                $total=0;
                            ?>
                            <?php foreach ($sk8er['sk8er_testimonials'] as $testimonial): ?><?php $total++; ?><?php endforeach; ?>
                            <?php foreach ($sk8er['sk8er_testimonials'] as $testimonial): ?>
                                <?php
                                    $image;

                                    if (!empty($testimonial['image'])) {
                                        $image = 'style="background-image: url('.$testimonial['image'].');"';
                                    } else { $image = ""; }
                                ?>

                                <?php if ($x==1): ?>
                                    <div class="one">
                                <?php endif ?>

                                <div class="testimonial">
                                    <div class="image-holder">
                                        <div class="image" <?php echo esc_url($image); ?>>
                                        </div>
                                    </div>
                                    <div class="actual-testimonial">
                                        <div class="inside">
                                            <?php if ($testimonial['url']): ?>
                                                <h3>"<?php echo esc_html($testimonial['url']); ?>"</h3>
                                            <?php endif ?>
                                            <p><?php echo esc_html($testimonial['description']); ?></p>
                                            <span>- <?php echo esc_html($testimonial['title']); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($x==2 || $y==$total): ?>
                                </div><!-- end one-->

                                    <?php $x=0; ?>
                                <?php endif ?>
                            <?php $x++; $y++; endforeach; ?>

                        </div>
                    <?php endif; ?>

                    <div class="testimonials-slick-arrows">
                    </div>
                </div>
            </div>
            </section>
        <?php endif ?>

        <?php if ($layout=='layout_2'): ?>
            <section class="style-8 style-element testimonials">
                <div class="inner">
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="container">
                            <div class="title-bar">
                                <?php if (!empty($subtitle)): ?>
                                    <span><?php echo esc_html($subtitle); ?></span>
                                <?php endif ?>
                                <?php if (!empty($title)): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if ($sk8er['sk8er_testimonials'][0]['description']): ?>

                    <?php endif; ?>

                    <div class="container testimonials-controls">
                       <div class="classic-testimonials" data-sds="2">

                            <?php foreach ($sk8er['sk8er_testimonials'] as $testimonial): ?>
                                <?php
                                    $image;

                                    if (!empty($testimonial['image'])) {
                                        $image = 'style="background-image: url('.$testimonial['image'].');"';
                                    } else { $image = ""; }
                                ?>

                                <div class="one">
                                    <div class="image" <?php echo esc_url($image); ?>>
                                    </div>
                                     <p>
                                         <?php echo esc_html($testimonial['description']); ?>
                                     </p>

                                     <span class="by"><?php echo esc_html($testimonial['title']); ?></span>
                                </div>
                            <?php endforeach; ?>

                       </div>
                   </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=='layout_3'): ?>
            <section class="style-misc style-element testimonials">
                <div class="inner">
                    <div class="container">
                        <div class="title-bar title-left">
                            <h3>Testimonios</h3>
                            <span class="testimonials-controls"></span>
                        </div>
                    </div>
                    <div class="container">
                        <div class="container">
                            <div class="classic-testimonials" data-sds="1">
                            <?php foreach ($sk8er['sk8er_testimonials'] as $testimonial): ?>
                                <div class="one">
                                    <div class="image" style="background-image: url(<?php echo esc_url($testimonial['image']); ?>);">
                                    </div>
                                     <p>
                                         <?php echo esc_html($testimonial['description']); ?>
                                     </p>

                                     <span class="by"><?php echo esc_html($testimonial['title']); ?></span>
                                </div>
                            <?php endforeach ?>

                            </div>
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
    "name"      => __("Testimonials", 'js_composer'),
    "description" => __('Insert Section with Testimonials', 'js_composer'),
    "base"      => "vc_s3_testimonials",
    "class"     => "vc_s3_testimonials",
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
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'js_composer' ),
            'param_name' => 'layout',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Layout 1', 'js_composer' ) => 'layout_1', __( 'Layout 2', 'js_composer' ) => 'layout_2', __( 'Layout 3', 'js_composer' ) => 'layout_3'),
            'std' => 'layout_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);