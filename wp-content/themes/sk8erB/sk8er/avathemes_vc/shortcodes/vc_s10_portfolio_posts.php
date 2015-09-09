<?php
/**
 *  Latest Work Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s10_portfolio_posts extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
        ), $atts));

        ob_start();

        wp_enqueue_script('sk8er-kinetic');
        wp_enqueue_script('sk8er-jquery-ui');
        wp_enqueue_script('sk8er-mousewheel');
        wp_enqueue_style('sk8er-swipebox');
        wp_enqueue_style('sk8er-smoothDivScroll');
        wp_enqueue_script('sk8er-smoothDivScroll');
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'portfolio', 'posts_per_page' => 8);
            $wp_query = new WP_Query( $args );
        ?>

        <?php if ( $wp_query->have_posts() ) : ?>

            <section class="style-10 portfolio">
                <div class="row portfolio-gallery-wrapper">
                    <div class="portfolio-gallery">

                        <?php while($wp_query->have_posts() ) : $wp_query->the_post() ?>
                            <?php if (has_post_thumbnail() ): ?>
                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                <?php $thumbnail = $image[0]; ?>
                            <?php else: ?>
                                <?php $thumbnail = "http://placehold.it/800x480"; ?>
                            <?php endif; ?>

                            <!-- one image -->
                                <div class="col-xs-6 col-sm-3">
                                    <div class="image col-same-height">
                                        <a href="<?php the_permalink(); ?>" class="full-link"></a>
                                        <div class="actual-image" style="background-image: url(<?php echo esc_url($thumbnail); ?>);"></div>
                                        <div class="hover">
                                            <?php the_title(); ?>
                                        </div>
                                    </div>
                                </div>
                            <!-- one image -->
                        <?php endwhile; ?>

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
    "name"      => __("Portfolio Posts (layout 4)", 'js_composer'),
    "description" => __('Insert Section with Latest Portfolio Posts', 'js_composer'),
    "base"      => "vc_s10_portfolio_posts",
    "class"     => "vc_s10_portfolio_posts",
    "icon"      => "icon-class",
    "controls"  => "full",
    "category"  => __('AvaThemes', 'js_composer'),
    "params"    => array(
        array(
            "type"        => "nothing",
            "heading"     => __("You Added Section with latest posts!", 'js_composer'),
            "param_name"  => "nothing",
            "value"       => "",
            "description" => __("", 'js_composer')
        ),
    )
);

// Add & init the shortcode
wpb_map($opts);
#new WPBakeryShortCode_laborator_banner2($opts);