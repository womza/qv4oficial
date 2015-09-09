<?php
/**
 *  Latest News Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s2_latest_news extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();
        ?>

        <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'post', 'posts_per_page' => 3);
            $wp_query = new WP_Query( $args );

            if ($sk8er['sk8er_post_likes']==1) {
                wp_enqueue_style( 'sk8er-postlikes');
            }
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-2 latest-news">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title) || !empty($subtitle)): ?>
                            <div class="title-bar">
                                <?php if (!empty($subtitle)): ?>
                                    <span><?php echo esc_html($subtitle); ?></span>
                                <?php endif ?>
                                <?php if (!empty($title)): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
            
                        <div class="row news-block">
                            <?php $x=1; global $sk8er_total; ?>
                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php $sk8er_total++; ?>
                            <?php endwhile; ?>

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php if ($x==1): ?>
                                    <div class="col-md-8 two">
                                <?php endif ?>
                                    
                                    <?php if ($x<3): ?>
                                        <div class="block">
                                            <?php if (has_post_thumbnail()): ?>
                                                <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                                <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <span class="topbottom-border"></span>
                                                        <span class="leftright-border"></span>
                                                    </a>
                                                </div>
                                                <div class="content">
                                            <?php else: ?>
                                                <div class="content" style="width: 100% !important;">
                                            <?php endif ?>
                                                <div class="inside">
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
                                                            <?php echo sk8er_excerpt(50); ?>
                                                        </p>
                                                    </div>
                                                    <div class="author-info">
                                                        <i class="fa fa-user"></i> <?php echo _e( 'by', 'sk8er'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
                                                    </div>
                                                </div>
                                            </div><!-- end of content -->
                                        </div><!-- end of block -->
                                    <?php endif ?>

                                <?php if ($x==2): ?>
                                    </div>
                                <?php endif ?>

                                <?php if ($x==3): ?>
                                    <div class="col-md-4 one">
                                        <div class="block">
                                            <?php if (has_post_thumbnail()): ?>
                                                <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                                <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <span class="topbottom-border"></span>
                                                        <span class="leftright-border"></span>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                <?php else: ?>
                                                <div class="content" style="width: 100% !important;">
                                            <?php endif ?>
                                                <div class="inside">
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
                                                            <?php echo sk8er_excerpt(50); ?>
                                                        </p>
                                                    </div>
                                                    <div class="author-info">
                                                        <i class="fa fa-user"></i> <?php echo _e( 'by', 'sk8er'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                                <?php if ($x==$sk8er_total): ?>
                                    </div><!--end row-->
                                <?php endif ?>
                            <?php $x++; endwhile; ?>
                    </div><!-- end of container-->
                </div><!-- end of inner-->
            </section>
        <?php endif; ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Latest Blog Posts (layout 2)", 'js_composer'),
    "description" => __('Insert Section with Latest Blog Posts', 'js_composer'),
    "base"      => "vc_s2_latest_news",
    "class"     => "vc_s2_latest_news",
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
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);