<?php
/**
 *  Latest News Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s18_latest_news extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
            'text'          => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => 1);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-18 latest-news">
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

                        <div class="row news">

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php if (has_post_thumbnail( $post->ID ) ): ?>
                                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                    <?php $thumbnail = $image[0]; ?>
                                <?php else: ?>
                                    <?php $thumbnail = ""; ?>
                                <?php endif; ?>

                                <div class="col-md-4">
                                    <div class="box">
                                        <div class="image" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                                            <a href="<?php the_permalink(); ?>"></a>
                                        </div>

                                        <div class="content">
                                            <span class="date"><?php the_time('F n, Y'); ?></span>
                                            <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                                            <p><?php echo sk8er_excerpt(20); ?></p>

                                            <div class="buttons">
                                                <a href="<?php the_permalink(); ?>" class="ia"><span><?php _e( 'Learn More' , 'sk8er' ); ?> <i class="fa fa-long-arrow-right"></i></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>

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
    "name"      => __("Latest Blog Posts (Layout 5)", 'js_composer'),
    "description" => __('Insert Section with Latest Blog Posts', 'js_composer'),
    "base"      => "vc_s18_latest_news",
    "class"     => "vc_s18_latest_news",
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