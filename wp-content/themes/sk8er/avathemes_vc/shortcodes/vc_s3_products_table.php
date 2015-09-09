<?php
/**
 *  Products Table Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s3_products_table extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>
    
        <section class="style-3 best">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title) || !empty($title)): ?>
                        <div class="title-bar">
                            <?php if (!empty($title)): ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif ?>
                            <?php if (!empty($subtitle)): ?>
                                <span><?php echo esc_html($subtitle); ?></span>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($sk8er['sk8er_products_table'][0]['title'])): ?>
                        <div class="row list">
                            <?php foreach ($sk8er['sk8er_products_table'] as $product): ?>
                                <div class="col-md-6">
                                <div class="box">
                                    <div class="info">
                                        <div class="valign">
                                            <h3><?php echo esc_html($product['title']); ?></h3>
                                            <?php if (!empty($product['description'])): ?>
                                                <p><?php echo esc_html($product['description']); ?></p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($product['image'])): ?>
                                        <div class="image">
                                            <img src="<?php echo esc_url($product['image']); ?>" alt="">
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

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
    "name"      => __("Products Table", 'js_composer'),
    "description" => __('Insert Section with Products in table', 'js_composer'),
    "base"      => "vc_s3_products_table",
    "class"     => "vc_s3_products_table",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Products (Table)</b> and from there add products you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("<b>BUT</b> you still need to have this block inserted on page!", 'js_composer')
        ),
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
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);