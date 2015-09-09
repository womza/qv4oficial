<?php
/**
 *  Big Quote Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_bigquote extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'quote'    => '',
            'by'    => '',
            'image'    => '',
            'link'		=> '',
            'background_image'  => '',
            'layout'        => '',
        ), $atts));

        ob_start();
        ?>

        <?php if (isset($quote)): ?>

            <?php
                $quote = html_entity_decode($quote);
            ?>

            <?php if ($layout=="layout_1"): ?>
                <section class="style-1 big-quote">
                    <div class="row">
                        <div class="col-sm-8 col-md-7 actual-quote">
                            <div class="inner">
                                <p>
                                    „ <?php echo apply_filters('the_content', $quote); ?> „
                                </p>

                                <?php if (!empty($by)): ?>
                                    <span class="who">
                                        - <?php echo esc_html($by); ?>
                                    </span>
                                <?php endif ?>
                            </div>
                        </div>
                        <?php if (!empty($image)): ?>
                            <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>
                            <div class="col-sm-4 quote-image" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);">
                                <?php if ($link!=""): ?>
                                    <a href="<?php echo esc_url($link); ?>" target="_blank"></a>
                                <?php else: ?>
                                    <a href="javascript:void(null);"></a>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    </div>
                </section>
            <?php endif ?>

            <?php if ($layout=="layout_2"): ?>
                <?php
                    $background_image_url = wp_get_attachment_image_src( $background_image, 'full' );

                    if (!empty($background_image_url)) {
                        $iurl = $background_image_url[0];
                    } else {
                        $iurl = "";
                    }
                ?>
                <section class="style-7 big-quote" style="background-image: url(<?php echo esc_url($iurl); ?>);">
                    <div class="inner">
                        <div class="container">
                            <div class="actual-quote">
                                <div class="inside">
                                    <p><?php echo apply_filters('the_content', $quote); ?></p>

                                    <span class="by"><?php _e( 'By' , 'sk8er' ); ?> <?php echo esc_html($by); ?></span>
                                </div>
                            </div>

                            <?php if (!empty($image)): ?>
                                <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>
                                <img src="<?php echo esc_url($image_url[0]); ?>" class="quote-img" />
                            <?php endif ?>
                        </div>
                    </div>
                </section>
            <?php endif ?>

            <?php if ($layout=="layout_3"): ?>
                <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>

                <section class="style-18 big-quote" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);">
                    <div class="inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-6">
                                    <div class="actual-quote">
                                        <p><?php echo apply_filters('the_content', $quote); ?></p>

                                        <?php if (!empty($by)): ?>
                                            <span class="who">- <?php echo esc_html($by); ?></span>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif ?>

        <?php endif ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Quote", 'js_composer'),
    "description" => __('Insert Quote Section', 'js_composer'),
    "base"      => "vc_bigquote",
    "class"     => "vc_bigquote",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textarea_html",
            "heading"     => __("Quote", 'js_composer'),
            "param_name"  => "quote",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Qute by", 'js_composer'),
            "param_name"  => "by",
            "value"       => "",
            "description" => __("Example: <b>John Williams Doe, Media Manager</b>", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Image (Upload Transparent for Layout 2)", 'js_composer'),
            "param_name"  => "image",
            "value"       => "",
            "description" => __("Add image", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Link on Image (Optional, Layout 1 only)", 'js_composer'),
            "param_name"  => "link",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Background Image (Layout 2 only)", 'js_composer'),
            "param_name"  => "background_image",
            "value"       => "",
            "description" => __("Add Bakckground image", 'js_composer')
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