<?php
/**
 *  Latest Work Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s7_posts_item_list extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'posts_from'    => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
        ?>

        <?php if ($posts_from=="portfolio_posts"): ?>

            <?php
                $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 8);
                $wp_query = new WP_Query( $args );
            ?>

        <?php elseif($posts_from=="shop_items"): ?>
            
            <?php
                $args = array( 'post_type' => 'product', 'posts_per_page' => 8);
                $wp_query = new WP_Query( $args );
            ?>

        <?php endif ?>

            <?php if ( $wp_query->have_posts() ) : ?>

                <section class="style-7 news">
                    <div class="wrapper">
                        <div class="title">
                            <h3><?php echo esc_html($title); ?></h3>
                        </div>

                        <?php while( $wp_query->have_posts() ): $wp_query->the_post(); ?>
                            <?php if (has_post_thumbnail( $post->ID ) ): ?>
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                <?php $thumbnail = $image[0]; ?>
                            <?php else: ?>
                                <?php $thumbnail = "http://placehold.it/800x480"; ?>
                            <?php endif; ?>

                            <div class="box" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                                <div class="hover">
                                    <span class="leftright-border"></span>
                                    <span class="topbottom-border"></span>

                                    <div class="inside">
                                        <h3><?php the_title(); ?></h3>

                                        <span class="by"><?php _e( 'By' , 'sk8er' ); ?> <?php the_author_meta( 'display_name' ); ?></span>

                                        <?php if ($posts_from=='portfolio_posts'): ?>
                                            <a href="<?php the_permalink(); ?>"><span><?php _e( 'Read More' , 'sk8er' ); ?></span></a>
                                        <?php elseif($posts_from=='shop_items'): ?>
                                            <a href="<?php the_permalink(); ?>"><span><?php _e( 'View in Shop' , 'sk8er' ); ?></span></a>
                                        <?php endif ?>

                                        
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>

            <?php else: ?>

                <p style="padding: 30px;text-align: center;"><?php _e('No Posts found.', 'sk8er'); ?></p>

            <?php endif; ?>


        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Portfolio Posts/Shop Item List", 'js_composer'),
    "description" => __('', 'js_composer'),
    "base"      => "vc_s7_posts_item_list",
    "class"     => "vc_s7_posts_item_list",
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
            'type' => 'dropdown',
            'heading' => __( 'Display what posts?', 'js_composer' ),
            'param_name' => 'posts_from',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( 'Portfolio Posts', 'js_composer' ) => 'portfolio_posts', __( 'Shop Items', 'js_composer' ) => 'shop_items',),
            'std' => 'portfolio_posts'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);