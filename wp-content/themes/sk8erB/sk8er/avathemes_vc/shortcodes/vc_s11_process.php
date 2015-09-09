<?php
/**
 * Text With Image Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s11_process extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'subtitle'    => '',
            'text'    => '',
            'steps_1'   => '',
            'steps_2'   => '',
            'steps_3'   => '',
            'steps_4'   => '',
            'steps_5'   => '',
        ), $atts));

        ob_start();

        wp_enqueue_script('sk8er-tabs');
        ?>

        <?php global $sk8er; $tabs = $sk8er['sk8er_process_tabs']; ?>

        <section class="style-11 order-process">
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
                            <div class="col-md-8 col-md-offset-2">
                                <p class="desc">
                                    <?php echo esc_html($text); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($steps_1) || !empty($steps_5)): ?>
                        <div class="process-steps">
                            <span class="step-1">
                                <i class="fa <?php echo esc_attr($steps_1); ?>"></i>
                            </span>
                            <span class="step-2">
                                <span><?php echo esc_html($steps_2); ?></span>
                            </span>
                            <span class="step-3">
                                <span><?php echo esc_html($steps_3); ?></span>
                            </span>
                            <span class="step-4">
                                <span><?php echo esc_html($steps_4); ?></span>
                            </span>
                            <span class="step-5">
                                <i class="fa <?php echo esc_attr($steps_5); ?>"></i>
                            </span>
                        </div>
                    <?php endif ?>

                    <?php if (!empty($tabs[0]['title'])): ?>
                        <div class="process-tabs">
                            <ul class="tab-select">
                                <?php $x=1; ?>
                                <?php foreach ($tabs as $tab): ?>
                                    <?php if ($x==1): ?>
                                        <li role="<?php echo esc_attr($x); ?>" class="active">
                                        <?php else: ?>
                                        <li role="<?php echo esc_attr($x); ?>">
                                    <?php endif ?>
                                    
                                        <a href="<?php echo "#tab-".$x ?>" class="ia" aria-controls="order" role="tab" data-toggle="tab">
                                            <span><?php echo esc_html($tab['title']); ?></span>
                                        </a>
                                    </li>
                                <?php $x++; endforeach ?>
                            </ul>
    
                            <div class="tab-content">
                                
                                <?php $y=1; ?>
                                <?php foreach ($tabs as $tab): ?>
                                    <?php if ($y==1): ?>
                                        <?php $active = "active" ?>
                                    <?php else: ?>
                                        <?php $active = ""; ?>
                                    <?php endif ?>
                                    <?php if ($y % 2 == 0): ?>
                                        <div role="tabpanel" class="tab-pane <?php echo esc_attr($active); ?> imgleft" id="<?php echo "tab-".$y ?>">
                                        <?php else: ?>
                                        <div role="tabpanel" class="tab-pane <?php echo esc_attr($active); ?>" id="<?php echo "tab-".$y ?>">
                                    <?php endif ?>
                                        <div class="row">
                                            <div class="col-md-6 text">
                                                <div class="title-bar">
                                                    <h3><?php echo esc_html($tab['title']); ?></h3>
                                                    <span><?php echo esc_html($tab['url']); ?></span>
                                                </div>

                                                <p class="desc">
                                                    <?php echo esc_html($tab['description']); ?>
                                                </p>
                                            </div>

                                            <?php if (!empty($tab['image'])): ?>
                                                <div class="col-md-6 image">
                                                    <img src="<?php echo esc_url($tab['image']); ?>" alt="">
                                                </div>
                                            <?php endif ?>
                                            
                                        </div>
                                    </div>
                                <?php $y++; endforeach ?>
                                
                            </div>
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
    "name"      => __("Section with Process and Tabs", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s11_process",
    'as_parent' => array('only' => 'statistics_item'),
    "class"     => "vc_s11_process",
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
            "heading"     => __("[Steps] 1 (Icon)", 'js_composer'),
            "param_name"  => "steps_1",
            "value"       => "",
            "description" => __("Go <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>here</a>, choose icon, copy name like this here: <b>fa-clock-o</b>", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Steps] 2", 'js_composer'),
            "param_name"  => "steps_2",
            "value"       => "",
            "description" => __("Short Description of this step", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Steps] 3", 'js_composer'),
            "param_name"  => "steps_3",
            "value"       => "",
            "description" => __("Short Description of this step", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Steps] 4", 'js_composer'),
            "param_name"  => "steps_4",
            "value"       => "",
            "description" => __("Short Description of this step", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("[Steps] 5 (Icon)", 'js_composer'),
            "param_name"  => "steps_5",
            "value"       => "",
            "description" => __("Go <a href='http://fortawesome.github.io/Font-Awesome/icons/' target='_blank'>here</a>, choose icon, copy name like this here: <b>fa-clock-o</b>", 'js_composer')
        ),
        array(
            "type"        => "nothing",
            "heading"     => __("For Tabs, You should go to <b>Theme Options</b> -> <b>Process and Tabs Section</b> and from there add tabs you want.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);