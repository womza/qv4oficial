<?php
/**
 * Text With Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_text_with_images extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'description' => '',
            'image_1'    => '',
            'image_2'   => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            $image_1_url = wp_get_attachment_image_src( $image_1, 'full' );
            $image_2_url = wp_get_attachment_image_src( $image_2, 'full' );
        ?>

       <section class="style-misc classictxtimg">
           <div class="inner">
               <div class="container">
                   <?php if (!empty($title)): ?>
                       <div class="title-bar">
                           <h3><?php echo esc_html($title); ?></h3>
                       </div>
                   <?php endif ?>

                   <div class="row">
                       <?php if (!empty($image_2)): ?>
                           <div class="col-md-6">
                               <img src="<?php echo esc_url($image_1_url[0]); ?>" alt="">
                           </div>
                       <?php endif ?>
                       <div class="col-md-6">
                           <?php if (!empty($description)): ?>
                               <div class="row desc-text">
                                   <div class="col-md-10">
                                       <p class="desc"><?php echo esc_html($description); ?></p>
                                   </div>
                               </div
                           <?php endif ?>>
                           <?php if (!empty($image_2)): ?>
                               <img src="<?php echo esc_url($image_2_url[0]); ?>" alt="">
                           <?php endif ?>
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
    "name"      => __("Text with Images", 'js_composer'),
    "description" => __('Insert Section with Text and Image', 'js_composer'),
    "base"      => "vc_text_with_images",
    "class"     => "vc_text_with_images",
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
            "type"        => "textarea",
            "heading"     => __("Description", 'js_composer'),
            "param_name"  => "description",
            "value"       => "",
            "description" => __("Add description for your section", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Image 1", 'js_composer'),
            "param_name"  => "image_1",
            "value"       => "",
            "description" => __("Add image for your section", 'js_composer')
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Image 2", 'js_composer'),
            "param_name"  => "image_2",
            "value"       => "",
            "description" => __("Add image for your section", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);