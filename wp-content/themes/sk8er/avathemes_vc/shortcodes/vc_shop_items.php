<?php
/**
 * Shop Items Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_shop_items extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'    => '',
            'subtitle' => '',
            'ppp'       => '',
            'items'     => '',
            'items_category' => '',
            'white_bg'  => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        ?>

        <?php
            if (empty($ppp) || !is_numeric($ppp)) {
                $ppp=3;
            }

            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $ppp,
            );

            if ($items=='latest') {
                $args['order'] = 'DESC';
            } elseif($items=='onsale') {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => $ppp,
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array( // Simple products type
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    )
                );
            } elseif($items=='fromcategory') {
                $args['product_cat'] = $items_category;
            }
            $wp_query = new WP_Query( $args );
        ?>


        <section class="style-2 shop-items">
            <div class="inner">
                <div class="container">

                    <div class="title-bar">
                        <span><?php echo esc_html($subtitle); ?></span>
                        <h3><?php echo esc_html($title); ?></h3>
                    </div>

                <?php if ($white_bg=='yes'): ?>
                    </div> <!--end of container-->

                    <div class="white_bg"><div class="container">
                <?php endif ?>

                    <?php if ($wp_query->have_posts()): ?>
                        <div class="posts-slick">
                            
                            <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                                <div class="item">
                                    <a href="<?php the_permalink(); ?>" class="img-wrapper">
                                        <?php woocommerce_template_loop_product_thumbnail(); ?>
                                        <?php woocommerce_show_product_loop_sale_flash(); ?>
                                    </a>

                                    <div class="info">
                                        <a href="<?php the_permalink(); ?>">
                                            <h3><?php the_title(); ?></h3>
                                            <span class="price"><?php woocommerce_template_single_price(); ?></span>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>

                        </div>
                    <?php else: ?>
                        <div style="text-align: center;padding-bottom:60px;">
                            <h3><?php echo __( 'No products found.', 'sk8er' ); ?></h3>
                        </div>
                    <?php endif ?>

                <?php if ($white_bg!='yes'): ?>
                    </div><!-- end of container-->
                <?php else: ?>
                    </div></div>
                <?php endif ?>
            </div>
        </section>

        

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Shop Items Section", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_shop_items",
    "class"     => "vc_shop_items",
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
            "type"        => "textfield",
            "heading"     => __("How much Items? (number)", 'js_composer'),
            "param_name"  => "ppp",
            "value"       => "",
            "description" => __("How much items should be displayed.", 'js_composer')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'What Items from Shop?', 'js_composer' ),
            'param_name' => 'items',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Latest', 'js_composer' ) => 'latest', __( 'On Sale', 'js_composer' ) => 'onsale', __( 'From Category', 'js_composer' ) => 'fromcategory'),
            'std' => 'latest'
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Category Slug", 'js_composer'),
            "param_name"  => "items_category",
            "value"       => "",
            "description" => __("If is <b>From Category</b> selected, paste here slug from category you want to display posts.", 'js_composer')
        ),
        array(
            'type' => 'checkbox',
            'heading' => __( 'White Background?', 'js_composer' ),
            'param_name' => 'white_bg',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Yes, please.', 'js_composer' ) => 'yes' ),
            'std' => ''
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);