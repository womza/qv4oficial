<?php
/**
 *  Events Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s4_events extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        wp_enqueue_style('sk8er-swipebox');
        ?>

        <?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'events', 'posts_per_page' => -1);
            $wp_query = new WP_Query( $args );

            if ($sk8er['sk8er_post_likes']==1) {
                wp_enqueue_style( 'sk8er-postlikes');
            }
        ?>

               <section class="style-4 happening">
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

                            <?php if ( $wp_query->have_posts() ) : ?>
                            <div class="row list">
                                <div class="happening-slick">
                                    <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                        <?php 
                                            $event_date = get_post_meta($post->ID, 'sk8er_event_date', true);
                                            $event_city = get_post_meta($post->ID, 'sk8er_event_city', true);
                                            $event_image = get_post_meta($post->ID, 'sk8er_event_image', true);
                                            $event_quote_smaller = get_post_meta($post->ID, 'sk8er_event_quote_smaller', true);
                                            $event_quote_bigger = get_post_meta($post->ID, 'sk8er_event_quote_bigger', true);
                                            $event_single_image = get_post_meta($post->ID, 'sk8er_event_single_image', true);
                                        ?>

                                        <div class="one">
                                            <div class="cpad event-info">
                                                <div class="inside" style="background-image: url(<?php echo esc_url($event_image); ?>);">
                                                    <i class="icon fa fa-calendar"></i>
                                                    <div class="content">
                                                        <?php if (!empty($event_date)): ?>
                                                            <span><?php echo esc_html($event_date); ?></span>
                                                        <?php endif ?>
                                                        <?php if (!empty($event_city)): ?>
                                                            <h3><?php echo esc_html($event_city); ?></h3>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cpad event-quote">
                                                <div class="inside">
                                                    <div class="content">
                                                        <?php if (!empty($event_quote_smaller)): ?>
                                                            <span><?php echo esc_html($event_quote_smaller); ?></span>
                                                        <?php endif ?>
                                                        <?php if (!empty($event_quote_bigger)): ?>
                                                            <h3><?php echo esc_html($event_quote_bigger); ?></h3>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cpad event-post">
                                                <div class="inside">
                                                    <?php if (has_post_thumbnail()): ?>
                                                        <?php $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' ); ?>
                                                        <div class="image" style="background-image: url(<?php echo esc_url($thumb_url[0]); ?>);">
                                                            <div class="cut"></div>
                                                            <a href="<?php the_permalink(); ?>"></a>
                                                        </div>
                                                        <div class="content">
                                                    <?php else: ?>
                                                        <div class="content" style="padding-top: 15px;">
                                                    <?php endif ?>
                                                        <div class="name">
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                        </div>
                                                        <div class="info">
                                                            <div class="left">
                                                                <i class="fa fa-calendar"></i> <?php the_time('M d, Y'); ?>
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
                                                                <?php echo sk8er_excerpt(35); ?>
                                                            </p>
                                                        </div>
                                                        <div class="author-info">
                                                            <i class="fa fa-user"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cpad event-image">
                                                <div class="inside" style="background-image: url(<?php echo esc_url($event_single_image); ?>);">
                                                    <div class="hover">
                                                      <div class="oh">
                                                        <span class="leftright-border"></span>
                                                        <span class="topbottom-border"></span>
                                                      </div>

                                                      <div class="links">
                                                          <a href="<?php echo esc_url($event_single_image); ?>" class="open-image swipebox" rel="gallery-event-<?php echo esc_attr($post->ID); ?>"><i class="fa fa-search-plus"></i></a>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="happening-slick-arrows"></div>
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
    "name"      => __("Events Posts", 'js_composer'),
    "description" => __('Insert Section with Events Posts', 'js_composer'),
    "base"      => "vc_s4_events",
    "class"     => "vc_s4_events",
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