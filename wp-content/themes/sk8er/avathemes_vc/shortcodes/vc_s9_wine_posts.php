<?php
/**
 * Wine Posts Shortcode for Visual Composer
 */

class WPBakeryShortCode_vc_s9_wine_posts extends  WPBakeryShortCode
{
    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title'         => '',
            'subtitle'      => '',
        ), $atts));

        ob_start();

        wp_enqueue_style('sk8er-slick');
        ?>

        <?php
            global $post;
            global $sk8er;
            $args = array( 'post_type' => 'wines', 'posts_per_page' => -1);
            $wp_query = new WP_Query( $args );
        ?>

            <section class="style-9 latest-wines">
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

                        <?php if ($wp_query->have_posts()): ?>
                            <div class="wines-slick">

                                <div class="actual-slick">

                                    <?php while($wp_query->have_posts()): $wp_query->the_post() ?>
                                        <?php
                                            $wine_year = get_post_meta($post->ID, 'sk8er_wine_year', true);
                                            $thumb_bg = get_post_meta($post->ID, 'sk8er_wine_thumb_bg', true);
                                        ?>

                                        <?php if (has_post_thumbnail()): ?>
                                            <?php
                                                $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                            ?>
                                        <?php endif ?>

                                        <div class="one">

                                            <div class="inside">
                                                <div class="image">
                                                    <div class="image-inside" style="background-image: url(<?php echo esc_url($thumb_bg); ?>);">
                                                        <?php if (has_post_thumbnail()): ?>
                                                            <a href="<?php the_permalink(); ?>"></a>
                                                            <img src="<?php echo esc_url($thumb_url[0]); ?>" alt="" />
                                                        <?php endif ?>
                                                    </div>
                                                </div>

                                                <div class="content">
                                                    <h3><?php the_title(); ?></h3>
                                                    <?php if (!empty($wine_year)): ?>
                                                        <span><?php echo esc_html($wine_year); ?></span>
                                                    <?php endif ?>
                                                    <p><?php echo sk8er_excerpt(25); ?></p>

                                                    <a href="<?php the_permalink(); ?>" class="learn-more ia"><?php _e( 'Learn more' , 'sk8er' ) ?></a>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                </div>

                            </div>
                        <?php endif ?>
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
    "name"      => __("Wine Posts", 'js_composer'),
    "description" => __('Insert Section with Latest Wine Posts', 'js_composer'),
    "base"      => "vc_s9_wine_posts",
    "class"     => "vc_s9_wine_posts",
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