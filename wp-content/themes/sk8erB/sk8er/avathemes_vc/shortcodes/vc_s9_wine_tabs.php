<?php
/**
 * Wine Tabs Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s9_wine_tabs extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'page_slug'     => '',
        ), $atts));

        ob_start();
        wp_enqueue_script('sk8er-tabs');
        ?>

        <?php global $sk8er; global $post; ?>

            <?php
                $args = array( 'pagename' => $page_slug);
                $wp_query = new WP_Query( $args );
                $x=0;
                $y=0;
            ?>

            <section class="style-9 tabs">
                <div class="container">
                    <ul class="tab-select">
                        <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                            <?php
                                $tabs = get_post_meta($post->ID, 'sk8er_tabs_section', true);
                            ?>
                            <?php if ($tabs): ?>
                                <?php foreach ($tabs as $tab): ?>
                                    <?php
                                        $tab_name                       = $tab['title'];
                                        $tab_image                      = $tab['image'];
                                    ?>

                                    <li role="presentation" <?php if($x==0){echo 'class="active"';} ?>>
                                        <a href="#tab-<?php echo esc_attr($x); ?>" role="tab" aria-controls="tab-<?php echo esc_attr($x); ?>" data-toggle="tab">
                                            <span><?php echo esc_html($tab_name); ?></span>
                                            <img src="<?php echo esc_url($tab_image); ?>" alt="">
                                        </a>
                                    </li>

                                <?php $x++; endforeach ?>
                            <?php endif ?>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <div class="tab-content">
                    <div class="container">

                        <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                            <?php
                                $tabs = get_post_meta($post->ID, 'sk8er_tabs_section', true);
                            ?>
                            <?php if ($tabs): ?>
                                <?php foreach ($tabs as $tab): ?>
                                    <?php
                                        $content_year = '';
                                        $content_text = '';
                                        $content_image = '';
                                        $content_background_image = '';

                                        if (isset($tab['content_year'])) {
                                            $content_year = $tab['content_year'];
                                        }

                                        if (isset($tab['content_text'])) {
                                            $content_text = $tab['content_text'];
                                        }

                                        if (isset($tab['content_image'])) {
                                            $content_image = $tab['content_image'];
                                        }

                                        if (isset($tab['content_background_image'])) {
                                            $content_background_image = $tab['content_background_image'];
                                        }

                                        $img_align = "";

                                       if (isset($tab['content_image_align'])) {
                                           $content_image_align            = $tab['content_image_align'];

                                           if ($content_image_align=="on") {
                                               $img_align = "imgright";
                                           }
                                       }
                                    ?>

                                    <div role="tabpanel" class="tab-pane <?php if($y==0){echo 'active';} ?> <?php echo esc_attr($img_align); ?>" id="<?php echo "tab-".$y; ?>" style="background: url(<?php echo esc_url($content_background_image); ?>);">
                                        <div class="col-md-6 image">
                                            <img src="<?php echo esc_url($content_image); ?>" alt="">
                                        </div>
                                        <div class="col-md-6 text">
                                            <div class="head-title">
                                                <div class="actual-title">
                                                    <span class="pre">
                                                        Since
                                                    </span>
                                                    <h3>
                                                        <?php echo esc_html($content_year); ?>
                                                    </h3>
                                                    <span class="endhr"></span>
                                                </div>
                                            </div>

                                            <div class="actual-text">
                                                <p><?php echo esc_html($content_text); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php $y++; endforeach ?>
                            <?php endif ?>
                        <?php endwhile; ?>
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
    "name"      => __("Wine Tabs Section", 'js_composer'),
    "description" => __('Insert Section with Tabs', 'js_composer'),
    "base"      => "vc_s9_wine_tabs",
    "class"     => "vc_s9_wine_tabs",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You should go to <b>Pages</b> -> Create page with page template 'Tabs Section' and fill fields.", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("There should be only one page with 'Tabs Section' template!", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Page Slug", 'js_composer'),
            "param_name"  => "page_slug",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);