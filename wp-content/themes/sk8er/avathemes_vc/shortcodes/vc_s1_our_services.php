<?php
/**
 *  Our Services list Shortcode for Visual Composer
 */
class WPBakeryShortCode_vc_s1_our_services extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
    	global $sk8er;
        extract(shortcode_atts(array(
            'title'    		=> '',
            'subtitle'    	=> '',
            'text'    		=> '',
            'shadow'		=> '',
            'layout'        => '',
            'title_style'   => '',
        ), $atts));

        ob_start();
        ?>

        <?php if ($layout=="layout_1"): ?>
                    <?php if (!empty($sk8er['sk8er_services'][0]['title'])): ?>
                        <?php if ($title_style=="style_1"): ?>
                                <section class="style-1 our-services">
                            <?php elseif($title_style=="style_2"): ?>
                                <section class="style-13 our-services">
                        <?php endif ?>

                        <?php if ($shadow=='yes'): ?>
                                <div class="inner" style="padding-top: 0;">
                            <?php else: ?>
                                <div class="inner">
                        <?php endif ?>

                                <div class="container">
                                    <div class="title-bar">
                                        <?php if (!empty($title)): ?>
                                            <?php if ($title_style=="style_1"): ?>
                                                    <h3><?php echo esc_html($title); ?></h3>
                                                <?php elseif($title_style=="style_2"): ?>
                                                    <h3><span><?php echo esc_html($title); ?></span></h3>
                                            <?php endif ?>
                                        <?php endif ?>
                                        <?php if (!empty($subtitle)): ?>
                                            <span><?php echo esc_html($subtitle); ?></span>
                                        <?php endif ?>
                                    </div>

                                    <div class="row">
                                        <?php if (!empty($text)): ?>
                                            <div class="col-md-10 col-md-offset-1">
                                                <p class="desc">
                                                    <?php echo esc_html($text); ?>
                                                </p>
                                            </div>
                                        <?php endif ?>

                                        <?php if ($shadow=='yes'): ?>
                                                <div class="col-md-10 col-md-offset-1 servicelist effect-1 haveshadow">
                                            <?php else: ?>
                                                <div class="col-md-10 col-md-offset-1 servicelist effect-1">
                                        <?php endif ?>

                                                <?php foreach ($sk8er['sk8er_services'] as $service): ?>
                                                    <div class="col-sm-6 col-md-4 box-holder">
                                                        <div class="box">
                                                            <div class="inner">
                                                                <?php if (!empty($service['url'])): ?>
                                                                    <div class="icon">
                                                                        <i class="fa <?php echo esc_attr($service['url']); ?>"></i>
                                                                    </div>
                                                                <?php endif ?>
                                                                <div class="name">
                                                                    <span class="leftright-border"></span>
                                                                    <?php echo esc_html($service['title']); ?>
                                                                    <span class="topbottom-border"></span>
                                                                </div>
                                                                <?php if (!empty($service['description'])): ?>
                                                                    <?php $service_description = explode('-', esc_html($service['description'])) ?>
                                                                    <p>
                                                                        <?php
                                                                        foreach($service_description as $key => $value)
                                                                            echo ($key + 1).") {$value}<br />";
                                                                        ?>
                                                                    </p>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach ?>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                    <?php endif ?>
        <?php endif ?>

        <?php if ($layout=="layout_2"): ?>
            <section class="style-5 whatwedo">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title)): ?>
                            <div class="title-bar">
                                <span><?php echo esc_html($subtitle); ?></span>
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        <?php endif ?>

                        <?php if (!empty($text)): ?>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <p class="desc">
                                        <?php echo esc_html($text); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="row list">

                            <?php if (isset($sk8er['sk8er_services'])): ?>
                                <?php foreach ($sk8er['sk8er_services'] as $service): ?>
                                    <div class="col-md-4">
                                        <div class="box">
                                            <div class="inside">
                                                <div class="main">
                                                    <?php if (!empty($service['url'])): ?>
                                                        <div class="icon">
                                                            <i class="fa <?php echo esc_attr($service['url']); ?>"></i>
                                                        </div>
                                                    <?php endif ?>

                                                    <div class="name">
                                                        <?php echo esc_html($service['title']); ?>
                                                    </div>

                                                    <?php if (!empty($service['description'])): ?>
                                                        <div class="text">
                                                            <p><?php echo esc_html($service['description']); ?></p>
                                                        </div>
                                                    <?php endif ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_3"): ?>
            <section class="style-5 products">
                <div class="inner">
                    <div class="container">
                        <div class="row list">
                            <?php foreach ($sk8er['sk8er_services'] as $service): ?>
                                <div class="col-md-4">
                                    <div class="box">
                                        <div class="icon">
                                            <i class="fa <?php echo esc_attr($service['url']); ?>"></i>
                                        </div>
                                        <div class="content">
                                            <div class="name"><?php echo esc_html($service['title']); ?></div>
                                            <p><?php echo esc_html($service['description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_4"): ?>
            <section class="style-12 services">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title)): ?>
                            <div class="title-bar">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        <?php endif ?>

                        <div class="row list">

                        <?php if ($sk8er['sk8er_services']): ?>
                            <?php foreach ($sk8er['sk8er_services'] as $service): ?>
                                <div class="col-md-4">
                                    <div class="box">
                                        <div class="icon">
                                            <i class="fa <?php echo esc_attr($service['url']); ?>"></i>
                                        </div>
                                        <div class="name">
                                            <?php echo esc_html($service['title']); ?>
                                        </div>
                                        <p><?php echo esc_html($service['description']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_5"): ?>
            <section class="style-12 mini-services">
                <div class="inner">
                    <div class="container">
                        <div class="row list">

                            <?php if ($sk8er['sk8er_services']): ?>
                                <?php foreach ($sk8er['sk8er_services'] as $service): ?>
                                    <div class="col-md-4">
                                        <div class="service">
                                            <div class="icon">
                                                <i class="fa <?php echo esc_attr($service['url']); ?>"></i>
                                            </div>
                                            <div class="content">
                                                <span class="name"><?php echo esc_html($service['title']); ?></span>
                                                <p><?php echo esc_html($service['description']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>


                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_6"): ?>
            <section class="style-17 services">
                <div class="inner">
                    <div class="container">

                        <?php foreach ($sk8er['sk8er_services'] as $service): ?>

                            <div class="col-md-4">
                                <div class="box">
                                    <div class="icon">
                                        <i class="fa <?php echo esc_attr($service['url']); ?>"></i>
                                    </div>
                                    <div class="content">
                                        <span class="name"><?php echo esc_html($service['title']); ?></span>
                                        <p><?php echo esc_html($service['description']); ?></p>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </section>
        <?php endif ?>

        <?php if ($layout=="layout_7"): ?>
            <section class="style-misc services">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title)): ?>
                            <div class="title-bar">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        <?php endif ?>

                        <div class="row service-list">

                            <?php foreach ($sk8er['sk8er_services'] as $single): ?>
                                <?php
                                    $real_title = "";

                                    $title = explode(" ", $single['title']);
                                    $count=0;
                                    $x=0;
                                    foreach ($title as $one) {$count++;}
                                    $half = round($count/2);

                                    foreach ($title as $one) {
                                        $x++;

                                        if ($x==1) {
                                            $real_title .= '<b>';
                                        }

                                        if ($x<$half) {
                                            $real_title .= $one.' ';
                                        } else {
                                            $real_title .= $one.' ';
                                        }

                                        if ($x==$half) {
                                            $real_title .= '</b>';
                                        }
                                    }

                                ?>

                                <div class="col-md-6">
                                    <div class="box">
                                        <div class="title">
                                            <span class="count">
                                            </span>
                                            <span class="name">
                                                <span class="inside">
                                                    <?php echo wp_kses($real_title, ''); ?>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="content">
                                            <p>
                                                <?php echo esc_html($single['description']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

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
    "name"      => __("Services list", 'js_composer'),
    "description" => __('Insert Services Section', 'js_composer'),
    "base"      => "vc_s1_our_services",
    "class"     => "vc_s1_our_services",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
    	array(
    	    "type"        => "textfield",
    	    "heading"     => __("Title (Layout 1, 2, 4 and 7 only)", 'js_composer'),
    	    "param_name"  => "title",
    	    "value"       => "",
    	    "description" => __("Add title for your section", 'js_composer')
    	),
    	array(
    	    "type"        => "textfield",
    	    "heading"     => __("Subtitle (Layout 1 and 2 only)", 'js_composer'),
    	    "param_name"  => "subtitle",
    	    "value"       => "",
    	    "description" => __("Add subtitle for your section", 'js_composer')
    	),
    	array(
    	    "type"        => "textarea",
    	    "heading"     => __("Text (Layout 1 and 2 only)", 'js_composer'),
    	    "param_name"  => "text",
    	    "value"       => "",
    	    "description" => __("Add text for your section", 'js_composer')
    	),
    	array(
	        'type' => 'checkbox',
	        'heading' => __( 'Shadow effect? (Layout 1 only)', 'js_composer' ),
	        'param_name' => 'shadow',
	        'description' => __( '', 'js_composer' ),
	        'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
	        'std' => ''
	    ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Layout', 'js_composer' ),
            'param_name' => 'layout',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Layout 1', 'js_composer' ) => 'layout_1', __( 'Layout 2', 'js_composer' ) => 'layout_2', __( 'Layout 3', 'js_composer' ) => 'layout_3', __( 'Layout 4', 'js_composer' ) => 'layout_4', __( 'Layout 5', 'js_composer' ) => 'layout_5', __( 'Layout 6', 'js_composer' ) => 'layout_6', __( 'Layout 7', 'js_composer' ) => 'layout_7'  ),
            'std' => 'layout_1'
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Title Style (Layout 1)', 'js_composer' ),
            'param_name' => 'title_style',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Style 1', 'js_composer' ) => 'style_1', __( 'Style 2', 'js_composer' ) => 'style_2'),
            'std' => 'style_1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);