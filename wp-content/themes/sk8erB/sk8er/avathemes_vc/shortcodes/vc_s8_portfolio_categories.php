<?php
/**
 *  Portfolio Categories Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s8_portfolio_categories extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'slugs'         => '',
            'portfolio_slug'          => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            $arrays = explode(",",$slugs);
            $taxonomies = get_terms( 'portfolio-categories', 'orderby=count&hide_empty=0' );
        ?>

        <section class="style-8 galleries">
            <div class="container">
                <div class="row">
                    
                    <?php foreach ($taxonomies as $single): ?>
                        <?php if (in_array($single->slug, $arrays)): ?>
                            <?php
                                wp_reset_query();
                                $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 1, 'taxonomy' => 'portfolio-categories', 'term' => $single->slug);
                                $wp_query = new WP_Query( $args );
                                if ($wp_query->have_posts()) {
                                    while ($wp_query->have_posts()) $wp_query->the_post(); {
                                        $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                        $style = "style='background-image: url(".$thumb_url[0].");'";
                                    }
                                }
                            ?>

                            <div class="col-md-6">
                                <div class="gallery" <?php echo wp_kses($style, ''); ?>>
                                    <div class="hover">
                                        <a href="<?php echo site_url(); ?>/<?php echo esc_attr($portfolio_slug) ."/#". $single->slug; ?>">
                                            <div class="inside">
                                                <div class="name">
                                                    <?php echo esc_html($single->name); ?>

                                                    <span class="preview-icon"><i class="fa fa-search"></i></span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>

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
    "name"      => __("Portfolio Categories", 'js_composer'),
    "description" => __('Insert Section with Portfolio Categories', 'js_composer'),
    "base"      => "vc_s8_portfolio_categories",
    "class"     => "vc_s8_portfolio_categories",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "textfield",
            "heading"     => __("Insert Categories slug seperated with comma.", 'js_composer'),
            "param_name"  => "slugs",
            "value"       => "",
            "description" => __("Example: <i>weddings,party,promotional</i>", 'js_composer')
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Portfolio Page Slug", 'js_composer'),
            "param_name"  => "portfolio_slug",
            "value"       => "",
            "description" => __("You can check it in <b>Page</b> on left side.", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);