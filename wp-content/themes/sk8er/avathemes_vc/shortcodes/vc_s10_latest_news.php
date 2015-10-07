<?php
/**
 *  Latest News Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s10_latest_news extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'text'          => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        ?>
        <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'post', 'posts_per_page' => 6);
            $wp_query = new WP_Query( $args );

            if ($sk8er['sk8er_post_likes']==1) {
                wp_enqueue_style( 'sk8er-postlikes');
            }
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-10 latest-news">
                <div class="container">
                    <div class="inner">
                        <div class="col-md-4">
                            <?php if (!empty($title) || !empty($text)): ?>
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
                                <div class="text">
                                    <?php echo wp_kses($text, array('br' => '')); ?>
                                </div>
                            <?php endif ?>

                            <div class="news-slick-controls"></div>
                        </div>
                        <div class="col-md-8">
                            <div class="news-slick">

                                <?php while($wp_query->have_posts()) : $wp_query->the_post() ?>
                                    <div class="one">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); ?>
                                            <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                                                <a href="<?php the_permalink(); ?>">
                                                    <span class="topbottom-border"></span>
                                                    <span class="leftright-border"></span>
                                                </a>
                                            </div>
                                        <?php endif ?>
                                        <div class="content">
                                            <div class="name">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </div>
                                            <div class="info">
                                                <div class="left">
                                                    <i class="fa fa-calendar"></i> <?php the_time('F n, Y'); ?>
                                                </div>
                                                <div class="right">
                                                    <?php if (function_exists( 'getPostLikeLink' )): ?>
                                                        <?php if ($sk8er['sk8er_post_likes']==1): ?>
                                                            <?php echo getPostLikeLink( get_the_ID() ); ?>
                                                        <?php endif ?>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                            <div class="text">
                                                <p>
                                                    <?php echo sk8er_excerpt(30); ?>
                                                </p>
                                            </div>
                                            <div class="author-info">
                                                <i class="fa fa-user"></i> <?php echo _e( 'by', 'sk8er'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <?php endif; ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Latest Blog Posts (Layout 3)", 'js_composer'),
    "description" => __('Insert Section with Latest Blog Posts', 'js_composer'),
    "base"      => "vc_s10_latest_news",
    "class"     => "vc_s10_latest_news",
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
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);