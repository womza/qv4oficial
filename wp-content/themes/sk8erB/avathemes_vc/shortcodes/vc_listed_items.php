<?php
/**
 * Listed Items Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_listed_items extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'text'    => '',
        ), $atts));

        ob_start();
        ?>

        <?php global $sk8er; ?>

        
        <section class="style-misc offer">
            <div class="inner">
                <div class="container">
                    <?php if (!empty($title)): ?>
                        <div class="title-bar">
                            <h3><?php echo esc_html($title); ?></h3>
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

                    <?php if (!empty($sk8er['sk8er_listed_items'][0]['title'])): ?>
                        <div class="row list">
                            
                            <?php foreach ($sk8er['sk8er_listed_items'] as $item): ?>

                                <div class="col-md-4">
                                    <div class="box">
                                        <div class="icon">
                                            <?php if (!empty($item['image'])): ?>
                                                <img src="<?php echo esc_url($item['image']); ?>" alt="">
                                            <?php elseif(!empty($item['url'])): ?>
                                                <i class="fa <?php echo esc_attr($item['url']); ?>"></i>
                                            <?php endif ?>
                                        </div>

                                        <div class="content">
                                            <span class="name"><?php echo esc_html($item['title']); ?></span>
                                            <p><?php echo esc_html($item['description']); ?></p>
                                        </div>
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
    "name"      => __("Listed Items Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_listed_items",
    "class"     => "vc_listed_items",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Theme Options</b> -> <b>Listed Items Section</b> and from there add items you want.", 'js_composer'),
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