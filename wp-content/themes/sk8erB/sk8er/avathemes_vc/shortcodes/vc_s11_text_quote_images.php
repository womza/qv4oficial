<?php
/**
 *  Latest News Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s11_text_quote_images extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'text'          => '',
            'first_name'    => '',
            'last_name'     => '',
            'quote_text'    => '',
            'quote_image'   => '',
            'images_block'  => '',
            'images_block_text' => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $sk8er;
        ?>

        <section class="style-11 textwithquote">
            <div class="inner">
                <div class="container">
                    <div class="row">
                        <?php if (!empty($images_block)): ?>
                                <div class="col-md-6">
                            <?php else: ?>
                                <div class="col-md-8 col-md-offset-2">
                        <?php endif ?>
                        
                            <?php if (!empty($text) || !empty($subtitle)): ?>
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
                                <p class="desc">
                                    <?php echo esc_html($text); ?>
                                </p>
                            <?php endif ?>

                            <?php if (!empty($quote_text)): ?>
                                <?php $quote_image = wp_get_attachment_image_src( $quote_image, 'full' ); ?>
                                <div class="quote">
                                    <div class="quote-head">
                                        <?php if (!empty($first_name)): ?>
                                            <span class="first-name">
                                                <?php echo esc_html($first_name); ?>
                                            </span>
                                        <?php endif ?>
                                        <?php if (!empty($last_name)): ?>
                                            <span class="last-name">
                                                <?php echo esc_html($last_name); ?>
                                            </span>
                                        <?php endif ?>

                                        <?php if (!empty($quote_image)): ?>
                                            <span class="image" style="background-image: url(<?php echo esc_url($quote_image[0]); ?>);">
                                            </span>
                                        <?php endif ?>
                                    </div>
                                    <div class="quote-text">
                                        <p><?php echo esc_html($quote_text); ?></p>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>


                        <?php if (!empty($images_block)): ?>
                            <?php $images_block = explode(',', $images_block); ?>
                            <div class="col-md-6 images-wrapper">
                                <div class="images col-same-height">
                                    <?php $x=1; foreach ($images_block as $image): ?>
                                        <?php if ($x<=4): ?>
                                            <?php $image_url = wp_get_attachment_image_src( $image, 'full' ); ?>

                                            <div class="image-holder col-half-height" style="background-image: url(<?php echo esc_url($image_url[0]); ?>);"></div>
                                        <?php endif ?>
                                    <?php $x++; endforeach ?>
                                    <?php if (!empty($images_block_text)): ?>
                                        <div class="text">
                                            <p>
                                                <?php echo wp_kses($images_block_text, 'b'); ?>
                                            </p>
                                        </div>
                                    <?php endif ?>
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
    "name"      => __("Section with Text, quote and images", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s11_text_quote_images",
    "class"     => "vc_s11_text_quote_images",
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

        array(
            "type"        => "textfield",
            "heading"     => __("[Quote] First Name", 'js_composer'),
            "param_name"  => "first_name",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Quote] Last Name", 'js_composer'),
            "param_name"  => "last_name",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("[Quote] Text", 'js_composer'),
            "param_name"  => "quote_text",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("[Quote] Image", 'js_composer'),
            "param_name"  => "quote_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_images",
            "heading"     => __("Images Block", 'js_composer'),
            "param_name"  => "images_block",
            "value"       => "",
            "description" => __("Last 4 uploaded will be visible.", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Images Block Text", 'js_composer'),
            "param_name"  => "images_block_text",
            "value"       => "<b>Love</b> what you <b>Work</b>",
            "description" => __("Wrap text in <b>b</b> tag for new line and different font.", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);