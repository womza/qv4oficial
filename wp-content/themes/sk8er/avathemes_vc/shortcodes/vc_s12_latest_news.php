<?php
/**
 *  Latest News Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s12_latest_news extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'ppp'           => '',
        ), $atts));

        ob_start();
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'post', 'posts_per_page' => $ppp);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>
    
            <?php if (!empty($title)): ?>
                <section class="style-12 our-team">
                    <div class="inner">
                        <div class="container">
                            <div class="title-bar">
                                <h3><?php echo esc_html($title); ?></h3>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif ?>

            <?php $x=0; while($wp_query->have_posts() ) : $wp_query->the_post(); ?>

                <?php if (has_post_thumbnail( $post->ID ) ): ?>
                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                    <?php $thumbnail = $image[0]; ?>
                <?php else: ?>
                    <?php $thumbnail = ""; ?>
                <?php endif; ?>

                <?php if ($x % 2 == 0): ?>
                    <section class="style-12 featured-post">
                        <?php else: ?>
                    <section class="style-12 featured-post image-right">
                <?php endif ?>

                    <div class="row">
                        <div class="col-md-6 post-image-wrapper">
                            <div class="post-image" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                                <a href="<?php the_permalink(); ?>">
                                    <span class="leftright-border"></span>
                                    <span class="topbottom-border"></span>

                                    <div class="links">
                                        <span class="open-external"><i class="fa fa-external-link"></i></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="post-info">
                                <div class="inside">
                                    <span class="date"><?php the_time('F n, Y'); ?></span>
                                    <a href="<?php the_permalink(); ?>" class="title ia"><?php the_title(); ?></a>

                                    <p><?php echo sk8er_excerpt(30); ?></p>

                                    <a href="<?php the_permalink(); ?>" class="read-more"><span><?php _e( 'Read More' , 'sk8er' ) ?></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            <?php $x++; endwhile; ?>
           
        <?php endif; ?>

        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}



$opts = array(
    "name"      => __("Latest Blog Posts (Layout 4)", 'js_composer'),
    "description" => __('Insert Section with Latest Blog Posts', 'js_composer'),
    "base"      => "vc_s12_latest_news",
    "class"     => "vc_s12_latest_news",
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
            'heading' => __( 'Show how many latest posts?', 'js_composer' ),
            'param_name' => 'ppp',
            'description' => __( '', 'js_composer' ),
            'value' => array( __( '1', 'js_composer' ) => '1', __( '2', 'js_composer' ) => '2', __( '3', 'js_composer' ) => '3'),
            'std' => '1'
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);