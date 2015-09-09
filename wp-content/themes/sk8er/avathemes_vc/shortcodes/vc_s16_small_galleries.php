<?php
/**
 *  Small Galleries Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s16_small_galleries extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'first_title'           => '',
            'first_name_first'      => '',
            'first_name_second'     => '',
            'first_images'          => '',
            'second_title'          => '',
            'second_name_first'     => '',
            'second_name_second'    => '',
            'second_images'         => '',
            'third_title'           => '',
            'third_name_first'      => '',
            'third_name_second'     => '',
            'third_images'          => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-swipebox');
        ?>

        <?php
            global $post;
            global $sk8er;
            $first_images   = explode(',', $first_images);
            $second_images  = explode(',', $second_images);
            $third_images   = explode(',', $third_images);
        ?>

        
        <section class="style-16 services-gallery">
            <div class="inner">
                <div class="container">
                    <div class="row">

                        <?php if (!empty($first_images)): ?>
                            <?php $a=1; foreach ($first_images as $image): ?>
                                <?php if ($a==1): ?>
                                    <?php $thumb_image = wp_get_attachment_image_src( $image, 'full' ); ?>
                                <?php endif ?>
                            <?php $a++; endforeach ?>

                            <div class="col-md-4">
                                <div class="box" style="background-image: url(<?php echo esc_url($thumb_image[0]); ?>);">
                                    <div class="hover">
                                        
                                        <?php $x=1; foreach ($first_images as $image): ?>
                                            <?php $url = wp_get_attachment_image_src( $image, 'full' ); ?>
                                            <?php if ($x!=1): ?>
                                                <a href="<?php echo esc_url($url[0]); ?>" class="swipebox" rel="first_gallery" style="display: none;"></a>
                                            <?php else: ?>
                                                <a href="<?php echo esc_url($url[0]); ?>" class="swipebox" rel="first_gallery"></a>
                                            <?php endif ?>
                                        <?php $x++; endforeach ?>

                                        <?php if (!empty($first_name_second)): ?>
                                            <div class="title double">
                                                <span><?php echo esc_html($first_name_first); ?></span>
                                                <span><?php echo esc_html($first_name_second); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="title single">
                                                <span><?php echo esc_html($first_name_first); ?></span>
                                            </div>
                                        <?php endif ?>
                                        
                                    </div>
                                </div>
                                <div class="name">
                                    <?php echo esc_html($first_title); ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($second_images)): ?>
                            <?php $b=1; foreach ($second_images as $image): ?>
                                <?php if ($b==1): ?>
                                    <?php $thumb_image = wp_get_attachment_image_src( $image, 'full' ); ?>
                                <?php endif ?>
                            <?php $b++; endforeach ?>

                            <div class="col-md-4">
                                <div class="box" style="background-image: url(<?php echo esc_url($thumb_image[0]); ?>);">
                                    <div class="hover">
                                        
                                        <?php $c=1; foreach ($second_images as $image): ?>
                                            <?php $url = wp_get_attachment_image_src( $image, 'full' ); ?>
                                            <?php if ($c!=1): ?>
                                                <a href="<?php echo esc_url($url[0]); ?>" class="swipebox" rel="second_gallery" style="display: none;"></a>
                                            <?php else: ?>
                                                <a href="<?php echo esc_url($url[0]); ?>" class="swipebox" rel="second_gallery"></a>
                                            <?php endif ?>
                                        <?php $c++; endforeach ?>

                                        <?php if (!empty($second_name_second)): ?>
                                            <div class="title double">
                                                <span><?php echo esc_html($second_name_first); ?></span>
                                                <span><?php echo esc_html($second_name_second); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="title single">
                                                <span><?php echo esc_html($second_name_first); ?></span>
                                            </div>
                                        <?php endif ?>
                                        
                                    </div>
                                </div>
                                <div class="name">
                                    <?php echo esc_html($second_title); ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($third_images)): ?>
                            <?php $d=1; foreach ($third_images as $image): ?>
                                <?php if ($d==1): ?>
                                    <?php $thumb_image = wp_get_attachment_image_src( $image, 'full' ); ?>
                                <?php endif ?>
                            <?php $d++; endforeach ?>

                            <div class="col-md-4">
                                <div class="box" style="background-image: url(<?php echo esc_url($thumb_image[0]); ?>);">
                                    <div class="hover">
                                        
                                        <?php $e=1; foreach ($third_images as $image): ?>
                                            <?php $url = wp_get_attachment_image_src( $image, 'full' ); ?>
                                            <?php if ($e!=1): ?>
                                                <a href="<?php echo esc_url($url[0]); ?>" class="swipebox" rel="third_gallery" style="display: none;"></a>
                                            <?php else: ?>
                                                <a href="<?php echo esc_url($url[0]); ?>" class="swipebox" rel="third_gallery"></a>
                                            <?php endif ?>
                                        <?php $e++; endforeach ?>

                                        <?php if (!empty($third_name_second)): ?>
                                            <div class="title double">
                                                <span><?php echo esc_html($third_name_first); ?></span>
                                                <span><?php echo esc_html($third_name_second); ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="title single">
                                                <span><?php echo esc_html($third_name_first); ?></span>
                                            </div>
                                        <?php endif ?>
                                        
                                    </div>
                                </div>
                                <div class="name">
                                    <?php echo esc_html($third_title); ?>
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
    "name"      => __("Small Galleries Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s16_small_galleries",
    "class"     => "vc_s16_small_galleries",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("Max. 3 per section.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),

        array(
            "type"        => "textfield",
            "heading"     => __("[1] Title", 'js_composer'),
            "param_name"  => "first_title",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[1] Name (first)", 'js_composer'),
            "param_name"  => "first_name_first",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[1] Name (second, optional)", 'js_composer'),
            "param_name"  => "first_name_second",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_images",
            "heading"     => __("[1] Images", 'js_composer'),
            "param_name"  => "first_images",
            "value"       => "",
            "description" => __("Add image for gallery", 'js_composer')
        ),

        array(
            "type"        => "textfield",
            "heading"     => __("[2] Title", 'js_composer'),
            "param_name"  => "second_title",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[2] Name (first)", 'js_composer'),
            "param_name"  => "second_name_first",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[2] Name (second, optional)", 'js_composer'),
            "param_name"  => "second_name_second",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_images",
            "heading"     => __("[2] Images", 'js_composer'),
            "param_name"  => "second_images",
            "value"       => "",
            "description" => __("Add image for gallery", 'js_composer')
        ),


        array(
            "type"        => "textfield",
            "heading"     => __("[3] Title", 'js_composer'),
            "param_name"  => "third_title",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[3] Name (first)", 'js_composer'),
            "param_name"  => "third_name_first",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[3] Name (second, optional)", 'js_composer'),
            "param_name"  => "third_name_second",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
        array(
            "type"        => "attach_images",
            "heading"     => __("[3] Images", 'js_composer'),
            "param_name"  => "third_images",
            "value"       => "",
            "description" => __("Add image for gallery", 'js_composer')
        ),


    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);