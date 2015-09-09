<?php
/**
 *  Grid Products List Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s6_grid_products_list extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'best3_title'               => '',
            'best3_1product_name'       => '',
            'best3_1product_image'      => '',
            'best3_2product_name'       => '',
            'best3_2product_image'      => '',
            'best3_3product_name'       => '',
            'best3_3product_image'      => '',

            'single_image'              => '',
            'single_title'              => '',
            'single_subtitle'           => '',
            'single_text'               => '',

            'side_images_big'           => '',
            'side_images_small_bl'      => '',
            'side_images_text_box_icon' => '',
            'side_images_text_box'      => '',

        ), $atts));

        ob_start();
        ?>

            <section class="style-6 biglist">
                    <div class="row">
                        <div class="col-md-3 products">
                            <div class="inside">
                                <div class="box-title"><?php echo esc_html($best3_title); ?></div>

                                <div class="list">
                                    <div class="product">
                                        <?php $best3_1pimage = wp_get_attachment_image_src( $best3_1product_image, 'full' ); ?>

                                        <div class="image">
                                            <img src="<?php echo esc_url($best3_1pimage[0]); ?>" alt="" />
                                        </div>
                                        <div class="name">
                                            <span><?php echo esc_html($best3_1product_name); ?></span>
                                        </div>
                                    </div>

                                    <div class="product">
                                        <?php $best3_2pimage = wp_get_attachment_image_src( $best3_2product_image, 'full' ); ?>

                                        <div class="image">
                                            <img src="<?php echo esc_url($best3_2pimage[0]); ?>" alt="" />
                                        </div>
                                        <div class="name">
                                            <span><?php echo esc_html($best3_2product_name); ?></span>
                                        </div>
                                    </div>

                                    <div class="product">
                                        <?php $best3_3pimage = wp_get_attachment_image_src( $best3_3product_image, 'full' ); ?>

                                        <div class="image">
                                            <img src="<?php echo esc_url($best3_3pimage[0]); ?>" alt="" />
                                        </div>
                                        <div class="name">
                                            <span><?php echo esc_html($best3_3product_name); ?></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 best-product">
                            <div class="inside">
                                <div class="valign">
                                    <?php $single_image_url = wp_get_attachment_image_src( $single_image, 'full' ); ?>

                                    <div class="image">
                                        <img src="<?php echo esc_url($single_image_url[0]); ?>" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="name"><?php echo esc_html($single_title); ?></div>
                                        <span><?php echo esc_html($single_subtitle); ?></span>

                                        <p><?php echo esc_html($single_text); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 images">
                            <?php
                                $image_big = wp_get_attachment_image_src( $side_images_big, 'full' );
                                $image_small = wp_get_attachment_image_src( $side_images_small_bl, 'full' );
                            ?>
                            <div class="row">
                                <div class="image-big" style="background-image: url(<?php echo esc_url($image_big[0]); ?>);">
                                </div>
                                <div class="image-smaller" style="background-image: url(<?php echo esc_url($image_small[0]); ?>);"></div>
                                <div class="image-text">
                                    <div class="inside">
                                        <div class="icon">
                                            <i class="fa <?php echo esc_attr($side_images_text_box_icon); ?>"></i>
                                        </div>
                                        <div class="name">
                                            <?php echo esc_html($side_images_text_box); ?>
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
    "name"      => __("Products List in Grid", 'js_composer'),
    "description" => __('Insert Section with Products', 'js_composer'),
    "base"      => "vc_s6_grid_products_list",
    "class"     => "vc_s6_grid_products_list",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("To make this work properly, you should fill all info below.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Best 3] Title", 'js_composer'),
            "param_name"  => "best3_title",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Best 3] 1. Product Name", 'js_composer'),
            "param_name"  => "best3_1product_name",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("[Best 3] 1. Product Image", 'js_composer'),
            "param_name"  => "best3_1product_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Best 3] 2. Product Name", 'js_composer'),
            "param_name"  => "best3_2product_name",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("[Best 3] 2. Product Image", 'js_composer'),
            "param_name"  => "best3_2product_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Best 3] 3. Product Name", 'js_composer'),
            "param_name"  => "best3_3product_name",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("[Best 3] 3. Product Image", 'js_composer'),
            "param_name"  => "best3_3product_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),

        array(
            "type"        => "attach_image",
            "heading"     => __("[Single Product] Product Image", 'js_composer'),
            "param_name"  => "single_image",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Single Product] Product Title", 'js_composer'),
            "param_name"  => "single_title",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Single Product] Subtitle", 'js_composer'),
            "param_name"  => "single_subtitle",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textarea",
            "heading"     => __("[Single Product] Text", 'js_composer'),
            "param_name"  => "single_text",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),

        array(
            "type"        => "attach_image",
            "heading"     => __("[Side Images] Big Image", 'js_composer'),
            "param_name"  => "side_images_big",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),

        array(
            "type"        => "attach_image",
            "heading"     => __("[Side Images] Small Image (bottom-left)", 'js_composer'),
            "param_name"  => "side_images_small_bl",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),

        array(
            "type"        => "textfield",
            "heading"     => __("[Side Images] Text Box Icon", 'js_composer'),
            "param_name"  => "side_images_text_box_icon",
            "value"       => "",
            "description" => __("Go <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='blank'>here</a>, find icon you want, paste name here like this: <i>fa-clock-o</i>", 'js_composer')
        ),

        array(
            "type"        => "textfield",
            "heading"     => __("[Side Images] Text Box", 'js_composer'),
            "param_name"  => "side_images_text_box",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);