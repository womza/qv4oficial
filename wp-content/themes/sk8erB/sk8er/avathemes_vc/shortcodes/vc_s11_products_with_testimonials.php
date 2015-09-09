<?php
/**
 *  Products with Testimonials Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s11_products_with_testimonials extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        ?>

        <?php
            global $sk8er;
            if (isset($sk8er['sk8er_pwt_background']['url'])) {
                $background_image = $sk8er['sk8er_pwt_background']['url'];
            }
            if (isset($sk8er['sk8er_pwt_products_title'])) {
                $products_title = $sk8er['sk8er_pwt_products_title'];
            }
            if (isset($sk8er['sk8er_pwt_products_subtitle'])) {
                $products_subtitle = $sk8er['sk8er_pwt_products_subtitle'];
            }
            if (isset($sk8er['sk8er_pwt_products'])) {
                $products_list  = $sk8er['sk8er_pwt_products'];
            }
            if (isset($sk8er['sk8er_pwt_testimonials'])) {
                $testimonials = $sk8er['sk8er_pwt_testimonials'];
            }
        ?>

            <section class="style-11 single-product" style="background-image: url(<?php echo esc_url($background_image); ?>);">
                <div class="inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="product-wrapper">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="product-info">
                                                <h3><?php echo esc_html($products_title); ?></h3>
                                                <span><?php echo esc_html($products_subtitle); ?></span>

                                                <?php if (!empty($products_list[0])): ?>
                                                    <ul>
                                                        <?php foreach ($products_list as $product): ?>
                                                            <li><?php echo esc_html($product); ?></li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                <?php endif ?>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="reviews">
                                                <div class="actual-review">

                                                    <?php foreach ($testimonials as $testimonial): ?>
                                                        <div class="one">
                                                            <span class="name"><?php echo esc_html($testimonial['title']); ?></span>
                                                            <span class="position"><?php echo esc_html($testimonial['url']); ?></span>

                                                            <p>
                                                                <?php echo esc_html($testimonial['description']); ?>
                                                            </p>

                                                            <?php if (!empty($testimonial['image'])): ?>
                                                                <div class="review-image">
                                                                    <img src="<?php echo esc_url($testimonial['image']); ?>" alt="">
                                                                </div>
                                                            <?php endif ?>
                                                        </div>
                                                    <?php endforeach ?>

                                                </div>
                                                <div class="review-controls">
                                                    <div class="inside">
                                                    <?php if (!empty($testimonials[0]['description'])): ?>

                                                        <?php $x=0; foreach ($testimonials as $testimonial): ?>
                                                            <div class="one">
                                                                <a href="javascript:void(null);" style="background-image: url(<?php echo esc_url($testimonial['image']); ?>)" data-slide-index="<?php echo esc_attr($x); ?>" ></a>
                                                            </div>
                                                        <?php $x++; endforeach ?>

                                                    <?php endif ?>
                                                    </div>
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
    "name"      => __("Products with Testimonials", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s11_products_with_testimonials",
    "class"     => "vc_s11_products_with_testimonials",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Products with Testimonials</b> and from there add image and fill other options. <i>This section is limited to only one per site.</i>", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);