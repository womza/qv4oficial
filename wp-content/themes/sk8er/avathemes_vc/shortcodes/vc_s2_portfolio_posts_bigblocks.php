<?php
/**
 *  Latest Work Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s2_portfolio_posts_bigblocks extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-swipebox');
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 6);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-2 portfolio">
                <div class="inner">
                    <div class="container">
                        <?php if (!empty($title) || !empty($subtitle)): ?>
                            <div class="container">
                                <div class="title-bar">
                                    <?php if (!empty($subtitle)): ?>
                                        <span><?php echo esc_html($subtitle); ?></span>
                                    <?php endif ?>
                                    <?php if (!empty($title)): ?>
                                        <h3><?php echo esc_html($title); ?></h3>
                                    <?php endif ?>
                                </div>
                            </div>
                        <?php endif ?>

                        <div class="row portfolio-works">

                            <?php while($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php if (has_post_thumbnail( $post->ID ) ): ?>
                                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                    <?php $thumbnail = $image[0]; ?>
                                <?php else: ?>
                                    <?php $thumbnail = "http://placehold.it/800x480"; ?>
                                <?php endif; ?>
                                <div class="col-sm-6 col-md-4 col-same-height">
                                    <div class="box" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
                                        <div class="hover">
                                            <div class="wrapper">
                                                <span class="topbottom-border"></span>
                                                <span class="leftright-border"></span>

                                                <span class="inside">
                                                    <span class="name"><?php the_title(); ?></span>
                                                    <hr>
                                                    <span class="links">
                                                        <a href="<?php echo esc_url($thumbnail); ?>" class="open-image swipebox" rel="gallery-post"><i class="fa fa-search-plus"></i></a>
                                                        <a href="<?php the_permalink(); ?>" class="open-external"><i class="fa fa-external-link"></i></a>
                                                    </span>
                                                </span>
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
    "name"      => __("Portfolio Posts In blocks", 'js_composer'),
    "description" => __('Insert Section with Latest Portfolio Posts', 'js_composer'),
    "base"      => "vc_s2_portfolio_posts_bigblocks",
    "class"     => "vc_s2_portfolio_posts_bigblocks",
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